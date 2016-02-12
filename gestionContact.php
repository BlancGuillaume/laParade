<?php 
   session_start();
   // page disponible uniquement par admin
   if (!isset($_SESSION['login']))
   {
      header('Location: index.php');
   }

   ini_set('display_errors','off'); // Pour ne pas avoir le message d'erreur : The mysql extension is deprecated
   include('bd/accessBD.php'); 

   $bd = new accessBD;
   $bd->connect();

   $req = "SELECT * FROM NEWS ORDER BY idNews DESC";
   $news = $bd->get_requete($req);

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

   if (isset($_POST['status'])){
      // On update le status du message
	  if ($_POST['status'] == 1) {
		$idMessageStatusChange = $_POST['idMessageAChanger'];
		$reqChangerStatusMessage      = "UPDATE MESSAGE
										SET statusMessage = 1
										WHERE idMessage ='".$idMessageStatusChange."'";
		$updateStatusMessage = $bd->set_requete($reqChangerStatusMessage);								
	  }
	} 
	
   $nouveauMessage = $bd->get_requete($reqNouveauMessage);
   $messageTraite = $bd->get_requete($reqMessageTraite);
?>

<!DOCTYPE HTML>
<html>
   <!-- HEAD -->
   <?php include('html_includes/head.php');?>

   <body>
      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="js/materialize.min.js"></script>
      <header>
         <nav>
            <div class="nav-wrapper">
               <!-- Titre du site non affiché -->
               <h1 id="titreSite">Librairie La Parade</h1>
               <img id="logo" src="images/logo_laparade.png"></img>
               <!-- Barre de navigation -->
               <ul id="nav-mobile" class="right hide-on-med-and-down">
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
								<?php if (isset($value['nomClient'])) { ?>
									<p><?php echo "Nom : ".$value['nomClient']; ?></p>
								<?php } ?>	
								<?php if (isset($value['prenomClient'])) { ?>
									<p><?php echo "Prenom : ".$value['prenomClient']; ?></p>
								<?php } ?>	
								<?php if (isset($value['mailClient'])) { ?>
									<p><?php echo  "Mail : ".$value['mailClient']; ?></p>
								<?php } ?>	
								<?php if (isset($value['numClient'])) { ?>
									<p><?php echo  "Tel : ".$value['numClient']; ?></p>
								<?php } ?>	
								<br>
								
								<strong>Le message : </strong>
								<?php if (isset($value['dateMessage'])) { ?>
									<p><?php echo  "Date : ".$value['dateMessage']; ?></p>
								<?php } ?>
								<?php if (isset($value['contenuMessage'])) { ?>
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
         						<!-- <p><?php echo $value['idMessage']; ?></p> -->
								<strong>Le client : </strong>
								<?php if (isset($value['nomClient'])) { ?>
									<p><?php echo "Nom : ".$value['nomClient']; ?></p>
								<?php } ?>	
								<?php if (isset($value['prenomClient'])) { ?>
									<p><?php echo "Prenom : ".$value['prenomClient']; ?></p>
							<?php } ?>	
							<?php if (isset($value['mailClient'])) { ?>
								<p><?php echo  "Mail : ".$value['mailClient']; ?></p>
							<?php } ?>	
							<?php if (isset($value['numClient'])) { ?>
								<p><?php echo  "Tel : ".$value['numClient']; ?></p>
							<?php } ?>	
							<br>
								
							<strong>Le message : </strong>
							<?php if (isset($value['dateMessage'])) { ?>
								<p><?php echo  "Date : ".$value['dateMessage']; ?></p>
							<?php } ?>
							<?php if (isset($value['contenuMessage'])) { ?>
								<p><?php echo  "Message : ".$value['contenuMessage']; ?></p>
							<?php } ?>	
         						

                              </div>
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
