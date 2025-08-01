-- SQL Script to Create and Populate University Database Tables
create database if not exists University;
use University;

-- 1. Create Students Table
CREATE TABLE Students (
    StudentID INT PRIMARY KEY,
    StudentName VARCHAR(100) NOT NULL,
    Major VARCHAR(50),
    EnrollmentDate DATE,
    DateOfBirth DATE,
    Email VARCHAR(100) UNIQUE
);

-- Insert data into Students Table
INSERT INTO Students (StudentID, StudentName, Major, EnrollmentDate, DateOfBirth, Email) VALUES
(1001, 'Alice Smith', 'Computer Science', '2022-09-01', '2004-03-15', 'alice.s@example.com'),
(1002, 'Bob Johnson', 'Electrical Eng.', '2021-09-01', '2003-07-22', 'bob.j@example.com'),
(1003, 'Carol White', 'Mathematics', '2023-01-15', '2005-01-10', 'carol.w@example.com'),
(1004, 'David Brown', 'Physics', '2022-09-01', '2004-11-05', 'david.b@example.com'),
(1005, 'Emily Davis', 'Biology', '2021-01-20', '2003-04-30', 'emily.d@example.com'),
(1006, 'Frank Green', 'Chemistry', '2023-09-01', '2005-09-18', 'frank.g@example.com'),
(1007, 'Grace Hall', 'Computer Science', '2022-01-10', '2004-02-28', 'grace.h@example.com'),
(1008, 'Henry King', 'History', '2021-09-01', '2003-12-01', 'henry.k@example.com'),
(1009, 'Ivy Lee', 'English', '2023-01-15', '2005-06-25', 'ivy.l@example.com'),
(1010, 'Jack Scott', 'Electrical Eng.', '2022-09-01', '2004-08-12', 'jack.s@example.com'),
(1011, 'Karen Adams', 'Mathematics', '2021-09-01', '2003-01-01', 'karen.a@example.com'),
(1012, 'Liam Baker', 'Physics', '2023-09-01', '2005-10-03', 'liam.b@example.com'),
(1013, 'Mia Clark', 'Biology', '2022-01-10', '2004-05-20', 'mia.c@example.com'),
(1014, 'Noah Davis', 'Chemistry', '2021-09-01', '2003-09-09', 'noah.d@example.com'),
(1015, 'Olivia Evans', 'Computer Science', '2023-01-15', '2005-02-14', 'olivia.e@example.com'),
(1016, 'Peter Foster', 'History', '2022-09-01', '2004-07-07', 'peter.f@example.com'),
(1017, 'Quinn Garcia', 'English', '2021-01-20', '2003-03-03', 'quinn.g@example.com'),
(1018, 'Rachel Harris', 'Electrical Eng.', '2023-09-01', '2005-11-11', 'rachel.h@example.com'),
(1019, 'Sam Jackson', 'Mathematics', '2022-01-10', '2004-06-06', 'sam.j@example.com'),
(1020, 'Tina Kim', 'Physics', '2021-09-01', '2003-10-10', 'tina.k@example.com'),
(1021, 'Uma Lopez', 'Biology', '2023-01-15', '2005-04-04', 'uma.l@example.com'),
(1022, 'Victor Martinez', 'Chemistry', '2022-09-01', '2004-09-01', 'victor.m@example.com'),
(1023, 'Wendy Nguyen', 'Computer Science', '2021-01-20', '2003-08-08', 'wendy.n@example.com'),
(1024, 'Xander Owens', 'History', '2023-09-01', '2005-05-05', 'xander.o@example.com'),
(1025, 'Yara Perez', 'English', '2022-01-10', '2004-12-12', 'yara.p@example.com'),
(1026, 'Zoe Quintana', 'Electrical Eng.', '2021-09-01', '2003-02-02', 'zoe.q@example.com'),
(1027, 'Alex Rodriguez', 'Mathematics', '2023-01-15', '2005-07-01', 'alex.r@example.com'),
(1028, 'Brenda Smith', 'Physics', '2022-09-01', '2004-01-20', 'brenda.s@example.com'),
(1029, 'Chris Taylor', 'Biology', '2021-01-20', '2003-06-10', 'chris.t@example.com'),
(1030, 'Diana Garcia', 'Computer Science', '2023-09-01', '2005-03-25', 'diana.g@example.com');

