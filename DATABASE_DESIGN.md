# Database Design

## Overview

The database is designed to support service-based businesses that manage customers, field technicians, work orders, invoicing, and payments.

This document defines the core business entities before implementation begins.

---

# Core Entities

## User

Represents a system user.

Examples:
- Administrator
- Manager
- Technician

---

## Role

Defines user permissions within the system.

Examples:
- Admin
- Manager
- Technician

---

## Customer

Represents a client receiving services.

A customer may have multiple service locations and work orders.

---

## Address

Stores customer service locations.

A customer may have multiple addresses.

---

## Service

Represents a service offered by the business.

Examples:
- AC Installation
- AC Repair
- Plumbing Inspection
- Equipment Maintenance

---

## Work Order

Represents a scheduled service visit.

Contains:
- Customer
- Address
- Assigned Technician
- Scheduled Date
- Status
- Notes

---

## Invoice

Generated after a work order is completed.

Contains invoice items, totals, taxes, and payment status.

---

## Payment

Represents a payment made against an invoice.

Supports multiple payment methods.

---

# Relationships

Customer
    ↓
Addresses

Customer
    ↓
Work Orders

Service
    ↓
Work Orders

User (Technician)
    ↓
Work Orders

Work Order
    ↓
Invoice

Invoice
    ↓
Payments

Role
    ↓
Users

---

# Future Entities

These may be introduced later:

- Attachments
- Activity Logs
- Notifications
- Service Categories
- Expenses
- Inventory
- Equipment
- Companies
- Branches

---

# Design Principles

- Normalized database structure
- Proper foreign key relationships
- Soft deletes where appropriate
- Timestamps on all business entities
- UUID support (optional future enhancement)