<?php
class accessBD {

    // Données nécessaires à la connexion à la base de données
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "laParade_db";
    private $conn;

    // Ajout de $num articles de type $artnr au panier

    function connect() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
    }

    // Suppression de $num articles du type $artnr du panier

    function insert_utilisateur($id, $mdp, $isAdmin) {
        // CREATION TABLE UTILISATEUR
        $sql = "INSERT INTO UTILISATEUR (idUtilisateur, mdpUtilisateur, isAdmin) VALUES ('$id', '$mdp', '$isAdmin')";

        if ($this->conn->query($sql) === TRUE) {
            echo "Ajout utilisateur effectuée";
            return 0;
        } else {
            echo "Erreur : " . $this->conn->error;
            return -1;
        }
    }

    function get_utilisateur($id) {
        $sql = "SELECT * FROM UTILISATEUR WHERE idUtilisateur='$id'";

        if ($result = $this->conn->query($sql)) {
            return $result->fetch_assoc();
        } else {
            echo "Erreur : " . $this->conn->error;
            return -1;
        }
    }
}
?>