-- 2. Create Courses Table
CREATE TABLE Courses (
    CourseID VARCHAR(10) PRIMARY KEY,
    CourseName VARCHAR(100) NOT NULL,
    Credits INT,
    Department VARCHAR(50)
);

-- Insert data into Courses Table
INSERT INTO Courses (CourseID, CourseName, Credits, Department) VALUES
('CS101', 'Intro to Programming', 3, 'Computer Science'),
('CS201', 'Data Structures', 4, 'Computer Science'),
('CS301', 'Algorithms', 4, 'Computer Science'),
('CS401', 'Database Systems', 3, 'Computer Science'),
('EE101', 'Circuit Analysis', 3, 'Electrical Eng.'),
('EE201', 'Digital Logic Design', 4, 'Electrical Eng.'),
('MA101', 'Calculus I', 4, 'Mathematics'),
('MA201', 'Linear Algebra', 3, 'Mathematics'),
('PH101', 'General Physics I', 4, 'Physics'),
('PH201', 'Quantum Mechanics', 3, 'Physics'),
('BI101', 'General Biology', 3, 'Biology'),
('BI201', 'Genetics', 4, 'Biology'),
('CH101', 'General Chemistry', 3, 'Chemistry'),
('CH201', 'Organic Chemistry', 4, 'Chemistry'),
('HI101', 'World History I', 3, 'History'),
('HI201', 'American History', 3, 'History'),
('EN101', 'Intro to Literature', 3, 'English'),
('EN201', 'Creative Writing', 3, 'English'),
('CS499', 'Senior Project (CS)', 3, 'Computer Science'),
('EE499', 'Senior Project (EE)', 3, 'Electrical Eng.'),
('MA499', 'Senior Project (MA)', 3, 'Mathematics'),
('PH499', 'Senior Project (PH)', 3, 'Physics'),
('BI499', 'Senior Project (BI)', 3, 'Biology'),
('CH499', 'Senior Project (CH)', 3, 'Chemistry'),
('HI499', 'Senior Project (HI)', 3, 'History'),
('EN499', 'Senior Project (EN)', 3, 'English'),
('CS202', 'Discrete Mathematics', 3, 'Computer Science'),
('EE301', 'Microelectronics', 4, 'Electrical Eng.'),
('MA301', 'Differential Equations', 3, 'Mathematics'),
('PH301', 'Thermodynamics', 3, 'Physics');

-- 3. Create Instructors Table
CREATE TABLE Instructors (
    InstructorID INT PRIMARY KEY,
    InstructorName VARCHAR(100) NOT NULL,
    Department VARCHAR(50),
    HireDate DATE,
    Salary DECIMAL(10,2)
);

