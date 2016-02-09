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
   
   $dir    = 'uploads';
   $photosGalerie = scandir($dir, 1);

   if ($_SESSION['erreur'] == -1) {
      var_dump($_SESSION['erreur']);
      header('Location: deconnexion.php');
   }

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
      <script type="text/javascript" src="js/script.js"></script>
      <header>
         <nav>
            <div>
               <!-- Titre du site non affiché -->
               <h1 id="titreSite">Librairie La Parade</h1>
               <img id="logo" src="images/logo.png"></img>
               <!-- Barre de navigation -->
               <ul id="nav-mobile" class="right hide-on-med-and-down">
                  <li><a href="index.php">Accueil</a></li>
                  <li class="active"><a href="gestionNews.php">News</a></li>
                  <li><a href="gestionReservation.php">Reservation</a></li>
                  <li><a href="gestionContact.php">Messages</a></li>
               </ul>
            </div>
         </nav>
      </header>
      
      <!-- Présentation --> 
      <section id="presentation" class="row"> 
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
