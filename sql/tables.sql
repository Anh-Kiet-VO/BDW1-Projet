/* -----------------------------------------
              CREATION DES TABLES
   ----------------------------------------- */
CREATE TABLE Categorie(
  catId INTEGER PRIMARY KEY,
  nomCat VARCHAR(250) NOT NULL
);

CREATE TABLE Photo(
  photoId INTEGER PRIMARY KEY,
  nomFich VARCHAR(250) NOT NULL,
  description VARCHAR(250) NOT NULL,
  catId INTEGER,
  FOREIGN KEY (catId) REFERENCES Categorie(catId)
);

CREATE TABLE Utilisateur(
  pseudo VARCHAR(250) NOT NULL PRIMARY KEY,
  mdp VARCHAR(250) NOT NULL,
  etat VARCHAR(250) NOT NULL,
  role VARCHAR(250) NOT NULL
);

/* -----------------------------------------
        INSERTION DES VALEURS DE BASE
   ----------------------------------------- */
INSERT INTO Categorie VALUES (1, "Chiens");
INSERT INTO Categorie VALUES (2, "Chats");
INSERT INTO Categorie VALUES (3, "Chèvres");
INSERT INTO Categorie VALUES (4, "Singes");
INSERT INTO Categorie VALUES (5, "Quokkas");
