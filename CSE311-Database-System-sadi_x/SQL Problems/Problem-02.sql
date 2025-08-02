/*
 Student (Id, name, street, city. Mobile, email, CGPA, Fee-paid, tot_cred)
 Takes (course-id, id, semester, year, GP)
 Course (course-id, title, credit-hour)

 Q.Write SQL statements for the following queries:
    a. Find Id, name, street and city of all students who have no email.
    b. Find Id, name, street and city of all students who use Gmail as his email. You have to search sub-string “gmail”.
    c. Find the city and street wise maximum, minimum and average CGPA for all students with CGPA >= 2 and average CGPA is also greater than or equal to 2.
    d. Find the city and street wise total amount, maximum, minimum and average Fee-paid in year 2016.
    e. Find the city and street wise total number of students, maximum, minimum and average CGPA for all 3 credit-hour courses. Output will be city, street, total-num-student, max-CGPA, min-CGPA, avg-CGPA.
    f. Find the city and street wise maximum, minimum and average CGPA in year 2016 for minimum CGPA greater than 2.
    g. Find semester and year wise GPA of all students. Average GP is considered as GPA.
    h. Find id, name, street, city and CGPA of those students who have taken courses in spring 2018 and CGPA is greater than the average GP of students of Dhaka district.
 */



-- AGGREGATE FUNCTIONS

-- COUNT() ==> returns the total number of rows or non-NULL values in a column
-- SUM() ==> returns the total sum of a numeric column
-- AVG() ==> returns the average (mean) of a numeric column
-- MIN() ==> returns the smallest (minimum) value in a column
-- MAX() ==> returns the largest (maximum) value in a column
-- FIRST() ==> returns the first value in a column (note: not supported in all SQL dialects)
-- LAST() ==> returns the last value in a column (note: not supported in all SQL dialects)
-- VAR() ==> returns the variance of a numeric column (varies by SQL dialect)
-- STDDEV() ==> returns the standard deviation of a numeric column (varies by SQL dialect)


 -- a. Find Id, name, street and city of all students who have no email.
SELECT Student.name, Student.id, Student.street
from Student
where email IS NULL;

-- b. Find Id, name, street and city of all students who use Gmail as his email. You have to search sub-string “gmail”.
select id, name, street, city, email
from Student
where email like '%gmail%';

-- c. Find the city and street wise maximum, minimum and average CGPA for all students with CGPA >= 2 and average CGPA is also greater than or equal to 2.
select
    city,
    street,
    max(Student.CGPA),
    min(Student.CGPA),
    round(avg(Student.CGPA), 2)
from Student
where
    CGPA>2
group by
    city, street
having
    avg(CGPA) > 2
order by
    city, street;

-- d. Find the city and street wise total amount, maximum, minimum and average Fee-paid in year 2016.
select
    Student.city,
    Student.street,
    sum(Student.fee_paid),
    max(Student.fee_paid),
    min(Student.fee_paid),
    avg(Student.fee_paid)
from
    Student
join
        Takes on Student.id=Takes.id
where
    Takes.year=2016
GROUP BY
    Student.city, student.street;

--  e. Find the city and street wise total number of students, maximum, minimum and average CGPA for all 3 credit-hour courses. Output will be city, street, total-num-student, max-CGPA, min-CGPA, avg-CGPA.
select
    student.city,
    student.street,
    count(Student.name),
    max(Student.CGPA),
    min(student.cgpa),
    avg(Student.CGPA)
from Student
join
    Takes on student.id=Takes.id
join
    Course on Takes.course_id=Course.course_id
where
    credit_hour=3
GROUP BY
    city, street;

-- f. Find the city and street wise maximum, minimum and average CGPA in year 2016 for minimum CGPA greater than 2.
select
    student.city,
    student.street,
    max(student.cgpa) as maximum_cgpa,
    min(student.cgpa) as minimum_cgpa,
    avg(student.cgpa) as average_cgpa
from
    student
join
        Takes on Student.id=Takes.id
where
    Takes.year=2016
group by
    student.city,
    student.street
having
    MIN(Student.CGPA) > 2;

-- g. Find semester and year wise GPA of all students. Average GPA is considered as Average CGPA.
select
    student.id,
    student.name,
    Takes.semester,
    Takes.year,
    avg(Student.cgpa)
from
    Student
join
        Takes on Student.id=Takes.id
group by
    Takes.semester,
    Takes.year,
    student.id,
    student.name;


-- h. Find id, name, street, city and CGPA of those students who have taken courses in spring 2018 and CGPA is greater than the average GP of students of Dhaka district.
select
    Student.id,
    Student.name,
    Student.street,
    student.city,
    student.CGPA
from
    Student
join
        Takes on Student.id=Takes.id
where
    Takes.semester = 'Spring'
    AND Takes.year = 2018
    AND Student.CGPA > (
        SELECT
            AVG(CGPA)
        FROM
            Student
    )
    AND Student.city='Dhaka';























