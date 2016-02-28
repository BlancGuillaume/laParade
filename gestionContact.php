<?php 
    session_start();

	// PAGE DISPONIBLE UNIQUEMENT PAR L'ADMINISTRATEUR : sinon redirection à la page d'accueil
	if (!isset($_SESSION['login']))
	{
	  header('Location: index.php');
	}

	// Pour ne pas avoir le message d'erreur : The mysql extension is deprecated
   	ini_set('display_errors','off'); 

   	// CONNEXION A LA BASE DE DONNEES
   	include('bd/accessBD.php'); 
	$bd = new accessBD;
	$bd->connect();

	// REQUETE PERMETTANT DE RECUPERER LES NOUVEAUX MESSAGES
    $reqNouveauMessage = "SELECT  m.idMessage,
								  m.contenuMessage,
								  m.dateMessage,
							   	  c.mailClient,
								  c.nomClient,
								  c.prenomClient,
								  c.numClient
						FROM MESSAGE m, CLIENT c
						WHERE m.statusMessage = 0
						AND m.mailClientMessage = c.mailClient";
	$nouveauMessage = $bd->get_requete($reqNouveauMessage);

	// REQUETE PERMETTANT DE RECUPERER LES MESSAGES	TRAITES					
    $reqMessageTraite = "SELECT   m.idMessage,
								  m.contenuMessage,
								  m.dateMessage,
							   	  c.mailClient,
								  c.nomClient,
								  c.prenomClient,
								  c.numClient
						FROM MESSAGE m, CLIENT c
						WHERE m.statusMessage = 1
						AND m.mailClientMessage = c.mailClient";

    $messageTraite = $bd->get_requete($reqMessageTraite);

	// CHANGEMENT DE STATUS D'UN MESSAGE (l'administrateur a appuyé sur le bouton TRAITER)
	if (isset($_POST['status'])){
		if ($_POST['status'] == 1) {
			// On update le status du message
			$idMessageStatusChange = $_POST['idMessageAChanger'];
			$reqChangerStatusMessage = "UPDATE MESSAGE
										SET statusMessage = 1
										WHERE idMessage ='".$idMessageStatusChange."'";
			$updateStatusMessage = $bd->set_requete($reqChangerStatusMessage);								
		}
		else if ($_POST['status'] == 2) { 
			// on supprime le message
			var_dump("a supprimer");
			var_dump($idMessageStatusChange);
			$idMessageStatusChange = $_POST['idMessageASupprimer'];
			$reqSupprimerMessage = "DELETE FROM MESSAGE WHERE idMessage ='".$idMessageStatusChange."'";
			$supprimerMessage = $bd->set_requete($reqSupprimerMessage);								
		} 
		header('Location: gestionContact.php');
	} 
	
    
?>

