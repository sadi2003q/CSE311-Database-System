-- Create database
CREATE DATABASE practise_problem2_1;
USE practise_problem2_1;

-- Create tables
CREATE TABLE Parents_S (
    F_NID VARCHAR(17) PRIMARY KEY,
    M_NID VARCHAR(17),
    Sid INT,
    F_name VARCHAR(50),
    M_name VARCHAR(50),
    street VARCHAR(100),
    city VARCHAR(50),
    income DECIMAL(12,2)
);

CREATE TABLE Student (
    Sid INT PRIMARY KEY,
    name VARCHAR(50),
    street VARCHAR(100),
    city VARCHAR(50),
    Mobile VARCHAR(11),
    email VARCHAR(100),
    CGPA DECIMAL(3,2),
    age INT,
    tot_cred INT,
    dept_id VARCHAR(10)
);

CREATE TABLE Takes (
    course_id VARCHAR(10),
    Sid INT,
    semester VARCHAR(10),
    year INT,
    gradepoint VARCHAR(2),
    PRIMARY KEY (course_id, Sid, semester, year)
);

CREATE TABLE Course (
    course_id VARCHAR(10) PRIMARY KEY,
    title VARCHAR(100),
    credit_hour INT
);

CREATE TABLE Parents_T (
    F_NID VARCHAR(17) PRIMARY KEY,
    M_NID VARCHAR(17),
    Tid INT,
    F_name VARCHAR(50),
    M_name VARCHAR(50),
    street VARCHAR(100),
    city VARCHAR(50),
    income DECIMAL(12,2)
);

CREATE TABLE Teacher (
    Tid INT PRIMARY KEY,
    name VARCHAR(50),
    designation VARCHAR(50),
    street VARCHAR(100),
    city VARCHAR(50),
    Mobile VARCHAR(11),
    email VARCHAR(100),
    salary DECIMAL(12,2),
    date_of_birth DATE,
    dept_id VARCHAR(10)
);

CREATE TABLE Teach (
    course_id VARCHAR(10),
    Tid INT,
    semester VARCHAR(10),
    year INT,
    remuneration DECIMAL(10,2),
    PRIMARY KEY (course_id, Tid, semester, year)
);



-- Insert data into Course table
INSERT INTO Course (course_id, title, credit_hour) VALUES
('CSE101', 'Introduction to Programming', 3),
('CSE102', 'Data Structures', 3),
('CSE201', 'Database Management Systems', 3),
('CSE202', 'Computer Networks', 3),
('CSE301', 'Software Engineering', 3),
('MAT101', 'Calculus I', 3),
('MAT102', 'Linear Algebra', 3),
('PHY101', 'Physics I', 4),
('ENG101', 'English Composition', 2),
('BAN101', 'Bangla Literature', 2),
('CSE103', 'Object Oriented Programming', 3),
('CSE203', 'Algorithms', 3),
('CSE302', 'Machine Learning', 4),
('CSE401', 'Thesis', 2),
('GEN101', 'Bangladesh Studies', 2);

