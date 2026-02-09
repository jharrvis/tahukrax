# Rebranding Plan: RCGO -> TahuKrax

This plan outlines the steps to rebrand the existing codebase from "RCGO" to "TahuKrax".

## User Review Required

> [!IMPORTANT]
> This process involves a global search and replace of "RCGO" to "TahuKrax". Please review the changes carefully to ensure no unintended replacements occur (e.g., variable names that happen to contain "RCGO").

## Proposed Changes

### Configuration Updates
#### [MODIFY] [.env.example](file:///d:/laragon/www/tahukrax/.env.example)
- Update `APP_NAME` from `Laravel` (or existing default) to `TahuKrax`.
- Check if `MAIL_FROM_NAME` uses `APP_NAME`.

#### [MODIFY] [config/app.php](file:///d:/laragon/www/tahukrax/config/app.php)
- Ensure `name` falls back to `TahuKrax` if `APP_NAME` is missing.

### Database Seeders
#### [MODIFY] [database/seeders](file:///d:/laragon/www/tahukrax/database/seeders)
- Update `SettingSeeder.php` and `LandingPageSeeder.php` to seed initial data with "TahuKrax" instead of "RCGO".

### Application Logic & Views
#### [MODIFY] [app](file:///d:/laragon/www/tahukrax/app)
- Update references in `app/Mail/*.php` (e.g., subject lines, sender names).
- Update references in `app/Http/Controllers/InvoiceController.php`.
- Update references in `app/Livewire/*.php`.

#### [MODIFY] [resources/views](file:///d:/laragon/www/tahukrax/resources/views)
- Perform a global search and replace in all Blade templates to update UI text, titles, and footers.

### Build Configuration
#### [MODIFY] [package.json](file:///d:/laragon/www/tahukrax/package.json)
- Update package name or description if applicable.

#### [MODIFY] [composer.json](file:///d:/laragon/www/tahukrax/composer.json)
- Update project description if applicable.

## Verification Plan

### Automated Verification
- Run `php artisan test` to ensuring no tests fail due to renaming.
- Check if the application name shows up correctly in `php artisan env`.

### Manual Verification
- Review critical pages (Landing, Login, Dashboard) to ensure branding is consistent.
- Check email templates (by triggering a test email if possible).
