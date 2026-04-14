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