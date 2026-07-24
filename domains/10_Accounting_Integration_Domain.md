---
Title: Accounting Integration Domain
Version: 1.0
Status: Draft
Priority: Critical

Dependencies:
- Procurement
- Inventory
- Manufacturing
- Sales Fulfillment & Export

Related Domains:
- Reporting
---

# Accounting Integration Domain

## 1. Overview

The Accounting Integration Domain serves as the bridge between operational transactions and the Accounting System.

It does not perform bookkeeping or maintain the General Ledger.

Its responsibility is to translate approved operational transactions into accounting events that are processed by the Accounting Module.

This approach ensures that financial records always originate from validated business transactions.

---

# 2. Business Objectives

The Accounting Integration Domain shall:

- Automatically generate accounting events.
- Eliminate manual journal preparation.
- Ensure accounting reflects operational transactions.
- Maintain complete financial traceability.
- Prevent duplicate postings.
- Support reposting when accounting periods are reopened.

---

# 3. Scope

Included

- Accounting Event Generation
- Journal Mapping
- Account Mapping
- Posting Queue
- Posting Status
- Financial Traceability
- Reposting

Excluded

- General Ledger
- Accounts Payable
- Accounts Receivable
- Bank Reconciliation
- Financial Statements
- Budgeting
- Tax Filing

---

# 4. Business Process

```text
Business Transaction

↓

Transaction Approved

↓

Accounting Event Created

↓

Posting Queue

↓

Accounting Module

↓

Journal Entry

↓

Posted
```

---

# 5. Actors

## Operational User

Creates operational transactions.

Examples

- Purchasing Officer
- Warehouse Staff
- Production Supervisor
- Sales Officer

---

## Accounting Officer

Responsible for

- Reviewing posting queue
- Resolving posting errors
- Reposting transactions

---

## Finance Manager

Responsible for

- Account Mapping
- Posting Policies

---

# 6. Functional Requirements

## 6.1 Chart of Accounts Mapping

Every transaction type shall be mapped to accounting accounts.

Examples

Goods Receipt

Inventory

Goods Received Not Yet Invoiced (GRNI)

---

Material Issue

Work In Process

Raw Material Inventory

---

Finished Goods Receipt

Finished Goods Inventory

Work In Process

---

Shipment

Cost of Goods Sold

Finished Goods Inventory

---

Sales Invoice

Accounts Receivable

Sales Revenue

---

## 6.2 Accounting Events

The system shall generate accounting events only after transaction approval.

Each event records

- Event Number
- Transaction Type
- Transaction Number
- Posting Date
- Branch
- Status
- Source Module

Status

- Pending
- Posted
- Failed
- Cancelled
- Reposted

---

## 6.3 Posting Queue

All accounting events enter a posting queue.

The queue records

- Queue Number
- Transaction
- Status
- Retry Count
- Error Message

---

## 6.4 Journal Mapping

Each business transaction has predefined journal templates.

Example

Goods Receipt

Debit Inventory

Credit GRNI

---

Shipment

Debit Cost of Goods Sold

Credit Finished Goods Inventory

---

Sales Invoice

Debit Accounts Receivable

Credit Sales Revenue

---

## 6.5 Reposting

Authorized users may repost failed accounting events.

Original accounting history shall remain intact.

---

## 6.6 Posting Validation

Before posting, verify

- Chart of Accounts exists.
- Posting Period is open.
- Currency is valid.
- Branch is valid.
- Transaction is approved.
- Event has not already been posted.

---

# 7. Business Rules

1. Only approved transactions generate accounting events.

2. One transaction creates one accounting event.

3. Accounting events cannot be edited.

4. Failed events remain in the posting queue.

5. Posted events cannot be reposted unless reversed.

6. Every accounting event references its originating transaction.

7. Duplicate postings are not permitted.

8. Closed accounting periods reject new postings.

---

# 8. Master Data

Uses

- Chart of Accounts
- Fiscal Periods
- Branches
- Currency
- Journal Templates
- Transaction Types

---

# 9. Transactions

Goods Receipt Event

Creates inventory accounting event.

---

Supplier Return Event

Creates reverse inventory event.

---

Material Issue Event

Creates Work In Process accounting event.

---

Production Completion Event

Creates Finished Goods accounting event.

---

Shipment Event

Creates Cost of Goods Sold accounting event.

---

Sales Invoice Event

Creates Revenue accounting event.

---

# 10. Workflow

Business Transaction

↓

Approved

↓

Accounting Event

↓

Posting Queue

↓

Validation

↓

Accounting Module

↓

Journal Entry Posted

---

# 11. Approval Process

Operational approval occurs in the originating domain.

Accounting Integration does not perform business approvals.

Posting failures require review by Accounting.

---

# 12. Inventory Impact

None.

Inventory movements are completed before accounting events are generated.

---

# 13. Accounting Impact

The following events typically generate journals.

## Goods Receipt

Debit Raw Material Inventory

Credit Goods Received Not Yet Invoiced (GRNI)

---

## Supplier Return

Debit GRNI

Credit Raw Material Inventory

---

## Material Issue

Debit Work In Process (WIP)

Credit Raw Material Inventory

---

## Finished Goods Receipt

Debit Finished Goods Inventory

Credit Work In Process (WIP)

---

## Inventory Adjustment

Increase

Debit Inventory

Credit Inventory Gain

Decrease

Debit Inventory Loss

Credit Inventory

---

## Shipment

Debit Cost of Goods Sold

Credit Finished Goods Inventory

---

## Sales Invoice

Debit Accounts Receivable

Credit Sales Revenue

---

## Credit Memo

Debit Sales Returns

Credit Accounts Receivable

---

## Debit Memo

Debit Accounts Receivable

Credit Sales Adjustment

---

# 14. Reports

- Accounting Event Register
- Posting Queue
- Failed Posting Report
- Posting Audit Trail
- Transaction Traceability
- Journal Mapping Report

---

# 15. Dashboard Widgets

- Pending Accounting Events
- Failed Postings
- Posted Today
- Posting Queue Size
- Journal Errors
- Reposting Requests

---

# 16. Notifications

- Posting Successful
- Posting Failed
- Closed Period
- Missing Account Mapping
- Queue Retry Required

---

# 17. Future Enhancements

- Integration with ERP Accounting
- Integration with QuickBooks
- Integration with SAP
- Integration with Xero
- Multi-currency Posting
- Consolidated Financial Posting

---

# 18. Out of Scope

This domain does not include:

- General Ledger
- Accounts Payable Processing
- Accounts Receivable Collections
- Cash Receipts
- Cash Disbursements
- Bank Reconciliation
- Financial Statements
- Tax Computation
- Payroll