-- Insert data into Student table
INSERT INTO Student (Sid, name, street, city, Mobile, email, CGPA, age, tot_cred, dept_id) VALUES
(1001, 'Abid Rahman', 'Dhanmondi 15', 'Dhaka', '01712345678', 'abid@gmail.com', 3.85, 22, 135, 'CSE'),
(1002, 'Fatima Khatun', 'Gulshan 2', 'Dhaka', '01823456789', 'fatima@gmail.com', 4.00, 21, 130, 'CSE'),
(1003, 'Mohammad Ali', 'Uttara 10', 'Dhaka', '01934567890', 'ali@gmail.com', 3.60, 23, 125, 'CSE'),
(1004, 'Rashida Begum', 'Shahbag', 'Dhaka', '01645678901', 'rashida@gmail.com', 3.90, 22, 140, 'EEE'),
(1005, 'Karim Uddin', 'Court Road', 'Rajshahi', '01756789012', 'karim@gmail.com', 3.45, 24, 128, 'CSE'),
(1006, 'Nasir Hossain', 'Medical Road', 'Rajshahi', '01867890123', 'nasir@gmail.com', 3.70, 23, 132, 'EEE'),
(1007, 'Salma Akter', 'Station Road', 'Chittagong', '01978901234', 'salma@gmail.com', 3.55, 22, 120, 'BBA'),
(1008, 'Rafiq Ahmed', 'GEC Circle', 'Chittagong', '01589012345', 'rafiq@gmail.com', 3.80, 25, 145, 'CSE'),
(1009, 'Taslima Nasreen', 'Kalabagan', 'Dhaka', '01690123456', 'taslima@gmail.com', 4.00, 20, 130, 'CSE'),
(1010, 'Habib Wahid', 'Banani', 'Dhaka', '01701234567', 'habib@gmail.com', 3.65, 24, 138, 'EEE'),
(1011, 'Ruma Khatun', 'Mohammadpur', 'Dhaka', '01812345678', 'ruma@gmail.com', 3.75, 23, 142, 'BBA'),
(1012, 'Jahangir Alam', 'New Market', 'Rajshahi', '01923456789', 'jahangir@gmail.com', 3.40, 25, 118, 'CSE'),
(1013, 'Shireen Aktar', 'Agrabad', 'Chittagong', '01634567890', 'shireen@gmail.com', 3.85, 22, 135, 'EEE'),
(1014, 'Babul Miah', 'Wari', 'Dhaka', '01745678901', 'babul@gmail.com', 3.50, 26, 125, 'BBA'),
(1015, 'Rokeya Begum', 'Ramna', 'Dhaka', '01856789012', 'rokeya@gmail.com', 3.95, 21, 148, 'CSE');

-- Insert data into Parents_S table
INSERT INTO Parents_S (F_NID, M_NID, Sid, F_name, M_name, street, city, income) VALUES
('1234567890123', '1234567890124', 1001, 'Abdul Rahman', 'Rashida Rahman', 'Dhanmondi 15', 'Dhaka', 750000.00),
('2345678901234', '2345678901235', 1002, 'Mohammad Hasan', 'Fatema Begum', 'Gulshan 2', 'Dhaka', 920000.00),
('3456789012345', '3456789012346', 1003, 'Ali Ahmed', 'Nasreen Akter', 'Uttara 10', 'Dhaka', 680000.00),
('4567890123456', '4567890123457', 1004, 'Abdul Karim', 'Rahima Khatun', 'Shahbag', 'Dhaka', 850000.00),
('5678901234567', '5678901234568', 1005, 'Karim Miah', 'Salma Begum', 'Court Road', 'Rajshahi', 520000.00),
('6789012345678', '6789012345679', 1006, 'Nasir Ali', 'Ruma Akter', 'Medical Road', 'Rajshahi', 580000.00),
('7890123456789', '7890123456790', 1007, 'Abdul Jabbar', 'Shireen Begum', 'Station Road', 'Chittagong', 450000.00),
('8901234567890', '8901234567891', 1008, 'Rafiqul Islam', 'Nasreen Khatun', 'GEC Circle', 'Chittagong', 720000.00),
('9012345678901', '9012345678902', 1009, 'Nazrul Islam', 'Tahmina Begum', 'Kalabagan', 'Dhaka', 980000.00),
('0123456789012', '0123456789013', 1010, 'Habibur Rahman', 'Rashida Akter', 'Banani', 'Dhaka', 1100000.00),
('1123456789012', '1123456789013', 1011, 'Ruhul Amin', 'Ruma Begum', 'Mohammadpur', 'Dhaka', 650000.00),
('2123456789012', '2123456789013', 1012, 'Jahangir Hossain', 'Salma Khatun', 'New Market', 'Rajshahi', 480000.00),
('3123456789012', '3123456789013', 1013, 'Akbar Ali', 'Shireen Begum', 'Agrabad', 'Chittagong', 420000.00),
('4123456789012', '4123456789013', 1014, 'Babul Hossain', 'Rahima Akter', 'Wari', 'Dhaka', 590000.00),
('5123456789012', '5123456789013', 1015, 'Rokon Uddin', 'Rokeya Khatun', 'Ramna', 'Dhaka', 780000.00);

