# OdysseyClan Laravel Project Guide

## Development Commands
- **Setup**: `composer install && npm install`
- **Run application**: `php artisan serve`
- **Frontend build**: `npm run dev` (development) or `npm run build` (production)
- **Code linting**: `./vendor/bin/pint` (Laravel Pint)
- **Run all tests**: `php artisan test`
- **Run single test**: `php artisan test --filter=test_name`
- **Run test suite**: `php artisan test --testsuite=Feature`

## Code Style Guidelines
- **PSR-4** autoloading standard
- **Models**: camelCase for properties, snake_case for database columns
- **Controllers**: use resource controller naming (index, create, store, show, edit, update, destroy)
- **Naming**: PascalCase for classes, camelCase for methods and properties
- **Imports**: group and order by standard Laravel conventions
- **Error handling**: use Laravel's exception handling system

## Project-Specific Information
- Uses SQLite database in development
- Vite for frontend build system
- PHP 8.2+ required