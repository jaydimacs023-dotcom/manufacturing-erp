# Welcome Page Replacement Plan

## Information Gathered

- **App Name**: Banana Chips Manufacturing System (Laravel-based ERP)
- **Current welcome.blade.php**: Default Laravel welcome page with generic Laravel branding/content
- **System Design System**:
  - Dark emerald/teal theme (`--color-sidebar-bg: #082c22`, `--color-primary-container: #02462f`)
  - Background gradients using emerald-900 to teal-800
  - Brand colors: emerald, teal
  - Font: Figtree
  - Login page uses: dark green background (`#06291f`) with radial gradients
- **Login Page Reference**: Beautiful 2-column layout with branding panel + form
- **Routes**: `/` returns `view('welcome')` - this is the unauthenticated landing page

## Plan

1. **Replace `resources/views/welcome.blade.php`** with a branded landing page that:
   - Uses the same dark green background (`#06291f`) as the login page
   - Has the same radial gradient overlay effect
   - Shows the system branding (Banana Chips ERP logo/name)
   - Has a hero section explaining what the ERP does
   - Shows feature highlights: Procurement, Inventory, Production, Quality Control, Warehouse, Sales & Export
   - Links to Login and Register pages
   - Has a footer with security/trust signals
   - Uses Figtree font, Tailwind CSS, consistent with system template
   - Responsive design
   - Matches the visual language of the login page

## Key Design Elements to Carry Over

- Background: `bg-[#06291f]` with radial gradient overlay
- Branding block with emerald icon and "Banana Chips Manufacturing" subtitle
- White card/panel for content
- Emerald accent colors
- Same button styles as login page
- Same typography (Figtree, font-headline)

## Files to Edit

1. `resources/views/welcome.blade.php` - Complete replacement

## Follow-up Steps

- Verify the welcome page renders correctly
- Check all links work (login, register)
- Ensure responsive behavior on mobile

