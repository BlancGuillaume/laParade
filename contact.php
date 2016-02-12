<?php 
   ini_set('display_errors','off'); // Pour ne pas avoir le message d'erreur : The mysql extension is deprecated
   include('bd/accessBD.php'); 

   $bd = new accessBD;
   $bd->connect();
   
   // On regarde si le formulaire a été complété 
   if (!empty($_POST)) {
  

		// Récupération de toutes les informations du formulaire de contact
		$dateMessage = date("Y-m-d H:i:s"); // le format DATETIME de MySQL
		$contenuMessage = addslashes($_POST['commentaire']);
		$mailClient = $_POST['email'];
		$nomClient = $_POST['nomMessage'];
		$prenomClient = $_POST['prenomMessage'];
		$numClient = $_POST['telephone'];
		$statusMessage = 0; // nouveau message
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
   
		$reqMessage = 	"INSERT INTO MESSAGE (contenuMessage, dateMessage, mailClientMessage, statusMessage)
						 VALUES ('".$contenuMessage."','".$dateMessage."','".$mailClient."','".$statusMessage."')";
												  
																								  
		$result = $bd->set_requete($reqMessage);	  
	}

	$req = "SELECT * FROM NEWS ORDER BY idNews DESC";
   	$news = $bd->get_requete($req);												  
?>

<!DOCTYPE HTML>
<html>
	<!-- HEAD -->
	<?php include('html_includes/head.php');?>

	<body>
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="js/materialize.min.js"></script>
		<script type="text/javascript" src="js/script.js"></script>
		<!-- HEADER -->
		<header>
		 <nav>
		    <div>
		       <!-- Titre du site non affiché -->
		       <h1 id="titreSite">Librairie La Parade</h1>
		       <img id="logo" src="images/logo_laparade.png"></img>
		       <!-- Barre de navigation -->
		       <ul id="nav-mobile" class="right hide-on-med-and-down">
		          <li><a href="index.php">Accueil</a></li>
		          <?php if (!isset($_SESSION['login'])) :?>
		             <li><a href="reservation.php">Reservation</a></li>
		             <li class="active"><a href="contact.php">Contact</a></li>
		          <?php else :?>
		             <li><a href="gestionNews.php">News</a></li>
		             <li><a href="gestionReservation.php">Reservation</a></li>
		             <li><a href="gestionContact.php">Messages</a></li>
		          <?php endif; ?>
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
		<!-- HEADER -->
		<?php include('html_includes/news.php');?>

		<!-- FOOTER -->
		<?php include('html_includes/footer.php');?>
      
   </div>
</html>