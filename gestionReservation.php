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
														
   if (isset($_POST['status'])){
      // On update le status de la reservation
	  if ($_POST['status'] == 1) {
		$idReservationaChanger = $_POST['idReservationAChanger'];
		$reqChangerStatusReservation = "UPDATE RESERVATION
										SET statusReservation = 1
										WHERE idReservation ='".$idReservationaChanger."'";
 																 
 													 
 		$updateStatusReservation = $bd->set_requete($reqChangerStatusReservation);
	  } else if($_POST['status'] == 2 ) {
		$idReservationaChanger = $_POST['idReservationAChanger'];
		$reqChangerStatusReservation = "UPDATE RESERVATION
										SET statusReservation = 2
										WHERE idReservation ='".$idReservationaChanger."'";									 
 		echo $reqChangerStatusReservation;								 
 		$updateStatusReservation = $bd->set_requete($reqChangerStatusReservation);
	  }
	}
	
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
				<!-- Titre du site non affiché -->
				<h1 id="titreSite">Librairie La Parade</h1>
				<img id="logo" src="images/logo.png"></img>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
	                <li><a href="index.php">Accueil</a></li>
	                <li><a href="gestionNews.php">News</a></li>
	                <li class="active"><a href="gestionReservation.php">Reservation</a></li>
                    <li><a href="gestionContact.php">Messages</a></li>
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
		  <!-- Par défaut on déploie les nouvelles demandes de réservations -->
	      <div class="collapsible-header active"><i class="material-icons">call_made</i>Nouvelles réservations</div>
	      <div class="collapsible-body"><p>
		  
		  
		  <!-- cards pour les nouvelles reservations -->
	      <?php if (!empty($nouvellesReservations)): ?>
	          
	         <?php foreach ($nouvellesReservations as $value){  ?>
	                     <div class="card red">
	                     <div class="card-content black-text">
						 
						 <!-- Bouton pour changer l'état de la réservation : de nouvelle (0) à en cours (1)
						   -- On envoie par POST l'id de la réservation à modifier -->
						 <form action="gestionReservation.php" method="post">
							<input type="hidden" name="status" value="1" /> 
							<input type="hidden" name="idReservationAChanger" value=<?php echo $value['idReservation']; ?> /> 
							<button id="boutonGestionReservation" type="submit"  name="action">traiter </button>
						  </form>
						 
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
	                     <div class="card green">
	                     <div class="card-content black-text">
						 
						 <!-- Bouton pour changer l'état de la réservation : de en cours (1) à terminé (2)
						   -- On envoie par POST l'id de la réservation à modifier -->
						 <form action="gestionReservation.php" method="post">
							<input type="hidden" name="status" value= 2 /> 
							<input type="hidden" name="idReservationAChanger" value=<?php echo $value['idReservation']; ?> /> 
							<button id="boutonGestionReservation" type="submit"  name="action">traiter </button>
						</form>
						
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
	                     <div class="card yellow">
	                     <div class="card-content black-text">
						 	 
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
	         <?php } ?>
	         
	      <?php endif ?>
		  
		  
		  </p></div>
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
		<?php if (isset($_SESSION['login'])) : ?>
		   <a id="lienEspaceUtilisateur" href="deconnexion.php">Deconnexion</a>
		<?php else : ?>
		   <a id="lienEspaceUtilisateur" href="#" data-width="500" data-rel="popup1" class="poplight">Connexion</a>
		<?php endif; ?>
		</footer>
		</aside>
	<?php endif; ?>

   </body>
</html>