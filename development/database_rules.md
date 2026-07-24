# Database Rules

Version: 1.0

---

# Purpose

This document defines the mandatory database design standards for the Banana Chips Manufacturing ERP.

Every migration, table, relationship, and index must follow these rules.

---

# Database Engine

Database

MySQL

Character Set

utf8mb4

Collation

utf8mb4_unicode_ci

Storage Engine

InnoDB

---

# Design Principles

- Normalize data to at least Third Normal Form (3NF).
- Avoid duplicate data.
- Keep tables focused on one business entity.
- Prefer explicit relationships.
- Avoid storing computed values unless required for performance.

---

# Primary Keys

Every table shall have one primary key.

Example

```sql
id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
```

---

# Foreign Keys

Every relationship must use foreign keys.

Example

```sql
supplier_id
purchase_order_id
warehouse_id
product_id
```

Use database constraints whenever appropriate.

---

# Audit Columns

Operational tables shall include:

```text
created_at
updated_at
created_by
updated_by
```

When Soft Deletes are enabled:

```text
deleted_at
deleted_by
```

---

# Soft Deletes

Soft Deletes are required for:

- Master Data
- Operational Transactions
- Configuration Records

Avoid soft deleting transactional detail records unless required by business rules.

---

# Timestamps

Always use Laravel timestamps.

Never create custom date columns for creation or modification tracking.

---

# Relationships

Use foreign keys instead of storing names.

Correct

```text
supplier_id
```

Incorrect

```text
supplier_name
```

---

# Cascade Rules

Choose delete behavior carefully.

Recommended defaults:

Master → Details

Cascade

Master → Transactions

Restrict

Reference Tables

Restrict

Never cascade-delete operational history.

---

# Lookup Tables

Use lookup tables instead of hardcoded values whenever the values may change.

Examples

- Product Categories
- Payment Terms
- Countries
- Warehouses
- Units of Measure

---

# Enumerations

Use PHP Enums for fixed application states.

Examples

- Status
- Transaction Type
- Approval State

Avoid storing application logic inside lookup tables.

---

# Indexing

Create indexes for:

- Foreign keys
- Document numbers
- Status
- Dates used in filtering
- Batch numbers
- Frequently searched fields

Avoid indexing every column.

---

# Unique Constraints

Use unique indexes where required.

Examples

- Product Code
- Supplier Code
- Customer Code
- Purchase Order Number
- Manufacturing Order Number

---

# Composite Unique Constraints

Use composite unique indexes when uniqueness depends on multiple columns.

Example

```text
warehouse_id
product_id
batch_number
```

---

# Decimal Values

Never use FLOAT for financial or quantity values.

Use DECIMAL.

Examples

```text
DECIMAL(15,2)
DECIMAL(18,4)
```

---

# Monetary Values

Use DECIMAL.

Examples

Unit Cost

Unit Price

Total Cost

Sales Amount

Tax Amount

---

# Quantity Fields

Use DECIMAL to support fractional quantities.

Examples

Raw Bananas

Cooking Oil

Seasoning

Finished Goods

---

# Status Columns

Store status using readable values or backed enums.

Examples

Draft

Approved

Cancelled

Completed

Rejected

Avoid numeric status codes.

---

# Files

Store only file paths.

Never store binary files in the database.

---

# Attachments

Use a dedicated attachments table when files belong to business transactions.

Example

Purchase Order

↓

Purchase Order Attachment

---

# Business Documents

Separate

Header

↓

Details

Never combine both in one table.

Example

purchase_orders

purchase_order_items

---

# Inventory Transactions

Never update stock directly.

Every inventory change must be recorded as an inventory movement.

Inventory balance is derived from validated movements.

---

# Accounting

Operational tables never store journal entries.

Accounting records belong to the Accounting Integration domain.

---

# Performance

Avoid SELECT *

Load only required columns.

Use eager loading where appropriate.

Paginate large datasets.

---

# Migrations

One migration

One responsibility.

Never modify existing production migrations.

Always create a new migration.

---

# Seeders

Use seeders only for:

- Roles
- Permissions
- Settings
- Units
- Countries
- Default Configuration

Never seed transactional data in production.

---

# Final Rule

The database is the source of truth.

Business logic belongs in Laravel Services, not in the database.