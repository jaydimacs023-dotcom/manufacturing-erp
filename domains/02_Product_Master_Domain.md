---
Title: Product Master Domain
Version: 1.0
Status: Draft
Priority: Critical

Dependencies:
- Administration

Related Domains:
- Procurement
- Inventory
- Manufacturing
- Quality Control
- Warehouse
- Sales & Export
- Reporting
---

# Product Master Domain

## 1. Overview

The Product Master Domain is the single source of truth for every item managed by the ERP.

Every operational domain references Product Master rather than maintaining its own product information.

The domain centralizes product definitions, units of measure, categories, packaging, specifications, shelf-life information, and product status.

No inventory quantities are stored in this domain.

---

# 2. Business Objectives

The Product Master Domain shall:

- Maintain all products.
- Maintain all raw materials.
- Maintain finished goods.
- Maintain packaging materials.
- Maintain consumables.
- Standardize product information.
- Prevent duplicate products.
- Support manufacturing.
- Support inventory management.
- Support procurement.
- Support sales.
- Support export documentation.

---

# 3. Product Types

The ERP supports:

• Raw Material

Examples

- Saba Banana
- Cooking Oil
- Salt
- Sugar
- Flavoring Powder

---

• Packaging Material

Examples

- Plastic Bag
- Label
- Master Carton
- Tape

---

• Finished Goods

Examples

- Original Banana Chips 100g
- BBQ Banana Chips 100g
- Cheese Banana Chips 200g

---

• Consumables

Examples

- Cleaning Materials
- Gloves
- Hair Nets

---

# 4. Functional Modules

## Product Categories

Examples

- Raw Materials
- Finished Goods
- Packaging
- Consumables

---

## Products

Each product maintains:

- Product Code
- Product Name
- Category
- Description
- Default UOM
- Status
- Shelf Life
- Product Image
- Barcode (future)
- QR Code (future)

---

## Units of Measure

Examples

- kg
- g
- L
- ml
- pc
- pack
- box
- carton

Support unit conversions where applicable.

---

## Product Specifications

Optional specifications include:

- Moisture Content
- Oil Content
- Color
- Thickness
- Flavor
- Export Grade

---

## Packaging Configuration

Examples

1 Carton = 50 Packs

1 Pack = 100 grams

---

## Shelf Life

Applicable for:

- Finished Goods
- Raw Materials

Support expiration tracking.

---

## Product Status

Draft

Active

Inactive

Discontinued

---

# 5. Business Rules

1. Product Code must be unique.

2. Product Name must be unique within its category.

3. Every product belongs to one category.

4. Every product has one default UOM.

5. Only Active products may be used in transactions.

6. Inactive products remain available for historical reporting.

7. Deleting products is prohibited if referenced by transactions.

Use Soft Deletes only when business rules allow.

---

# 6. Relationships

Product

↓

Purchase Order

↓

Inventory

↓

Manufacturing

↓

Quality Inspection

↓

Warehouse

↓

Sales Order

↓

Reporting

---

# 7. Master Data

- Product Categories
- Products
- Units of Measure
- Packaging Types
- Product Specifications

---

# 8. Transactions

None.

This domain manages master data only.

---

# 9. Reports

- Product List
- Active Products
- Inactive Products
- Product Categories
- Shelf Life Report
- Packaging Configuration Report

---

# 10. Future Enhancements

- Barcode Printing
- QR Code Labels
- GS1 Standards
- Product Images
- Product Cost History
- Multi-language Product Names