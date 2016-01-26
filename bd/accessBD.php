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
        $this->conn = mysql_connect($this->servername,$this->username,$this->password) or die ("erreur de connexion");
        mysql_select_db($this->dbname,$this->conn) or die ("erreur de connexion base");
        return $this->conn;
    }

    function set_requete($requete) { // pour INSERT, UPDATE...
        // Exécution de la requête
        // echo $requete . '<br />';
        $result = mysql_query($requete);

        return $result;
    }

    function get_requete($requete) { // pour SELECT
        // Exécution de la requête
        $result = mysql_query($requete);
        $array = array();

        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            array_push($array, $row);
        }

        mysql_free_result($result);
        return $array;
    }

    function deconnect() {
        mysql_close($this->conn);
    }

    // Suppression de $num articles du type $artnr du panier

    // function insert_utilisateur($id, $mdp, $isAdmin) {
    //     // CREATION TABLE UTILISATEUR
    //     $sql = "INSERT INTO UTILISATEUR (idUtilisateur, mdpUtilisateur, isAdmin) VALUES ('$id', '$mdp', '$isAdmin')";

    //     if ($this->conn->query($sql) === TRUE) {
    //         echo "Ajout utilisateur effectuée";
    //         return 0;
    //     } else {
    //         echo "Erreur : " . $this->conn->error;
    //         return -1;
    //     }
    // }
	
	/*
	function insert_reservation_client($mailClient, $nomClient, $prenomClient, $numClient, $dateLimiteReservation, $commentaireReservation,     ) {
	
		// La date actuelle, celle de la reservation
		$dateReservation = date("d-m-Y");
		
		// TODO : verifier que l'utilisateur n'existe pas déja
		$sql = "INSERT INTO CLIENT VALUES ('$mailClient', '$nomClient', '$prenomClient', '$numClient')
				INSERT INTO RESERVATION ($dateReservation, '$dateLimiteReservation', '$commentaireReservation', '$mailClient'";
				
		// SELECT de la dernière reservation pour chopper l'id reservation ? Risqué ?
		
				
		$sql .= "INSERT INTO LIVRE ($numISBM, $nomLivre, $auteurLivre, $editeurLivre, $idReservation)";
		
		
		
		if ($this->conn->query($sql) === TRUE) {
            echo "Ajout de la reservation effectuée";
            return 0;
        } else {
            echo "Erreur : " . $this->conn->error;
            return -1;
        }
	}
	
	*/
	
	
	

    // function get_utilisateur($id) {
    //     $sql = "SELECT * FROM UTILISATEUR WHERE idUtilisateur='$id'";

    //     if ($result = $this->conn->query($sql)) {
    //         return $result->fetch_assoc();
    //     } else {
    //         echo "Erreur : " . $this->conn->error;
    //         return -1;
    //     }
    // }

    // function get_news() {
    //     $i = 0;
    //     $result = array();
    //     $sql = mysql_query('SELECT idNews, nomNews, contenuNews, imageNews, lienNews FROM NEWS');
    //     while (mysql_fetch_array($sql) = $row) {
    //         $result[$i]['idNews'] = $row['idNews'];
    //         $result[$i]['nomNews'] = $row['nomNews'];
    //         $result[$i]['contenuNews'] = $row['contenuNews'];
    //         $result[$i]['imageNews'] = $row['imageNews'];
    //         $result[$i]['lienNews'] = $row['lienNews'];
    //         $i++;
    //     }
    //     return $result;
    // }
}
?>