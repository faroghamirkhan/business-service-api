<?php

namespace Tests\Feature\Api\V1\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_logout_successfully(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth-token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer '.$token)
            ->postJson('/api/v1/auth/logout');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Logout successful.',
                'data' => null,
            ]);
    }

    public function test_logout_revokes_the_current_access_token(): void
    {
        $user = User::factory()->create();
        $tokenResult = $user->createToken('auth-token');
        $tokenId = $tokenResult->accessToken->id;

        $this->withHeader('Authorization', 'Bearer '.$tokenResult->plainTextToken)
            ->postJson('/api/v1/auth/logout')
            ->assertStatus(200);

        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => $tokenId,
        ]);
    }

    public function test_revoked_token_cannot_access_me_endpoint(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth-token')->plainTextToken;

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->postJson('/api/v1/auth/logout')
            ->assertStatus(200);

        $this->app['auth']->forgetGuards();

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson('/api/v1/auth/me')
            ->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Unauthenticated.',
            ]);
    }

    public function test_logout_does_not_revoke_other_active_tokens_for_the_same_user(): void
    {
        $user = User::factory()->create();
        $tokenToRevoke = $user->createToken('auth-token');
        $otherToken = $user->createToken('auth-token');

        $this->withHeader('Authorization', 'Bearer '.$tokenToRevoke->plainTextToken)
            ->postJson('/api/v1/auth/logout')
            ->assertStatus(200);

        $this->app['auth']->forgetGuards();

        $this->withHeader('Authorization', 'Bearer '.$tokenToRevoke->plainTextToken)
            ->getJson('/api/v1/auth/me')
            ->assertStatus(401);

        $this->withHeader('Authorization', 'Bearer '.$otherToken->plainTextToken)
            ->getJson('/api/v1/auth/me')
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'User retrieved successfully.',
            ]);

        $this->assertDatabaseHas('personal_access_tokens', [
            'id' => $otherToken->accessToken->id,
        ]);
    }

    public function test_unauthenticated_logout_returns_401(): void
    {
        $response = $this->postJson('/api/v1/auth/logout');

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Unauthenticated.',
            ]);
    }
}
