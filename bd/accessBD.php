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
		

		if (mysql_errno()) { 
          $error = "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$query\n<br>"; 
		  echo $requete;
		  echo $error;
        }
	
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
}
?>