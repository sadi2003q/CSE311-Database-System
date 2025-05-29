se practise_problem2_1;
-- Write SQL expression to find Sid, F-NID, M-NID, mobile, email and age of all students whose tot-cred is greater than or equal to 130.
select student.Sid, parents_s.f_nid, parents_s.m_nid, student.mobile, student.email, student.age
from student join parents_s on parents_s.Sid=student.Sid
where student.tot_cred>=130;



-- Write SQL expression to find F-NID, Sid, course-id and title for all students whose parents live in Dhaka.
select parents_s.f_nid, student.sid, takes.course_id, course.title
from student join parents_s on parents_s.sid=student.sid
join takes on student.sid=takes.sid
join course on takes.course_id=course.course_id
where parents_s.city='Dhaka';


-- Q. 3: Write SQL expression to find Sid, name, street, city and average gradepoint of each student.
SELECT
    s.Sid,
    s.name,
    s.street,
    s.city,
    ROUND(AVG(CASE
        WHEN t.gradepoint = 'A+' THEN 4.0
        WHEN t.gradepoint = 'A' THEN 4.0
        WHEN t.gradepoint = 'A-' THEN 3.7
        WHEN t.gradepoint = 'B+' THEN 3.3
        WHEN t.gradepoint = 'B' THEN 3.0
        WHEN t.gradepoint = 'B-' THEN 2.7
        WHEN t.gradepoint = 'C+' THEN 2.3
        WHEN t.gradepoint = 'C' THEN 2.0
        WHEN t.gradepoint = 'C-' THEN 1.7
        WHEN t.gradepoint = 'D+' THEN 1.3
        WHEN t.gradepoint = 'D' THEN 1.0
        ELSE 0.0
    END), 2) AS average_gradepoint
FROM
    Student s
LEFT JOIN
    Takes t ON s.Sid = t.Sid
GROUP BY
    s.Sid, s.name, s.street, s.city;
-- Q. 4: Find city and street wise average, maximum and minimum income of parents (of students) living in Dhaka or Rajshahi and average income higher than 500000.

select avg(parents_s.income), max(parents_s.income), min(parents_s.income)
from parents_s
where parents_s.city in ('Dhaka', 'Rajshahi')
group by parents_s.city, parents_s.street
having AVG(income) > 500000;

