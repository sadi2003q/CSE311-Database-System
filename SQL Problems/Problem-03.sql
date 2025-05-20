/*

Q. 3: For the given queries as follows, find the schema and write SQL:

    a. Find customer name, customer street and customer city of all customers who has same amount of loan as customer ‘Abid’.
    b. Find customer name, branch name and amount of loan for all customers who have loan in the same branches where ‘Zahid’ has loan.
    c. Find customer name, account number and customer city of all customers who has account in the same branches where ‘Zahid’ has accounts.
    d. Find the list of customer name, branch name and branch city of all customers who lives in ‘Dhaka’.
    e. Find the list of customer name, branch name and branch city of all customers who have accounts in all branch city.
    f. Find customer name, street and city of those customers who have accounts at all branches located in ‘Barishal’.
    g. The customers who have closed their accounts will be removed from the account and depositor relations. The customers who have paid their loans will be removed from the loan and borrower relations. So there are some customers who have no account and also some customers who have no loan. Find these customer names, customer street and customer city for the above using joins.
    h. Insert all the loans of branch name = “NSU” to the account relation as loan number will be account number and amount will be balance.
    i. Update the database as follows: those borrower have loans more than 50000, decrease their loan by 10%. For other borrowers, make their loan zero.
    j. Delete all loans of customers who lives in ‘Gazipur’.

Q. 4: Given the relational schema as follows:  ​​​​

employee (perso_ name, street, city)
works (person_name, company_name, salary)
company (company_name, city)

Write SQL for the following queries:
a. Find person name, street, employee city, company name, company city for all employees salary greater than 10000.
b. Find person name, street and city of all employees who live in the same city as ‘Mr. Akib’ lives.
c. Find all person name of all employees who live in the same city as the company.

 */

/*
branch(branch_name, branch city, assets)
customer (customer_name, customer_street, customer_city)
loan (loan_number, branch_name, amount)
borrower (customer_name, loan_number)
account (account_number, branch_name, balance )
depositor (customer_name, account_number)
 */
use Practise_Question_02;

-- a. Find customer name, customer street and customer city of all customers who has same amount of loan as customer ‘Megan Scott’.
select
    customer.customer_name,
    customer.customer_street,
    customer.customer_city,
    loan.amount
from
    customer
join
        borrower on customer.customer_name=borrower.customer_name
join
        loan on borrower.loan_number=loan.loan_number
where
    loan.amount = (
        select
            loan.amount
        from
            loan
        join
                borrower on loan.loan_number=borrower.loan_number
        where
            borrower.customer_name='Megan Scott'
    ) and borrower.customer_name != 'Megan Scott'

ORDER BY loan.amount, customer.customer_name;

-- b. Find customer name, branch name and amount of loan for all customers who have loan in the same branches where ‘Kevin Gonzalez’ has loan.
SELECT
    c.customer_name,
    l.branch_name,
    l.amount
FROM
    customer c
JOIN
    borrower b ON b.customer_name = c.customer_name
JOIN
    loan l ON b.loan_number = l.loan_number
WHERE
    l.branch_name IN (
        SELECT
            l2.branch_name
        FROM
            loan l2
        JOIN
            borrower b2 ON b2.loan_number = l2.loan_number
        WHERE
            b2.customer_name = 'Kevin Gonzalez'
    )
ORDER BY
    c.customer_name;

-- c. Find customer name, account number and customer city of all customers who has account in the same branches where ‘Megan Scott’ has accounts.
select
    c.customer_name,
    a.account_number,
    c.customer_city,
    a.branch_name
from customer c
join
        depositor d on d.customer_name=c.customer_name
join
        account a on a.account_number=d.account_number
where
    a.branch_name in (
        select
            a2.branch_name
        from
            account a2

         join
                depositor d2 on d2.account_number=a2.account_number
        join
                customer c2 on d2.customer_name=c2.customer_name
        where
            c2.customer_name='Megan Scott'
    );


-- d. Find the list of customer name, branch name and branch city of all customers who lives in ‘Chicago’.
select
    c.customer_name,
    b.branch_name,
    b.branch_city
from customer c
join depositor d on d.customer_name=c.customer_name
join account a on d.account_number=a.account_number
join branch b on b.branch_name=a.branch_name
where c.customer_city = 'Chicago';

-- e. Find the list of customer name, branch name and branch city of all customers who have accounts in all branch city.
select
    c.customer_name,
    b.branch_name,
    b.branch_city
from customer c
join depositor d on d.customer_name=c.customer_name
join account a on d.account_number=a.account_number
join branch b on b.branch_name=a.branch_name
where c.customer_name in (
        select d2.customer_name
        from depositor d2
        join account a2 on d2.account_number=a2.account_number
        join branch b2 on b2.branch_name=a2.branch_name
        group by d2.customer_name
        having count(distinct b2.branch_city) = (
            SELECT COUNT(DISTINCT branch_city)
            FROM branch
        )
    );

-- f. Find customer name, street and city of those customers who have accounts at all branches located in ‘Barista’.
select
    c.customer_name,
    b.branch_name,
    b.branch_city
from customer c
join depositor d on d.customer_name=c.customer_name
join account a on d.account_number=a.account_number
join branch b on b.branch_name=a.branch_name
where c.customer_name in (
        select d2.customer_name
        from depositor d2
        join account a2 on d2.account_number=a2.account_number
        join branch b2 on b2.branch_name=a2.branch_name
        group by d2.customer_name
        having count(*)
    );

-- The customers who have closed their accounts will be removed from the account and depositor relations. The customers who have paid their loans will be removed from the loan and borrower relations. So there are some customers who have no account and also some customers who have no loan. Find these customer names, customer street and customer city for the above using joins.
select
    c.customer_name,
    c.customer_street,
    c.customer_city
from customer c
left join borrower b on b.customer_name=c.customer_name
left join depositor d on d.customer_name=c.customer_name
where
    b.customer_name is null
    and d.customer_name is null;

-- Insert all the loans of branch name = “NSU” to the account relation as loan number will be account number and amount will be balance.
insert into account(account_number, branch_name, balance)
select loan_number, branch_name, amount
from loan
where branch_name='nsu';

-- i. Update the database as follows: those borrower have loans more than 50000, decrease their loan by 10%. For other borrowers, make their loan zero.