<?php 
   session_start();

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

   /* POUR LA GALERIE : récupération des images du dossier galerie */
   $dir = 'galerie';
   $photosGalerie = scandir($dir, 1);

   /* POUR LA GALERIE : suppression de l'image sélectionnée */
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
      // suppression du lien
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
         <!-- Barre de navigation -->
         <nav id="barreNavigation">
            <div>
               <!-- Titre du site non affiché -->
               <h1 id="titreSite">Librairie La Parade</h1>
               <!-- Logo -->
               <img id="logo" src="images/logo_laparade.png"></img>
               <!-- Menu -->
               <ul id="menu">
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

               <!-- Affichage du contenu du fichier presentation.txt --> 
               <p>
                  <?php
                     $fichier='presentation.txt';
                     $contenu_string = file_get_contents($fichier);
                     print utf8_encode($contenu_string);
                  ?>
               </p><br><br>
            </div>

            <!-- GALERIE --> 
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
               <!-- NAVIGATION DANS LA GALERIE (cf fonction afficherImages de js/script.js) --> 
               <ul id="navGalerie">
                  <li id="prec"><a class="waves-effect waves-light btn-large" id="prevButton" ><i class="material-icons left">skip_previous</i></a></li>
                  <li id="suiv"><a class="waves-effect waves-light btn-large" id="nextButton" ><i class="material-icons left">skip_next</i></a></li>
               </ul>
               <!-- SUPPRESSION IMAGE (contenu administrateur) --> 
               <?php if (isset($_SESSION['login'])): ?>
                  <form action="index.php" method="post">
                    <input type="hidden" id="nomImageASupprimer" name="nomImageASupprimer" value=<?php echo 'galerie/' . $photosGalerie[0]; ?> />  
                    <button id="boutonSupprimerNew" type="submit" name="action" class="waves-effect waves-light btn-large">Supprimer</button>
                  </form>   
               <?php endif; ?>
               <br />
               <!-- AJOUT IMAGE (contenu administrateur) --> 
               <?php if (isset($_SESSION['login'])): ?>
                  <form action="uploadImagesGalerie.php" method="post" enctype="multipart/form-data">
                     <div class="input-field">
                       <input type="file" name="fileToUpload" id="fileToUpload">
                     </div>
                     <button id="boutonAjoutImagesGalerie" type="submit" name="action">Ajouter</button>
                  </form>

                  <!-- Affichage de la pop up d'ajout des images (pour savoir si téléchargement a réussi ou non)-->
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

                  <!-- On réinitialise les variables --> 
                  <?php unset($_SESSION['erreurGalerie']); ?>
                  <?php unset($_FILES["fileToUpload"]["name"]); ?>

               <?php endif; ?>
         </div>
         
         <!-- PRESENTATION DES DIFFERENTS SERVICES QUE PROPOSENT LA LIBRAIRIE --> 
         </div>
         <div id="presentationService" class="row">
            <div id="presentationReservation" class="card col white">
               <h5>Reservation de livres</h5>
               <img id="imageLivre" src="images/livre.jpg"></img>
               <p>Grace a l'onglet <a href="reservation.html">RESERVATION</a>, vous pouvez désormais réserver vos livres en remplissant simplement le formulaire.
                  Votre bon et dévoué librairie validera alors votre commande et vous contactera lors de l'arrivée de vos livres !</p>
            </div>
            <div id="presentationNews" class="card col white">
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
