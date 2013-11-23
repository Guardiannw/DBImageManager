USE dbimagemanager;

CREATE TABLE ServiceRequests
(
    ID int PRIMARY KEY AUTO_INCREMENT,
    Status ENUM('In Progress', 'Completed', 'New') DEFAULT 'New',
    ReceiverID int DEFAULT 0,
    ContactName varchar(100) NOT NULL,
    ContactEmail varchar(100) NULL,
    ContactPhone varchar(14) NULL,
    ClientID int,
    SchoolID int,
    OrderType varchar(50) NULL,
    ContactType varchar(25) NULL,
    Issue text NULL,
    AssigneeID int DEFAULT 0,
    PercentComplete float DEFAULT 0,
    Notes mediumtext NULL,
    DateReceived date
);