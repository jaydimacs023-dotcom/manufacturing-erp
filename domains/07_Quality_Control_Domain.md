---
Title: Quality Control Domain
Version: 1.0
Status: Draft
Priority: High

Dependencies:
- Administration
- Procurement
- Inventory
- Manufacturing

Related Domains:
- Warehouse
- Accounting Integration
---

# Quality Control Domain

## 1. Overview

The Quality Control (QC) Domain ensures that all raw materials, work-in-process (WIP), and finished goods meet the company's quality standards before they proceed to the next stage of the manufacturing process.

QC is responsible for inspection and quality decisions only.

QC does not own inventory or manufacturing transactions. Instead, its inspection results determine whether materials or products can continue through the production process.

---

# 2. Business Objectives

The Quality Control Domain shall:

- Verify the quality of incoming raw materials.
- Monitor product quality during manufacturing.
- Inspect finished goods before warehousing.
- Record quality test results.
- Maintain complete batch traceability.
- Prevent defective materials or products from entering production or shipment.

---

# 3. Scope

Included

- Incoming Quality Inspection
- In-Process Quality Inspection
- Finished Goods Inspection
- Quality Checklists
- Batch Traceability
- Non-Conformance Recording
- Corrective Actions

Excluded

- Inventory Adjustments
- Warehouse Transfers
- Manufacturing Execution
- Accounting Entries

---

# 4. Business Process

```text
Incoming Materials
        │
        ▼
Incoming QC
        │
        ├── Passed
        │      │
        │      ▼
        │ Raw Material Warehouse
        │
        └── Failed
               │
               ▼
       Quarantine / Supplier Return

Manufacturing
        │
        ▼
In-Process QC
        │
        ├── Passed
        │      │
        │      ▼
        │ Continue Production
        │
        └── Failed
               │
               ▼
       Rework / Scrap

Finished Goods
        │
        ▼
Final QC
        │
        ├── Passed
        │      │
        │      ▼
        │ Finished Goods Warehouse
        │
        └── Failed
               │
               ▼
        Rework / Disposal
```

---

# 5. Actors

## Quality Inspector

Responsible for:

- Performing inspections
- Recording measurements
- Approving or rejecting materials

---

## Quality Supervisor

Responsible for:

- Reviewing failed inspections
- Approving corrective actions
- Monitoring quality trends

---

## Production Supervisor

Responsible for:

- Implementing corrective actions
- Coordinating rework

---

## Warehouse Staff

Responsible for:

- Moving accepted or rejected materials based on QC decisions

---

# 6. Functional Requirements

## 6.1 Incoming Quality Inspection

Performed after receiving materials from suppliers.

Applicable items:

- Raw Bananas
- Cooking Oil
- Flavorings
- Sugar
- Salt
- Packaging Materials

Inspection records include:

- Inspection Number
- Goods Receipt Reference
- Supplier
- Product
- Batch Number
- Inspector
- Inspection Date
- Result
- Remarks

Possible Results:

- Passed
- Failed
- Conditional Acceptance

---

## 6.2 In-Process Quality Inspection

Performed during manufacturing.

Inspection points may include:

- Slice Thickness
- Frying Temperature
- Frying Time
- Oil Quality
- Product Color
- Product Texture
- Seasoning Consistency

Inspection may be performed multiple times during one Manufacturing Order.

---

## 6.3 Finished Goods Inspection

Performed before finished goods are transferred to the Finished Goods Warehouse.

Inspection criteria:

- Product Weight
- Packaging Seal
- Label Accuracy
- Product Appearance
- Taste
- Expiration Date
- Batch Number

Only approved products may proceed to warehousing.

---

## 6.4 Non-Conformance

The system shall record:

- Defect Type
- Quantity Affected
- Severity
- Root Cause
- Recommended Action
- Responsible Department

---

## 6.5 Corrective Actions

For failed inspections, the system shall allow:

- Rework
- Re-inspection
- Disposal
- Supplier Return (incoming materials only)

Corrective actions shall remain linked to the original inspection record.

---

# 7. Business Rules

1. Every Goods Receipt requires Incoming QC before inventory becomes available.

2. Every Manufacturing Order may require one or more In-Process QC inspections.

3. Finished Goods cannot enter the Finished Goods Warehouse without passing Final QC.

4. Failed inspections require a recorded reason.

5. Re-inspected items retain the original inspection history.

6. All inspections must be linked to a batch number.

7. Quality records are read-only after approval.

---

# 8. Master Data

Uses

- Products
- Quality Checklists
- Defect Types
- Inspection Types
- Inspection Standards
- Batch Numbers

---

# 9. Transactions

Incoming Inspection

Creates Quality Inspection Record.

---

In-Process Inspection

Creates Production Quality Record.

---

Finished Goods Inspection

Creates Final Inspection Record.

---

Corrective Action

Creates Corrective Action Record.

---

# 10. Workflow

Goods Receipt

↓

Incoming QC

↓

Accepted?

↓

Raw Material Warehouse

↓

Manufacturing

↓

In-Process QC

↓

Finished Goods

↓

Final QC

↓

Finished Goods Warehouse

---

# 11. Approval Process

Incoming QC

↓

Quality Inspector

↓

Quality Supervisor (optional for failures)

---

Final QC

↓

Quality Inspector

↓

Quality Supervisor

↓

Approved

---

# 12. Inventory Impact

Quality Control does not directly modify inventory.

Inspection results trigger actions in other domains:

- Accepted incoming materials → Inventory receives stock.
- Rejected incoming materials → Procurement handles supplier return.
- Accepted finished goods → Inventory receives finished goods.
- Failed finished goods → Manufacturing handles rework or scrap.

---

# 13. Accounting Impact

No accounting entries originate from QC.

Inventory valuation and financial effects are handled by the Accounting Integration Domain after inventory transactions occur.

---

# 14. Reports

- Incoming Inspection Report
- In-Process Inspection Report
- Final Inspection Report
- Failed Inspection Summary
- Defect Analysis
- Corrective Action Report
- Batch Traceability Report
- Supplier Quality Performance
- Production Quality Performance

---

# 15. Dashboard Widgets

- Pending Inspections
- Passed vs Failed Inspections
- Incoming QC Today
- Final QC Today
- Top Defect Types
- Rework Rate
- Supplier Quality Rating
- Batch Rejections

---

# 16. Notifications

- Inspection Assigned
- Inspection Failed
- Corrective Action Required
- Re-inspection Scheduled
- Final QC Approved

---

# 17. Future Enhancements

- Digital inspection forms
- Image attachments
- Laboratory test integration
- Statistical Process Control (SPC)
- HACCP compliance
- ISO 22000 quality records

---

# 18. Out of Scope

This domain does not include:

- Purchasing
- Inventory Movements
- Warehouse Operations
- Manufacturing Execution
- Sales
- Export
- Accounting Journals