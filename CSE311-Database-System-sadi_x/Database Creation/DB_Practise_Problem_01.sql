
# Create Database for Practise Question 01
-- Drop tables if they already exist
DROP TABLE IF EXISTS Takes;
DROP TABLE IF EXISTS Student;
DROP TABLE IF EXISTS Course;

create database if not exists Practise_Question_01;
use Practise_Question_01;

-- Create Student table
CREATE TABLE Student (
    id INT PRIMARY KEY,
    name VARCHAR(100),
    street VARCHAR(100),
    city VARCHAR(50),
    mobile VARCHAR(15),
    email VARCHAR(100),
    CGPA FLOAT,
    fee_paid DECIMAL(10, 2),
    tot_cred INT
);

-- Create Course table
CREATE TABLE Course (
    course_id VARCHAR(10) PRIMARY KEY,
    title VARCHAR(100),
    credit_hour INT
);

-- Create Takes table
CREATE TABLE Takes (
    course_id VARCHAR(10),
    id INT,
    semester VARCHAR(10),
    year INT,
    GP FLOAT,
    FOREIGN KEY (course_id) REFERENCES Course(course_id),
    FOREIGN KEY (id) REFERENCES Student(id)
);

-- Insert sample data into Student
INSERT INTO Student VALUES
(1001, 'Alice', 'Main Street', 'Dhaka', '01711111111', 'alice@gmail.com', 3.5, 12000, 90),
(1002, 'Bob', 'Lake Road', 'Chittagong', '01722222222', NULL, 2.7, 8000, 60),
(1003, 'Charlie', 'Hill Road', 'Dhaka', '01733333333', 'charlie@yahoo.com', 1.9, 5000, 45),
(1004, 'David', 'Main Street', 'Khulna', '01744444444', 'david@gmail.com', 3.2, 15000, 80),
(1005, 'Eva', 'Lake Road', 'Dhaka', '01755555555', 'eva@hotmail.com', 2.1, 9000, 65),
(1100, 'Frank', 'Ocean Ave', 'Chittagong', '01766666666', 'frank@gmail.com', 2.9, 7000, 50),
(2000, 'Grace', 'Sunset Blvd', 'Sylhet', '01777777777', 'grace@gmail.com', 3.7, 10000, 95),
(2001, 'Hannah', 'Green Road', 'Dhaka', '01788888888', 'hannah@yahoo.com', 3.6, 11000, 92),
(2002, 'Ian', 'Park Street', 'Khulna', '01799999999', 'ian@hotmail.com', 2.5, 6000, 55),
(2003, 'Jane', 'Rose Avenue', 'Chittagong', '01811111111', 'jane@gmail.com', 3.1, 7500, 70),
(2004, 'Kyle', 'Main Street', 'Sylhet', '01822222222', 'kyle@outlook.com', 2.8, 9500, 68),
(2005, 'Laura', 'Sunset Blvd', 'Dhaka', '01833333333', NULL, 3.0, 8500, 72),
(2006, 'Mike', 'Hill Road', 'Rajshahi', '01844444444', 'mike@yahoo.com', 2.2, 7800, 58),
(2007, 'Nina', 'Lake Road', 'Chittagong', '01855555555', 'nina@gmail.com', 3.4, 10200, 89),
(2008, 'Oscar', 'Ocean Ave', 'Khulna', '01866666666', NULL, 1.8, 4900, 42),
(2009, 'Paula', 'Green Road', 'Dhaka', '01877777777', 'paula@hotmail.com', 2.9, 7300, 63),
(2010, 'Quinn', 'Park Street', 'Sylhet', '01888888888', 'quinn@gmail.com', 3.3, 9700, 86),
(2011, 'Rachel', 'Rose Avenue', 'Rajshahi', '01899999999', 'rachel@yahoo.com', 2.6, 6400, 57),
(2012, 'Steve', 'Main Street', 'Chittagong', '01911111111', 'steve@gmail.com', 3.0, 8000, 75),
(2013, 'Tina', 'Sunset Blvd', 'Dhaka', '01922222222', NULL, 2.4, 7100, 60),
(2014, 'Umar', 'Hill Road', 'Sylhet', '01933333333', 'umar@hotmail.com', 3.5, 9900, 88),
(2015, 'Vera', 'Lake Road', 'Rajshahi', '01944444444', 'vera@gmail.com', 2.1, 6700, 53),
(2016, 'Will', 'Ocean Ave', 'Khulna', '01955555555', 'will@yahoo.com', 2.3, 6200, 49),
(2017, 'Xena', 'Green Road', 'Chittagong', '01966666666', NULL, 3.8, 11500, 94),
(2018, 'Yasir', 'Park Street', 'Dhaka', '01977777777', 'yasir@gmail.com', 3.2, 8600, 77),
(2019, 'Zara', 'Rose Avenue', 'Khulna', '01988888888', 'zara@hotmail.com', 2.0, 5600, 51),
(2020, 'Ayan', 'Main Street', 'Rajshahi', '01999999999', 'ayan@yahoo.com', 3.1, 9200, 79),
(2021, 'Bela', 'Palm Street', 'Dhaka', '01611111111', 'bela@gmail.com', 3.0, 8900, 76),
(2022, 'Cyrus', 'Hill Road', 'Chittagong', '01622222222', 'cyrus@yahoo.com', 2.6, 6800, 59),
(2023, 'Dina', 'Ocean Ave', 'Sylhet', '01633333333', NULL, 3.4, 9500, 83),
(2024, 'Eshan', 'Lake Road', 'Khulna', '01644444444', 'eshan@hotmail.com', 2.3, 6000, 48),
(2025, 'Farah', 'Green Road', 'Rajshahi', '01655555555', 'farah@gmail.com', 3.6, 10500, 91),
(2026, 'Gavin', 'Sunset Blvd', 'Dhaka', '01666666666', NULL, 2.0, 5700, 46),
(2027, 'Helena', 'Park Street', 'Chittagong', '01677777777', 'helena@outlook.com', 2.7, 7300, 62),
(2028, 'Imran', 'Main Street', 'Sylhet', '01688888888', 'imran@gmail.com', 3.2, 9100, 78),
(2029, 'Joya', 'Rose Avenue', 'Rajshahi', '01699999999', NULL, 3.1, 8700, 74),
(2030, 'Kamal', 'Palm Street', 'Khulna', '01511111111', 'kamal@yahoo.com', 2.8, 6900, 66);