-- Insert data into Instructors Table
INSERT INTO Instructors (InstructorID, InstructorName, Department, HireDate, Salary) VALUES
(5001, 'Dr. Alan Turing', 'Computer Science', '2010-08-01', 95000.00),
(5002, 'Dr. Ada Lovelace', 'Computer Science', '2015-01-15', 88000.00),
(5003, 'Prof. Marie Curie', 'Physics', '2005-09-01', 110000.00),
(5004, 'Dr. Albert Einstein', 'Physics', '2012-03-10', 92000.00),
(5005, 'Prof. Isaac Newton', 'Mathematics', '2000-01-01', 120000.00),
(5006, 'Dr. Emmy Noether', 'Mathematics', '2018-06-20', 85000.00),
(5007, 'Prof. Charles Darwin', 'Biology', '2008-04-01', 105000.00),
(5008, 'Dr. Rosalind Franklin', 'Biology', '2017-11-01', 87000.00),
(5009, 'Prof. Linus Pauling', 'Chemistry', '2003-07-01', 115000.00),
(5010, 'Dr. Dorothy Hodgkin', 'Chemistry', '2016-02-10', 89000.00),
(5011, 'Prof. Stephen Hawking', 'Electrical Eng.', '2007-09-01', 108000.00),
(5012, 'Dr. Nikola Tesla', 'Electrical Eng.', '2014-05-20', 90000.00),
(5013, 'Prof. Jane Austen', 'English', '2006-10-01', 98000.00),
(5014, 'Dr. Virginia Woolf', 'English', '2019-03-01', 82000.00),
(5015, 'Prof. Yuval Harari', 'History', '2011-02-01', 100000.00),
(5016, 'Dr. Mary Beard', 'History', '2017-08-15', 86000.00),
(5017, 'Dr. Grace Hopper', 'Computer Science', '2013-09-01', 93000.00),
(5018, 'Dr. Richard Feynman', 'Physics', '2016-04-01', 91000.00),
(5019, 'Dr. Alan Turing', 'Computer Science', '2010-08-01', 95000.00),
(5020, 'Dr. Ada Lovelace', 'Computer Science', '2015-01-15', 88000.00),
(5021, 'Prof. Marie Curie', 'Physics', '2005-09-01', 110000.00),
(5022, 'Dr. Emmy Noether', 'Mathematics', '2018-06-20', 85000.00),
(5023, 'Prof. Charles Darwin', 'Biology', '2008-04-01', 105000.00),
(5024, 'Dr. Rosalind Franklin', 'Biology', '2017-11-01', 87000.00),
(5025, 'Prof. Linus Pauling', 'Chemistry', '2003-07-01', 115000.00),
(5026, 'Dr. Dorothy Hodgkin', 'Chemistry', '2016-02-10', 89000.00),
(5027, 'Prof. Stephen Hawking', 'Electrical Eng.', '2007-09-01', 108000.00),
(5028, 'Dr. Nikola Tesla', 'Electrical Eng.', '2014-05-20', 90000.00),
(5029, 'Prof. Jane Austen', 'English', '2006-10-01', 98000.00),
(5030, 'Dr. Virginia Woolf', 'English', '2019-03-01', 82000.00);


-- 4. Create Departments Table (Must be created before Enrollments due to FK dependency)
CREATE TABLE Departments (
    DeptID VARCHAR(10) PRIMARY KEY,
    DeptName VARCHAR(50) NOT NULL,
    HeadOfDeptID INT,
    Location VARCHAR(50),
    FOREIGN KEY (HeadOfDeptID) REFERENCES Instructors(InstructorID)
);

-- Insert data into Departments Table
INSERT INTO Departments (DeptID, DeptName, HeadOfDeptID, Location) VALUES
('CS', 'Computer Science', 5001, 'Engineering'),
('EE', 'Electrical Eng.', 5011, 'Engineering'),
('MA', 'Mathematics', 5005, 'Science Hall'),
('PH', 'Physics', 5003, 'Science Hall'),
('BI', 'Biology', 5007, 'Life Sciences'),
('CH', 'Chemistry', 5009, 'Life Sciences'),
('HI', 'History', 5015, 'Humanities'),
('EN', 'English', 5013, 'Humanities'),
('PSY', 'Psychology', 5002, 'Social Sci.'),
('SOC', 'Sociology', 5004, 'Social Sci.'),
('ECON', 'Economics', 5006, 'Business'),
('ART', 'Art & Design', 5008, 'Fine Arts'),
('MUS', 'Music', 5010, 'Fine Arts'),
('NUR', 'Nursing', 5012, 'Health Sci.'),
('LAW', 'Law', 5014, 'Law School'),
('MED', 'Medicine', 5016, 'Medical Ctr.'),
('BUS', 'Business Admin.', 5017, 'Business'),
('EDU', 'Education', 5018, 'Education Bldg'),
('GEOL', 'Geology', 5019, 'Science Hall'),
('STAT', 'Statistics', 5020, 'Science Hall'),
('COMM', 'Communications', 5021, 'Humanities'),
('POLS', 'Political Science', 5022, 'Social Sci.'),
('ARCH', 'Architecture', 5023, 'Design Bldg'),
('ENV', 'Environmental Sci.', 5024, 'Life Sciences'),
('LING', 'Linguistics', 5025, 'Humanities'),
('PHIL', 'Philosophy', 5026, 'Humanities'),
('ANTH', 'Anthropology', 5027, 'Social Sci.'),
('FIN', 'Finance', 5028, 'Business'),
('MKT', 'Marketing', 5029, 'Business'),
('HRM', 'Human Resources Mgmt', 5030, 'Business');


