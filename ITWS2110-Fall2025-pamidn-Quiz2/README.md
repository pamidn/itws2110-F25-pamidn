## 1. Design Decisions

1. **Virtual Host & Folder Structure**  
   - I created a virtual host named `websysquiz2` and pointed it to the project folder `ITWS2110-Fall2025-pamidn-Quiz2` so that all web files are organized in a single location.  
   - Used `config.php` to store database connection info for easier maintenance and to avoid repeating credentials in every file.  

2. **Database Structure**  
   - `users` table stores all user information including a salted, hashed password for security.  
   - `projects` table stores project information.  
   - `projectMembership` table manages the many-to-many relationship between users and projects.  
   - Chose MySQL for database management because it integrates well with PHP and XAMPP.  

3. **Login & Registration**  
   - Login checks both user existence and correct password using password hashing and salting.  
   - Registration creates new users with secure hashed passwords.  

4. **Project Management**  
   - Project form requires at least 3 members to ensure collaboration.  
   - Added highlighting of newly added projects for visual feedback.  
   - Checked for duplicate project names before insertion to prevent redundancy.  

---

## 2. Handling First-Time Users / Database Install  

If a user visits the site and the database does not exist, I would implement an **installation check** in `config.php` or `index.php`:

1. On every page load, check if the database exists:  

```php
$conn = new mysqli($host, $user, $password);
if (!$conn->select_db('ITWS2110_Fall2025_pamidn_Quiz2')) {
    // Database does not exist
    // Run SQL from setupDB.txt to create database and tables
}


3. Preventing Duplicate Projects

Before inserting a project, query the projects table to check if a project with the same name already exists.

If it exists, display an error message and do not insert.

This prevents accidental duplication of projects.