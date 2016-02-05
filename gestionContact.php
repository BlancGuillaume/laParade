<?php 
   ini_set('display_errors','off'); // Pour ne pas avoir le message d'erreur : The mysql extension is deprecated
   include('bd/accessBD.php'); 

   $bd = new accessBD;
   $bd->connect();

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
               <a href="images/blason.gif" class="brand-logo">Librairie la Parade</a>
               <!-- Barre de navigation -->
               <ul id="nav-mobile" class="right hide-on-med-and-down">
                  <li class="active"><a href="index.php">Presentation</a></li>
                  <li><a href="reservation.php">Reservation</a></li>
                  <li><a href="contact.php">Contact</a></li>
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
	  
	  
	<ul class="collapsible" data-collapsible="expandable"> <!-- Plusieurs menus peuvent être ouvert en même temps -->
    <li>
	  <!-- Par défaut on déploie les nouvelles demandes de réservations -->
      <div class="collapsible-header active"><i class="material-icons">call_made</i>Nouveau message</div>
      <div class="collapsible-body"><p>
	  <!-- cards pour les nouveaux messages -->
      <?php if (!empty($nouveauMessage)): ?>
          
         <?php foreach ($nouveauMessage as $value){  ?>
               <div class="col s3 m3">
                 
                     <div class="card red">
                     <div class="card-content white-text">
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
	  
	</p></div>
    </li>
    <li>
      <div class="collapsible-header"><i class="material-icons">done</i>Message traite</div>
      <div class="collapsible-body"><p>
	  	   <!-- cards pour les messages traités-->
	  <?php if (!empty($messageTraite)): ?>
          
         <?php foreach ($messageTraite as $value){  ?>
               <div class="col s3 m3">
                     <div class="card green">
                     <div class="card-content white-text">
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
	  
	  </p></div>
    </li>
    
  </ul>
	  
      
   </body>
</html>
