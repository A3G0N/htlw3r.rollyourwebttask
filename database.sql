drop DATABASE if EXISTS MemeGenerator;
create DATABASE MemeGenerator;
use MemeGenerator;

create TABLE Picture(
    PK_PictureID INT AUTO_INCREMENT,
    Pfad VARCHAR(255),
    PRIMARY KEY (PK_PictureID)
    );

CREATE TABLE MemeBenutzer(
    PK_UserID INT PRIMARY KEY AUTO_INCREMENT, 
    Name VARCHAR(255)
    );
    
create TABLE Meme(
    PK_PictureID INT PRIMARY KEY AUTO_INCREMENT,
    TextUp VARCHAR(255),
    TextDown VARCHAR(255),
    FK_PictureID INT, 
    FK_UserID INT, 
    FOREIGN KEY (FK_PictureID) REFERENCES Picture(PK_PictureID),
    FOREIGN KEY (FK_UserID) REFERENCES MemeBenutzer(PK_UserID)
);

