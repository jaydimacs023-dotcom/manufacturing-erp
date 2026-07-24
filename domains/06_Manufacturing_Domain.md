---
Title: Manufacturing Domain
Version: 1.0
Status: Draft
Priority: Critical
Dependencies:
- Administration
- Procurement
- Inventory

Related Domains:
- Quality Control
- Warehouse
- Accounting Integration
---

# Manufacturing Domain

## 1. Overview

The Manufacturing Domain is the core of the Banana Chips Manufacturing ERP.

Its responsibility is to transform raw materials into finished products while maintaining complete traceability of materials, production batches, labor, waste, yield, and production costs.

Every production activity begins with a Manufacturing Order (MO).

The Manufacturing Order serves as the central transaction that connects inventory, quality control, warehouse, and accounting.

---

# 2. Business Objectives

The Manufacturing Domain shall:

- Plan production.
- Convert raw materials into finished products.
- Track material consumption.
- Monitor production progress.
- Record production yield.
- Record production waste.
- Produce finished goods.
- Maintain complete batch traceability.
- Supply production information to Accounting.

---

# 3. Scope

Included

- Bill of Materials (BOM)
- Production Planning
- Manufacturing Orders
- Material Issuance
- Production Execution
- Production Output
- Yield Monitoring
- Waste Monitoring
- Production Completion

Excluded

- Procurement
- Inventory Adjustments
- Warehouse Transfers
- Export
- Accounting Journals

---

# 4. Business Process

The manufacturing process follows the actual banana chips production flow.

```text
Production Planning
        │
        ▼
Manufacturing Order
        │
        ▼
Reserve Raw Materials
        │
        ▼
Issue Materials
        │
        ▼
Peeling
        │
        ▼
Slicing
        │
        ▼
Washing
        │
        ▼
Frying
        │
        ▼
Seasoning
        │
        ▼
Cooling
        │
        ▼
Packaging
        │
        ▼
Finished Goods Inspection
        │
        ▼
Receive Finished Goods
        │
        ▼
Manufacturing Complete
```

---

# 5. Actors

## Production Planner

Responsible for

- Production Schedule
- Manufacturing Orders

---

## Production Supervisor

Responsible for

- Starting Production
- Supervising Operations
- Recording Production

---

## Production Operator

Responsible for

- Executing production activities

---

## Warehouse Staff

Responsible for

- Material Issuance
- Finished Goods Receiving

---

## Quality Inspector

Responsible for

- Production Quality Inspection

---

# 6. Functional Requirements

## 6.1 Bill of Materials (BOM)

Defines the standard materials required to produce one finished product.

Example

Banana Chips (100 g)

- Raw Banana
- Cooking Oil
- Flavoring
- Packaging Bag
- Label

Each BOM includes:

- BOM Number
- Product
- Version
- Effective Date
- Status
- Material List
- Standard Quantities

Only one active BOM may exist for a product at a time.

---

## 6.2 Production Planning

Production may be planned:

- Daily
- Weekly
- Monthly

Planning considers:

- Customer Orders
- Export Orders
- Finished Goods Stock
- Available Raw Materials

---

## 6.3 Manufacturing Order

The Manufacturing Order (MO) is the primary production document.

Each MO contains:

- MO Number
- Product
- Planned Quantity
- Planned Start Date
- Planned End Date
- Warehouse
- BOM Version
- Status

Status

- Draft
- Planned
- Released
- In Progress
- Quality Inspection
- Completed
- Cancelled

---

## 6.4 Material Reservation

When an MO is released, the system reserves inventory.

Reserved inventory cannot be used by another MO.

---

## 6.5 Material Issuance

Warehouse issues materials to Production.

Issued materials include:

- Raw Bananas
- Cooking Oil
- Flavoring
- Packaging Materials

Inventory decreases when materials are issued.

---

## 6.6 Production Execution

Production stages:

1. Peeling
2. Slicing
3. Washing
4. Frying
5. Seasoning
6. Cooling
7. Packaging

