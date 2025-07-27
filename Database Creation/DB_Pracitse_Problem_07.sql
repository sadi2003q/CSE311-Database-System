create database Practise_Question_07;
use Practise_Question_07;

-- 1. Departments Table
CREATE TABLE Departments (
    department_id INT PRIMARY KEY,
    department_name VARCHAR(100) NOT NULL UNIQUE,
    head_of_department_id INT, -- Will be a foreign key to Instructors
    budget DECIMAL(15, 2) DEFAULT 0.00
);

-- 2. Buildings Table
CREATE TABLE Buildings (
    building_id INT PRIMARY KEY,
    building_name VARCHAR(100) NOT NULL UNIQUE,
    address VARCHAR(255),
    year_built INT
);

-- 3. Instructors Table
CREATE TABLE Instructors (
    instructor_id INT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE,
    phone_number VARCHAR(20),
    hire_date DATE,
    salary DECIMAL(10, 2),
    department_id INT,
    building_id INT, -- Office location
    FOREIGN KEY (department_id) REFERENCES Departments(department_id),
    FOREIGN KEY (building_id) REFERENCES Buildings(building_id)
);

-- Add foreign key to Departments for head_of_department_id
ALTER TABLE Departments
ADD CONSTRAINT fk_head_of_department
FOREIGN KEY (head_of_department_id) REFERENCES Instructors(instructor_id);

-- 4. Students Table
CREATE TABLE Students (
    student_id INT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    date_of_birth DATE,
    email VARCHAR(100) UNIQUE,
    phone_number VARCHAR(20),
    enrollment_date DATE,
    major_department_id INT,
    gpa DECIMAL(3, 2),
    FOREIGN KEY (major_department_id) REFERENCES Departments(department_id)
);

-- 5. Courses Table
CREATE TABLE Courses (
    course_id INT PRIMARY KEY,
    course_name VARCHAR(100) NOT NULL,
    course_code VARCHAR(10) NOT NULL UNIQUE,
    credits INT NOT NULL,
    department_id INT,
    instructor_id INT, -- Primary instructor for the course
    building_id INT, -- Classroom location
    room_number VARCHAR(10),
    FOREIGN KEY (department_id) REFERENCES Departments(department_id),
    FOREIGN KEY (instructor_id) REFERENCES Instructors(instructor_id),
    FOREIGN KEY (building_id) REFERENCES Buildings(building_id)
);

-- 6. Enrollments Table (Many-to-Many relationship between Students and Courses)
CREATE TABLE Enrollments (
    enrollment_id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    enrollment_date DATE,
    grade VARCHAR(2),
    FOREIGN KEY (student_id) REFERENCES Students(student_id),
    FOREIGN KEY (course_id) REFERENCES Courses(course_id),
    UNIQUE (student_id, course_id)
);

-- Insert Sample Data

-- Buildings
INSERT INTO Buildings (building_id, building_name, address, year_built) VALUES
(101, 'Main Academic Building', '123 University Ave', 1980),
(102, 'Science Complex', '456 Research Blvd', 2005),
(103, 'Arts & Humanities Center', '789 Culture St', 1995),
(104, 'Engineering Hall', '101 Tech Way', 2010),
(105, 'Library', '200 Knowledge Rd', 1975);

-- Departments
INSERT INTO Departments (department_id, department_name, budget) VALUES
(1, 'Computer Science', 1500000.00),
(2, 'Physics', 1200000.00),
(3, 'English', 800000.00),
(4, 'Electrical Engineering', 1300000.00),
(5, 'Mathematics', 900000.00),
(6, 'Chemistry', 1100000.00);

-- Instructors (some without department_id initially to test LEFT JOINs)
INSERT INTO Instructors (instructor_id, first_name, last_name, email, phone_number, hire_date, salary, department_id, building_id) VALUES
(1001, 'Alice', 'Smith', 'alice.smith@university.edu', '555-1001', '2010-08-15', 90000.00, 1, 101),
(1002, 'Bob', 'Johnson', 'bob.j@university.edu', '555-1002', '2005-01-20', 110000.00, 2, 102),
(1003, 'Carol', 'Williams', 'carol.w@university.edu', '555-1003', '2012-09-01', 85000.00, 3, 103),
(1004, 'David', 'Brown', 'david.b@university.edu', '555-1004', '2008-03-10', 95000.00, 4, 104),
(1005, 'Eve', 'Davis', 'eve.d@university.edu', '555-1005', '2015-06-01', 75000.00, 5, 101),
(1006, 'Frank', 'Miller', 'frank.m@university.edu', '555-1006', '2018-02-28', 70000.00, 1, 101),
(1007, 'Grace', 'Wilson', 'grace.w@university.edu', '555-1007', '2000-11-01', 120000.00, 2, 102),
(1008, 'Henry', 'Moore', 'henry.m@university.edu', '555-1008', '2020-01-01', 65000.00, NULL, 105); -- Instructor not assigned to a department yet

