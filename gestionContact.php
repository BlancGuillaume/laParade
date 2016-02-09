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
   <head>
      <meta charset="utf-8" />
      <title>Librairie la Parade</title>
      <link href="css/style.css" rel="stylesheet" type="text/css">
      <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   </head>
   <body>
      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="js/materialize.min.js"></script>
      <header>
         <nav>
            <div class="nav-wrapper">
               <!-- Titre du site non affiché -->
               <h1 id="titreSite">Librairie La Parade</h1>
               <img id="logo" src="images/logo.png"></img>
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
	  
	<section id="presentation">
   	<ul class="collapsible" data-collapsible="expandable"> <!-- Plusieurs menus peuvent être ouvert en même temps -->
         <li>
   	   <!-- Par défaut on déploie les nouvelles demandes de contact -->
            <div class="collapsible-header active"><i class="material-icons">call_made</i>Nouveau message</div>
            <div class="collapsible-body">
               <p>
         	   <!-- cards pour les nouveaux messages -->
               <?php if (!empty($nouveauMessage)): ?>
                   
                  <?php foreach ($nouveauMessage as $value){  ?> 
					<!-- Bouton pour changer le status du message : de nouveau à traité 
					     On envoie par POST l'id du message à modifier -->
					<form action="gestionContact.php" method="post">
						<input type="hidden" name="status" value="1" /> <!-- 1 pour traité (0 quand c'est un nouveau message) -->
						<input type="hidden" name="idMessageAChanger" value=<?php echo $value['idMessage']; ?> /> 
						<button id="boutonGestionMessage" type="submit"  name="action">traiter </button>
					</form>				  
                              <div class="card red">
                              <div class="card-content black-text">
         						<p><?php echo $value['idMessage']; ?></p>
         						<p><?php echo $value['contenuMessage']; ?></p>
         						<p><?php echo $value['dateMessage']; ?></p>
                                 
         						<p><?php echo $value['prenomClient']; ?></p>
         						<p><?php echo $value['nomClient']; ?></p>
         						<p><?php echo $value['mailClient']; ?></p>
         						<p><?php echo $value['numClient']; ?></p>
                              </div>
                           </div>
                  <?php } ?>
                  
               <?php endif ?>
      	     </p>
            </div>
         </li>
         <li>
            <div class="collapsible-header"><i class="material-icons">done</i>Message traite</div>
            <div class="collapsible-body">
               <p>
      	  	   <!-- cards pour les messages traités-->
         	  <?php if (!empty($messageTraite)): ?>
                  <?php foreach ($messageTraite as $value){  ?>
                        <div class="col s3 m3">
                              <div class="card green">
                              <div class="card-content black-text">
         						<p><?php echo $value['idMessage']; ?></p>
         						<p><?php echo $value['contenuMessage']; ?></p>
         						<p><?php echo $value['dateMessage']; ?></p>
                                 
         						<p><?php echo $value['prenomClient']; ?></p>
         						<p><?php echo $value['nomClient']; ?></p>
         						<p><?php echo $value['mailClient']; ?></p>
         						<p><?php echo $value['numClient']; ?></p>
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
   <!-- cards pour les news -->
   <?php if (!empty($news)): ?>
      <aside class="container-cards"> <!-- ajout d'une nouvelle news -> dans cette div -->   
      <?php for ($i = 0; $i < 5 && !empty($news[$i]); $i++) : ?>
            <div class="col s3 m3">
               <?php if ($i == 0 || $i == 3): ?>
                  <div class="card orangefonce">
               <?php elseif($i == 1 || $i == 4): ?>
                  <div class="card orange">
               <?php else: ?>
                  <div class="card orangeclair">
               <?php endif ?>
                  <div class="card-content white-text">
                     <span><?php echo $news[$i]['nomNews'];?></span>
                     <p><?php echo $news[$i]['contenuNews']; ?></p>
                     <?php if ($news[$i]['lienNews'] != NULL): ?>
                        <a href=<?php echo "\"" . $news[$i]['lienNews'] . "\""; ?>>LIEN</a>
                     <?php endif ?>
                     <?php if ($news[$i]['imageNews'] != NULL): ?>
                        <img src=<?php echo "\"" . $news[$i]['imageNews'] . "\""; ?>></img>
                     <?php endif ?>
                  </div>
               </div>
            </div>
      <?php endfor; ?>
      <footer>
         <a id="lienEspaceUtilisateur" href="deconnexion.php">Deconnexion</a>
      </footer>
      </aside>
   <?php endif; ?>
      
   </body>
</html>
