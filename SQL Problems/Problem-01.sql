/*
 Student (Id, name, street, city. Mobile, email, CGPA, Fee-paid, tot_cred)
 Takes (course-id, id, semester, year, GP)
 Course (course-id, title, credit-hour)

Q: Write SQL statements for the following queries
    a. Find all distinct street and cities where students live.
    b. Find all cities for students with Ids between 1111 and 6666. There will be no duplicate in the result.
    c. Find all Id, name and course id of all students who took courses in the year 2000.
    d. Find all Id, name, course id, title and year of all students who registered all 3 credit hour courses.

Q. 2: Write SQL statements for the following queries:
    a. Find Id, name, street and city of all students who have no email.
    b. Find Id, name, street and city of all students who use Gmail as his email. You have to search sub-string “gmail”.
    c. Find the city and street wise maximum, minimum and average CGPA for all students with CGPA >= 2 and average CGPA is also greater than or equal to 2.
    d. Find the city and street wise total amount, maximum, minimum and average Fee-paid in year 2016.
    e. Find the city and street wise total number of students, maximum, minimum and average CGPA for all 3 credit-hour courses. Output will be city, street, total-num-student, max-CGPA, min-CGPA, avg-CGPA.
    f. Find the city and street wise maximum, minimum and average CGPA in year 2016 for minimum CGPA greater than 2.
    g. Find semester and year wise GPA of all students. Average GP is considered as GPA.
    h. Find id, name, street, city and CGPA of those students who have taken courses in spring 2018 and CGPA is greater than the average GP of students of Dhaka district.
 */

/*
-- IN: Select students who are from either Mumbai or Delhi
-- NOT IN: Select students who are NOT from Mumbai or Delhi
-- BETWEEN: Select students whose marks are between 80 and 95 (inclusive)
 */
use Practise_Question_01;

--  a. Find all distinct street and cities where students live.
select distinct street, city from Student;

-- b. Find all cities for students with Ids between 1111 and 6666. There will be no duplicate in the result.
select distinct
    Student.city, Student.id
from
    student
where Student.id between 1111 and 6666;

-- c. Find all Id, name and course id of all students who took courses in the year 2000.
select
    Student.id, Student.name, Takes.course_id
from
    Student
join
        Takes on Student.id = Takes.id
where
    Takes.year=2000;

-- d. Find all Id, name, course id, title and year of all students who registered all 3 credit hour courses.
select
    Student.id,
    Student.name,
    Course.course_id,
    Course.title,
    Takes.year
from
    Student
join
        Takes on Takes.id = Student.id
join
        Course on Takes.course_id=Course.course_id
where
    Course.credit_hour=3;