-- Update Departments with head_of_department_id
UPDATE Departments SET head_of_department_id = 1001 WHERE department_id = 1; -- Alice Smith
UPDATE Departments SET head_of_department_id = 1002 WHERE department_id = 2; -- Bob Johnson
UPDATE Departments SET head_of_department_id = 1003 WHERE department_id = 3; -- Carol Williams
UPDATE Departments SET head_of_department_id = 1004 WHERE department_id = 4; -- David Brown
UPDATE Departments SET head_of_department_id = 1005 WHERE department_id = 5; -- Eve Davis
UPDATE Departments SET head_of_department_id = 1007 WHERE department_id = 6; -- Grace Wilson

-- Students
INSERT INTO Students (student_id, first_name, last_name, date_of_birth, email, phone_number, enrollment_date, major_department_id, gpa) VALUES
(2001, 'John', 'Doe', '2002-05-10', 'john.doe@student.university.edu', '555-2001', '2020-09-01', 1, 3.85),
(2002, 'Jane', 'Smith', '2001-11-22', 'jane.s@student.university.edu', '555-2002', '2019-09-01', 2, 3.92),
(2003, 'Peter', 'Jones', '2003-01-15', 'peter.j@student.university.edu', '555-2003', '2021-09-01', 1, 3.50),
(2004, 'Emily', 'Chen', '2002-07-03', 'emily.c@student.university.edu', '555-2004', '2020-09-01', 3, 3.70),
(2005, 'Michael', 'Wang', '2000-09-18', 'michael.w@student.university.edu', '555-2005', '2018-09-01', 4, 3.65),
(2006, 'Sarah', 'Lee', '2003-03-25', 'sarah.l@student.university.edu', '555-2006', '2021-09-01', 5, 3.95),
(2007, 'Chris', 'Garcia', '2001-08-08', 'chris.g@student.university.edu', '555-2007', '2019-09-01', 1, 3.20),
(2008, 'Anna', 'Rodriguez', '2004-02-29', 'anna.r@student.university.edu', '555-2008', '2022-09-01', 2, 3.80),
(2009, 'Tom', 'Wilson', '2002-12-01', 'tom.w@student.university.edu', '555-2009', '2020-09-01', NULL, 3.10); -- Student without a major yet

-- Courses
INSERT INTO Courses (course_id, course_name, course_code, credits, department_id, instructor_id, building_id, room_number) VALUES
(3001, 'Introduction to Programming', 'CS101', 3, 1, 1001, 101, 'A101'),
(3002, 'Calculus I', 'MA101', 4, 5, 1005, 101, 'A102'),
(3003, 'Physics for Engineers', 'PH201', 4, 2, 1002, 102, 'B201'),
(3004, 'Data Structures', 'CS201', 3, 1, 1006, 101, 'A103'),
(3005, 'Literary Analysis', 'EN201', 3, 3, 1003, 103, 'C101'),
(3006, 'Circuit Design', 'EE301', 3, 4, 1004, 104, 'D101'),
(3007, 'Advanced Quantum Mechanics', 'PH401', 4, 2, 1007, 102, 'B202'),
(3008, 'Database Systems', 'CS305', 3, 1, 1001, 101, 'A101'),
(3009, 'Differential Equations', 'MA301', 3, 5, 1005, 101, 'A102'),
(3010, 'Organic Chemistry I', 'CH201', 4, 6, 1007, 102, 'B203'); -- Instructor 1007 (Grace Wilson) teaches Chemistry

-- Enrollments
INSERT INTO Enrollments (student_id, course_id, grade) VALUES
(2001, 3001, 'A'), -- John Doe - Intro to Programming
(2001, 3004, 'B+'), -- John Doe - Data Structures
(2001, 3002, 'A-'), -- John Doe - Calculus I
(2002, 3003, 'A'), -- Jane Smith - Physics for Engineers
(2002, 3007, 'A+'), -- Jane Smith - Advanced Quantum Mechanics
(2003, 3001, 'B'), -- Peter Jones - Intro to Programming
(2003, 3008, 'C+'), -- Peter Jones - Database Systems
(2004, 3005, 'A'), -- Emily Chen - Literary Analysis
(2005, 3006, 'B'), -- Michael Wang - Circuit Design
(2006, 3002, 'A+'), -- Sarah Lee - Calculus I
(2006, 3009, 'A'), -- Sarah Lee - Differential Equations
(2007, 3001, 'C'), -- Chris Garcia - Intro to Programming
(2007, 3004, 'D'), -- Chris Garcia - Data Structures (failing grade)
(2008, 3003, 'B+'), -- Anna Rodriguez - Physics for Engineers
(2009, 3001, 'P'), -- Tom Wilson - Intro to Programming (Pass/Fail)
(2009, 3005, 'F'); -- Tom Wilson - Literary Analysis (failing grade)
