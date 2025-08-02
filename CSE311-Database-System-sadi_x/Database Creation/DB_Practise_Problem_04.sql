/*
employee (person name, street, city)
works (person_name, company_name, salary)
company (company_name, city)

Write SQL for the following queries:
a. Find person name, street, employee city, company name, company city for all employees salary greater than 10000.
b. Find person name, street and city of all employees who live in the same city as ‘Mr. Akib’ lives.
c. Find all person name of all employees who live in the same city as the company.
 */


 -- Create database
CREATE DATABASE if not exists Practise_Question_04;
USE Practise_Question_04;

-- Create company table
CREATE TABLE company (
    company_name VARCHAR(100) PRIMARY KEY,
    city VARCHAR(50)
);

-- Create employee table
CREATE TABLE employee (
    person_name VARCHAR(100) PRIMARY KEY,
    street VARCHAR(100),
    city VARCHAR(50)
);

-- Create works table
CREATE TABLE works (
    person_name VARCHAR(100),
    company_name VARCHAR(100),
    salary DECIMAL(10,2),
    PRIMARY KEY (person_name, company_name),
    FOREIGN KEY (person_name) REFERENCES employee(person_name),
    FOREIGN KEY (company_name) REFERENCES company(company_name)
);


-- Insert companies in Bangladesh
INSERT INTO company (company_name, city) VALUES
('Grameenphone Ltd', 'Dhaka'),
('Robi Axiata Limited', 'Dhaka'),
('Banglalink Digital Communications', 'Dhaka'),
('Square Pharmaceuticals', 'Dhaka'),
('Beximco Pharmaceuticals', 'Dhaka'),
('Walton Hi-Tech Industries', 'Gazipur'),
('PRAN-RFL Group', 'Narsingdi'),
('ACI Limited', 'Dhaka'),
('Bashundhara Group', 'Dhaka'),
('City Group', 'Chittagong'),
('M.M. Ispahani Limited', 'Chittagong'),
('Akij Group', 'Dhaka'),
('Navana Group', 'Dhaka'),
('Transcom Group', 'Dhaka'),
('Partex Star Group', 'Dhaka'),
('Bengal Group of Industries', 'Dhaka'),
('Nitol Niloy Group', 'Dhaka'),
('Ananda Group', 'Dhaka'),
('Habib Group', 'Chittagong'),
('KDS Group', 'Dhaka'),
('Mondol Group', 'Khulna'),
('Gemcon Group', 'Dhaka'),
('Doreen Group', 'Dhaka'),
('Aamra Companies', 'Dhaka'),
('Bengal Meat', 'Dhaka'),
('ACI Logistics', 'Chittagong'),
('Runner Group', 'Gazipur'),
('Orion Group', 'Dhaka'),
('PQS Limited', 'Dhaka'),
('Epyllion Group', 'Dhaka');

