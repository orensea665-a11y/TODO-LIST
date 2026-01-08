# TODO-LIST
# todo-app
Project System
To-Do List App
A complete, beginner-friendly to-do list application built as a college final project. It allows users to manage tasks and categories dynamically, with a modern UI and secure backend. Features full CRUD operations (Create, Read, Update, Delete) for tasks and categories, with no page reloads thanks to AJAX.

Features
Task Management: Add, edit, delete, and view tasks with titles, descriptions, status (pending/completed), due dates, and category assignments.
Category Management: Organize tasks into categories (e.g., "Work", "Personal").
Dynamic UI: Responsive design that works on desktop and mobile. Sidebar navigation for easy switching between sections.
Real-Time Updates: JavaScript (Fetch API) handles form submissions and data loading without refreshing the page.
Secure Backend: PHP with prepared statements to prevent SQL injection. MySQL database for data storage.
Error Handling: Client-side and server-side validation with user-friendly messages.
Sample Data: Includes pre-loaded tasks and categories for testing.

Technologies Used
Frontend: HTML5, CSS3 (modern, responsive design), Vanilla JavaScript (no frameworks).
Backend: PHP 7+ (procedural style, mysqli extension), MySQL 5.7+.
Tools: Git for version control, GitHub for hosting, Local server ( Laragon or XAMPP).

Prerequisites
A local web server with PHP and MySQL ( Laragon, XAMPP, or WAMP).
A web browser (Chrome, Firefox, etc.).
Basic knowledge of running a local server (Apache and MySQL must be started).
Installation and Setup
Follow these steps to run the app locally:

1. Download the Code
Clone or download the repository: git clone https://github.com/yourusername/todo-list-app.git (replace with your actual GitHub URL).
Extract the ZIP if downloaded manually.
Place the todo-app folder in your server's root directory ( C:\laragon\www\ for Laragon or htdocs for XAMPP).

2. Set Up the Database
Start your MySQL server (via Laragon/XAMPP control panel).
Open phpMyAdmin (usually at http://localhost/phpmyadmin).
Create a new database or run the provided SQL script:
Go to the "SQL" tab.
Copy-paste the contents of php/db_setup.sql and click "Go".
This creates the database (todo_app), tables (users, categories, tasks), and inserts sample data.

3. Configure Database Connection
Open php/config.php in a text editor.
Update the credentials if needed (default: host='localhost', dbname='todo_app', username='root', password=''):
php

Copy code
$host = 'localhost';  // Change if your server is different
$dbname = 'todo_app';
$username = 'root';  // Your MySQL username
$password = '';      // Your MySQL password (leave empty if none)
Save the file.

4. Run the App
Start your Apache server (via Laragon/XAMPP).
Open your browser and navigate to http://localhost/todo-app/index.html.
The app should load with sample data. Use the sidebar to switch between "Tasks" and "Categories".

Usage
Navigation: Click "Tasks" or "Categories" in the sidebar to view lists.

Adding Items:
For Tasks: Click "Add Task", fill in title (required), description, status, due date, and select a category (add categories first if none exist).

For Categories: Click "Add Category", enter name (required) and description.
Editing/Deleting: Click "Edit" or "Delete" buttons in the tables. Confirm deletions.

Dynamic Updates: Changes appear instantly without page reloads. Loading indicators and messages show status.

Responsive: Resize your browser or test on mobile for adaptive layout.
