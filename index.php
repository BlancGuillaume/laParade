<?php 
   session_start();
   if (isset($_SESSION['login']))
   {
      //var_dump($_SESSION['login']);
   }

   ini_set('display_errors','off'); // Pour ne pas avoir le message d'erreur : The mysql extension is deprecated
   include('bd/accessBD.php'); 

   $bd = new accessBD;
   $bd->connect();

   $dir = 'galerie';
   $photosGalerie = scandir($dir, 1);

   if ($_SESSION['erreur'] == -1) {
      var_dump($_SESSION['erreur']);
      header('Location: deconnexion.php');
   }

   // Suppression image 
   if (isset($_POST['nomImageASupprimer'])){

      $element = explode("/", $_POST['nomImageASupprimer']);

      $tmp = 0;
      for ($i = 0 ; $i < count($element) ; $i++) {
         var_dump($element[$i]);
         if ($tmp == 1 || strcmp($element[$i],"galerie") == 0) {
            $tmp = 1; 
            if ($cheminImage != NULL) $cheminImage = $cheminImage . '/' . $element[$i];
            else $cheminImage = $element[$i];
         }
      }
      unlink($cheminImage);    
      header('Location: index.php');            
   } 
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
                  <li class="active"><a href="index.php">Accueil</a></li>
                  <?php if (!isset($_SESSION['login'])) :?>
                     <li><a href="reservation.php">Reservation</a></li>
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

      <!-- Présentation --> 
      <section id="presentation" class="row"> 
         <div id="accrochePresentation" class="card col">
            <div id="bienvenue">
               <h3>Bienvenue
                  <?php if (isset($_SESSION['login'])): ?> administrateur
                  <?php endif; ?>
                  </h3>
               <p><?php
                  $fichier='presentation.txt';
                  $contenu_string = file_get_contents($fichier);
                  print utf8_encode($contenu_string);
               ?></p>

                  <br><br></p>
            </div>

            <div id="galerie">
               <ul id="ensemblePhotos">
                  <?php $i = 1;foreach ($photosGalerie as $photo) :?>
                     <?php if (!in_array($photo,array(".",".."))) : ?>
                        <li><a href=<?php echo 'galerie/' . $photo;?>></a></li>
                     <?php endif;?>
                  <?php endforeach;?>
               </ul>
               <dl id="photo">
                  <?php if (!in_array($photosGalerie[0],array(".",".."))) : ?>
                     <dt><?php echo $photosGalerie[0];?></dt>
                     <dd><img id="photoAAfficher" src=<?php echo 'galerie/' . $photosGalerie[0];?> alt=<?php echo 'galerie/' . $photosGalerie[0];?> /></dd>
                  <?php endif; ?>
               </dl>
               <ul id="nav">
                  <li id="prec"><a class="waves-effect waves-light btn-large" id="prevButton" ><i class="material-icons left">skip_previous</i></a></li>
                  <li id="suiv"><a class="waves-effect waves-light btn-large" id="nextButton" ><i class="material-icons left">skip_next</i></a></li>
               </ul>
               <?php if (isset($_SESSION['login'])): ?>
                  <form action="index.php" method="post">
                    <input type="hidden" id="nomImageASupprimer" name="nomImageASupprimer" value=<?php echo 'galerie/' . $photosGalerie[0]; ?> />  
                    <button id="boutonSupprimerNew" type="submit" name="action" class="waves-effect waves-light btn-large">Supprimer</button>
                  </form>   
               <?php endif; ?>
               <br />
               <?php if (isset($_SESSION['login'])): ?>
                  <form action="uploadImagesGalerie.php" method="post" enctype="multipart/form-data">
                     <div class="input-field">
                       <input type="file" name="fileToUpload" id="fileToUpload">
                     </div>
                     <button id="boutonAjoutImagesGalerie" type="submit" name="action">Ajouter</button>
                  </form>
                  <!-- Affichage de la pop up d'ajout de news (réussi ou non ?)-->
                  <?php if ($_SESSION['erreurGalerie'] != "no") :?>
                     <?php if ($_SESSION['erreurGalerie'] == "champs") : ?>
                        <script>alert("L'image n'a pas été uploadé. Vous n'avez pas sélectionné d'image.");</script>

                      <?php elseif ($_SESSION['erreurGalerie'] == "notImage") : ?>
                        <script>alert("L'image n'a pas été uploadé. L'image choisi n'est pas une image.");</script>

                      <?php elseif ($_SESSION['erreurGalerie'] == "taille") : ?>
                        <script>alert("L'image n'a pas été uploadé. L'image est trop grande.");</script>

                      <?php elseif ($_SESSION['erreurGalerie'] == "format") : ?>
                        <script>alert("L'image n'a pas été uploadé. Seuls les formats : jpg, gif, jpeg, png sont acceptés.");</script>

                     <?php elseif ($_SESSION['erreurGalerie'] == "existeDeja") : ?>
                        <script>alert("L'image n'a pas été uploadé. Elle existe déjà.");</script>

                      <?php elseif ($_SESSION['erreurGalerie'] == "upload") : ?>
                        <script>alert("L'image n'a pas été uploadé. Erreur lors du téléchargement.");</script>

                      <?php endif;?>

                  <?php else : ?>
                     <script>alert("L'image' a été ajouté à la galerie");</script>
                  <?php endif;?>

                  <?php unset($_SESSION['erreurGalerie']); ?>
                  <?php unset($_FILES["fileToUpload"]["name"]); ?>

               <?php endif; ?>
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

      <!-- HEADER -->
      <?php include('html_includes/news.php');?>

      <!-- FOOTER -->
      <?php include('html_includes/footer.php');?>

   </body>

   
   
</html>
