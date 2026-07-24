# ERP Business Glossary

Version: 1.0

---

# Purpose

This glossary defines the official business terminology used throughout the Banana Chips Manufacturing ERP.

All documentation, database design, source code, user interfaces, reports, and AI-generated code shall use these definitions consistently.

Do not introduce alternate terms for the same concept.

---

# General Terms

## ERP

Enterprise Resource Planning.

An integrated business system that manages all operational processes from procurement through reporting.

---

## Business Domain

A logical business area responsible for a specific set of processes.

Examples:

- Procurement
- Inventory
- Manufacturing
- Warehouse
- Sales Fulfillment & Export

---

## Master Data

Business information that changes infrequently and is reused across multiple transactions.

Examples:

- Products
- Warehouses
- Suppliers
- Customers
- Units of Measure

---

## Transaction

A business activity that records an operational event.

Examples:

- Purchase Order
- Goods Receipt
- Manufacturing Order
- Sales Order

---

## Document

A numbered business transaction.

Examples:

PO-2026-000001

MO-2026-000010

SO-2026-000034

---

# Product Terms

## Product

Any item managed by the ERP.

Includes:

- Raw Materials
- Finished Goods
- Packaging Materials
- Consumables

---

## Raw Material

Material consumed during production.

Examples:

- Saba Banana
- Cooking Oil
- Salt
- Sugar
- Flavoring Powder

---

## Packaging Material

Material used for packing finished goods.

Examples:

- Plastic Bag
- Label
- Master Carton
- Tape

---

## Finished Goods

Products ready for sale or export.

Examples:

- Original Banana Chips 100g
- BBQ Banana Chips 100g

---

## Unit of Measure (UOM)

Standard measurement used by products.

Examples:

- Kilogram (kg)
- Gram (g)
- Liter (L)
- Piece (pc)
- Box
- Carton

---

# Procurement Terms

## Purchase Request (PR)

An internal request to purchase materials.

---

## Purchase Order (PO)

A formal order sent to a supplier requesting materials.

---

## Supplier

A company or individual that provides materials or services.

---

## Goods Receipt (GR)

Confirmation that purchased materials have been physically received.

Goods Receipt increases inventory after quality approval.

---

## Supplier Return

The process of returning rejected materials to a supplier.

---

# Inventory Terms

## Inventory

The recorded quantity of stock available within the system.

---

## Inventory Movement

A transaction that changes inventory quantity.

Examples:

- Goods Receipt
- Material Issue
- Material Return
- Shipment
- Adjustment

---

## Stock Balance

Current available inventory quantity.

---

## Reserved Stock

Inventory allocated for a future transaction.

Reserved stock cannot be used elsewhere.

---

## Batch

A group of products manufactured or received together.

Every batch has a unique batch number.

---

## Lot

Equivalent to Batch.

For this ERP, use **Batch** consistently.

---

## FEFO

First Expired, First Out.

Inventory issuing method where products with the earliest expiration date are issued first.

---

# Manufacturing Terms

## Manufacturing Order (MO)

The primary production document.

Authorizes production of finished goods.

---

## Bill of Materials (BOM)

The list of materials required to manufacture one finished product.

---

## Work In Process (WIP)

Materials currently undergoing production but not yet completed.

---

## Production Yield

Percentage of finished product obtained from consumed raw materials.

Formula

Finished Output ÷ Raw Material Input × 100

---

## Production Waste

Material lost during manufacturing.

Examples:

- Banana Peel
- Burnt Chips
- Oil Loss
- Damaged Packaging

---

## Rework

Processing defective products again to meet quality standards.

---

## Scrap

Materials or products that cannot be recovered.

---

# Quality Control Terms

## Incoming Inspection

Quality inspection performed after receiving purchased materials.

---

## In-Process Inspection

Quality inspection performed during production.

---

## Final Inspection

Inspection before finished goods enter warehouse.

---

## Non-Conformance

Failure to meet defined quality standards.

---

## Corrective Action

Action taken to resolve quality problems.

---

# Warehouse Terms

## Put-away

Moving received materials into assigned storage locations.

---

## Picking

Collecting products from storage for production or shipment.

---

## Packing

Preparing products for shipment.

---

## Dispatch

Physical release of products from the warehouse.

---

## Storage Location

The physical location where inventory is stored.

Examples:

Warehouse

↓

Area

↓

Rack

↓

Bin

---

# Sales & Export Terms

## Customer

Organization purchasing finished goods.

---

## Sales Order (SO)

Customer order requesting products.

---

## Export Order

Shipment grouping for international deliveries.

---

## Packing List

Document describing shipment contents.

---

## Commercial Invoice

Commercial document stating products, quantities, and selling prices.

---

## Shipment

Movement of finished goods to customers.

---

# Accounting Terms

## Accounting Event

A financial event generated from an approved business transaction.

---

## Journal Entry

The accounting record created from an accounting event.

---

## Work In Process (WIP)

Temporary inventory account representing unfinished production.

---

## Cost of Goods Sold (COGS)

Cost of inventory sold to customers.

---

## Goods Received Not Yet Invoiced (GRNI)

Temporary liability for goods received before the supplier invoice.

---

# Reporting Terms

## Dashboard

A collection of business metrics displayed visually.

---

## KPI

Key Performance Indicator.

A measurable value used to evaluate business performance.

Examples:

- Production Yield
- Waste Percentage
- Inventory Turnover
- On-Time Delivery

---

# User Roles

## Administrator

Maintains system configuration.

---

## Purchasing Officer

Manages procurement.

---

## Warehouse Staff

Performs warehouse operations.

---

## Production Supervisor

Oversees manufacturing.

---

## Quality Inspector

Performs inspections.

---

## Sales Officer

Manages customer orders.

---

## Export Officer

Coordinates export shipments.

---

## Accounting Officer

Reviews accounting events.

---

# Standard Abbreviations

| Abbreviation | Meaning |
|--------------|---------|
| ERP | Enterprise Resource Planning |
| PR | Purchase Request |
| PO | Purchase Order |
| GR | Goods Receipt |
| MO | Manufacturing Order |
| BOM | Bill of Materials |
| WIP | Work In Process |
| QC | Quality Control |
| UOM | Unit of Measure |
| SO | Sales Order |
| FEFO | First Expired, First Out |
| COGS | Cost of Goods Sold |
| GRNI | Goods Received Not Yet Invoiced |
| KPI | Key Performance Indicator |

---

# Terminology Rules

Always use these official terms throughout the project.

Examples:

✔ Manufacturing Order

✘ Production Order

✔ Goods Receipt

✘ Receiving Voucher

✔ Batch

✘ Lot

✔ Warehouse

✘ Stock Room

✔ Finished Goods

✘ Finished Products

✔ Supplier

✘ Vendor

✔ Customer

✘ Client

If multiple industry terms exist, always use the preferred term defined in this glossary.

---

# Final Rule

This glossary is the authoritative source for ERP terminology.

All documentation, code, database objects, reports, and user interfaces shall follow these definitions consistently.