-- DROP statements (please don't change these)
DROP TABLE IF EXISTS `Clinical`;
DROP TABLE IF EXISTS `Score`;
DROP TABLE IF EXISTS `Requirement`;

CREATE TABLE Clinical (
ID int NOT NULL,
Name VARCHAR(100) NOT NULL,

PRIMARY KEY (ID)
);

CREATE TABLE Score (
ID int NOT NULL,
ClinicalID int NOT NULL,
EnjoyTimeScore int NOT NULL,
StaffSupportScore int NOT NULL,
SiteFacilitationScore int NOT NULL,
PreceptorFacilitationScore int NOT NULL,
RecommendableScore int NOT NULL,
CommentStaffSit varchar(200),
CommentInstructor varchar(200),

PRIMARY KEY (ID),
FOREIGN KEY (ClinicalID) REFERENCES Clinical (ID)
);

CREATE TABLE Requirement (
    ID int NOT NULL,
    Title varchar(100) NOT NULL,
    OptionOne varchar(255) NOT NULL,
    OptionTwo varchar(255),

    PRIMARY KEY (ID)
);

INSERT INTO Clinical (ID, Name) VALUES
    (1, 'Clinical A'),
    (2, 'Clinical B');


INSERT INTO Score (ID, ClinicalID, EnjoyTimeScore, StaffSupportScore, SiteFacilitationScore, PreceptorFacilitationScore, RecommendableScore, CommentStaffSit, CommentInstructor) VALUES
    (1, 1, 4, 5, 3, 5, 5, 'Great experience', 'Instructor was helpful'),
    (2, 2, 3, 4, 4, 3, 5, 'Okay', 'Could be better'),
    (3, 2, 5, 5, 5, 5, 5,'Excellent', 'Instructor was fantastic'),
    (4, 1, 2, 3, 2, 2, 2, 'Not so good', 'Instructor was not helpful'),
    (5, 1, 4, 5, 4, 4, 1, 'Good', 'Instructor did a decent job');

INSERT INTO Requirement (ID, Title, OptionOne, OptionTwo) VALUES
(1, )
