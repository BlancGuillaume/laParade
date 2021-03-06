<?php 
	// Pour ne pas avoir le message d'erreur : The mysql extension is deprecated
    ini_set('display_errors','off'); 

    // CONNEXION A LA BASE DE DONNEES
    include('bd/accessBD.php'); 
	$bd = new accessBD;
	$bd->connect();

	/* POUR LA CONNEXION : affichage alerte si erreur de connexion */
	if ($_SESSION['erreurConnection'] == -1) {
		unset($_SESSION['erreurConnection']);
		echo '<script>alert("Echec de la connection : mail ou mot de passe invalide.");</script>';
	}
	
   // On regarde si le formulaire a été complété 
   if (!empty($_POST)) {

		// Récupération de toutes les informations du formulaire de réservation
		$dateReservation = date("Y-m-d H:i:s"); // le format DATETIME de MySQL
		$dateLimiteReservation =  $_POST['dateLimiteReception'];  
		
		// Fonction addslashes pour éviter erreur d'insertions de bdd
		$commentaireReservation = addslashes($_POST['commentaire']);
		$mailClient = $_POST['email'];
		$nomClient = addslashes($_POST['nom']);
		$prenomClient = addslashes($_POST['prenom']);
		$numClient = $_POST['telephone'];
		$nomEtablissement = addslashes($_POST['etablissement']);
		$numISBM = $_POST['isbn'];
		$nomLivre = addslashes($_POST['titre']);
		$auteurLivre = addslashes($_POST['auteur']);
		$editeurLivre = addslashes($_POST['editeur']);
		$statusReservation = 0;
 
		$erreurFormulaire = 0; // différent de 0 s'il y a une erreur 
		
		// Plusieurs champs obligatoires peuvent avoir été omis.
		// On va consruire le message au fur et a mesure
		$erreurMessage = "La réservation a échouée, le(s) champ(s) suivant doivent être complétés : ";
		
		 if (empty($nomLivre)) {
			$erreurMessage .= "titre ";
			$erreurFormulaire = 1;
		 }
		 if (empty($auteurLivre)) {
			$erreurMessage .= "auteur ";
			$erreurFormulaire = 1;
		 }
		 if (empty($editeurLivre)) {
			$erreurMessage .= "editeur ";
			$erreurFormulaire = 1;
		 }
		 if (empty($mailClient)) {
			$erreurMessage .= "mail ";
			$erreurFormulaire = 1;
		 }
		 if (empty($nomClient)) {
			$erreurMessage .= "nom ";
			$erreurFormulaire = 1;
		 }
		 if (empty($prenomClient)) {
			$erreurMessage .= "prénom ";
			$erreurFormulaire = 1;
		 }
		 
		// Affichage de la pop du succès de la réservation, ou de l'echec dans le cas contraire
		if ($erreurFormulaire == 1) {
			// Il y a eu une erreur
			echo "<script> alert('".$erreurMessage."');</script>";
		} else {
			// Ajout de la réservation	
			$reqClientExiste = 	"SELECT * 
							FROM CLIENT 
							WHERE mailClient = '".$mailClient."'"; 
			$resultClientExiste = $bd->get_requete($reqClientExiste);
   
			// Le client est t'il déja dans la bd ? 
			if (empty($resultClientExiste)) {
				// Non : ajout du client
				$reqInsertionClient = "INSERT INTO CLIENT VALUES ('".$mailClient."', '".$nomClient."', '".$prenomClient."', '".$numClient."')"; 
				$result = $bd->set_requete($reqInsertionClient);
			} 
   
			// Un établissement a t'il été renseigné ?
			if (!empty($nomEtablissement)) {
				// Oui un établissement a été renseigné
		
				$reqEtablissementExiste = 	"SELECT * 
											FROM ETABLISSEMENT 
											WHERE nomEtablissement = '".$nomEtablissement."'"; 
				$resultEtablissementExiste = $bd->get_requete($reqEtablissementExiste);
		
				// L'etablissement est il dans la bd ? 
				if (empty($resultEtablissementExiste)) {			
					// Non : ajout de l'établissement
					$reqInsertionEtablissement = "INSERT INTO ETABLISSEMENT VALUES ('".$nomEtablissement."')"; 
					$result = $bd->set_requete($reqInsertionEtablissement);
				} 
			}	
   
			$reqReservation = "INSERT INTO RESERVATION (dateReservation, 
														dateLimiteReservation,
														commentaireReservation,
														mailClientReservation,
														nomEtablissementReservation,
														numISBM,
														nomLivre,
														auteurLivre,
														editeurLivre,
														statusReservation)
		
			VALUES ('".$dateReservation."', 
					'".$dateLimiteReservation."', 
					'".$commentaireReservation."',
					'".$mailClient."',
					'".$nomEtablissement."',
					'".$numISBM."',
					'".$nomLivre."',
					'".$auteurLivre."',
					'".$editeurLivre."',
					'".$statusReservation."')";
													  										 
			$result = $bd->set_requete($reqReservation);	  
		
			// Popup de succès 
			echo "<script> alert(\"Réservation effectuée. Nous vous contacterons prochainement\");</script>";
		}	
	}												  
?>