-- Insert data into Teacher table
INSERT INTO Teacher (Tid, name, designation, street, city, Mobile, email, salary, date_of_birth, dept_id) VALUES
(1001, 'Dr. Aminul Islam', 'Professor', 'Dhanmondi 32', 'Dhaka', '01711111111', 'aminul@university.edu.bd', 120000.00, '1975-03-15', 'CSE'),
(1002, 'Dr. Rashida Sultana', 'Associate Professor', 'Gulshan 1', 'Dhaka', '01722222222', 'rashida@university.edu.bd', 95000.00, '1980-07-22', 'CSE'),
(1003, 'Prof. Mohammad Karim', 'Professor', 'Uttara 7', 'Dhaka', '01733333333', 'karim@university.edu.bd', 130000.00, '1970-11-08', 'EEE'),
(1004, 'Dr. Fatema Begum', 'Assistant Professor', 'Shahbag', 'Dhaka', '01744444444', 'fatema@university.edu.bd', 75000.00, '1985-02-14', 'CSE'),
(1005, 'Dr. Nazrul Haque', 'Associate Professor', 'Court Road', 'Rajshahi', '01755555555', 'nazrul@university.edu.bd', 88000.00, '1978-09-30', 'CSE'),
(1006, 'Prof. Salma Khatun', 'Professor', 'Medical Road', 'Rajshahi', '01766666666', 'salma@university.edu.bd', 125000.00, '1972-05-18', 'EEE'),
(1007, 'Dr. Rafiq Uddin', 'Assistant Professor', 'Station Road', 'Chittagong', '01777777777', 'rafiq@university.edu.bd', 72000.00, '1987-12-03', 'BBA'),
(1008, 'Dr. Taslima Akter', 'Associate Professor', 'GEC Circle', 'Chittagong', '01788888888', 'taslima@university.edu.bd', 92000.00, '1979-04-25', 'CSE'),
(1009, 'Prof. Habibur Rahman', 'Professor', 'Kalabagan', 'Dhaka', '01799999999', 'habib@university.edu.bd', 135000.00, '1968-08-12', 'CSE'),
(1010, 'Dr. Ruma Yasmin', 'Assistant Professor', 'Banani', 'Dhaka', '01700000000', 'ruma@university.edu.bd', 78000.00, '1986-01-20', 'EEE'),
(1011, 'Dr. Jahangir Kabir', 'Associate Professor', 'Mohammadpur', 'Dhaka', '01711110000', 'jahangir@university.edu.bd', 90000.00, '1981-06-07', 'BBA'),
(1012, 'Prof. Shireen Sultana', 'Professor', 'New Market', 'Rajshahi', '01722220000', 'shireen@university.edu.bd', 128000.00, '1973-10-15', 'CSE'),
(1013, 'Dr. Babul Akter', 'Assistant Professor', 'Agrabad', 'Chittagong', '01733330000', 'babul@university.edu.bd', 74000.00, '1988-03-28', 'EEE'),
(1014, 'Dr. Rokeya Islam', 'Associate Professor', 'Wari', 'Dhaka', '01744440000', 'rokeya@university.edu.bd', 85000.00, '1982-11-11', 'BBA'),
(1015, 'Prof. Abdul Mannan', 'Professor', 'Ramna', 'Dhaka', '01755550000', 'mannan@university.edu.bd', 140000.00, '1969-04-05', 'CSE');

