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

-- Students Who Enrolled in Fall 2023 But Not Spring 2023
SELECT * FROM Students S
JOIN Enrollments E ON S.StudentID=E.StudentID
WHERE S.StudentID IN (

    SELECT Enrollments.StudentID FROM Enrollments WHERE Enrollments.Semester='Fall 2023'

) and s.StudentID NOT IN (

    SELECT Enrollments.StudentID FROM Enrollments WHERE Enrollments.Semester='Spring 2023'

);

-- Find the names of courses that have more credits than the average credits of all courses.
SELECT C.CourseName FROM Courses C
WHERE C.Credits > (

    SELECT AVG(Courses.Credits) FROM Courses

);

-- Find the names of courses that have more credits than the average credits of all courses from their department.
SELECT C1.CourseName, C1.Credits, C1.Department
FROM Courses C1
WHERE C1.Credits > (SELECT AVG(C2.Credits) FROM Courses C2 WHERE C2.Department = C1.Department);

-- List the names of students who have the earliest DateOfBirth (are the oldest) within their respective majors.


-- Find the names of departments where every instructor earns a salary greater than $90,000.
SELECT * FROM Departments D
WHERE NOT EXISTS(

    SELECT 1 FROM Instructors I
             WHERE I.Department=D.DeptName AND I.Salary<90000


);

-- List the names of students who have enrolled in every course offered by the 'Computer Science' department.
SELECT  S.StudentName FROM Students S
WHERE NOT EXISTS(
    select C.courseID from Courses C
          where c.Department='Computer Science'
          and not exists(
              select e.enrollmentID from Enrollments e
                    where e.EnrollmentID=s.StudentID and e.CourseID=C.CourseID
          )
);

SELECT S.StudentName
FROM Students S
WHERE NOT EXISTS (
    SELECT C.CourseID
    FROM Courses C
    WHERE C.Department = 'Computer Science'
    AND NOT EXISTS (
        SELECT E.EnrollmentID
        FROM Enrollments E
        WHERE E.StudentID = S.StudentID AND E.CourseID = C.CourseID
    )
);

-- Find the names of courses that have at least 5 distinct students enrolled.
SELECT C.CourseName FROM Courses C
WHERE C.CourseID IN (
    SELECT E.CourseID FROM Enrollments E
    GROUP BY E.CourseID
    HAVING COUNT(DISTINCT E.StudentID) >=5

    );

-- List the names of instructors who are currently serving as the head of a department.
SELECT I.InstructorName FROM Instructors I
WHERE I.InstructorID IN (
    SELECT D.HeadOfDeptID FROM Departments D
    WHERE D.HeadOfDeptID=I.InstructorID
);

-- Retrieve the names of students who have never received an 'F' grade in any course.
SELECT DISTINCT S.StudentName
FROM Students S
WHERE NOT EXISTS (
    SELECT 1
    FROM Enrollments E
    WHERE E.StudentID = S.StudentID AND E.Grade = 'F'
);


-- Find the names of departments that have no instructors hired after '2020-12-31'.
SELECT * FROM Departments D
WHERE D.DeptID NOT IN (
    SELECT 1
    FROM Instructors I
    WHERE I.Department=D.DeptID AND I.HireDate> '2020-12-31'
);


-- Find the course name(s) that had the maximum number of enrollments in 'Fall 2023'.
-- Step 1: Count enrollments per course in Fall 2023
select C.CourseName from Courses C
where C.






SELECT CourseName
FROM Courses
WHERE CourseID IN (
    SELECT CourseID
    FROM Enrollments
    WHERE Semester = 'Fall 2023'
    GROUP BY CourseID
    HAVING COUNT(*) = (
        -- Step 2: Find the maximum count
        SELECT MAX(EnrollCount)
        FROM (
            SELECT COUNT(*) AS EnrollCount
            FROM Enrollments
            WHERE Semester = 'Fall 2023'
            GROUP BY CourseID
        ) AS CountTable
    )
);
















