---
Title: Sales Fulfillment & Export Domain
Version: 1.0
Status: Draft
Priority: High

Dependencies:
- Administration
- Inventory
- Warehouse

Related Domains:
- Manufacturing
- Accounting Integration
---

# Sales Fulfillment & Export Domain

## 1. Overview

The Sales Fulfillment & Export Domain manages the complete customer order lifecycle, from order receipt through export shipment.

Its purpose is to ensure that customer orders are fulfilled accurately, export requirements are met, and shipments are completed on schedule.

This domain owns commercial transactions.

Physical warehouse operations remain the responsibility of the Warehouse Domain.

---

# 2. Business Objectives

The Sales Fulfillment & Export Domain shall:

- Manage customer information.
- Record customer orders.
- Reserve finished goods.
- Plan shipments.
- Generate export documents.
- Track shipment status.
- Maintain complete order history.

---

# 3. Scope

Included

- Customer Management
- Sales Quotations (Optional)
- Sales Orders
- Order Allocation
- Export Orders
- Packing Lists
- Commercial Invoices
- Shipping Instructions
- Container Planning
- Shipment Tracking

Excluded

- Warehouse Picking
- Physical Packing
- Inventory Valuation
- Accounts Receivable
- General Ledger

---

# 4. Business Process

```text
Customer Inquiry
        │
        ▼
Quotation (Optional)
        │
        ▼
Sales Order
        │
        ▼
Inventory Availability Check
        │
        ▼
Stock Allocation
        │
        ▼
Export Order
        │
        ▼
Packing List
        │
        ▼
Commercial Invoice
        │
        ▼
Warehouse Dispatch
        │
        ▼
Shipment
```

---

# 5. Actors

## Sales Officer

Responsible for:

- Customer management
- Sales orders
- Order monitoring

---

## Export Officer

Responsible for:

- Export documentation
- Shipment scheduling
- Coordination with freight forwarders

---

## Warehouse Supervisor

Responsible for:

- Confirming shipment readiness

---

## Customer

Receives finished products.

---

# 6. Functional Requirements

## 6.1 Customer Management

Maintain:

- Customer Code
- Customer Name
- Address
- Country
- Contact Person
- Contact Number
- Email
- Payment Terms
- Currency
- Active Status

---

## 6.2 Sales Order

Each Sales Order shall contain:

- Sales Order Number
- Customer
- Order Date
- Delivery Date
- Currency
- Products
- Ordered Quantity
- Selling Price
- Status

Status:

- Draft
- Confirmed
- Allocated
- Ready for Shipment
- Shipped
- Closed
- Cancelled

---

## 6.3 Inventory Availability

The system shall verify:

- Available Stock
- Reserved Stock
- Pending Production

If inventory is insufficient, the order remains pending until stock becomes available.

---

## 6.4 Stock Allocation

Upon confirmation, finished goods may be reserved for the Sales Order.

Reserved inventory cannot be allocated to another order.

---

## 6.5 Export Order

The Export Order groups one or more Sales Orders for shipment.

Each Export Order includes:

- Export Order Number
- Destination Country
- Customer
- Port of Loading
- Port of Destination
- Vessel (optional)
- ETD (Estimated Time of Departure)
- ETA (Estimated Time of Arrival)
- Status

---

## 6.6 Packing List

The system shall generate a Packing List containing:

- Product
- Batch Number
- Quantity
- Number of Cartons
- Net Weight
- Gross Weight

---

## 6.7 Commercial Invoice

Generate:

- Invoice Number
- Customer
- Product Details
- Quantity
- Unit Price
- Total Amount
- Currency

Financial posting is handled by the Accounting Integration Domain.

---

## 6.8 Shipment Tracking

Track shipment stages:

- Planned
- Ready
- Loaded
- Dispatched
- In Transit
- Delivered

---

# 7. Business Rules

1. Only available finished goods may be allocated.

2. Orders cannot be shipped without stock allocation.

3. Every shipment requires a Packing List.

4. Commercial Invoices reference approved Sales Orders.

5. Cancelled Sales Orders release reserved inventory.

6. Export Orders may combine multiple Sales Orders for the same destination.

7. Batch numbers shall be traceable for every exported product.

---

# 8. Master Data

Uses

- Customers
- Products
- Countries
- Ports
- Shipping Terms
- Currencies

---

# 9. Transactions

Sales Order

Creates customer demand.

---

Stock Allocation

Reserves inventory.

---

Export Order

Creates shipment plan.

---

Packing List

Creates shipment document.

---

Commercial Invoice

Creates billing document.

---

Shipment Confirmation

Completes customer fulfillment.

---

# 10. Workflow

Customer

↓

Sales Order

↓

Inventory Check

↓

Stock Allocation

↓

Export Order

↓

Packing List

↓

Warehouse Dispatch

↓

Shipment

↓

Order Closed

---

# 11. Approval Process

Sales Order (optional)

↓

Sales Manager

↓

Confirmed

---

Export Order

↓

Export Manager

↓

Shipment Authorized

---

# 12. Inventory Impact

Sales Orders do not reduce inventory.

Stock Allocation reserves inventory.

Warehouse Dispatch triggers inventory deduction through the Inventory Domain.

---

# 13. Accounting Impact

Accounting entries are generated by the Accounting Integration Domain.

Typical events:

Commercial Invoice

- Debit Accounts Receivable
- Credit Sales Revenue

Shipment

- Debit Cost of Goods Sold
- Credit Finished Goods Inventory

---

# 14. Reports

- Sales Order Register
- Open Orders
- Customer Order History
- Export Order Register
- Shipment Schedule
- Commercial Invoice Register
- Export by Country
- Product Sales Summary
- Customer Sales Summary

---

# 15. Dashboard Widgets

- Open Sales Orders
- Orders Awaiting Stock
- Export Shipments This Week
- Sales This Month
- Top Customers
- Top Export Destinations
- Pending Dispatches

---

# 16. Notifications

- New Sales Order
- Stock Allocated
- Shipment Scheduled
- Shipment Dispatched
- Export Documents Ready

---

# 17. Future Enhancements

- Customer Portal
- Online Order Entry
- Freight Cost Tracking
- Container Optimization
- EDI Integration
- Shipping API Integration

---

# 18. Out of Scope

This domain does not include:

- Warehouse Picking
- Inventory Adjustments
- Manufacturing
- Accounts Receivable Collections
- General Ledger
- Purchasing