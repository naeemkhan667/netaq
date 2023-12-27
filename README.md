# netaq
# User Enrollments
## Create Enrollment
- user_id
- course_id

## Get Enrollment (Particular User)
- user_id

## Update Enrollment
- status (Active | Completed)

## List Enrollment
### All Enrollments
### All Enrollments for Particular Course
- course_id
### All Enrollments for Particular User
- user_id
================================

Http
/Kernal.php
 \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,

 Ran the migration
 php artisan migrate:refresh

php artisan make:controller EnrollmentController

php artisan make:model Course
