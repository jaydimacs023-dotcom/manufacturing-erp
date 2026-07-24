# Audit Rules

Version: 1.0

---

# Purpose

This document defines auditing standards for all business activities.

Every significant action shall be traceable.

---

# Audit Principles

- No hidden changes.
- Every important action is recorded.
- Audit history is immutable.
- Users cannot modify audit records.

---

# Auditable Events

Examples

- Create
- Update
- Delete (Soft Delete)
- Restore
- Submit
- Approve
- Reject
- Cancel
- Complete
- Login
- Logout

---

# Audit Information

Each audit record shall include:

- User
- Action
- Module
- Document Number
- Date
- Time
- IP Address (optional)
- Remarks (optional)

---

# Data Changes

When practical, record:

Old Value

↓

New Value

Sensitive fields such as passwords shall never be stored.

---

# Soft Delete

Deleting operational records shall create an audit entry.

---

# Login Activity

Record:

- Successful Login
- Failed Login
- Logout

---

# Report Access

Optional

Record access to sensitive reports.

Examples

- Financial Reports
- Payroll
- Executive Dashboards

---

# Audit Retention

Audit records shall never be deleted during normal operations.

---

# Final Rule

Audit history is evidence.

It exists to explain who performed an action, when it occurred, and what changed.