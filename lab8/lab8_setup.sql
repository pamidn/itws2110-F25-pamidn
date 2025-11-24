-- =========================================
-- Lab 8 Setup SQL
-- =========================================

-- 1. Create the database
CREATE DATABASE IF NOT EXISTS websyslab8 CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE websyslab8;

-- 2. Create courses table
CREATE TABLE courses (
    crn INT(11) PRIMARY KEY,
    prefix VARCHAR(4) NOT NULL,
    number SMALLINT(4) NOT NULL,
    title VARCHAR(255) NOT NULL,
    section VARCHAR(10),
    year SMALLINT(4)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 3. Create students table (phone fixed as VARCHAR)
CREATE TABLE students (
    rin INT(9) PRIMARY KEY,
    rcsID CHAR(7),
    firstname VARCHAR(100) NOT NULL,
    lastname VARCHAR(100) NOT NULL,
    alias VARCHAR(100) NOT NULL,
    phone VARCHAR(15),
    street VARCHAR(255),
    city VARCHAR(100),
    state CHAR(2),
    zip CHAR(10)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 4. Create grades table
CREATE TABLE grades (
    id INT PRIMARY KEY AUTO_INCREMENT,
    crn INT,
    rin INT,
    grade INT(3) NOT NULL,
    FOREIGN KEY (crn) REFERENCES courses(crn),
    FOREIGN KEY (rin) REFERENCES students(rin)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- =========================================
-- Insert sample data
-- =========================================

-- Courses
INSERT INTO courses (crn, prefix, number, title, section, year)
VALUES
(1001, 'CSCI', 101, 'Intro to CS', 'A', 2025),
(1002, 'CSCI', 102, 'Data Structures', 'B', 2025),
(1003, 'MATH', 201, 'Calculus I', 'A', 2025),
(1004, 'PHYS', 101, 'Physics I', 'C', 2025);

-- Students
INSERT INTO students (rin, rcsID, firstname, lastname, alias, phone, street, city, state, zip)
VALUES
(100000001, 'r123456', 'Alice', 'Smith', 'Ally', '5551234567', '123 Maple St', 'Troy', 'NY', '12180'),
(100000002, 'r234567', 'Bob', 'Jones', 'Bobby', '5552345678', '456 Oak St', 'Troy', 'NY', '12180'),
(100000003, 'r345678', 'Carol', 'Taylor', 'Caz', '5553456789', '789 Pine St', 'Troy', 'NY', '12180'),
(100000004, 'r456789', 'David', 'Lee', 'Dave', '5554567890', '321 Birch St', 'Troy', 'NY', '12180');

-- Grades
INSERT INTO grades (crn, rin, grade)
VALUES
(1001, 100000001, 95),
(1001, 100000002, 88),
(1001, 100000003, 92),
(1002, 100000001, 85),
(1002, 100000004, 90),
(1003, 100000002, 91),
(1003, 100000003, 87),
(1003, 100000004, 94),
(1004, 100000001, 78),
(1004, 100000004, 99);

-- =========================================
-- Lab Queries
-- =========================================

-- 1. List all students alphabetically by RIN
SELECT * FROM students ORDER BY rin;

-- 2. List all students alphabetically by last name
SELECT * FROM students ORDER BY lastname;

-- 3. List all students alphabetically by RCSID
SELECT * FROM students ORDER BY rcsID;

-- 4. List all students alphabetically by first name
SELECT * FROM students ORDER BY firstname;

-- 5. List students (rin, name, address) with any grade > 90
SELECT s.rin, s.firstname, s.lastname, s.street, s.city, s.state, s.zip
FROM students s
JOIN grades g ON s.rin = g.rin
WHERE g.grade > 90;

-- 6. Average grade per course
SELECT c.crn, c.title, AVG(g.grade) AS avg_grade
FROM courses c
JOIN grades g ON c.crn = g.crn
GROUP BY c.crn, c.title;

-- 7. Number of students per course
SELECT c.crn, c.title, COUNT(g.rin) AS num_students
FROM courses c
JOIN grades g ON c.crn = g.crn
GROUP BY c.crn, c.title;

