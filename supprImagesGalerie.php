<?php 
	if (isset($_POST['idNewsASupprimer'])){
	  $idNewsASupprimer = $_POST['idNewsASupprimer'];
	  var_dump($idNewsASupprimer);
	  // $reqSupprimerNews = "DELETE FROM NEWS
	  //                 WHERE idNews ='".$idNewsASupprimer."'";
	  // $supprimerNews = $bd->set_requete($reqSupprimerNews);                      
	} 
?>