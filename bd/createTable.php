<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "laParade_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// CREATION TABLE UTILISATEUR
$sql = "CREATE TABLE UTILISATEUR (
idUtilisateur VARCHAR(50) PRIMARY KEY, 
mdpUtilisateur VARCHAR(20) NOT NULL,
isAdmin BOOLEAN NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table UTILISATEUR created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

// CREATION TABLE NEWS
$sql = "CREATE TABLE NEWS (
idNews INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
nomNews VARCHAR(50),
contenuNews TEXT  NOT NULL, -- Stocke des chaînes de 65535 caractères maximum. Ce champ est insensible à la casse
imageNews VARCHAR(50), 
lienNews VARCHAR(50)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table NEWS created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

// CREATION TABLE CLIENT
$sql = "CREATE TABLE CLIENT (
mailClient VARCHAR(50) PRIMARY KEY, 
nomClient VARCHAR(50) NOT NULL,
prenomClient VARCHAR(50) NOT NULL,
numClient VARCHAR(50)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table CLIENT created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

// CREATION TABLE MESSAGE
$sql = "CREATE TABLE MESSAGE (
idMessage INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
contenuMessage TEXT  NOT NULL, -- Stocke des chaînes de 65535 caractères maximum. Ce champ est insensible à la casse
dateMessage DATETIME NOT NULL, 
mailClientMessage VARCHAR(50) NOT NULL, 
CONSTRAINT fk_message_client             -- On donne un nom à notre clé
        FOREIGN KEY (mailClientMessage)  -- Colonne sur laquelle on crée la clé
        REFERENCES CLIENT(mailClient)    -- Colonne de référence
)";

if ($conn->query($sql) === TRUE) {
    echo "Table MESSAGE created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}


// CREATION TABLE ETABLISSEMENT
$sql = "CREATE TABLE ETABLISSEMENT (
nomEtablissement VARCHAR(50) PRIMARY KEY
)";

if ($conn->query($sql) === TRUE) {
    echo "Table ETABLISSEMENT created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}


// CREATION TABLE RESERVATION
$sql = "CREATE TABLE RESERVATION (
idReservation INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
dateReservation DATETIME NOT NULL,
dateLimiteReservation DATETIME, 
commentaireReservation TEXT, -- Stocke des chaînes de 65535 caractères maximum. Ce champ est insensible à la casse
mailClientReservation VARCHAR(50) NOT NULL, 
nomEtablissementReservation VARCHAR(50),
numISBM INT(20),
nomLivre VARCHAR(50) NOT NULL, 
auteurLivre VARCHAR(50) NOT NULL, 
editeurLivre VARCHAR(50) NOT NULL,
CONSTRAINT fk_reservation_client                -- On donne un nom à notre clé
        FOREIGN KEY (mailClientReservation)     -- Colonne sur laquelle on crée la clé
        REFERENCES CLIENT(mailClient),          -- Colonne de référence      
CONSTRAINT fk_reservation_etablissement           
        FOREIGN KEY (nomEtablissementReservation)  
        REFERENCES ETABLISSEMENT(nomEtablissement)      
)";

if ($conn->query($sql) === TRUE) {
    echo "Table RESERVATION created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}


$conn->close();
?>