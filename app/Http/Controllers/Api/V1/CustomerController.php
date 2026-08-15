<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Customer\StoreCustomerRequest;
use App\Models\Customer;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Api\V1\CustomerResource;
use App\Http\Requests\Api\V1\Customer\UpdateCustomerRequest;

class CustomerController extends Controller
{
    use ApiResponse;

    public function index(): JsonResponse
    {
        $customers = Customer::all();
        return $this->success(
            CustomerResource::collection($customers),
            'Customers retrieved successfully.'
        );
    }

    /**
     * Store a newly created customer.
     */
    public function store(StoreCustomerRequest $request): JsonResponse
    {
        $customer = Customer::create($request->validated());

        return $this->success(
            CustomerResource::collection($customer),
            'Customer created successfully.',
            201
        );
    }

    /**
     * Display the specified customer.
     */
    public function show(Customer $customer): JsonResponse
    {
        return $this->success(
            new CustomerResource($customer),
            'Customer retrieved successfully.'
        );
    }

    /**
     * Update the specified customer.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer): JsonResponse
    {
        $customer->update($request->validated());

        return $this->success(
            new CustomerResource($customer->fresh()),
            'Customer updated successfully.'
        );
    }
}