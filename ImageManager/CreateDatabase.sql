CREATE DATABASE dbimagemanager;
USE dbimagemanager;

/* Create the Schools Table */
CREATE TABLE Schools
(
    ID int PRIMARY KEY AUTO_INCREMENT,
    Name varchar(50) UNIQUE NOT NULL,
    PrincipalFirstName varchar(20) NULL,
    PrincipalLastName varchar(20) NULL,
    PhoneNo char(14) NULL,
    FaxNo char(14) NULL
);

/* Create the Students Table */
CREATE TABLE Clients
(
    ID int PRIMARY KEY AUTO_INCREMENT,
    SchoolID int NOT NULL,
    IDNumber int UNIQUE NULL,
    FirstName varchar(20) NOT NULL,
    LastName varchar(20) NOT NULL,
    ClientType ENUM('Student', 'Employee') DEFAULT 'Student' NOT NULL,
    CONSTRAINT fk_clients_schoolid FOREIGN KEY (SchoolID) REFERENCES Schools (ID)
);

/* Create the Jobs Table */
CREATE TABLE Jobs
(
    ID int PRIMARY KEY AUTO_INCREMENT,
    Name varchar(50) UNIQUE NOT NULL,
    SchoolID int NULL,
    Date date NOT NULL,
    ImageDirectory varchar(100) UNIQUE NOT NULL,
    INDEX Date (Date)
);

/* Create the Images Table */
CREATE TABLE Images
(
    ID int PRIMARY KEY AUTO_INCREMENT,
    Directory varchar(100) NOT NULL,
    ClientID int NOT NULL,
    Name varchar(40) UNIQUE,
    JobID int NOT NULL,
    CONSTRAINT fk_images_directory FOREIGN KEY (Directory) REFERENCES Jobs (ImageDirectory),
    CONSTRAINT fk_images_clientid FOREIGN KEY (ClientID) REFERENCES Clients (ID),
    CONSTRAINT fk_images_jobid FOREIGN KEY (JobID) REFERENCES Jobs (ID)
);

/* Create the JobLineItems Table */
CREATE TABLE JobLineItems
(
    ItemNumber int AUTO_INCREMENT NOT NULL,
    JobID int NOT NULL,
    Grade int NULL,
    Teacher int NOT NULL,
    ClientID int NOT NULL,
    PRIMARY KEY (ItemNumber, JobID),
    CONSTRAINT fk_joblineitems_jobid FOREIGN KEY (JobID) REFERENCES Jobs (ID),
    CONSTRAINT fk_joblineitems_teacher FOREIGN KEY (Teacher) REFERENCES Clients (ID)
);
    
