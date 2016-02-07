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
   $dir    = 'uploads';
   $photosGalerie = scandir($dir, 1);

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
               <!-- Barre de navigation -->
               <ul id="nav-mobile" class="right hide-on-med-and-down">
                  <li class="active"><a href="index.php">Acceuil</a></li>
                  <li><a href="reservation.php">Reservation</a></li>
                  <li><a href="contact.php">Contact</a></li>
                  <li><a href="connexion.php">Espace utilisateur</a></li>
               </ul>
            </div>
         </nav>
      </header>
      <!-- Présentation --> 
      <section id="presentation" class="row"> 
         <div id="accrochePresentation" class="card col white">
            <div id="bienvenue">
               <h3>Bienvenue</h3>
               <p><?php
                  $fichier='presentation.txt';
                  $contenu_string = file_get_contents($fichier);
                  print utf8_encode($contenu_string);
               ?></p>

                  <br><br></p>
            </div>

            <div id="galerie">
               <ul id="galerie_mini">
                  <?php $i = 1;foreach ($photosGalerie as $photo) :?>
                     <?php if (!in_array($photo,array(".",".."))) : ?>
                        <li><a href=<?php echo 'uploads/' . $photo;?>></a></li>
                     <?php endif;?>
                  <?php endforeach;?>
               </ul>
               <dl id="photo">
                  <?php if (!in_array($photosGalerie[0],array(".",".."))) : ?>
                     <dt><?php echo $photosGalerie[0];?></dt>
                     <dd><img id="big_pict" src=<?php echo 'uploads/' . $photosGalerie[0];?> alt=<?php echo 'uploads/' . $photosGalerie[0];?> /></dd>
                  <?php endif; ?>
               </dl>
               <ul id="nav">
                  <li id="prec"><a class="waves-effect waves-light btn-large" id="prevButton" ><i class="material-icons left">skip_previous</i></a></li>
                  <li id="suiv"><a class="waves-effect waves-light btn-large" id="nextButton" ><i class="material-icons left">skip_next</i></a></li>
               </ul>
         </div>
         </div>
         <div id="presentationService" class="row">
            <div id="presentationReservation" class="card col white">
               <h5>Reservation de livres</h5>
               <img id="imageLivre" src="images/livre.jpg"></img>
               <p>Grace a l'onglet <a href="reservation.html">RESERVATION</a>, vous pouvez désormais réserver vos livres en remplissant simplement le formulaire.
                  Votre bon et dévoué librairie validera alors votre commande et vous contactera lors de l'arrivée de vos livres !</p>
            </div>
            <div id="presentationNews"class="card col white">
               <h5>News</h5>
               <!-- <img id="imageNews" src="images/news.jpg"></img> -->
               <p>Afin de vous tenir informés de toutes les dernières nouveautés de votre libraire, des news apparaissent à gauche de votre écran.</p>
            </div>
             <div id="presentationContact" class="card col white">
               <h5>Contact</h5>
               <!-- <img id="imageContact" src="images/contact.jpg"></img> -->
               <p>Pour toutes questions, vous pouvez contacter votre librairie grâce à l'onglet <a href="contact.html">CONTACT</a>.</p>
            </div>
         </div>
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
         </aside>
      <?php endif; ?>
      
   </body>
</html>
