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

	// REQUETE PERMETTANT DE RECUPERER TOUTES LES NOUVELLES RESERVATIONS
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
	
	// REQUETE PERMETTANT DE RECUPERER TOUTES LES RESERVATIONS EN COURS						
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

	// REQUETE PERMETTANT DE RECUPERER TOUTES LES RESERVATIONS TERMINEES
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
	
	// CHANGEMENT DE STATUS D'UNE RESERVATION (l'administrateur a appuyé sur le bouton TRAITER)								
    if (isset($_POST['status'])){
		// On update le status de la reservation
		if ($_POST['status'] == 1) {
			$idReservationaChanger = $_POST['idReservationAChanger'];
			$reqChangerStatusReservation = "UPDATE RESERVATION
											SET statusReservation = 1
											WHERE idReservation ='".$idReservationaChanger."'";
 																 
 													 
 			$updateStatusReservation = $bd->set_requete($reqChangerStatusReservation);
	  	} 
	  	else if($_POST['status'] == 2 ) {
			$idReservationaChanger = $_POST['idReservationAChanger'];
			$reqChangerStatusReservation = "UPDATE RESERVATION
											SET statusReservation = 2
											WHERE idReservation ='".$idReservationaChanger."'";									 
	 		echo $reqChangerStatusReservation;								 
	 		$updateStatusReservation = $bd->set_requete($reqChangerStatusReservation);
	  	}
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
	  
		<section id="gestionReservation" class="row card"> 
			<ul class="collapsible" data-collapsible="expandable"> <!-- Plusieurs menus peuvent être ouvert en même temps -->
			    <li>
					<!-- Par défaut on déploie les nouvelles demandes de réservations -->
					<div class="collapsible-header active" id="collapseHeader1">
						<i class="material-icons">call_made</i>Nouvelles réservations
					</div>

			      	<div class="collapsible-body" id="collapse1"><p>
					  	<!-- cards pour les nouvelles reservations -->
			      		<?php if (!empty($nouvellesReservations)): ?>
					        <?php foreach ($nouvellesReservations as $value) :?>
				                <div class="card red">
					                <div class="card-content black-text">
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
										<strong>La reservation : </strong>
										<?php if (isset($value['nomLivre'])) { ?>
											<p><?php echo "Le livre : ".$value['nomLivre']; ?></p>
										<?php } ?>	
										<?php if (isset($value['numISBM'])) { ?>
											<p><?php echo "NumISBN : ".$value['numISBM']; ?></p>
										<?php } ?>	
										<?php if (isset($value['auteurLivre'])) { ?>
											<p><?php echo "Auteur : ".$value['auteurLivre']; ?></p>
										<?php } ?>	
										<?php if (isset($value['editeurLivre'])) { ?>
											<p><?php echo "Editeur : ".$value['editeurLivre']; ?></p>
										<?php } ?>	
										<?php if (isset($value['dateReservation'])) { ?>
											<p><?php echo "Date de reservation : ".$value['dateReservation']; ?></p>
										<?php } ?>		
										<?php if (isset($value['dateLimiteReservation'])) { ?>
											<p><?php echo "Date limite de reservation : ".$value['dateLimiteReservation']; ?></p>
										<?php } ?>	
										<?php if (isset($value['commentaireReservation'])) { ?>
											<p><?php echo "Commentaire : ".$value['commentaireReservation']; ?></p>
										<?php } ?>	
										<!-- Bouton pour changer l'état de la réservation : de nouvelle (0) à en cours (1)
										  -- On envoie par POST l'id de la réservation à modifier -->
										<br>
										<form action="gestionReservation.php" method="post">
												<input type="hidden" name="status" value="1" /> 
												<input type="hidden" name="idReservationAChanger" value=<?php echo $value['idReservation']; ?> /> 
												<button id="boutonGestionReservation" class="btn waves-effect waves-light" type="submit"  name="action">traiter </button>
										</form>							
					                </div>
				            	</div>
					        <?php endforeach; ?>
			    		<?php endif ?>
			    	</p></div>
			    </li>

			    <li>
					<div class="collapsible-header" id="collapseHeader2">
						<i class="material-icons">trending_flat</i>Réservations en cours
					</div>

			      	<div class="collapsible-body" id="collapse2"><p>
				  	   <!-- cards pour les reservations en cours-->
						<?php if (!empty($reservationsEnCours)): ?>
				          
					        <?php foreach ($reservationsEnCours as $value):?>
				                <div class="card green">
					            	<div class="card-content black-text">
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
										<strong>La reservation : </strong>
										<?php if (isset($value['nomLivre'])) { ?>
											<p><?php echo "Le livre : ".$value['nomLivre']; ?></p>
										<?php } ?>	
										<?php if (isset($value['numISBM'])) { ?>
											<p><?php echo "NumISBN : ".$value['numISBM']; ?></p>
										<?php } ?>	
										<?php if (isset($value['auteurLivre'])) { ?>
											<p><?php echo "Auteur : ".$value['auteurLivre']; ?></p>
										<?php } ?>	
										<?php if (isset($value['editeurLivre'])) { ?>
											<p><?php echo "Editeur : ".$value['editeurLivre']; ?></p>
										<?php } ?>	
										<?php if (isset($value['dateReservation'])) { ?>
											<p><?php echo "Date de reservation : ".$value['dateReservation']; ?></p>
										<?php } ?>		
										<?php if (isset($value['dateLimiteReservation'])) { ?>
											<p><?php echo "Date limite de reservation : ".$value['dateLimiteReservation']; ?></p>
										<?php } ?>	
										<?php if (isset($value['commentaireReservation'])) { ?>
											<p><?php echo "Commentaire : ".$value['commentaireReservation']; ?></p>
										<?php } ?>	
									    <!-- Bouton pour changer l'état de la réservation : de en cours (1) à terminé (2)
										-- On envoie par POST l'id de la réservation à modifier -->
										<br>
										<form action="gestionReservation.php" method="post">
											<input type="hidden" name="status" value= 2 /> 
											<input type="hidden" name="idReservationAChanger" value=<?php echo $value['idReservation']; ?> /> 
											<button id="boutonGestionReservation" class="btn waves-effect waves-light" type="submit"  name="action">traiter </button>
										</form>
															
					            	</div>
					            </div>
					         <?php endforeach; ?>
				         
				    	<?php endif; ?>
				  
					</p></div>
			    </li>
			    <li>
			      	<div class="collapsible-header" id="collapseHeader3">
			      		<i class="material-icons">done</i>Réservations terminées
			      	</div>
			      	<div class="collapsible-body" id="collapse3"><p>
				  
						<!-- cards pour les reservations  terminées-->
						<?php if (!empty($reservationsTerminees)): ?>
					        <?php foreach ($reservationsTerminees as $value): ?>
				                <div class="card yellow">
				                    <div class="card-content black-text">
									 	 
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
										<strong>La reservation : </strong>
										<?php if (isset($value['nomLivre'])) { ?>
											<p><?php echo "Le livre : ".$value['nomLivre']; ?></p>
										<?php } ?>	
										<?php if (isset($value['numISBM'])) { ?>
											<p><?php echo "NumISBN : ".$value['numISBM']; ?></p>
										<?php } ?>	
										<?php if (isset($value['auteurLivre'])) { ?>
											<p><?php echo "Auteur : ".$value['auteurLivre']; ?></p>
										<?php } ?>	
										<?php if (isset($value['editeurLivre'])) { ?>
											<p><?php echo "Editeur : ".$value['editeurLivre']; ?></p>
										<?php } ?>	
										<?php if (isset($value['dateReservation'])) { ?>
											<p><?php echo "Date de reservation : ".$value['dateReservation']; ?></p>
										<?php } ?>		
										<?php if (isset($value['dateLimiteReservation'])) { ?>
											<p><?php echo "Date limite de reservation : ".$value['dateLimiteReservation']; ?></p>
										<?php } ?>	
										<?php if (isset($value['commentaireReservation'])) { ?>
											<p><?php echo "Commentaire : ".$value['commentaireReservation']; ?></p>
										<?php } ?>		
				                    </div>
				               	</div>
					        <?php endforeach;?>
					    <?php endif ?>
					</p></div>
			    </li>
		  	</ul>
		</section>

		<!-- HEADER -->
		<?php include('html_includes/news.php');?>

		<!-- FOOTER -->
		<?php include('html_includes/footer.php');?>

   </body>
</html>