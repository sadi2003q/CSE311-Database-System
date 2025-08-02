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


-- a. Update fee-paid for all students by the total course-fee paid for all taken courses and course fee is not null.

UPDATE Student
SET Student.Fee_paid = (
    SELECT SUM(T.course_fee)
    FROM Takes T
    WHERE T.id = Student.id AND T.course_fee IS NOT NULL
)
WHERE EXISTS (
    SELECT 1
    FROM Takes T2
    WHERE T2.id = Student.id AND T2.course_fee IS NOT NULL
);

-- b. Insert all students of Spring 2018 into student_backup relation and delete their information from takes and student relation.