-- Insert sample data into Course
INSERT INTO Course VALUES
('CSE101', 'Intro to CS', 3),
('CSE102', 'Data Structures', 3),
('MAT101', 'Calculus I', 4),
('PHY101', 'Physics I', 3),
('ENG101', 'English Composition', 2),
('CSE103', 'Algorithms', 3),
('CSE201', 'Computer Architecture', 4),
('CSE202', 'Operating Systems', 4),
('CSE203', 'Database Systems', 3),
('MAT102', 'Calculus II', 4),
('MAT201', 'Linear Algebra', 3),
('MAT202', 'Discrete Mathematics', 3),
('PHY102', 'Physics II', 3),
('PHY201', 'Modern Physics', 4),
('CHEM101', 'General Chemistry', 4),
('BIO101', 'Biology I', 3),
('ENG102', 'Technical Writing', 2),
('HIS101', 'World History', 3),
('PHIL101', 'Introduction to Philosophy', 3),
('PSY101', 'Introduction to Psychology', 3),
('ECON101', 'Principles of Economics', 3),
('ART101', 'Art Appreciation', 2),
('MUS101', 'Music Theory', 2),
('CSE301', 'Artificial Intelligence', 3),
('CSE302', 'Machine Learning', 3),
('CSE303', 'Computer Networks', 3),
('CSE304', 'Software Engineering', 4),
('CSE401', 'Data Mining', 3),
('CSE402', 'Cloud Computing', 3),
('MAT301', 'Probability & Statistics', 3),
('MAT302', 'Differential Equations', 3),
('PHY301', 'Quantum Mechanics', 4),
('CHEM201', 'Organic Chemistry', 4),
('BIO201', 'Genetics', 4),
('ENG201', 'Creative Writing', 3),
('HIS201', 'American History', 3),
('PHIL201', 'Ethics', 3),
('PSY201', 'Abnormal Psychology', 3),
('ECON201', 'Microeconomics', 3),
('ECON202', 'Macroeconomics', 3),
('ART201', 'Digital Art', 3),
('MUS201', 'Music Composition', 3),
('BUS101', 'Introduction to Business', 3),
('BUS201', 'Marketing', 3),
('BUS202', 'Financial Accounting', 3);