<!DOCTYPE HTML>
<html>
   <!-- HEAD -->
   <?php include('html_includes/head.php');?>

   <body>
      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="js/materialize.min.js"></script>
      <header>
        <!-- Barre de navigation -->
        <nav id="barreNavigation">
            <div>
               <!-- Titre du site non affiché -->
               <h1 id="titreSite">Librairie La Parade</h1>
               <!-- Logo -->
               <img id="logo" src="images/logo_laparade.png"></img>
               <!-- Menu -->
               <ul id="menu">
                  <li><a href="index.php">Accueil</a></li>
                  <li><a href="gestionNews.php">News</a></li>
                  <li><a href="gestionReservation.php">Reservation</a></li>
                  <li class="active"><a href="gestionContact.php">Messages</a></li>
               </ul>
            </div>
         </nav>
      </header>
	  
	  <!-- Initialisation du menu "acordéon" -->
	  <script type="text/javascript">
	   $(document).ready(function(){
			$('.collapsible').collapsible({
				accordion : false // A setting that changes the collapsible behavior to expandable instead of the default accordion style
			});
		});
      </script>
	  
	<section id="gestionReservation" class="row card"> 
   	<ul class="collapsible" data-collapsible="expandable"> <!-- Plusieurs menus peuvent être ouvert en même temps -->
         <li>
   	   <!-- Par défaut on déploie les nouvelles demandes de contact -->
            <div class="collapsible-header active" id="collapseHeader1"><i class="material-icons">call_made</i>Nouveau message</div>
            <div class="collapsible-body" id="collapse1">
               <p>
         	   <!-- cards pour les nouveaux messages -->
               <?php if (!empty($nouveauMessage)): ?>
                   
                  <?php foreach ($nouveauMessage as $value){  ?> 			  
                              <div class="card red">
                              <div class="card-content black-text">
         						<!--<p><?php echo $value['idMessage']; ?></p>-->
								<strong>Le client : </strong>
								<?php if (!empty($value['nomClient'])) { ?>
									<p><?php echo "Nom : ".$value['nomClient']; ?></p>
								<?php } ?>	
								<?php if (!empty($value['prenomClient'])) { ?>
									<p><?php echo "Prenom : ".$value['prenomClient']; ?></p>
								<?php } ?>	
								<?php if (!empty($value['mailClient'])) { ?>
									<p><?php echo  "Mail : ".$value['mailClient']; ?></p>
								<?php } ?>	
								<?php if (!empty($value['numClient'])) { ?>
									<p><?php echo  "Tel : ".$value['numClient']; ?></p>
								<?php } ?>	
								<br>
								
								<strong>Le message : </strong>
								<?php if (!empty($value['dateMessage'])) { ?>
									<p><?php echo  "Date : ".$value['dateMessage']; ?></p>
								<?php } ?>
								<?php if (!empty($value['contenuMessage'])) { ?>
									<p><?php echo  "Message : ".$value['contenuMessage']; ?></p>
								<?php } ?>	
								<br>
								<!-- Bouton pour changer le status du message : de nouveau à traité 
								On envoie par POST l'id du message à modifier -->
								<form action="gestionContact.php" method="post">
									<input type="hidden" name="status" value="1" /> <!-- 1 pour traité (0 quand c'est un nouveau message) -->
									<input type="hidden" name="idMessageAChanger" value=<?php echo $value['idMessage']; ?> /> 
									<button id="boutonGestionMessage" class="btn waves-effect waves-light" type="submit"  name="action">traiter </button>
								</form>	
                              </div>
                           </div>
                  <?php } ?>
                  
               <?php endif ?>
      	     </p>
            </div>
         </li>
         <li>
            <div class="collapsible-header" id="collapseHeader3"><i class="material-icons" >done</i>Message traite</div>
            <div class="collapsible-body" id="collapse3">
               <p>
      	  	   <!-- cards pour les messages traités-->
         	  <?php if (!empty($messageTraite)): ?>
                  <?php foreach ($messageTraite as $value){  ?>
                        <div class="col s3 m3">
                              <div class="card green">
                              <div class="card-content black-text">
								<!-- L'id du message a supprimer -->
         						<?php $idMessageASupprimer = $value['idMessage']; ?></p>
								<strong>Le client : </strong>
								<?php if (!empty($value['nomClient'])) { ?>
									<p><?php echo "Nom : ".$value['nomClient']; ?></p>
								<?php } ?>	
								<?php if (!empty($value['prenomClient'])) { ?>
									<p><?php echo "Prenom : ".$value['prenomClient']; ?></p>
							<?php } ?>	
							<?php if (!empty($value['mailClient'])) { ?>
								<p><?php echo  "Mail : ".$value['mailClient']; ?></p>
							<?php } ?>	
							<?php if (!empty($value['numClient'])) { ?>
								<p><?php echo  "Tel : ".$value['numClient']; ?></p>
							<?php } ?>	
							<br>
								
							<strong>Le message : </strong>
							<?php if (!empty($value['dateMessage'])) { ?>
								<p><?php echo  "Date : ".$value['dateMessage']; ?></p>
							<?php } ?>
							<?php if (!empty($value['contenuMessage'])) { ?>
								<p><?php echo  "Message : ".$value['contenuMessage']; ?></p>
							<?php } ?>	
                              </div>
							  <!-- Bouton pour changer le status du message : on le supprime
						    On envoie par POST l'id du message à supprimer -->
							<form action="gestionContact.php" method="post">
								<input type="hidden" name="status" value="2" /> <!-- 2 pour supprimer message -->
								<input type="hidden" name="idMessageASupprimer" value=<?php echo $idMessageASupprimer; ?> /> 
								<button id="boutonGestionMessage" class="btn waves-effect waves-light" type="submit"  name="action">supprimer</button>
							</form>
                           </div>
                        </div>
                  <?php } ?>
               <?php endif ?>
         	  </p>
            </div>
          </li>
       
      </ul>
   </section>

   <!-- HEADER -->
   <?php include('html_includes/news.php');?>

   <!-- FOOTER -->
   <?php include('html_includes/footer.php');?>
      
   </body>
</html>
