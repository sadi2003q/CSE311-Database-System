/*
 Q5: The relational schema for student course registration are as follows

Student (Id, name, street, city, dept_id, Mobile, email, CGPA, Fee-paid, tot_cred)
Takes (course-id, id, semester, year, GP, course_fee)
Course (course-id, title, credit-hour)
Student_backup (Id, name, street, city, dept_id, Mobile, email, CGPA, Fee-paid, tot_cred)


a. Update fee-paid for all students by the total course-fee paid for all taken courses and course fee is not null.
b. Insert all students of Spring 2018 into student_backup relation and delete their information from takes and student relation.
c. Make course fee = 0 for all students taking course in Summer 2024 and CGPA =4.
d. Update total credit of all students with the sum of credit hour of courses taken and GP not null and not ‘F’
 */

-- Create database
CREATE DATABASE Practise_Question_05;
USE Practise_Question_05;

-- Create Student table
CREATE TABLE Student (
    Id VARCHAR(20) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    street VARCHAR(100),
    city VARCHAR(50),
    dept_id VARCHAR(10),
    Mobile VARCHAR(15),
    email VARCHAR(100),
    CGPA DECIMAL(3,2),
    Fee_paid DECIMAL(10,2),
    tot_cred INT
);

-- Create Course table
CREATE TABLE Course (
    course_id VARCHAR(10) PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    credit_hour INT NOT NULL
);

-- Create Takes table
CREATE TABLE Takes (
    course_id VARCHAR(10),
    Id VARCHAR(20),
    semester VARCHAR(20),
    year INT,
    GP VARCHAR(2),
    course_fee DECIMAL(10,2),
    PRIMARY KEY (course_id, Id, semester, year),
    FOREIGN KEY (course_id) REFERENCES Course(course_id),
    FOREIGN KEY (Id) REFERENCES Student(Id)
);

-- Create Student_backup table
CREATE TABLE Student_backup (
    Id VARCHAR(20) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    street VARCHAR(100),
    city VARCHAR(50),
    dept_id VARCHAR(10),
    Mobile VARCHAR(15),
    email VARCHAR(100),
    CGPA DECIMAL(3,2),
    Fee_paid DECIMAL(10,2),
    tot_cred INT
);


