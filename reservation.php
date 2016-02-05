<?php 
   ini_set('display_errors','off'); // Pour ne pas avoir le message d'erreur : The mysql extension is deprecated
   include('bd/accessBD.php'); 

   // On regarde si le formulaire a été complété 
   if (!empty($_POST)) {
   
		// le formulaire a été complété, connexion à la BD
		$bd = new accessBD;
		$bd->connect();

		// Récupération de toutes les informations du formulaire de réservation
		$dateReservation = date("Y-m-d H:i:s"); // le format DATETIME de MySQL
		$dateLimiteReservation =  $_POST['dateLimiteReception'];  
		var_dump($dateLimiteReservation);
		$commentaireReservation = $_POST['commentaire'];
		$mailClient = $_POST['email'];
		$nomClient = $_POST['nom'];
		$prenomClient = $_POST['prenom'];
		$numClient = $_POST['telephone'];
		$nomEtablissement = $_POST['etablissement'];
		$numISBM = $_POST['isbn'];
		$nomLivre = $_POST['titre'];
		$auteurLivre = $_POST['auteur'];
		$editeurLivre = $_POST['editeur'];
		$statusReservation = 0;
   
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
?>




<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Librairie la Parade</title>
		<link href="css/style.css" rel="stylesheet" type="text/css">
		<!--Import Google Icon Font-->
		<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<!--Import materialize.css-->
		<!--<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/> -->
	</head>
	<body>
		<!--Import jQuery before materialize.js-->
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="js/materialize.min.js"></script>
		<header>
			<nav>
				<div class="nav-wrapper">
					<!--<h1><img id="logo" class="brand-logo" src="images/blason.gif"/></h1>-->
					<a href="images/blason.gif" class="brand-logo">Librairie la Parade</a>
					<ul id="nav-mobile" class="right hide-on-med-and-down">
						<li><a href="index.php">Presentation</a></li>
						<li class="active"><a href="reservation.php">Reservation</a></li>
						<li><a href="contact.php">Contact</a></li>
					</ul>
				</div>
			</nav>
		</header>

		<!-- cards pour les news -->
      	<aside class="container-cards"> <!-- ajout d'une nouvelle news -> dans cette div -->
            <div class="col s2 m3">
               <div class="card orange darken-2">
                  <div class="card-content white-text">
                     <span>News 1 du 16 janvier 2016</span>
                     <p>Voici la dernière nouveauté à la Librairie la Parade ! Nous vous invitons à venir achter des livres, pleins de livres blablabla. Venez nombreux ! Café offert ! COULEUR : orange darken-2</p>
                     <a href="#">LIEN</a>
                  </div>
               </div>
            </div>
            <div class="col s2 m3">
               <div class="card orange">
                  <div class="card-content white-text">
                     <span>News 2 du 16 janvier 2016</span>
                     <p>Nous vous souhaitons une bonne année ! COULEUR : orange</p>
                     <a href="#">LIEN</a>
                  </div>
               </div>
            </div>
            <div class="col s2 m3">
               <div class="card orange lighten-1">
                  <div class="card-content white-text">
                     <span>News 3 du 16 janvier 2016</span>
                     <p>Blablablablablablab lablablablablaba COULEUR : orange lighten-1</p>
                     <a href="#">LIEN</a>
                  </div>
               </div>
            </div>
      	</aside>

		<!-- Page Layout here -->
		
	
		
		
		<form action="reservation.php" method="post">
		
		
		<div class="row" id="formulaireReservation">
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
								<label for="commentaire">Date limite de reception</label>
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
			<div class="col s12 m5">
				<div id="cardclient">
					<!-- - - Card Client - - - -->
					<div class="card col white">
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
		
	</body>
</html>