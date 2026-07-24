---
Title: Procurement Domain
Version: 1.0
Status: Draft
Priority: Critical
Dependencies:
- Administration Domain
Related Domains:
- Inventory
- Manufacturing
- Accounting Integration
---

# Procurement Domain

## 1. Overview

The Procurement Domain manages the acquisition of raw materials, packaging materials, consumables, equipment, and services required for banana chips manufacturing.

Its primary objective is to ensure that the right materials are purchased from approved suppliers at the right quantity, quality, price, and delivery schedule.

Procurement ends once purchased goods have been accepted into inventory.

---

# 2. Business Objectives

The Procurement Domain shall:

- Standardize purchasing procedures.
- Prevent unauthorized purchases.
- Maintain supplier information.
- Track purchase history.
- Ensure complete receiving records.
- Provide inventory traceability.
- Supply accurate purchasing information for Accounting.

---

# 3. Scope

Included

- Supplier Management
- Purchase Requests
- Purchase Orders
- Goods Receiving
- Supplier Returns
- Purchase History

Excluded

- Inventory Adjustments
- Production
- Warehouse Transfers
- Payment Processing
- Accounts Payable

---

# 4. Business Process

The procurement workflow follows the operational needs of a banana chips manufacturing facility.

```text
Department

↓

Purchase Request

↓

Approval

↓

Purchase Order

↓

Supplier Delivery

↓

Goods Receiving

↓

Incoming Quality Inspection

↓

Accepted?
      │
 ┌────┴─────┐
 │          │
Yes        No
 │          │
 ▼          ▼
Inventory   Supplier Return
```

---

# 5. Actors

## Requestor

Initiates requests for required materials.

Examples

- Warehouse Staff
- Production Supervisor
- Quality Control

---

## Purchasing Officer

Responsible for

- Supplier Selection
- Purchase Orders
- Delivery Monitoring

---

## Warehouse Staff

Responsible for

- Receiving
- Quantity Verification

---

## Quality Inspector

Responsible for

Incoming quality inspection.

---

## Procurement Manager

Responsible for

Purchase approval.

---

# 6. Functional Requirements

## Supplier Management

Maintain

- Supplier Code
- Supplier Name
- Address
- Contact Person
- Mobile Number
- Email
- Tax Information
- Payment Terms
- Active Status

The system shall not allow duplicate supplier codes.

---

## Purchase Request

The system shall allow departments to request:

- Raw Bananas
- Cooking Oil
- Salt
- Flavorings
- Sugar
- Packaging Materials
- LPG
- Cleaning Supplies
- Office Supplies
- Equipment

Each Purchase Request shall contain

- Request Number
- Request Date
- Department
- Required Date
- Priority
- Requested By
- Status
- Remarks

Status

- Draft
- Submitted
- Approved
- Rejected
- Converted to PO
- Cancelled

---

## Purchase Order

Purchase Orders shall only be created from approved Purchase Requests.

A Purchase Order shall include

- Supplier
- Delivery Address
- Expected Delivery Date
- Payment Terms
- Currency
- Ordered Items

Status

- Draft
- Approved
- Sent
- Partially Received
- Fully Received
- Closed
- Cancelled

---

## Goods Receiving

Upon supplier delivery

Warehouse personnel shall record

- Purchase Order
- Delivery Receipt
- Supplier Invoice Number
- Date Received
- Warehouse
- Received By

Each received item shall contain

- Quantity Ordered
- Quantity Received
- Unit Cost
- Batch Number (optional)
- Expiry Date (if applicable)

Receiving updates inventory only after successful quality inspection.

---

## Supplier Return

Returned materials shall reference the original Goods Receipt.

Reasons include

- Damaged Packaging
- Spoiled Bananas
- Incorrect Quantity
- Wrong Item
- Failed Quality Inspection

---

# 7. Business Rules

1. Purchase Orders require an approved Purchase Request.

2. Cancelled Purchase Orders cannot be edited.

3. Partial deliveries are allowed.

4. Remaining quantities stay open until fully received or closed.

5. Suppliers cannot exceed ordered quantities without user confirmation.

6. Returned quantities cannot exceed received quantities.

7. Every receiving transaction must reference a Purchase Order.

8. Goods Receipt numbers are system-generated.

9. Supplier records cannot be deleted if transactions exist.

---

# 8. Master Data

Uses

- Suppliers
- Products
- Units of Measure
- Warehouses
- Departments
- Tax Codes
- Currency

---

# 9. Transactions

## Purchase Request

Creates

Purchase Request

No inventory impact.

---

## Purchase Order

Creates

Purchase Order

No inventory impact.

---

## Goods Receipt

Creates

Goods Receipt

Inventory increases after QC acceptance.

---

## Supplier Return

Creates

Supplier Return

Inventory decreases.

---

# 10. Workflow

## Standard Procurement Workflow

```text
Production

↓

Needs Raw Materials

↓

Purchase Request

↓

Department Approval

↓

Purchasing

↓

Supplier

↓

Delivery

↓

Receiving

↓

Quality Inspection

↓

Inventory
```

---

# 11. Approval Process

Purchase Request

Requester

↓

Department Head

↓

Purchasing

↓

Purchase Order

Purchase Order Approval

Purchasing Officer

↓

Procurement Manager

↓

Released to Supplier

Approval thresholds may later be based on purchase amount.

---

# 12. Inventory Impact

Purchase Request

No impact.

Purchase Order

No impact.

Goods Receipt

Increase inventory.

Supplier Return

Decrease inventory.

Rejected items

Stored in Quarantine Warehouse until disposition.

---

# 13. Accounting Impact

Accounting entries are generated by the Accounting Integration Domain.

Typical events include:

Goods Receipt

- Debit Inventory
- Credit Goods Received Not Yet Invoiced (GRNI) or Accounts Payable, depending on accounting policy.

Supplier Return

- Reverse the inventory receipt and related liability.

---

# 14. Reports

Operational Reports

- Purchase Request Summary
- Purchase Order Register
- Outstanding Purchase Orders
- Supplier Purchase History
- Supplier Performance
- Goods Receipt Register
- Supplier Returns Report
- Purchase Lead Time
- Monthly Purchases

---

# 15. Dashboard Widgets

- Pending Purchase Requests
- Pending Approvals
- Open Purchase Orders
- Deliveries Due Today
- Late Deliveries
- Monthly Purchase Value
- Top Suppliers
- Most Purchased Materials

---

# 16. Notifications

Examples

- Purchase Request Submitted
- Purchase Request Approved
- Purchase Order Approved
- Delivery Due Tomorrow
- Partial Delivery Received
- Goods Failed Inspection
- Supplier Return Created

---

# 17. Future Enhancements

- Supplier Portal
- Supplier Performance Scorecards
- Automatic Reorder Suggestions
- Purchase Price Trend Analysis
- Email Purchase Orders
- Barcode Receiving
- QR Code Receiving

---

# 18. Out of Scope

This domain does not include:

- Inventory Adjustments
- Stock Transfers
- Manufacturing Orders
- Production Scheduling
- Export Operations
- Accounts Payable Processing
- Supplier Payments