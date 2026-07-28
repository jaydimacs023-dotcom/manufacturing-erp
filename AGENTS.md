# Repository Guidelines

## Project Structure & Module Organization

This is a Laravel 13 manufacturing ERP. Domain code lives in `app/Modules/<Domain>/`, typically separated into models, repositories, services, requests, policies, and controllers. Shared application services and repositories remain in `app/Services/` and `app/Repositories/`. Blade pages and reusable components are under `resources/views/`; browser assets enter through `resources/css/app.css` and `resources/js/app.js`. Routes are defined in `routes/`.

Database migrations are grouped by business domain in `database/migrations/`; factories and seeders sit beside them. PHPUnit tests are split between `tests/Unit/` and `tests/Feature/`. Before changing a feature, consult `docs/00_DOMAIN_INDEX.md`, then read only the owning file in `domains/` and any documented dependencies. Mandatory implementation rules are in `development/`.

## Build, Test, and Development Commands

- `composer setup` installs PHP and JavaScript dependencies, prepares `.env`, generates the key, migrates, and builds assets.
- `composer dev` runs the Laravel server, queue listener, log viewer, and Vite watcher together.
- `npm run dev` runs only the Vite development server.
- `npm run build` creates production frontend assets.
- `composer test` clears cached configuration and runs the PHPUnit suite.
- `php artisan test --filter=AuthenticationTest` runs one test class or matching method.
- `vendor/bin/pint` formats PHP using Laravel Pint.

## Coding Style & Naming Conventions

Follow `.editorconfig`: UTF-8, LF endings, four-space indentation, and two spaces for YAML. Use PSR-4 namespaces and Laravel conventions. Classes use `PascalCase`, variables use `camelCase`, and database tables and columns use `snake_case`. Begin action methods with verbs, such as `approvePurchaseOrder()`.

Keep business logic in the owning domain, with controllers delegating through services and repositories. Use policies for authorization, server-side request validation, enums instead of magic status values, and `DB::transaction()` for business transactions. Comments should explain why, not restate what the code does.

## Testing Guidelines

PHPUnit 12 uses `tests/Unit` and `tests/Feature`; test files end in `Test.php`. Tests run against in-memory SQLite with synchronous queues and array-backed cache, mail, and sessions. Add feature tests for HTTP, authorization, and workflow behavior; use unit tests for isolated services or rules. No minimum coverage threshold is configured.

## Commit & Pull Request Guidelines

Recent history contains mostly `.` placeholder subjects and one initial commit, so no reliable commit convention exists. Use concise imperative subjects that identify the affected domain, for example `Add approval flow for purchase orders`. No pull request template is present; include the affected domain, migration or configuration impact, test evidence, linked issue, and screenshots for Blade UI changes.
