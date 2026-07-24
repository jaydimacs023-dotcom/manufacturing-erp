# Database Naming Conventions

Version: 1.0

---

# General Rules

Use

snake_case

for everything.

Avoid abbreviations unless universally understood.

---

# Table Names

Plural nouns.

Examples

users

products

suppliers

customers

warehouses

purchase_orders

purchase_order_items

manufacturing_orders

inventory_movements

sales_orders

---

# Pivot Tables

Alphabetical order.

Examples

product_supplier

role_permission

user_role

---

# Column Names

snake_case

Examples

purchase_order_number

received_date

approved_by

batch_number

production_date

---

# Foreign Keys

Always end with

_id

Examples

supplier_id

customer_id

warehouse_id

product_id

user_id

---

# Boolean Fields

Use readable prefixes.

Examples

is_active

is_default

is_locked

is_taxable

has_expiration

---

# Date Fields

End with

_at

for timestamps.

Examples

approved_at

received_at

completed_at

cancelled_at

For business dates:

order_date

delivery_date

production_date

expiration_date

---

# Quantity Fields

Use descriptive names.

Examples

ordered_quantity

issued_quantity

received_quantity

available_quantity

reserved_quantity

waste_quantity

---

# Monetary Fields

Examples

unit_cost

unit_price

subtotal

discount_amount

tax_amount

total_amount

---

# Percentage Fields

End with

_percent

Examples

yield_percent

waste_percent

tax_percent

discount_percent

---

# Status Fields

Use

status

Avoid

status_code

status_id

when using application enums.

---

# Numbering Fields

Use

*_number

Examples

purchase_order_number

manufacturing_order_number

sales_order_number

invoice_number

batch_number

---

# Reference Fields

External references

*_reference

Examples

supplier_reference

customer_reference

bank_reference

---

# Attachment Fields

Store paths.

Examples

attachment_path

image_path

document_path

---

# Audit Fields

created_by

updated_by

deleted_by

approved_by

reviewed_by

---

# Soft Delete

deleted_at

deleted_by

---

# Index Names

Laravel defaults are acceptable.

For custom indexes:

idx_products_code

idx_inventory_batch

idx_sales_order_date

---

# Foreign Key Names

Laravel defaults are acceptable.

If custom:

fk_purchase_orders_supplier

fk_inventory_product

---

# Constraint Names

Meaningful names.

Examples

unique_product_code

unique_purchase_order_number

unique_batch_per_product

---

# View Names

Prefix with

vw_

Examples

vw_inventory_balance

vw_production_summary

vw_sales_summary

---

# Stored Procedures

Avoid unless absolutely necessary.

Business logic belongs in Laravel.

---

# Final Rule

Database names should be readable without requiring documentation.