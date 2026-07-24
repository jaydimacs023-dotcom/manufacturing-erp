# Laravel Rules

Version: 1.0

---

# Framework

Laravel 12

PHP 8.4+

MySQL

Blade

TailwindCSS

AlpineJS

---

# Architecture

Modular Monolith

Feature-Sliced Design

Clean Architecture

Repository Pattern

Service Layer

Action Classes (only for complex business operations)

---

# Directory Structure

Each domain owns

- Controllers
- Models
- Services
- Repositories
- Requests
- Policies
- Resources
- Routes
- Views

Never access another domain's internal implementation directly.

---

# Controllers

Controllers must remain thin.

Maximum responsibilities

- Receive Request
- Validate Request
- Call Service
- Return Response

Never perform business calculations.

---

# Services

Business logic belongs here.

Examples

PurchaseOrderService

ManufacturingService

InventoryService

ShipmentService

---

# Repositories

Repositories only access the database.

Never place business rules inside repositories.

---

# Models

Models represent data.

Models should not contain complex business logic.

Keep relationships simple.

---

# Form Requests

Every Create

Every Update

Must use Form Requests.

No inline validation.

---

# Policies

Authorization

Always use Policies.

Never use role checks directly inside controllers.

Bad

```
if(auth()->user()->role=="admin")
```

Good

```
$this->authorize('approve',$purchaseOrder);
```

---

# Database

Use

Migrations

Seeders

Factories

Never manually modify production schema.

---

# Eloquent

Prefer

Relationships

Scopes

Accessors

Mutators

Avoid raw SQL unless performance requires it.

---

# Events

Use Events for

Inventory Movement

Accounting Event

Notifications

Audit Logging

Avoid tight coupling between domains.

---

# Queue

Queue long-running tasks.

Examples

Export PDF

Excel Export

Email

Notifications

Large Reports

---

# Blade

Business logic

NOT allowed.

Blade only displays data.

---

# Components

Reuse Blade Components.

Examples

Buttons

Cards

Tables

Badges

Alerts

Forms

Modals

---

# Routes

Use Resource Controllers whenever possible.

Group routes by domain.

---

# Middleware

Authentication

Authorization

Audit

Localization

---

# Configuration

Never hardcode

Company

Tax

Currency

Warehouse

Status

Always use configuration or database settings.

---


# Testing

Feature Tests

For workflows.

Unit Tests

For services.

---
---

# Clean Blade Architecture

## Philosophy

Blade templates are presentation files only.

Blade is responsible for displaying information.

Blade must never contain business logic, calculations, inventory logic, accounting logic, workflow decisions, or database queries.

---

## Blade Responsibilities

Blade may only:

- Display data
- Loop through collections
- Render Blade Components
- Display validation errors
- Show session messages
- Format dates
- Format numbers
- Render conditional UI elements

Examples

✔ Display Product Name

✔ Display Status Badge

✔ Display Table Rows

✔ Display Currency

✔ Display Date

---

## Blade Must Never

Do NOT perform:

- Business calculations
- Inventory calculations
- Manufacturing calculations
- Financial calculations
- Database queries
- Complex conditionals
- Workflow decisions
- Status determination

Bad

```blade
{{ $order->items->sum(fn($item) => $item->qty * $item->price) }}
```

Good

```blade
{{ $purchaseOrder->total_amount }}
```

Computed by

PurchaseOrderService

---

Bad

```blade
@if($inventory->available_quantity > 0)
```

Good

```blade
@if($inventory->isAvailable())
```

or preferably

```blade
@if($canIssueStock)
```

prepared by the Service.

---

Bad

```blade
{{ $manufacturingOrder->materials->sum('issued_quantity') }}
```

Good

```blade
{{ $manufacturingSummary->totalIssuedQuantity }}
```

Prepared by

ManufacturingService

---

# Service Layer Responsibilities

Services own all business computations.

Examples

PurchaseOrderService

- Total Amount
- Tax
- Discount
- Approval Logic

InventoryService

- Available Quantity
- Reserved Quantity
- Stock Validation
- FEFO Selection

ManufacturingService

- Production Yield
- Material Consumption
- Waste Percentage
- Production Cost

SalesService

- Shipment Quantity
- Remaining Balance
- Export Totals

AccountingEventService

- Journal Preparation
- Debit/Credit Mapping

ReportingService

- Dashboard Statistics
- KPI Calculations
- Summary Totals

---

# Controllers

Controllers coordinate requests only.

Controller flow

Receive Request

↓

Validate Request

↓

Call Service

↓

Return View

Controllers should never calculate totals.

Controllers should never prepare reports.

Controllers should never manipulate inventory.

---

# View Models (Recommended)

When a screen becomes complex, prepare a View Data Object.

Example

DashboardData

contains

- Today's Production
- Today's Sales
- Low Stock Count
- Pending Purchase Orders
- Pending Manufacturing Orders

Blade simply renders DashboardData.

---

# Database Access

Database queries belong only in

- Repository
- Service (through Repository)

Never inside Blade.

Never inside Blade Components.

---

# Final Rule

If a Blade template needs to calculate something,

Stop.

Move the calculation into the appropriate Service and pass the prepared result to the view.

Blade should only render data.

Laravel conventions take precedence unless they conflict with documented business rules.