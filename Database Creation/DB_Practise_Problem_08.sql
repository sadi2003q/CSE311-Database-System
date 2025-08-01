Create DATABASE Practise_Question_08;
use Practise_Question_08;


CREATE TABLE Authors (
    AuthorID INT PRIMARY KEY,
    FirstName VARCHAR(50),
    LastName VARCHAR(50),
    BirthYear INT
);

CREATE TABLE Books (
    BookID INT PRIMARY KEY,
    Title VARCHAR(100),
    AuthorID INT,
    Genre VARCHAR(50),
    PublicationYear INT,
    ISBN VARCHAR(13),
    FOREIGN KEY (AuthorID) REFERENCES Authors(AuthorID)
);

CREATE TABLE Members (
    MemberID INT PRIMARY KEY,
    FirstName VARCHAR(50),
    LastName VARCHAR(50),
    Email VARCHAR(100),
    JoinDate DATE
);

CREATE TABLE Loans (
    LoanID INT PRIMARY KEY,
    BookID INT,
    MemberID INT,
    LoanDate DATE,
    ReturnDate DATE,
    FOREIGN KEY (BookID) REFERENCES Books(BookID),
    FOREIGN KEY (MemberID) REFERENCES Members(MemberID)
);

-- Insert sample data (at least 10 tuples per table)
INSERT INTO Authors (AuthorID, FirstName, LastName, BirthYear) VALUES
(1, 'Jane', 'Austen', 1775),
(2, 'George', 'Orwell', 1903),
(3, 'J.K.', 'Rowling', 1965),
(4, 'Mark', 'Twain', 1835),
(5, 'Agatha', 'Christie', 1890),
(6, 'Ernest', 'Hemingway', 1899),
(7, 'Virginia', 'Woolf', 1882),
(8, 'F. Scott', 'Fitzgerald', 1896),
(9, 'Toni', 'Morrison', 1931),
(10, 'Gabriel', 'Garcia Marquez', 1927);

INSERT INTO Books (BookID, Title, AuthorID, Genre, PublicationYear, ISBN) VALUES
(1, 'Pride and Prejudice', 1, 'Romance', 1813, '9780141439518'),
(2, '1984', 2, 'Dystopian', 1949, '9780451524935'),
(3, 'Harry Potter and the Philosopher''s Stone', 3, 'Fantasy', 1997, '9780747532699'),
(4, 'Animal Farm', 2, 'Dystopian', 1945, '9780141036137'),
(5, 'Adventures of Huckleberry Finn', 4, 'Adventure', 1884, '9780486280615'),
(6, 'Murder on the Orient Express', 5, 'Mystery', 1934, '9780062693662'),
(7, 'The Old Man and the Sea', 6, 'Fiction', 1952, '9780684830490'),
(8, 'Mrs Dalloway', 7, 'Fiction', 1925, '9780156628709'),
(9, 'The Great Gatsby', 8, 'Fiction', 1925, '9780743273565'),
(10, 'Beloved', 9, 'Fiction', 1987, '9781400033416'),
(11, 'One Hundred Years of Solitude', 10, 'Magical Realism', 1967, '9780060883287'),
(12, 'Sense and Sensibility', 1, 'Romance', 1811, '9780141439662');

INSERT INTO Members (MemberID, FirstName, LastName, Email, JoinDate) VALUES
(1, 'John', 'Doe', 'john.doe@email.com', '2023-01-15'),
(2, 'Jane', 'Smith', 'jane.smith@email.com', '2023-02-20'),
(3, 'Bob', 'Johnson', 'bob.johnson@email.com', '2023-03-10'),
(4, 'Alice', 'Brown', 'alice.brown@email.com', '2023-04-05'),
(5, 'Charlie', 'Davis', 'charlie.davis@email.com', '2023-05-12'),
(6, 'Emma', 'Wilson', 'emma.wilson@email.com', '2023-06-18'),
(7, 'Michael', 'Taylor', 'michael.taylor@email.com', '2023-07-22'),
(8, 'Sarah', 'Anderson', 'sarah.anderson@email.com', '2023-08-30'),
(9, 'David', 'Thomas', 'david.thomas@email.com', '2023-09-15'),
(10, 'Laura', 'Martinez', 'laura.martinez@email.com', '2023-10-10');

INSERT INTO Loans (LoanID, BookID, MemberID, LoanDate, ReturnDate) VALUES
(1, 1, 1, '2023-06-01', '2023-06-15'),
(2, 2, 2, '2023-06-05', NULL),
(3, 3, 1, '2023-06-10', '2023-06-20'),
(4, 4, 3, '2023-06-12', NULL),
(5, 5, 4, '2023-06-15', '2023-06-30'),
(6, 6, 5, '2023-07-01', NULL),
(7, 7, 6, '2023-07-05', '2023-07-20'),
(8, 8, 7, '2023-07-10', NULL),
(9, 9, 8, '2023-07-15', '2023-07-25'),
(10, 10, 9, '2023-07-20', NULL),
(11, 11, 10, '2023-07-25', '2023-08-05'),
(12, 12, 2, '2023-08-01', NULL);