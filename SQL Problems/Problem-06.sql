use University;



-- List the names of students who are enrolled in the course 'CS101'.

select s.StudentName from Students s
where s.StudentID in (

    select e.StudentID from Enrollments e
    where e.CourseID='CS101'

);


-- Find the names of courses that currently have no students enrolled (i.e., no entries in the Enrollments table).
select c.CourseName from Courses c
where c.CourseID not in (
    select distinct e.CourseID from Enrollments e

    );


-- Retrieve the names of instructors who earn more than the average salary of instructors in their own department
select i.InstructorName from Instructors i
where i.Salary > (
    select AVG(ii.Salary) from Instructors ii
    where ii.Department=i.Department
    );


-- List the names of students who have not enrolled in any course yet.
select s.StudentName from Students s
where s.StudentID not in (
    select DISTINCT e.StudentID from Enrollments e
    );


-- Find the names of departments that have more than 3 instructors.
select d.DeptName from Departments d
where d.DeptName in (
    select i.Department from Instructors i
    group by i.Department
    having count(i.InstructorID) > 3
);


-- Get the names of students who have received an 'A' grade in at least one course.
select s.StudentName from Students s
where s.StudentID in (
    select DISTINCT e.StudentID from Enrollments e
    where e.Grade like 'A'

);