-- Insert departments (for dept_id reference)
INSERT INTO Student (Id, name, street, city, dept_id, Mobile, email, CGPA, Fee_paid, tot_cred) VALUES
('2018-1-60-001', 'Ahmed Rahman', 'Dhanmondi Road 15', 'Dhaka', 'CSE', '01711234567', 'ahmed.rahman@edu.bd', 3.75, 50000.00, 90),
('2018-1-60-002', 'Fatima Akter', 'Mirpur Section 2', 'Dhaka', 'EEE', '01721234568', 'fatima.akter@edu.bd', 3.92, 45000.00, 85),
('2018-1-60-003', 'Rahim Khan', 'Uttara Sector 7', 'Dhaka', 'CSE', '01731234569', 'rahim.khan@edu.bd', 3.45, 55000.00, 95),
('2018-1-60-004', 'Sabrina Islam', 'Banani Road 11', 'Dhaka', 'BBA', '01741234570', 'sabrina.islam@edu.bd', 3.88, 60000.00, 100),
('2018-1-60-005', 'Kamal Hossain', 'Gulshan Avenue', 'Dhaka', 'ECO', '01751234571', 'kamal.hossain@edu.bd', 3.20, 40000.00, 80),
('2019-1-60-001', 'Nusrat Jahan', 'Mohammadpur', 'Dhaka', 'CSE', '01761234572', 'nusrat.jahan@edu.bd', 3.95, 65000.00, 105),
('2019-1-60-002', 'Arif Chowdhury', 'Bashundhara R/A', 'Dhaka', 'EEE', '01771234573', 'arif.chowdhury@edu.bd', 3.65, 50000.00, 90),
('2019-1-60-003', 'Tahmina Begum', 'Motijheel', 'Dhaka', 'BBA', '01781234574', 'tahmina.begum@edu.bd', 3.78, 55000.00, 95),
('2019-1-60-004', 'Sajid Alam', 'Farmgate', 'Dhaka', 'ECO', '01791234575', 'sajid.alam@edu.bd', 3.50, 45000.00, 85),
('2019-1-60-005', 'Farhana Yasmin', 'Shyamoli', 'Dhaka', 'CSE', '01801234576', 'farhana.yasmin@edu.bd', 4.00, 70000.00, 110),
('2020-1-60-001', 'Imran Hossain', 'Agrabad', 'Chittagong', 'EEE', '01811234577', 'imran.hossain@edu.bd', 3.85, 60000.00, 100),
('2020-1-60-002', 'Sharmin Akter', 'Nasirabad', 'Chittagong', 'BBA', '01821234578', 'sharmin.akter@edu.bd', 3.72, 50000.00, 90),
('2020-1-60-003', 'Rajib Hasan', 'Halishahar', 'Chittagong', 'ECO', '01831234579', 'rajib.hasan@edu.bd', 3.30, 45000.00, 85),
('2020-1-60-004', 'Sonia Rahman', 'Kotwali', 'Chittagong', 'CSE', '01841234580', 'sonia.rahman@edu.bd', 3.90, 65000.00, 105),
('2020-1-60-005', 'Faisal Mahmud', 'Patenga', 'Chittagong', 'EEE', '01851234581', 'faisal.mahmud@edu.bd', 3.55, 55000.00, 95),
('2021-1-60-001', 'Nargis Sultana', 'Khalishpur', 'Khulna', 'BBA', '01861234582', 'nargis.sultana@edu.bd', 3.80, 60000.00, 100),
('2021-1-60-002', 'Asad Ullah', 'Sonadanga', 'Khulna', 'ECO', '01871234583', 'asad.ullah@edu.bd', 3.45, 50000.00, 90),
('2021-1-60-003', 'Laila Kabir', 'Jamtola', 'Khulna', 'CSE', '01881234584', 'laila.kabir@edu.bd', 3.95, 70000.00, 110),
('2021-1-60-004', 'Tareq Rahman', 'Boyra', 'Khulna', 'EEE', '01891234585', 'tareq.rahman@edu.bd', 3.65, 55000.00, 95),
('2021-1-60-005', 'Nasrin Akter', 'Shiromoni', 'Khulna', 'BBA', '01901234586', 'nasrin.akter@edu.bd', 3.25, 45000.00, 85),
('2022-1-60-001', 'Sohel Rana', 'Tongi', 'Gazipur', 'ECO', '01911234587', 'sohel.rana@edu.bd', 3.75, 60000.00, 100),
('2022-1-60-002', 'Jesmin Akter', 'Konabari', 'Gazipur', 'CSE', '01921234588', 'jesmin.akter@edu.bd', 3.88, 65000.00, 105),
('2022-1-60-003', 'Rehana Begum', 'Bhabanipur', 'Gazipur', 'EEE', '01931234589', 'rehana.begum@edu.bd', 3.50, 50000.00, 90),
('2022-1-60-004', 'Jamal Uddin', 'Board Bazar', 'Gazipur', 'BBA', '01941234590', 'jamal.uddin@edu.bd', 3.95, 70000.00, 110),
('2022-1-60-005', 'Shabnam Parvin', 'Pubail', 'Gazipur', 'ECO', '01951234591', 'shabnam.parvin@edu.bd', 3.20, 45000.00, 85),
('2023-1-60-001', 'Omar Faruk', 'Station Road', 'Narsingdi', 'CSE', '01961234592', 'omar.faruk@edu.bd', 3.85, 60000.00, 100),
('2023-1-60-002', 'Hasina Begum', 'Chandpur Road', 'Narsingdi', 'EEE', '01971234593', 'hasina.begum@edu.bd', 3.65, 55000.00, 95),
('2023-1-60-003', 'Shahidul Islam', 'Madhabdi', 'Narsingdi', 'BBA', '01981234594', 'shahidul.islam@edu.bd', 3.45, 50000.00, 90),
('2023-1-60-004', 'Rina Akter', 'Shibpur', 'Narsingdi', 'ECO', '01991234595', 'rina.akter@edu.bd', 3.90, 65000.00, 105),
('2023-1-60-005', 'Monir Hossain', 'Raipura', 'Narsingdi', 'CSE', '01501234596', 'monir.hossain@edu.bd', 4.00, 70000.00, 110);

-- Insert courses
INSERT INTO Course (course_id, title, credit_hour) VALUES
('CSE101', 'Introduction to Computer Science', 3),
('CSE103', 'Structured Programming', 3),
('CSE205', 'Data Structures', 3),
('CSE207', 'Algorithms', 3),
('CSE301', 'Database Systems', 3),
('CSE303', 'Operating Systems', 3),
('CSE401', 'Artificial Intelligence', 3),
('CSE403', 'Machine Learning', 3),
('EEE101', 'Basic Electrical Engineering', 3),
('EEE201', 'Circuit Theory', 3),
('EEE301', 'Digital Electronics', 3),
('EEE401', 'Power Systems', 3),
('BBA101', 'Principles of Management', 3),
('BBA201', 'Financial Accounting', 3),
('BBA301', 'Marketing Management', 3),
('BBA401', 'Strategic Management', 3),
('ECO101', 'Principles of Economics', 3),
('ECO201', 'Microeconomics', 3),
('ECO301', 'Macroeconomics', 3),
('ECO401', 'Development Economics', 3),
('MAT101', 'Calculus I', 3),
('MAT201', 'Calculus II', 3),
('PHY101', 'Physics I', 3),
('CHE101', 'Chemistry I', 3),
('ENG101', 'English Composition', 3),
('BAN101', 'Bangla Literature', 3),
('SOC101', 'Introduction to Sociology', 3),
('STA201', 'Probability and Statistics', 3),
('CSE105', 'Discrete Mathematics', 3),
('EEE203', 'Electronics I', 3);