Each stage may record:

- Start Time
- End Time
- Operator
- Remarks

---

## 6.7 Production Output

Production records:

- Finished Quantity
- Rejected Quantity
- Waste Quantity

Finished goods are received into inventory only after QC approval.

---

## 6.8 Yield Monitoring

Yield is calculated as:

Finished Product Quantity ÷ Raw Material Quantity

Example

500 kg Raw Banana

↓

410 kg Finished Product

Yield = 82%

Yield history shall be maintained.

---

## 6.9 Waste Monitoring

The system records waste generated during production.

Examples

- Banana Peels
- Burnt Chips
- Oil Loss
- Rejected Product
- Packaging Damage

Each waste entry records:

- Waste Type
- Quantity
- Reason
- Responsible Production Batch

---

## 6.10 Production Completion

Production is completed only when:

- All materials have been issued.
- QC has approved the finished goods.
- Finished goods have been received into inventory.

---

# 7. Business Rules

1. Manufacturing Orders require an approved BOM.

2. Manufacturing cannot begin without available inventory.

3. Materials cannot exceed reserved quantities without authorization.

4. Finished goods cannot be received before QC approval.

5. Every MO must reference one BOM.

6. Every finished product must have a production batch number.

7. Yield shall be automatically calculated.

8. Waste shall always be recorded with a reason.

9. Cancelled Manufacturing Orders cannot be restarted.

10. Every production activity shall be traceable.

---

# 8. Master Data

Uses

- Products
- Bill of Materials
- Warehouses
- Units of Measure
- Production Batch Types

---

# 9. Transactions

Manufacturing Order

Creates production transaction.

No inventory movement.

---

Material Issue

Consumes inventory.

---

Material Return

Returns unused materials.

---

Production Output

Creates finished goods.

---

Waste Recording

Records production losses.

---

Production Completion

Closes Manufacturing Order.

---

# 10. Workflow

Production Planning

↓

Manufacturing Order

↓

Material Reservation

↓

Material Issue

↓

Production

↓

Quality Inspection

↓

Finished Goods Receipt

↓

Close Manufacturing Order

---

# 11. Approval Process

Production Plan

↓

Production Manager

↓

Approved

↓

Manufacturing Order Released

Production Completion requires QC approval.

---

# 12. Inventory Impact

Material Issue

↓

Decrease Raw Materials

Production Completion

↓

Increase Finished Goods

Material Return

↓

Increase Raw Materials

Waste

↓

Decrease Inventory

---

# 13. Accounting Impact

Accounting entries are generated by the Accounting Integration Domain.

Typical manufacturing events:

Material Issue

- Debit Work in Process (WIP)
- Credit Raw Materials Inventory

Finished Goods Receipt

- Debit Finished Goods Inventory
- Credit Work in Process (WIP)

Production Waste

- Debit Manufacturing Variance / Waste
- Credit Work in Process or Inventory

---

# 14. Reports

Production Reports

- Manufacturing Order Register
- Production Schedule
- Daily Production Summary
- Material Consumption
- Yield Analysis
- Waste Analysis
- Production Batch History
- Finished Goods Output
- Production Efficiency

---

# 15. Dashboard Widgets

- Manufacturing Orders Today
- Production Progress
- Current Yield %
- Waste %
- Materials Awaiting Issue
- Finished Goods Today
- Production Efficiency
- Production by Product

---

# 16. Notifications

- Manufacturing Order Released
- Materials Ready for Issue
- Production Started
- QC Required
- Manufacturing Completed
- Low Yield Alert
- High Waste Alert

---

# 17. Future Enhancements

- Machine Integration
- Production Scheduling Optimization
- Barcode Production Tracking
- IoT Sensors
- Mobile Production Monitoring
- OEE (Overall Equipment Effectiveness)

---

# 18. Out of Scope

This domain does not include:

- Supplier Purchasing
- Warehouse Transfers
- Sales Orders
- Export Documents
- General Ledger Posting