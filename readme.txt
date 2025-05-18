Final Year Project Management System
====================================

This is a web-based Final Year Project (FYP) Management System developed using PHP, MySQL, HTML/CSS, and XAMPP. It supports three user roles: Admin, Lecturer, and Student — each with specific capabilities to manage, evaluate, and track project progress.

Features
--------

Students:
- Submit project proposals
- View approval status and progress

Lecturers:
- Review student proposals
- Approve or reject submissions
- Update project progress

Admins:
- Manage users (students and lecturers)
- Assign lecturers to projects
- View overall system status

Technologies Used
-----------------
- PHP (backend logic)
- MySQL (database)
- HTML/CSS (frontend)
- phpMyAdmin (database management)
- XAMPP (local server environment)

Login Credentials (for testing)
-------------------------------
Admin:
- Email: admin@example.com
- Password: admin123

Lecturer:
- Email: s123@gmail.com / j123@gmail.com
- Password: abd123 / ras123

Student:
- Email: f123@gmail.com / a123@gmail.com
- Password: far123 / ahmed123

Installation Instructions (XAMPP)
---------------------------------
1. Download or clone the project:
   git clone https://github.com/yourusername/FYP-Management-System.git

2. Move the project folder into:
   C:/xampp/htdocs/

3. Open phpMyAdmin by navigating to:
   http://localhost/phpmyadmin

4. Create a new database named:
   project

5. Import the provided SQL file (e.g., project.sql)

6. Open your browser and visit:
   http://localhost/FYP-Management-System

Security Measures
-----------------
- Passwords are hashed using PHP’s password_hash()
- All database queries use prepared statements to prevent SQL injection
- Sessions are used to control access to restricted pages
- Role-based access ensures users can only see appropriate content
- Users can securely log out using session_destroy()

Folder Structure
----------------
FYP-Management-System/
├── admin/
├── lecturer/
├── student/
├── includes/
│   └── db_connect.php
├── assets/
├── index.html / login.html
└── project.sql

License
-------
This project is developed for academic purposes only and is not licensed for commercial use.