-- Insert takes records
INSERT INTO Takes (course_id, Id, semester, year, GP, course_fee) VALUES
-- Spring 2018 courses
('CSE101', '2018-1-60-001', 'Spring', 2018, 'A', 5000.00),
('CSE103', '2018-1-60-001', 'Spring', 2018, 'A-', 5000.00),
('MAT101', '2018-1-60-001', 'Spring', 2018, 'B+', 4000.00),
('ENG101', '2018-1-60-001', 'Spring', 2018, 'A', 3000.00),
('CSE101', '2018-1-60-002', 'Spring', 2018, 'A+', 5000.00),
('EEE101', '2018-1-60-002', 'Spring', 2018, 'A', 5000.00),
('MAT101', '2018-1-60-002', 'Spring', 2018, 'A', 4000.00),
('ENG101', '2018-1-60-002', 'Spring', 2018, 'A-', 3000.00),
('BBA101', '2018-1-60-004', 'Spring', 2018, 'A', 5000.00),
('ECO101', '2018-1-60-004', 'Spring', 2018, 'B+', 4000.00),
('MAT101', '2018-1-60-004', 'Spring', 2018, 'A-', 4000.00),
('ENG101', '2018-1-60-004', 'Spring', 2018, 'A', 3000.00),

-- Summer 2024 courses (for query c)
('CSE205', '2023-1-60-005', 'Summer', 2024, 'A', 6000.00),
('CSE207', '2023-1-60-005', 'Summer', 2024, 'A+', 6000.00),
('CSE301', '2023-1-60-005', 'Summer', 2024, 'A', 6000.00),
('CSE205', '2022-1-60-004', 'Summer', 2024, 'A', 6000.00),
('CSE207', '2022-1-60-004', 'Summer', 2024, 'A', 6000.00),

-- Other semesters
('CSE103', '2019-1-60-001', 'Fall', 2018, 'A', 5000.00),
('CSE205', '2019-1-60-001', 'Spring', 2019, 'A-', 6000.00),
('CSE207', '2019-1-60-001', 'Fall', 2019, 'B+', 6000.00),
('CSE301', '2019-1-60-001', 'Spring', 2020, 'A', 6000.00),
('CSE303', '2019-1-60-001', 'Fall', 2020, 'A-', 6000.00),
('CSE401', '2019-1-60-001', 'Spring', 2021, 'A', 7000.00),
('CSE403', '2019-1-60-001', 'Fall', 2021, 'A+', 7000.00),
('EEE101', '2019-1-60-002', 'Fall', 2018, 'A', 5000.00),
('EEE201', '2019-1-60-002', 'Spring', 2019, 'A-', 5000.00),
('EEE203', '2019-1-60-002', 'Fall', 2019, 'B+', 5000.00),
('EEE301', '2019-1-60-002', 'Spring', 2020, 'A', 6000.00),
('EEE401', '2019-1-60-002', 'Fall', 2020, 'A-', 6000.00),
('BBA101', '2019-1-60-003', 'Fall', 2018, 'A', 5000.00),
('BBA201', '2019-1-60-003', 'Spring', 2019, 'A-', 5000.00),
('BBA301', '2019-1-60-003', 'Fall', 2019, 'B+', 5000.00),
('BBA401', '2019-1-60-003', 'Spring', 2020, 'A', 6000.00),
('ECO101', '2019-1-60-004', 'Fall', 2018, 'A', 4000.00),
('ECO201', '2019-1-60-004', 'Spring', 2019, 'A-', 4000.00),
('ECO301', '2019-1-60-004', 'Fall', 2019, 'B+', 4000.00),
('ECO401', '2019-1-60-004', 'Spring', 2020, 'A', 5000.00),
('CSE101', '2019-1-60-005', 'Fall', 2018, 'A', 5000.00),
('CSE103', '2019-1-60-005', 'Spring', 2019, 'A+', 5000.00),
('CSE205', '2019-1-60-005', 'Fall', 2019, 'A', 6000.00),
('CSE207', '2019-1-60-005', 'Spring', 2020, 'A+', 6000.00),
('CSE301', '2019-1-60-005', 'Fall', 2020, 'A', 6000.00),
('CSE303', '2019-1-60-005', 'Spring', 2021, 'A+', 6000.00),
('CSE401', '2019-1-60-005', 'Fall', 2021, 'A', 7000.00),
('CSE403', '2019-1-60-005', 'Spring', 2022, 'A+', 7000.00);

