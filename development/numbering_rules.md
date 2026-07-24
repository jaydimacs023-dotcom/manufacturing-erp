# Document Numbering Rules

Version: 1.0

---

# Purpose

This document defines the official document numbering standards for the Banana Chips Manufacturing ERP.

All business documents shall obtain their document numbers exclusively through the NumberSeriesService.

Document numbers shall never be manually entered by users.

---

# Design Principles

Every business document shall have:

- A unique document number
- A document prefix
- A running sequence
- Automatic generation
- No duplicate numbers

Users shall never modify generated document numbers.

---

# General Format

Document numbers follow this format:

PREFIX-YEAR-SEQUENCE

Example

PO-2026-000001

MO-2026-000125

SO-2026-000031

---

# Format Rules

Prefix

Uppercase letters only.

Year

Four digits.

Sequence

Six digits with leading zeros.

Examples

000001

000250

001025

125489

---

# Number Reset Policy

The running sequence resets every calendar year.

Example

2026

PO-2026-000001

↓

PO-2026-999999

2027

PO-2027-000001

---

# Document Prefixes

## Administration

USR

User Record

ROL

Role

BR

Branch

WH

Warehouse

---

## Product Master

PRD

Product

CAT

Product Category

UOM

Unit of Measure

---

## Business Partner

SUP

Supplier

CUS

Customer

BP

Business Partner

---

## Procurement

PR

Purchase Request

PO

Purchase Order

GR

Goods Receipt

SR

Supplier Return

---

## Inventory

IM

Inventory Movement

IA

Inventory Adjustment

ST

Stock Transfer

---

## Manufacturing

BOM

Bill of Materials

MO

Manufacturing Order

MR

Material Return

WO

Waste Record

---

## Quality Control

IQC

Incoming Quality Inspection

PQC

Process Quality Inspection

FQC

Finished Goods Inspection

CAR

Corrective Action Report

---

## Warehouse

PT

Put-away

PK

Picking

PS

Packing Slip

DSP

Dispatch

---

## Sales Fulfillment & Export

QT

Quotation

SO

Sales Order

EO

Export Order

PL

Packing List

CI

Commercial Invoice

---

## Accounting Integration

AE

Accounting Event

JE

Journal Entry

---

## Reporting

RPT

Generated Report

---

# Sequence Rules

Each document type maintains its own independent sequence.

Example

Purchase Orders

PO-2026-000001

PO-2026-000002

PO-2026-000003

Manufacturing Orders

MO-2026-000001

MO-2026-000002

MO-2026-000003

Sequences never share counters.

---

# Transaction Timing

A document number is generated only when the document is created.

Example

User clicks

Create Purchase Order

↓

System generates

PO-2026-000145

---

# Draft Documents

Draft documents already receive permanent document numbers.

Numbers are never reused even if the draft is cancelled.

Example

PO-2026-000012

Cancelled

↓

PO-2026-000013

Next document

---

# Deleted Documents

Document numbers are never reused.

Deleted or cancelled records retain their original numbers.

---

# Document Revisions

Business documents are not renumbered.

Revisions retain the same document number.

Revision tracking, if implemented, shall use a separate revision field.

Example

PO-2026-000145

Revision

2

---

# Import Rules

Imported historical records shall preserve their original document numbers when possible.

If conflicts exist, the system shall assign new numbers while storing the original reference.

Example

Original Number

PO-2025-000235

Stored As

Legacy Reference Number

---

# Batch Numbers

Batch numbers follow a different format.

Recommended format

BATCH-YYYYMMDD-XXXX

Example

BATCH-20260724-0001

BATCH-20260724-0002

Batch numbers are unique.

---

# Production Lots

Every Manufacturing Order produces one or more batches.

Each batch receives its own batch number.

Example

MO-2026-000021

↓

BATCH-20260724-0003

---

# Shipment Numbers

Dispatch documents

DSP-2026-000031

Export Orders

EO-2026-000014

Commercial Invoice

CI-2026-000018

Packing List

PL-2026-000017

---

# NumberSeriesService

All numbering shall be generated through a centralized service.

Responsibilities

- Generate next document number
- Prevent duplicates
- Handle yearly reset
- Support transactions
- Prevent race conditions
- Log generation history

No module may generate document numbers independently.

---

# Concurrency

Number generation must be atomic.

When multiple users create documents simultaneously:

- Every user receives a unique number
- No duplicates occur
- No skipped numbers due to race conditions

Cancelled documents may create intentional gaps.

---

# Business Rules

1. Document numbers are unique.

2. Document numbers are immutable.

3. Numbers are automatically generated.

4. Numbers cannot be edited.

5. Every document type has its own sequence.

6. Sequences reset yearly.

7. Cancelled documents retain their numbers.

8. Deleted documents retain their numbers.

9. Batch numbers are independent from document numbers.

10. Only NumberSeriesService generates document numbers.

---

# Future Enhancements

The numbering engine should support configurable formats.

Examples

PO-{YYYY}-{000001}

PO-{YY}-{BRANCH}-{000001}

PO-{COMPANY}-{YYYY}-{000001}

MO-{PLANT}-{YYYY}-{000001}

without changing business logic.

---

# Final Rule

Document numbers identify business transactions.

They are permanent, unique, automatically generated, and never reused.