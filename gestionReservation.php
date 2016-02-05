<?php 
   ini_set('display_errors','off'); // Pour ne pas avoir le message d'erreur : The mysql extension is deprecated
   include('bd/accessBD.php'); 

   $bd = new accessBD;
   $bd->connect();

   $reqNouvellesReservations = "SELECT  r.idReservation,
										r.dateReservation, 
										r.dateLimiteReservation, 
										r.commentaireReservation, 
										r.nomEtablissementReservation,
									    r.numISBM, 
										r.nomLivre, 
										r.auteurLivre, 
										r.editeurLivre, 
										r.statusReservation,
										c.mailClient,
										c.nomClient,
										c.prenomClient,
										c.numClient
								FROM RESERVATION r, CLIENT c
								WHERE statusReservation = 0
								AND r.mailClientReservation = c.mailClient";
								
   $reqReservationsEnCours = "SELECT    r.idReservation,
										r.dateReservation, 
										r.dateLimiteReservation, 
										r.commentaireReservation, 
										r.nomEtablissementReservation,
									    r.numISBM, 
										r.nomLivre, 
										r.auteurLivre, 
										r.editeurLivre, 
										r.statusReservation,
										c.mailClient,
										c.nomClient,
										c.prenomClient,
										c.numClient
								FROM RESERVATION r, CLIENT c
								WHERE statusReservation = 1
								AND r.mailClientReservation = c.mailClient";

	$reqReservationsTerminees = "SELECT r.idReservation, 
										r.dateReservation, 
										r.dateLimiteReservation, 
										r.commentaireReservation, 
										r.nomEtablissementReservation,
									    r.numISBM, 
										r.nomLivre, 
										r.auteurLivre, 
										r.editeurLivre, 
										r.statusReservation,
										c.mailClient,
										c.nomClient,
										c.prenomClient,
										c.numClient
								FROM RESERVATION r, CLIENT c
								WHERE statusReservation = 2
								AND r.mailClientReservation = c.mailClient";							
														
   $nouvellesReservations = $bd->get_requete($reqNouvellesReservations);
   $reservationsEnCours = $bd->get_requete($reqReservationsEnCours);
   $reservationsTerminees = $bd->get_requete($reqReservationsTerminees);
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
      <div class="collapsible-header active"><i class="material-icons">call_made</i>Nouvelles réservations</div>
      <div class="collapsible-body"><p>
	  <!-- cards pour les nouvelles reservations -->
      <?php if (!empty($nouvellesReservations)): ?>
          
         <?php foreach ($nouvellesReservations as $value){  ?>
               <div class="col s3 m3">
                 
                     <div class="card red">
                     <div class="card-content white-text">
						<p><?php echo $value['idReservation']; ?></p>
						<p><?php echo $value['nomLivre']; ?></p>
						<p><?php echo $value['numISBM']; ?></p>
                        <p><?php echo $value['auteurLivre']; ?></p>
						<p><?php echo $value['editeurLivre']; ?></p>	
						
						<p><?php echo $value['dateReservation']; ?></p>
						<p><?php echo $value['dateLimiteReservation']; ?></p>
						<p><?php echo $value['commentaireReservation']; ?></p>
						<p><?php echo $value['statusReservation']; ?></p>
						
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
      <div class="collapsible-header"><i class="material-icons">trending_flat</i>Réservations en cours</div>
      <div class="collapsible-body"><p>
	  	   <!-- cards pour les reservations en cours-->
	  <?php if (!empty($reservationsEnCours)): ?>
          
         <?php foreach ($reservationsEnCours as $value){  ?>
               <div class="col s3 m3">
                     <div class="card green">
                     <div class="card-content white-text">
						<p><?php echo $value['idReservation']; ?></p>
						<p><?php echo $value['nomLivre']; ?></p>
						<p><?php echo $value['numISBM']; ?></p>
                        <p><?php echo $value['auteurLivre']; ?></p>
						<p><?php echo $value['editeurLivre']; ?></p>	
						
						<p><?php echo $value['dateReservation']; ?></p>
						<p><?php echo $value['dateLimiteReservation']; ?></p>
						<p><?php echo $value['commentaireReservation']; ?></p>
						<p><?php echo $value['statusReservation']; ?></p>
						
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
      <div class="collapsible-header"><i class="material-icons">done</i>Réservations terminées</div>
      <div class="collapsible-body"><p>
	  
	  	   <!-- cards pour les reservations  terminées-->
	  <?php if (!empty($reservationsTerminees)): ?>
          
         <?php foreach ($reservationsTerminees as $value){  ?>
               <div class="col s3 m3">
                     <div class="card yellow">
                     <div class="card-content white-text">
						<p><?php echo $value['idReservation']; ?></p>
						<p><?php echo $value['nomLivre']; ?></p>
						<p><?php echo $value['numISBM']; ?></p>
                        <p><?php echo $value['auteurLivre']; ?></p>
						<p><?php echo $value['editeurLivre']; ?></p>	
						
						<p><?php echo $value['dateReservation']; ?></p>
						<p><?php echo $value['dateLimiteReservation']; ?></p>
						<p><?php echo $value['commentaireReservation']; ?></p>
						<p><?php echo $value['statusReservation']; ?></p>
						
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
