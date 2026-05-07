# TaskFlow

TaskFlow is a simple Project Management Tool built with PHP, MySQL, HTML, CSS, and JavaScript.

## Day 1 Progress
- Created project structure
- Created `taskflow` database
- Created `users`, `projects`, and `tasks` tables
- Finished `config.php` and `dbconnect.php`
- Database connection test successful

## Day 2 Progress
- Added `functions.php`
- Built user registration page
- Added server-side validation
- Prevented duplicate email registration
- Used `password_hash()` for password security
- Added a simple placeholder login page
- Added basic CSS styling
- Registration data successfully stored in MySQL

## Day 3 Progress
- Built the user login page
- Added server-side validation for login form
- Verified user credentials using `password_verify()`
- Implemented PHP session-based authentication
- Added `auth_check.php` to protect private pages
- Built a simple dashboard page for login testing
- Added logout functionality
- Successfully tested login, logout, and route protection

## Day 4 Progress
- Added reusable `header.php` and `footer.php`
- Upgraded `dashboard.php` to display real database statistics
- Queried total projects, total tasks, pending tasks, and completed tasks
- Added navigation bar and footer layout
- Improved dashboard styling with card-based layout
- Successfully tested dashboard access, session protection, and logout navigation

## Day 5 Progress
- Built `projects.php` to display the current user's project list
- Built `add_project.php` for creating new projects
- Added server-side validation for project creation
- Used prepared statements to insert project data into MySQL
- Updated the navigation bar to include the Projects page
- Added project table styling and empty-state layout
- Successfully tested project creation and dashboard project count update

## Day 6 Progress
- Built `edit_project.php` to update project information
- Built `delete_project.php` to remove projects
- Updated `projects.php` so Edit and Delete actions are functional
- Added ownership checks to prevent unauthorized project access
- Added validation for editing project data
- Used prepared statements for update and delete operations
- Successfully tested project update, deletion, and dashboard project count changes

## Day 7 Progress
- Built `tasks.php` to display the current user's task list
- Used SQL JOIN to show each task with its related project name
- Built `add_task.php` for creating new tasks
- Added validation to ensure tasks are linked to a valid project
- Prevented task creation when no projects exist
- Updated navigation to include the Tasks page
- Updated `projects.php` so each project can link to its related tasks
- Successfully tested task creation and dashboard task count updates

## Day 8 Progress
- Built `edit_task.php` to update task information
- Built `delete_task.php` to remove tasks
- Updated `tasks.php` so Edit and Delete actions are functional
- Added ownership checks to prevent unauthorized task access
- Added validation for editing task data
- Used prepared statements for update and delete operations
- Successfully tested task updates, deletion, and dashboard task count changes

## Today's Updates (2026-05-07)

## Overview
This update includes enhancements to the TASKFLOW project, focusing on task management, AJAX updates, and file upload functionality.

## Files Modified / Added
1. **logout.php**
   - Updated logout logic using `session_start()`, `session_unset()`, and `session_destroy()`.
   - Redirects to `login.php` after logout.

2. **projects.php**
   - Adjustments and improvements for project listing and display.
   - Ensured prepared statements are used for database queries.

3. **update_task_status.php** *(new)*
   - Handles AJAX requests from `tasks.php` to toggle task status between "Pending" and "Completed".
   - Ensures only the logged-in user's tasks are updated.
   - Uses PDO prepared statements for security.

4. **uploadfile.php** *(new)*
   - Handles file uploads for tasks.
   - Uploaded files are saved in the `uploads/` directory.
   - Updates the corresponding task's `file_path` in the database.

## Features Implemented
- Dynamic task status update via AJAX without page reload.
- Task file upload support with view/download functionality.
- Logout functionality properly clears session data.
- Minor improvements to project display and database interactions.

## Notes
- All database interactions use PDO prepared statements for security.
- File uploads are saved to the `uploads/` directory (ensure this folder exists and is writable).
- Tested on local XAMPP environment; all new features work as expected.