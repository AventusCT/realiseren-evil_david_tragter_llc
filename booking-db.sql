CREATE TABLE afspraken(
    afspraakID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    voorNaam VARCHAR(255) NOT NULL,
    achterNaam VARCHAR(255) NOT NULL,
    afspraakDatum DATE NOT NULL,
    afspraakTijd TIME NOT NULL
);