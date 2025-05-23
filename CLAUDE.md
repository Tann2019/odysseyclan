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
- Dark theme based gaming clan website
- Admin panel with full content management

## Admin Panel Features

### Access & Security
- **Admin Routes**: All admin routes protected by `AdminMiddleware`
- **Access URL**: `/admin` (requires admin privileges)
- **Authentication**: Users with `is_admin = true` in database
- **Create Admin**: Use `/admin/admins/create` or Artisan command

### Content Management Systems

#### News Management (`/admin/news`)
- **Create/Edit/Delete** news articles for homepage
- **Publishing Control**: Draft/Published status with timestamps
- **Rich Content**: Title, excerpt, content, featured images
- **Author Tracking**: Automatic author assignment
- **Features**: Pagination, search, status badges

#### Events Management (`/admin/events`)
- **Event Types**: Tournament, Training, Special, Community
- **Scheduling**: Event date/time, registration deadlines
- **Participant Limits**: Optional max participant controls
- **Featured Events**: Highlight important events on homepage
- **Status Control**: Active/Inactive event management

#### Gallery Management (`/admin/gallery`)
- **Image Categories**: General, Tournaments, Events, Members, Training
- **Organization**: Sort order, featured image flags
- **Metadata**: Titles, descriptions, uploader tracking
- **Visual Management**: Grid view with category filtering
- **Image Preview**: Live URL preview during upload

#### Member Management (`/admin/members`)
- **Full CRUD**: View, edit, activate/deactivate members
- **Advanced Filtering**: By rank, status, search terms
- **Verification Integration**: Direct links to verification system
- **Bulk Operations**: Pagination with 15 items per page

#### Verification System (`/admin/verification`)
- **Review Queue**: Pending verification requests
- **Approval Workflow**: Approve/reject with notes and reasons
- **Status Management**: Reset rejected members to pending
- **History Tracking**: Recently verified/rejected lists

### Database Models
- **News**: title, content, excerpt, image_url, published status, author
- **Events**: title, description, type, dates, participant limits, featured status
- **GalleryImages**: title, description, image_url, category, sort_order, featured
- **Members**: Enhanced with verification workflow
- **Users**: Admin flag support

### Frontend Integration
- **Main Page**: Embedded Twitch stream (https://www.twitch.tv/raabbits)
- **Dark Theme**: Consistent dark mode styling across admin panels
- **Responsive Design**: Mobile-friendly admin interface
- **Live Preview**: Image URL validation and preview

## Production Readiness Checklist
- ✅ Admin security middleware implemented
- ✅ CSRF protection on all forms
- ✅ Input validation on all admin forms
- ✅ Dark mode styling consistency
- ✅ Error handling and user feedback
- ✅ Database migrations for all new features
- ⚠️ Main page integration pending (news/events display)
- ⚠️ File upload system (currently URL-based)