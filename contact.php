<?php 
   ini_set('display_errors','off'); // Pour ne pas avoir le message d'erreur : The mysql extension is deprecated
   include('bd/accessBD.php'); 

   // On regarde si le formulaire a été complété 
   if (!empty($_POST)) {
   
		// le formulaire a été complété, connexion à la BD
		$bd = new accessBD;
		$bd->connect();

		// Récupération de toutes les informations du formulaire de contact
		$dateMessage = date("Y-m-d H:i:s"); // le format DATETIME de MySQL
		$contenuMessage = $_POST['commentaire'];
		$mailClient = $_POST['email'];
		$nomClient = $_POST['nomMessage'];
		$prenomClient = $_POST['prenomMessage'];
		$numClient = $_POST['telephone'];
   
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
   
		$reqMessage = 	"INSERT INTO MESSAGE (contenuMessage, dateMessage, mailClientMessage)
						 VALUES ('".$contenuMessage."','".$dateMessage."','".$mailClient."')";
												  
																								  
		$result = $bd->set_requete($reqMessage);	  
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
						<li><a href="reservation.php">Reservation</a></li>
						<li class="active"><a href="contact.html">Contact</a></li>
					</ul>
				</div>
			</nav>
		</header>
		<section id="presentation" class="row">
			<div id="accrochePresentation" class="card col white">
				<h3>Nous contacter</h3>
				<p>Située dans le centre commercial de la Parade, la librairie jouit d'un ensemble de petis commerces voisins : superette, boulangerie, boucherie, fleuriste, pharmacie, dépanneur informatique, d'une école de danse, d'une pizzeria et d'une école primaire.<br><br><i class="material-icons prefix">theaters</i>Libraire la Parade<br>73, Chemin de Palama<br>13013 MARSEILLE (CHATEAU GOMBERT)<br><br><i class="material-icons prefix">phone</i>0491686917<br><br><i class="material-icons prefix">email</i>librairielaparade@live.fr<br><br></p>
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d292.8365407089034!2d5.439726729829342!3d43.356943641108984!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12c99580dfa08cad%3A0x791b175554fdc87c!2s73+Chemin+de+Palama%2C+13013+Marseille!5e1!3m2!1sfr!2sfr!4v1453217430076" 
					width="300" height="225" frameborder="0" style="border:0" allowfullscreen></iframe>
				<br/> <br/>
			</div>
			
			<form action="contact.php" method="post">
			
			<div id="cardQuestions" class="card col white">
				<h4>Posez vos questions</h4>
				<div class="input-field col s12">
					<i class="material-icons prefix">label</i>
					<input id="nomMessage" name="nomMessage" type="text" class="validate">
					<label for="nomMessage">Nom</label>
				</div>
				<div class="input-field col s12">
					<i class="material-icons prefix">perm_contact_calendar</i>
					<input id="prenomMessage" name="prenomMessage" type="text" class="validate">
					<label for="prenomMessage">Prenom</label>
				</div>
				<div class="input-field col s12">
					<i class="material-icons prefix">email</i>
					<input id="email" name="email" type="email" class="validate">
					<label for="email">Email</label>
				</div>
				<div class="input-field col s12">
					<i class="material-icons prefix">phone</i>
					<input id="telephone" name="telephone" type="text" class="validate">
					<label for="telephone">Telephone</label>
				</div>
				<div class="input-field col s12">
					<i class="material-icons prefix">chat</i>
					<textarea id="commentaire" name="commentaire" class="materialize-textarea validate"></textarea>
					<label for="commentaire">Message</label>
				</div>
			</div>
			<!-- Validation du message -->
			
				<button class="btn waves-effect waves-light" type="submit" name="action">envoyer message
				<i class="material-icons right">send</i>
				</button>
			</form>
		</section>
		
		<!-- cards pour les news -->
		<aside class="container-cards">
			<!-- ajout d'une nouvelle news -> dans cette div -->
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
	</body>
</html>