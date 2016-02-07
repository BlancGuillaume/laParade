<?php 
   session_start();
   if (isset($_SESSION['login']))
   {
      var_dump($_SESSION['login']);
   }

   ini_set('display_errors','off'); // Pour ne pas avoir le message d'erreur : The mysql extension is deprecated
   include('bd/accessBD.php'); 

   $bd = new accessBD;
   $bd->connect();

   $req = "SELECT * FROM NEWS ORDER BY idNews DESC";
   $news = $bd->get_requete($req);

    if (!empty($_POST)) {
   		
     	$mdpUtilisateur = $_POST['mdpUtilisateur'];
  		$idUtilisateur = $_POST['mailUtilisateur'];

  		$reqUserExists 	= 	"SELECT * 
							 FROM UTILISATEUR 
							 WHERE idUtilisateur = '".$idUtilisateur."'
							 AND mdpUtilisateur = '".$mdpUtilisateur."'"; 
  		$user = $bd->get_requete($reqUserExists);

  		if (!empty($user)) {
  			session_start();
  			$_SESSION['login'] = $_POST['mailUtilisateur'];
  			header('Location: index.php');
  			exit();
  		}
  		else {
  			$_SESSION['erreur'] = -1;
        header('Location: index.php');
  		}
	}

?>