-- Insert employees
INSERT INTO employee (person_name, street, city) VALUES
('Mr. Akib', 'Road 12/A', 'Dhaka'),
('Ms. Fatima Rahman', 'Banani Road 11', 'Dhaka'),
('Mr. Rahim Khan', 'Gulshan Avenue', 'Dhaka'),
('Ms. Tahmina Akter', 'Mirpur Road', 'Dhaka'),
('Mr. Sajid Hossain', 'Dhanmondi Road 2', 'Dhaka'),
('Ms. Nusrat Jahan', 'Uttara Sector 4', 'Dhaka'),
('Mr. Arif Chowdhury', 'Motijheel Commercial Area', 'Dhaka'),
('Ms. Sabrina Islam', 'Bashundhara Residential Area', 'Dhaka'),
('Mr. Kamal Ahmed', 'Mohakhali DOHS', 'Dhaka'),
('Ms. Farhana Yasmin', 'Baridhara Diplomatic Zone', 'Dhaka'),
('Mr. Imran Hossain', 'Agrabad Commercial Area', 'Chittagong'),
('Ms. Sharmin Akter', 'Nasirabad', 'Chittagong'),
('Mr. Rajib Hasan', 'Halishahar', 'Chittagong'),
('Ms. Sonia Rahman', 'Kotwali', 'Chittagong'),
('Mr. Faisal Mahmud', 'Patenga', 'Chittagong'),
('Ms. Nargis Sultana', 'Jamtola', 'Khulna'),
('Mr. Asad Ullah', 'Khalishpur', 'Khulna'),
('Ms. Laila Kabir', 'Sonadanga', 'Khulna'),
('Mr. Tareq Rahman', 'Boyra', 'Khulna'),
('Ms. Nasrin Akter', 'Shiromoni', 'Khulna'),
('Mr. Sohel Rana', 'Tongi Station Road', 'Gazipur'),
('Ms. Jesmin Akter', 'Konabari', 'Gazipur'),
('Ms. Rehana Begum', 'Bhabanipur', 'Gazipur'),
('Mr. Jamal Uddin', 'Board Bazar', 'Gazipur'),
('Ms. Shabnam Parvin', 'Pubail', 'Gazipur'),
('Mr. Omar Faruk', 'Station Road', 'Narsingdi'),
('Ms. Hasina Begum', 'Chandpur Road', 'Narsingdi'),
('Mr. Shahidul Islam', 'Madhabdi', 'Narsingdi'),
('Ms. Rina Akter', 'Shibpur', 'Narsingdi'),
('Mr. Monir Hossain', 'Raipura', 'Narsingdi');

-- Insert works relationships
INSERT INTO works (person_name, company_name, salary) VALUES
('Mr. Akib', 'Grameenphone Ltd', 150000.00),
('Ms. Fatima Rahman', 'Robi Axiata Limited', 120000.00),
('Mr. Rahim Khan', 'Banglalink Digital Communications', 9500.00),
('Ms. Tahmina Akter', 'Square Pharmaceuticals', 85000.00),
('Mr. Sajid Hossain', 'Beximco Pharmaceuticals', 110000.00),
('Ms. Nusrat Jahan', 'Walton Hi-Tech Industries', 7500.00),
('Mr. Arif Chowdhury', 'PRAN-RFL Group', 105000.00),
('Ms. Sabrina Islam', 'ACI Limited', 8000.00),
('Mr. Kamal Ahmed', 'Bashundhara Group', 125000.00),
('Ms. Farhana Yasmin', 'City Group', 9000.00),
('Mr. Imran Hossain', 'M.M. Ispahani Limited', 115000.00),
('Ms. Sharmin Akter', 'Akij Group', 7800.00),
('Mr. Rajib Hasan', 'Navana Group', 132000.00),
('Ms. Sonia Rahman', 'Transcom Group', 8500.00),
('Mr. Faisal Mahmud', 'Partex Star Group', 95000.00),
('Ms. Nargis Sultana', 'Bengal Group of Industries', 8200.00),
('Mr. Asad Ullah', 'Nitol Niloy Group', 140000.00),
('Ms. Laila Kabir', 'Ananda Group', 8800.00),
('Mr. Tareq Rahman', 'Habib Group', 92000.00),
('Ms. Nasrin Akter', 'KDS Group', 7600.00),
('Mr. Sohel Rana', 'Mondol Group', 128000.00),
('Ms. Jesmin Akter', 'Gemcon Group', 8300.00),
('Ms. Rehana Begum', 'Doreen Group', 98000.00),
('Mr. Jamal Uddin', 'Aamra Companies', 7500.00),
('Ms. Shabnam Parvin', 'Bengal Meat', 112000.00),
('Mr. Omar Faruk', 'ACI Logistics', 8900.00),
('Ms. Hasina Begum', 'Runner Group', 105000.00),
('Mr. Shahidul Islam', 'Orion Group', 9200.00),
('Ms. Rina Akter', 'PQS Limited', 135000.00),
('Mr. Monir Hossain', 'Epyllion Group', 8200.00);




