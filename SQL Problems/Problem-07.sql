--  Find the names of all students who are enrolled in at least one course taught by an instructor whose salary is above $100,000, and also list the names of those courses.


/*

Here are 20 advanced SQL JOIN questions based on the University Database schema provided. These questions require a solid understanding of various JOIN types, subqueries, aggregation, and conditional logic.

Advanced SQL JOIN Questions

Find the names of all students who are enrolled in at least one course taught by an instructor whose salary is above $100,000, and also list the names of those courses.

Hint: Multiple INNER JOINs.

List all departments that have no instructors assigned to them, or whose head of department is not yet specified.

Hint: LEFT JOIN with IS NULL conditions.

Find the student_id, first_name, last_name of students who are enrolled in 'Introduction to Programming' (CS101) but have a grade worse than 'B'.

Hint: INNER JOIN with a WHERE clause and string comparison.

For each department, list the department_name and the first_name and last_name of its head. Include departments that do not currently have a head assigned.

Hint: LEFT JOIN on the Departments table to Instructors for the head of department.

Identify all courses that are taught in a building built before 2000, and list the course_name, building_name, and year_built.

Hint: INNER JOIN with a date/year condition.

Find the student_id, first_name, last_name, and course_name for all students who have enrolled in more than one course from the 'Computer Science' department.

Hint: Multiple JOINs, GROUP BY, HAVING, and a subquery or derived table.

List the department_name and the average gpa of students majoring in that department. Include departments with no students, showing NULL for average GPA.

Hint: LEFT JOIN, GROUP BY, AVG().

Retrieve the names of all instructors who teach at least one course in the same building where their office is located.

Hint: Self-join or multiple joins with a matching condition on building_id.

Find the first_name and last_name of students who are enrolled in a course taught by 'Alice Smith' and also enrolled in a course taught by 'Bob Johnson'.

Hint: Multiple JOINs and potentially INTERSECT or IN/EXISTS with subqueries.

Show the course_name and the total number of students enrolled in each course. Include courses with zero enrollments.

Hint: LEFT JOIN, GROUP BY, COUNT().

List the department_name and the first_name, last_name of the instructor with the highest salary in that department. If multiple instructors have the same highest salary, list all of them.

Hint: Correlated subquery or Common Table Expression (CTE) with window functions (e.g., RANK()) if your SQL dialect supports it, otherwise a complex join.

Find the student_id, first_name, last_name of students who have a GPA higher than the average GPA of all students in their respective major department.

Hint: Correlated subquery or JOIN with a subquery that calculates average GPA per department.

Retrieve pairs of course_name that are taught by the same instructor.

Hint: Self-JOIN on the Courses table.

List the first_name, last_name of instructors who teach courses in more than one building.

Hint: JOIN, GROUP BY, HAVING COUNT(DISTINCT building_id).

Find the student_id, first_name, last_name, and email of students who have enrolled in a course but have not yet received a grade (i.e., grade is NULL or empty).

Hint: INNER JOIN with a WHERE clause checking for NULL or empty string.

For each building, list its building_name and the total number of distinct departments that have courses taught in that building.

Hint: JOIN, GROUP BY, COUNT(DISTINCT department_id).

Identify any student_id and course_id pairs in the Enrollments table that violate the UNIQUE (student_id, course_id) constraint (i.e., duplicate enrollments).

Hint: Self-JOIN or GROUP BY and HAVING COUNT() > 1.*

List the first_name, last_name of instructors who teach a course with 'Physics' in its name, but whose primary department is not 'Physics'.

Hint: Multiple JOINs with complex WHERE conditions and string matching (LIKE).

Show the department_name and the course_name for all courses, and if the course has a primary instructor, include their first_name and last_name. If a course has no instructor, still list the course and department.

Hint: LEFT JOIN from Courses to Instructors and Departments.




 */

select s.first_name, s.last_name, c.course_name from Students s
join Enrollments e using(student_id)
join courses c using(course_id)
join Instructors i using(instructor_id)
where i.salary > 1000000


-- List all departments that have no instructors assigned to them, or whose head of department is not yet specified.

SELECT
    D.department_name
FROM
    Departments AS D
WHERE
    D.head_of_department_id IS NULL -- Checks if the head of department is not specified
    OR NOT EXISTS (                 -- Checks if no instructors are assigned to this department
        SELECT 1
        FROM Instructors AS I
        WHERE I.department_id = D.department_id
    );

-- Retrieve the first_name, last_name of all instructors, and for each instructor, show the course_name of all courses they teach. If an instructor teaches no courses, they should still appear in the result with NULL for course_name.

























