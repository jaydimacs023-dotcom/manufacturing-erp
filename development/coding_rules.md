# Coding Rules

Version: 1.0

---

# Purpose

This document defines the mandatory coding standards for the Banana Chips Manufacturing ERP.

Every generated file, class, migration, controller, service, repository, and Blade template must follow these rules.

---

# General Principles

- Write code that is easy to understand.
- Favor readability over cleverness.
- Avoid unnecessary abstractions.
- Follow SOLID principles.
- Follow Clean Architecture.
- Follow Domain-Driven Design.
- Follow Feature-Sliced Design.
- Every feature belongs to exactly one domain.

---

# Domain Ownership

Every business logic belongs to one domain only.

Example

✔ Manufacturing computes production yield.

✘ Reporting computes production yield.

Reporting only displays data.

---

# Single Responsibility

One class.

One responsibility.

Examples

UserService

✔ Create User
✔ Update User
✔ Disable User

Not

✘ Generate Reports
✘ Send Emails
✘ Create Purchase Orders

---

# No Duplicate Logic

If business logic already exists

Reuse it.

Never duplicate.

---

# Naming

Classes

PascalCase

```
PurchaseOrderService
```

Variables

camelCase

```
purchaseOrder
```

Database

snake_case

```
purchase_orders
```

Columns

snake_case

```
purchase_order_number
```

Methods

Verb first.

```
createPurchaseOrder()

approvePurchaseOrder()

completeManufacturingOrder()
```

---

# File Size

Recommended limits

Controller

< 200 lines

Service

< 400 lines

Model

< 250 lines

Migration

One responsibility only.

---

# Comments

Only explain WHY.

Never explain WHAT.

Good

```php
// Prevent negative inventory due to concurrent requests.
```

Bad

```php
// Increment inventory by one.
```

---

# Exceptions

Never ignore exceptions.

Handle them properly.

Never

```
catch(Exception $e){}
```

Always

- Log
- Return proper message
- Rollback transaction if needed

---

# Database Transactions

Business transactions

MUST use

```
DB::transaction()
```

Examples

- Purchase Order Approval
- Goods Receipt
- Manufacturing Completion
- Shipment Confirmation

---

# Soft Delete

Use Soft Deletes for

- Users
- Products
- Suppliers
- Customers
- Purchase Orders
- Manufacturing Orders

Never permanently delete operational data.

---

# UUID

Primary keys

UUID

Never use incremental IDs for public references.

---

# Magic Numbers

Avoid

```
status = 3
```

Use

```
Status::APPROVED
```

---

# Constants

Use Enums where possible.

Example

ManufacturingStatus

Draft

Released

In Progress

Completed

Cancelled

---

# Logging

Every important transaction must be logged.

Examples

- Approval
- Cancellation
- Inventory Movement
- Production Completion

---

# Auditing

Every business transaction must record

- Created By
- Updated By
- Created At
- Updated At

Important approvals should also record

- Approved By
- Approved At

---

# Security

Never trust frontend validation.

Always validate on the server.

Never expose internal IDs unnecessarily.

Use Policies for authorization.

---

# Performance

Avoid N+1 queries.

Always eager load relationships when appropriate.

Paginate large datasets.

Do not load unnecessary columns.

---

# Code Reuse

Prefer

Service

↓

Repository

↓

Model

Never

Controller

↓

Controller

---

# Final Rule

When in doubt

Choose the simpler implementation.