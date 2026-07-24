# AI Bootstrap Instructions

Version: 1.0

---

# Purpose

This document defines how an AI assistant shall initialize itself before performing any analysis, design, or implementation for the Banana Chips Manufacturing ERP.

This document is part of the project documentation and shall be treated as an instruction manual for AI-assisted development.

---

# Initialization Sequence

Before responding to any implementation request, read the following documents in order.

## Foundation

1. 00_README.md
2. 00_SYSTEM.md
3. 00_AGENTS.md
4. 00_DOMAIN_INDEX.md
5. 00_DECISION_LOG.md

---

## Development Standards

6. development/coding_rules.md
7. development/laravel_rules.md
8. development/database_rules.md
9. development/database_naming.md
10. development/ui_rules.md
11. development/glossary.md
12. development/numbering_rules.md
13. development/workflow_rules.md
14. development/approval_rules.md
15. development/audit_rules.md
16. development/security_rules.md
17. development/implementation_order.md

---

# Domain Loading Rules

Do NOT read every domain document.

Read only the domain being implemented.

Read related domains only when business dependencies require them.

Example

Manufacturing

Read

- 06_Manufacturing_Domain.md

If necessary

- 02_Product_Master_Domain.md
- 05_Inventory_Domain.md
- 07_Quality_Control_Domain.md
- 10_Accounting_Integration_Domain.md

Do not read unrelated domains.

---

# Development Principles

The AI shall:

- Follow the documentation as the single source of truth.
- Prefer existing services over creating duplicate logic.
- Keep controllers thin.
- Place business rules in Services.
- Use Form Requests for validation.
- Use Policies for authorization.
- Follow Laravel conventions.
- Follow Clean Architecture.
- Follow Domain-Driven Design.
- Follow Feature-Sliced Design.
- Follow Modular Monolith architecture.

---

# Implementation Strategy

Unless instructed otherwise, implement features in the following order.

1. Migration
2. Model
3. Relationships
4. Repository
5. Service
6. Form Request
7. Policy
8. Controller
9. Routes
10. Blade Views
11. Tests
12. Documentation Update

Generate only one step at a time unless explicitly requested.

---

# Documentation Rules

Do not duplicate business rules.

Reference existing documentation whenever possible.

If documentation conflicts, follow this priority:

1. Decision Log
2. Domain Document
3. Development Rules
4. README

If uncertainty remains, request clarification before implementing.

---

# Response Rules

Do not generate unnecessary files.

Do not introduce new architecture without justification.

Do not change database design without checking related domains.

Do not invent manufacturing workflows.

Base manufacturing workflows on actual banana chips production and export processes documented by the project.

---

# Final Rule

The goal is to build a maintainable, production-ready ERP for banana chips manufacturing using Laravel 12, Blade, Tailwind CSS, Alpine.js, and MySQL.

The AI shall prioritize consistency, simplicity, and adherence to the documented architecture over introducing unnecessary complexity.