-- 5. Create Enrollments Table
CREATE TABLE Enrollments (
    EnrollmentID INT PRIMARY KEY,
    StudentID INT NOT NULL,
    CourseID VARCHAR(10) NOT NULL,
    Semester VARCHAR(20),
    Grade VARCHAR(2),
    FOREIGN KEY (StudentID) REFERENCES Students(StudentID),
    FOREIGN KEY (CourseID) REFERENCES Courses(CourseID)
);

-- Insert data into Enrollments Table
INSERT INTO Enrollments (EnrollmentID, StudentID, CourseID, Semester, Grade) VALUES
(1, 1001, 'CS101', 'Fall 2022', 'A'),
(2, 1001, 'MA101', 'Fall 2022', 'B+'),
(3, 1002, 'EE101', 'Fall 2021', 'A-'),
(4, 1002, 'PH101', 'Fall 2021', 'B'),
(5, 1003, 'MA101', 'Spring 2023', 'A'),
(6, 1003, 'CS101', 'Spring 2023', 'B+'),
(7, 1004, 'PH101', 'Fall 2022', 'A'),
(8, 1004, 'MA101', 'Fall 2022', 'C+'),
(9, 1005, 'BI101', 'Spring 2021', 'A-'),
(10, 1005, 'CH101', 'Spring 2021', 'B'),
(11, 1006, 'CH101', 'Fall 2023', 'IP'),
(12, 1007, 'CS201', 'Spring 2023', 'A'),
(13, 1007, 'CS101', 'Fall 2022', 'A'),
(14, 1008, 'HI101', 'Fall 2021', 'B+'),
(15, 1009, 'EN101', 'Spring 2023', 'A-'),
(16, 1010, 'EE201', 'Fall 2022', 'B'),
(17, 1011, 'MA201', 'Spring 2022', 'A'),
(18, 1012, 'PH201', 'Fall 2023', 'IP'),
(19, 1013, 'BI201', 'Spring 2023', 'B+'),
(20, 1014, 'CH201', 'Spring 2022', 'A-'),
(21, 1015, 'CS301', 'Fall 2023', 'IP'),
(22, 1015, 'CS201', 'Spring 2023', 'B'),
(23, 1016, 'HI201', 'Spring 2023', 'A'),
(24, 1017, 'EN201', 'Fall 2023', 'IP'),
(25, 1018, 'EE101', 'Fall 2023', 'IP'),
(26, 1019, 'MA101', 'Fall 2022', 'A'),
(27, 1020, 'PH101', 'Fall 2021', 'B+'),
(28, 1021, 'BI101', 'Spring 2023', 'A-'),
(29, 1022, 'CH101', 'Fall 2022', 'B'),
(30, 1023, 'CS101', 'Spring 2021', 'A'),
(31, 1024, 'HI101', 'Fall 2023', 'IP'),
(32, 1025, 'EN101', 'Spring 2023', 'A-'),
(33, 1026, 'EE101', 'Fall 2021', 'B'),
(34, 1027, 'MA101', 'Spring 2023', 'A'),
(35, 1028, 'PH101', 'Fall 2022', 'C+'),
(36, 1029, 'BI101', 'Spring 2021', 'A-'),
(37, 1030, 'CS101', 'Fall 2023', 'IP'),
(38, 1001, 'CS201', 'Spring 2023', 'A-'),
(39, 1002, 'EE201', 'Spring 2022', 'B+'),
(40, 1003, 'MA201', 'Fall 2023', 'IP'),
(41, 1004, 'PH201', 'Spring 2023', 'B'),
(42, 1005, 'BI201', 'Fall 2022', 'A'),
(43, 1006, 'CH201', 'Spring 2024', 'IP'),
(44, 1007, 'CS301', 'Fall 2023', 'IP'),
(45, 1008, 'HI201', 'Spring 2022', 'B-'),
(46, 1009, 'EN201', 'Fall 2023', 'IP'),
(47, 1010, 'EE301', 'Spring 2023', 'A-'),
(48, 1011, 'MA301', 'Fall 2023', 'IP'),
(49, 1012, 'PH301', 'Spring 2024', 'IP'),
(50, 1013, 'BI499', 'Fall 2023', 'IP');
