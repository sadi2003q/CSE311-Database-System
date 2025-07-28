
/*

List all members who have not borrowed any books by George Orwell.
Find the average number of days books are borrowed for each genre, considering only completed loans (ReturnDate is not NULL).
These questions combine INNER JOIN, LEFT JOIN, subqueries, GROUP BY, and date calculations to provide intermediate-level practice with the library database. Would you like me to provide the SQL solutions for these questions?Find all members who have borrowed books written by authors born after 1900, showing member names and book titles.
List all books that have never been borrowed, including their author names.
Find members who have borrowed more than one book, showing their full name and the count of books borrowed.
Identify books currently on loan (ReturnDate is NULL) along with the member's email and loan date.
Find the most popular genre based on the number of loans, including only genres with at least one loan.
List all authors who have written books that were borrowed by a specific member (e.g., MemberID = 1).
Find members who joined after 2023-02-01 and have borrowed at least one book published after 1950.
Identify books that were borrowed within 30 days of their publication year, showing book title and author name.
List all members who have not borrowed any books by George Orwell.
Find the average number of days books are borrowed for each genre, considering only completed loans (ReturnDate is not NULL).
These questions combine INNER JOIN, LEFT JOIN, subqueries, GROUP BY, and date calculations to provide intermediate-level practice with the library database. Would you like me to provide the SQL solutions for these questions?
 */

/*
 [Authors]                        [Books]
+-------------+                +----------------+
| AuthorID    |◄──┐            | BookID         |
| FirstName   |   │            | Title          |
| LastName    |   │            | AuthorID (FK)  |◄───┐
| BirthYear   |   │            | Genre          |    │
+-------------+   │            | PublicationYear|    │
                  │            | ISBN           |    │
                  │            +----------------+    │
                  │                                  │
                  │                                  │
[Members]         │            [Loans]               │
+-------------+   │            +-----------------+   │
| MemberID    |◄──┼─────────── | LoanID          |   │
| FirstName   |   │            | BookID (FK)     |───┘
| LastName    |   │            | MemberID (FK)   |
| Email       |   │            | LoanDate        |
| JoinDate    |   │            | ReturnDate      |
+-------------+   │            +-----------------+
                  │
                  └─ One-to-Many Relationship
 */

-- Identify books that were borrowed within 30 days of their publication year, showing book title and author name.






;



-- Find members who joined after 2023-02-01 and have borrowed at least one book published after 1950.
select CONCAT(Members.FirstName, Members.LastName) as Member from Members
join Loans on Members.MemberID=Loans.LoanID
join Books on Loans.BookID=Books.BookID
where Members.JoinDate > '2023-02-01' and Books.PublicationYear > 1950

;






-- List all authors who have written books that were borrowed by a specific member (e.g., MemberID = 1).
select CONCAT(Authors.FirstName, ' ', Authors.LastName) as Author
from Authors join Books using(AuthorID)
join loans using(BookID)
join Members using(MemberID)
where Members.MemberID=1

;

-- Find the most popular genre based on the number of loans, including only genres with at least one loan.
select Books.Genre, count(*) as Loan_count from Books
join Loans using(BookID)
group by Books.Genre
having count(*) > 1
order by Loan_count
limit 1;






-- List all books that have never been borrowed, including their author names.
select Books.Title, CONCAT(Authors.FirstName, ' ' ,Authors.LastName) as Author from Books
join Authors using(AuthorID)
where Books.BookID not in (
    select Books.BookID from Books join Loans using(BookID)
);




-- Find all members who have borrowed books written by authors born after 1900, showing member names and book titles.
select Members.FirstName, Books.Title from Members
join Loans using(MemberID)
join Books using(BookID)
join Authors using(AuthorID)
where YEAR(Authors.BirthYear) > 1900;






