-- Insert data into Parents_T table
INSERT INTO Parents_T (F_NID, M_NID, Tid, F_name, M_name, street, city, income) VALUES
('1234567890123', '1234567890124', 1001, 'Abdul Rahman', 'Rashida Rahman', 'Dhanmondi 32', 'Dhaka', 850000.00),
('9876543210987', '9876543210988', 1002, 'Rashid Ahmed', 'Sultana Begum', 'Gulshan 1', 'Dhaka', 720000.00),
('8765432109876', '8765432109877', 1003, 'Karim Mollah', 'Rahima Khatun', 'Uttara 7', 'Dhaka', 950000.00),
('7654321098765', '7654321098766', 1004, 'Fazlul Haque', 'Fatema Akter', 'Shahbag', 'Dhaka', 680000.00),
('6543210987654', '6543210987655', 1005, 'Nazrul Ahmed', 'Nasreen Begum', 'Court Road', 'Rajshahi', 540000.00),
('5432109876543', '5432109876544', 1006, 'Salim Uddin', 'Salma Akter', 'Medical Road', 'Rajshahi', 620000.00),
('4321098765432', '4321098765433', 1007, 'Rafique Miah', 'Rashida Khatun', 'Station Road', 'Chittagong', 480000.00),
('3210987654321', '3210987654322', 1008, 'Taslim Ahmed', 'Tahmina Begum', 'GEC Circle', 'Chittagong', 590000.00),
('2109876543210', '2109876543211', 1009, 'Habib Miah', 'Rahima Akter', 'Kalabagan', 'Dhaka', 880000.00),
('1098765432109', '1098765432110', 1010, 'Ruhul Amin', 'Ruma Khatun', 'Banani', 'Dhaka', 750000.00),
('0987654321098', '0987654321099', 1011, 'Jahangir Miah', 'Jaheda Begum', 'Mohammadpur', 'Dhaka', 670000.00),
('9876543210988', '9876543210989', 1012, 'Shireen Mollah', 'Sultana Akter', 'New Market', 'Rajshahi', 520000.00),
('8765432109877', '8765432109878', 1013, 'Babul Ahmed', 'Rashida Begum', 'Agrabad', 'Chittagong', 450000.00),
('7654321098766', '7654321098767', 1014, 'Rokon Uddin', 'Rokeya Akter', 'Wari', 'Dhaka', 710000.00),
('6543210987655', '6543210987656', 1015, 'Abdul Mannan', 'Rashida Khatun', 'Ramna', 'Dhaka', 820000.00);

-- Insert data into Takes table
INSERT INTO Takes (course_id, Sid, semester, year, gradepoint) VALUES
-- Abid Rahman (1001) courses for Fall 2018 - these will be used in queries 5 and 6
('CSE101', 1001, 'Fall', 2018, 'A'),
('CSE102', 1001, 'Fall', 2018, 'A-'),
('MAT101', 1001, 'Fall', 2018, 'B+'),
-- Other students taking same courses as Abid in Fall 2018
('CSE101', 1002, 'Fall', 2018, 'A+'),
('CSE102', 1002, 'Fall', 2018, 'A'),
('MAT101', 1002, 'Fall', 2018, 'A'),
('CSE101', 1009, 'Fall', 2018, 'A'),
('CSE102', 1009, 'Fall', 2018, 'A+'),
('MAT101', 1009, 'Fall', 2018, 'A-'),
-- Additional course data
('CSE201', 1001, 'Spring', 2019, 'A-'),
('CSE202', 1002, 'Spring', 2019, 'A'),
('CSE301', 1003, 'Fall', 2019, 'B+'),
('PHY101', 1004, 'Spring', 2020, 'A'),
('ENG101', 1005, 'Fall', 2020, 'B'),
('BAN101', 1006, 'Spring', 2021, 'A-');

-- Insert data into Teach table
INSERT INTO Teach (course_id, Tid, semester, year, remuneration) VALUES
-- Spring 2024 courses with 3 credits (for query 7)
('CSE101', 1001, 'Spring', 2024, 15000.00),
('CSE102', 1002, 'Spring', 2024, 15000.00),
('CSE201', 1004, 'Spring', 2024, 15000.00),
('MAT101', 1005, 'Spring', 2024, 15000.00),
('CSE301', 1008, 'Spring', 2024, 15000.00),
-- Spring 2023 courses (for query 9)
('CSE101', 1001, 'Spring', 2023, 12000.00),
('CSE102', 1002, 'Spring', 2023, 12000.00),
('CSE103', 1002, 'Spring', 2023, 12000.00),
('CSE201', 1004, 'Spring', 2023, 12000.00),
('MAT101', 1005, 'Spring', 2023, 12000.00),
('MAT102', 1005, 'Spring', 2023, 12000.00),
('PHY101', 1003, 'Spring', 2023, 16000.00),
('ENG101', 1007, 'Spring', 2023, 8000.00),
('BAN101', 1011, 'Spring', 2023, 8000.00),
('CSE203', 1009, 'Spring', 2023, 12000.00);