<!DOCTYPE HTML>
<html>

	<!-- HEAD -->
    <?php include('html_includes/head.php');?>

	<body>
		<!--Import jQuery before materialize.js-->
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="js/codeAutre/materialize.min.js"></script>
		<script type="text/javascript" src="js/notreCode/script.js"></script>
		<script src="js/codeAutre/jquery.lazyload.js"></script>

		<!-- HEADER -->
      	<header>
        	<!-- Barre de navigation -->
        	<nav id="barreNavigation">
	            <div>
	                <!-- Titre du site non affiché -->
	                <h1 id="titreSite">Librairie La Parade</h1>
	                <!-- Logo -->
	                <img id="logo" class="imgAsynchrone" data-original="images/logo_laparade.png"></img>
	                <!-- Menu -->
	                <ul id="menu">
			            <li><a href="index.php">Accueil</a></li>
			            <?php if (!isset($_SESSION['login'])) :?>
			               <li class="active"><a href="reservation.php">Reservation</a></li>
			               <li><a href="contact.php">Contact</a></li>
			            <?php else :?>
			               <li><a href="gestionNews.php">News</a></li>
			               <li><a href="gestionReservation.php">Reservation</a></li>
			               <li><a href="gestionContact.php">Messages</a></li>
			            <?php endif; ?>
			        </ul>
			    </div>
		   </nav>
		</header>

		<form action="reservation.php" method="post">
		<div class="row" id="presentation">
			<!-- - - - - - - - - - -  Section ouvrage  - - - - - - - - - - --> 
			<div id="cardLivre" class="col s12 m5">
				<div class="card col white">
					<h5>Le livre</h5>
					<div class="row">   
						<div class="col s12">
							<!-- Titre du livre -->
							<div class="input-field col s12">
								<i class="material-icons prefix">label</i>
								<input id="titre" name="titre" type="text" class="validate">
								<label for="titre">Titre</label>
							</div>

							<!-- Auteur du livre -->
							<div class="input-field col s12">
								<i class="material-icons prefix">perm_contact_calendar</i>
								<input id="auteur" name="auteur" type="text" class="validate">
								<label for="auteur">Auteur</label>
							</div>
							<!-- Editeur du livre -->
							<div class="input-field col s12">
								<i class="material-icons prefix">view_column</i>
								<input id="editeur" name="editeur" type="text" class="validate">
								<label for="editeur">Editeur</label>
							</div>
							<!-- ISBN du livre -->
							<div class="input-field col s12">
								<i class="material-icons prefix">view_column</i>
								<input id="isbn" name="isbn" type="text" class="validate">
								<label for="isbn">ISBN</label>
							</div>
							<!-- Date limite de réception -->
							<div class="input-field col s12">
								<i class="material-icons prefix">web</i>
								<input type="date" class="datepicker" name="dateLimiteReception">
								<label for="dateLimiteReception">Date limite de reception</label>
							</div>
							<!-- Initialisation du dateppicker -->
							<script type="text/javascript">
								$('.datepicker').pickadate({
								   selectMonths: true, // Creates a dropdown to control month
								   selectYears: 15 // Creates a dropdown of 15 years to control year
								 });
							</script>
							<!-- Commentaire -->
							<div class="input-field col s12">
								<i class="material-icons prefix">chat</i>
								<textarea id="commentaire" name="commentaire" class="materialize-textarea validate"></textarea>
								<label for="commentaire">Commentaire</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- - - - - - - - - - - Section Client et etudiant - - - - - - - - - - -->
			<div id="cardClientEtudiant" class="col s12 m5">
				<div id="cardClient" class="card col white">
					<!-- - - Card Client - - - -->
						<h5>Mes informations</h5>
						<div class="row">
							<div class="col s12">
								<!-- Nom + prénom -->
								<div class="input-field col s6">
									<i class="material-icons prefix">account_circle</i>
									<input id="prenom" name="prenom" type="text" class="validate">
									<label for="prenom">Prenom</label>
								</div>
								<div class="input-field col s6">
									<input id="nom" name="nom" type="text" class="validate">
									<label for="nom">Nom</label>
								</div>
								<!-- Telephone -->
								<div class="input-field col s12">
									<i class="material-icons prefix">phone</i>
									<input id="telephone" name="telephone" type="text" class="validate">
									<label for="telephone">Telephone</label>
								</div>
								<!-- Email -->
								<div class="input-field col s12">
									<i class="material-icons prefix">email</i>
									<input id="email" name="email" type="email" class="validate">
									<label for="email">Email</label>
								</div>
							</div>
						</div>
					</div>
					<!-- - - Card etudiant - - -->
					<div id="cardEtudiant" class="card col white">
						<h5>Etudiant</h5>
						<div class="row">
							<div class="col s12">
								Le livre que vous commandez est pour un usage scolaire ? <br/>
								Dites nous quel établissement vous l'a demandé :
								<div class="input-field col s12">
									<i class="material-icons prefix">store</i>
									<input id="etablissement" name="etablissement" type="text" class="validate">
									<label for="etablissement">Etablissement</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Validation de la commande -->
				<button id="boutonReservation" class="btn waves-effect waves-light" type="submit"  name="action">reserver
					<i class="material-icons right">send</i>
				</button>
				</form>
			</div>
		</div>
		
		<!-- NEWS -->
		<?php include('html_includes/news.php');?>

		<!-- FOOTER -->
		<?php include('html_includes/footer.php');?>
   </div>
</html>