-- Insert sample data into Takes
INSERT INTO Takes VALUES
('CSE101', 1001, 'Spring', 2018, 3.5),
('CSE102', 1001, 'Fall', 2000, 3.8),
('MAT101', 1002, 'Fall', 2016, 2.7),
('PHY101', 1003, 'Spring', 2018, 2.0),
('CSE101', 1002, 'Fall', 2000, 2.5),
('ENG101', 1004, 'Spring', 2016, 3.0),
('CSE102', 1005, 'Spring', 2018, 2.2),
('PHY101', 1100, 'Spring', 2016, 2.9),
('CSE101', 2000, 'Spring', 2018, 3.7),
('MAT101', 2000, 'Fall', 2016, 3.5),
('CSE103', 1001, 'Fall', 2018, 3.2),
('CSE201', 1002, 'Spring', 2017, 3.1),
('CSE202', 1003, 'Fall', 2017, 2.8),
('CSE203', 1004, 'Spring', 2019, 3.5),
('MAT102', 1005, 'Fall', 2019, 2.9),
('MAT201', 1100, 'Spring', 2020, 3.3),
('MAT202', 2000, 'Fall', 2020, 3.6),
('PHY102', 1001, 'Spring', 2019, 2.7),
('PHY201', 1002, 'Fall', 2018, 3.0),
('CHEM101', 1003, 'Spring', 2017, 2.5),
('BIO101', 1004, 'Fall', 2016, 3.1),
('ENG102', 1005, 'Spring', 2018, 3.4),
('HIS101', 1100, 'Fall', 2019, 3.7),
('PHIL101', 2000, 'Spring', 2020, 3.9),
('PSY101', 1001, 'Fall', 2017, 2.8),
('ECON101', 1002, 'Spring', 2018, 3.2),
('ART101', 1003, 'Fall', 2019, 3.5),
('MUS101', 1004, 'Spring', 2020, 3.0),
('CSE301', 1005, 'Fall', 2018, 3.6),
('CSE302', 1100, 'Spring', 2019, 3.8),
('CSE303', 2000, 'Fall', 2020, 3.2),
('CSE304', 1001, 'Spring', 2017, 3.1),
('CSE401', 1002, 'Fall', 2018, 3.4),
('CSE402', 1003, 'Spring', 2019, 3.7),
('MAT301', 1004, 'Fall', 2020, 3.0),
('MAT302', 1005, 'Spring', 2017, 2.9),
('PHY301', 1100, 'Fall', 2018, 3.5),
('CHEM201', 2000, 'Spring', 2019, 3.2),
('BIO201', 1001, 'Fall', 2020, 3.6),
('ENG201', 1002, 'Spring', 2017, 3.3),
('HIS201', 1003, 'Fall', 2018, 3.4),
('PHIL201', 1004, 'Spring', 2019, 3.7),
('PSY201', 1005, 'Fall', 2020, 3.1),
('ECON201', 1100, 'Spring', 2017, 3.5),
('ECON202', 2000, 'Fall', 2018, 3.8),
('ART201', 1001, 'Spring', 2019, 3.2),
('MUS201', 1002, 'Fall', 2020, 3.4),
('BUS101', 1003, 'Spring', 2017, 3.6),
('BUS201', 1004, 'Fall', 2018, 3.0),
('BUS202', 1005, 'Spring', 2019, 3.5),
('CSE101', 1003, 'Fall', 2017, 2.8),
('CSE102', 1004, 'Spring', 2018, 3.1),
('MAT101', 1005, 'Fall', 2019, 3.4),
('PHY101', 1100, 'Spring', 2020, 2.9),
('ENG101', 2000, 'Fall', 2017, 3.2),
('CSE101', 1004, 'Spring', 2018, 3.5),
('CSE102', 1005, 'Fall', 2019, 3.0),
('MAT101', 1100, 'Spring', 2020, 3.6),
('PHY101', 2000, 'Fall', 2017, 3.1),
('ENG101', 1001, 'Spring', 2018, 3.4);
