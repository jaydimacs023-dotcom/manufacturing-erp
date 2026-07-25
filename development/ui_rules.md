# UI Rules

Version: 1.0

---

# Design Philosophy

The ERP is designed for daily operational use.

Priority

Speed

↓

Readability

↓

Consistency

↓

Aesthetics

---

# Theme

Modern

Clean

Professional

Minimal

No unnecessary animations.

---

# Color Palette

Primary

Blue

Secondary

Gray

Success

Green

Warning

Amber

Danger

Red

Background

Light Gray

Cards

White

---

# Typography

Font

Inter

Headings

Bold

Body

Regular

Avoid decorative fonts.

---

# Layout

Top Navigation

Header

↓

Sidebar

↓

Content

↓

Footer (optional)

---

# Sidebar

Grouped by domains.

Never exceed two levels.

Example

Procurement

- Purchase Requests
- Purchase Orders

Manufacturing

- Manufacturing Orders
- Bill of Materials

Inventory

- Stock Inquiry
- Stock Movements

---

# Forms

Label above input.

Required fields marked.

Validation messages below field.

Large Save button.

Cancel button always available.

---

# Tables

Default columns

Actions

Document Number

Date

Status

Created By

Updated At

Use pagination.

Support search.

Support filters.

Support export.

---

# Status Badges

Draft

Gray

Approved

Green

Pending

Amber

Rejected

Red

Cancelled

Dark Gray

Completed

Blue

---

# Buttons

Primary

Solid Blue

Secondary

Gray

Danger

Red

Never place more than one primary button per screen.

---

# Modals

Use only for

Confirmation

Small forms

Warnings

Large forms should use dedicated pages.

---

# Dashboard

Each role has its own dashboard.

Widgets should display

Count

Trend

Status

Quick Action

Recent Activity

---

# Notifications

Top-right toast notifications.

Types

Success

Warning

Error

Information

---

# Icons

Use Lucide Icons.

Maintain consistency.

Do not mix icon libraries.

---

# Responsive Design

Desktop first.

Tablet supported.

Mobile

Read-only where practical.

Complex ERP forms are optimized for desktop usage.

---

# Accessibility

Sufficient color contrast.

Keyboard navigation.

Visible focus states.

Descriptive labels.

---

# Loading States

Every asynchronous action must display

Loading spinner

or

Skeleton loader

---

# Empty States

Every empty table should display

Illustration

Short explanation

Primary action button

Example

"No Purchase Orders found."

[Create Purchase Order]

---
---

# Searchable Selection Components

## Philosophy

The ERP shall prioritize speed and efficiency for daily users.

Whenever a form requires selecting data from a potentially large dataset, the system shall use a searchable lookup component instead of a standard HTML select element.

---

# Standard Lookup Component

Every lookup field shall provide:

- Search while typing
- Keyboard navigation
- Mouse selection
- Clear selection
- Loading indicator
- No page reload
- Server-side search
- Pagination for large datasets

---

# User Interaction

Example

Product

[____________________]

User types

ban

↓

System immediately displays

• Banana Chips Original 100g
• Banana Chips BBQ 100g
• Banana Chips Cheese 100g
• Banana Saba Raw

↓

User selects one item

↓

Store the selected Product ID

Display the Product Name

---

# Search Behavior

The component shall begin searching after:

Minimum

2 characters

Debounce

300 milliseconds

Server-side filtering

Required

---

# Search Fields

Products

- Product Code
- Product Name
- Barcode (future)

Suppliers

- Supplier Code
- Supplier Name

Customers

- Customer Code
- Customer Name

Warehouse

- Warehouse Code
- Warehouse Name

Bill of Materials

- BOM Number
- Product Name

Manufacturing Orders

- MO Number

Purchase Orders

- PO Number

Sales Orders

- SO Number

Batch

- Batch Number

---

# Search Results

Display useful information.

Example

Product

--------------------------------------

P000125

Banana Chips Original 100g

Available

2,540 packs

--------------------------------------

P000126

Banana Chips BBQ 100g

Available

890 packs

--------------------------------------

Do not display only the product name.

---

# Performance

Always perform server-side searching.

Never preload thousands of records into the browser.

Avoid loading all products during page initialization.

---

# Selected Item

After selection

Display

Product Code

Product Name

Unit of Measure

Current Stock (when applicable)

Do not expose database IDs.

---

# Keyboard Shortcuts

Recommended

↓ Move Down

↑ Move Up

Enter Select

Esc Close

Tab Next Field

---

# Reusable Component

The ERP shall provide one reusable lookup component.

Examples

<x-searchable-select>

or

<x-lookup-field>

The component shall be configurable.

Example

<x-searchable-select
    source="products"
    value="product_id"
/>

The same component shall support:

- Products
- Suppliers
- Customers
- Warehouses
- Employees
- Manufacturing Orders
- Purchase Orders
- Sales Orders
- Batches

without duplication.

---

# Implementation Rules

Search logic belongs in:

LookupService

Repository

Controller

Blade only renders results.

---

# Accessibility

The component shall support:

- Keyboard navigation
- Screen readers
- Clear focus indicators

---

# Final Rule

Large datasets shall never use a traditional HTML select element.

All master data selection shall use the standardized Searchable Lookup Component.

# Error States

Errors should explain

What happened

Why

How to resolve it

Avoid technical jargon for end users.

---

# Consistency Rules

Use the same

Buttons

Tables

Forms

Cards

Filters

Status badges

Empty Fallback

Across every domain.

---

# Final Rule

Every screen should allow a new employee to understand its purpose within a few minutes, without requiring extensive training.