<?php 
   session_start();
   if (isset($_SESSION['login']))
   {
      var_dump($_SESSION['login']);
   }

   ini_set('display_errors','off'); // Pour ne pas avoir le message d'erreur : The mysql extension is deprecated
   include('bd/accessBD.php'); 

   $bd = new accessBD;
   $bd->connect();

   $req = "SELECT * FROM NEWS ORDER BY idNews DESC";
   $news = $bd->get_requete($req);

    if (!empty($_POST)) {
   		
   		$mdpUtilisateur = $_POST['mdpUtilisateur'];
		$idUtilisateur = $_POST['mailUtilisateur'];

		$reqUserExists 	= 	"SELECT * 
							 FROM UTILISATEUR 
							 WHERE idUtilisateur = '".$idUtilisateur."'
							 AND mdpUtilisateur = '".$mdpUtilisateur."'"; 
  		$user = $bd->get_requete($reqUserExists);

  		if (!empty($user)) {
  			session_start();
			$_SESSION['login'] = $_POST['mailUtilisateur'];
			header('Location: news.php');
			exit();
  		}
  		else {
  			$erreur = -1;
  		}
	}

?>

<!DOCTYPE HTML>
<html>
      <meta charset="utf-8" />
      <title>Librairie la Parade</title>
      <link href="css/style.css" rel="stylesheet" type="text/css">
      <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   </head>
   <body>
      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="js/materialize.min.js"></script>
      <script type="text/javascript" src="js/script.js"></script>
      <header>
         <nav>
            <div class="nav-wrapper">
               <a href="images/blason.gif" class="brand-logo">Librairie la Parade</a>
               <!-- Barre de navigation -->
               <ul id="nav-mobile" class="right hide-on-med-and-down">
                  <li><a href="index.php">Acceuil</a></li>
                  <li><a href="reservation.php">Reservation</a></li>
                  <li><a href="contact.php">Contact</a></li>
                  <li class="active"><a href="connexion.php">Espace utilisateur</a></li>
               </ul>
            </div>
         </nav>
      </header>
      <!-- Présentation --> 
      <section id="presentation" class="row"> 
      	<?php if (empty($_SESSION['login'])) : ?>
	      	<form action="connexion.php" method="post">
		         <div id="cardConnexion" class="col s12 m5">
						<div class="card col white">
							<h5>Connexion</h5>
							<div class="row">   
								<div class="col s12">
									<div class="input-field col s12">
										<i class="material-icons prefix">mail</i>
										<input id="mailUtilisateur" name="mailUtilisateur" type="text" class="validate">
										<label for="mailUtilisateur">Mail</label>
									</div>
									<div class="input-field col s12">
										<i class="material-icons prefix">vpn_key</i>
										<input id="mdpUtilisateur" name="mdpUtilisateur" type="text" class="validate">
										<label for="mdpUtilisateur">Mot de passe</label>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- Validation de la connexion -->
					<button id="boutonConnexion" class="btn waves-effect waves-light" type="submit"  name="action">Connexion
						<i class="material-icons right">send</i>
					</button>
				</form>
			<?php else :?>
				<form action="deconnexion.php" method="post">
					<button id="boutonConnexion" class="btn waves-effect waves-light" type="submit"  name="action">Deconnexion
						<i class="material-icons right">send</i>
					</button>
				</form>
			<?php endif; ?>
      </section>

      <!-- cards pour les news -->
      <?php if (!empty($news)): ?>
         <aside class="container-cards"> <!-- ajout d'une nouvelle news -> dans cette div -->   
         <?php for ($i = 0; $i < 5; $i++) : ?>
               <div class="col s3 m3">
                  <?php if ($i == 0 || $i == 3): ?>
                     <div class="card orange darken-2">
                  <?php elseif($i == 1 || $i == 4): ?>
                     <div class="card orange">
                  <?php else: ?>
                     <div class="card orange lighten-1">
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
         </aside>
      <?php endif; ?>
      
   </body>
</html>
