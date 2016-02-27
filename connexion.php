<?php 
   session_start();

   if (isset($_SESSION['login']))
   {
      var_dump($_SESSION['login']);
   }

   ini_set('display_errors','off'); // Pour ne pas avoir le message d'erreur : The mysql extension is deprecated
   include('bd/accessBD.php'); 

   // CONNEXION A LA BASE DE DONNEES
   $bd = new accessBD;
   $bd->connect();

    // VERIFIER QUE VARIABLES POST EXISTE
    if (isset($_POST['mdpUtilisateur']) && isset($_POST['mailUtilisateur'])) {
   		
     	$mdpUtilisateur = $_POST['mdpUtilisateur'];
  		$idUtilisateur = $_POST['mailUtilisateur'];

      // RECHERCHE DANS LA BASE DE DONNEES SI LES IDENTIFIANTS SONT CORRECTS ET SI L'UTILISATEUR EST BIEN ADMINISTRATEUR
  		$reqUserExists 	= 	"SELECT * 
							 FROM UTILISATEUR 
							 WHERE idUtilisateur = '".$idUtilisateur."'
							 AND mdpUtilisateur = '".$mdpUtilisateur."'
               AND isAdmin = 1"; 
  		$user = $bd->get_requete($reqUserExists);

      // OUI : CONNEXION DE L'UTILISATEUR
  		if (!empty($user)) {
  			session_start();
  			$_SESSION['login'] = $_POST['mailUtilisateur'];
  			header('Location: index.php');
  			exit();
  		}
      // NON : ENVOI MESSAGE ERREUR
  		else {
  			$_SESSION['erreurConnection'] = -1;
        header('Location: index.php');
  		}
	}

?>
