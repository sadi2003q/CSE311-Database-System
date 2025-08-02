/*
employee (person_name, street, city)
works (person_name, company_name, salary)
company (company_name, city)

Write SQL for the following queries:
a. Find person_name, street, employee city, company name, company city for all employees salary greater than 10000.
b. Find person name, street and city of all employees who live in the same city as ‘Mr. Akib’ lives.
c. Find all person name of all employees who live in the same city as the company.
 */


 -- a. Find person name, street, employee city, company name, company city for all employees salary greater than 10000.
select employee.person_name, employee.city, employee.street, company.company_name, company.city
from employee join works on employee.person_name=works.person_name
join company on works.company_name=company.company_name
where
    works.salary>10000;

-- b. Find person name, street and city of all employees who live in the same city as ‘Mr. Akib’ lives.
select employee.person_name, employee.street, employee.city
from employee
where employee.city = (
    select employee.city from employee
    where employee.person_name='Mr. Akib'
);

-- c. Find all person name of all employees who live in the same city as the company.
select employee.person_name, employee.city, company.city
from employee join works on employee.person_name=works.person_name
join company on works.company_name=company.company_name
where employee.city=company.city;


