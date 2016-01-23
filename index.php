<?php 
   include('bd/accessBD.php'); 

   $bd = new accessBD;
   $bd->connect();

   $id = "flo";
   $mdp = "root";
   $isAdmin = true;
   $bd->insert_utilisateur($id, $mdp, $isAdmin);
   $result = $bd->get_utilisateur($id);
   echo "Mot de passe : " . $result['mdpUtilisateur'];
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
               <a href="images/blason.gif" class="brand-logo">Librairie la Parade</a>
               <!-- Barre de navigation -->
               <ul id="nav-mobile" class="right hide-on-med-and-down">
                  <li class="active"><a href="index.html">Presentation</a></li>
                  <li><a href="reservation.html">Reservation</a></li>
                  <li><a href="contact.html">Contact</a></li>
               </ul>
            </div>
         </nav>
      </header>
      <!-- Présentation --> 
      <section id="presentation" class="row"> 
         <div id="accrochePresentation" class="card col white">
            <h3>Bienvenue</h3>
            <p>Reprise en 2004 par Arnauld et Patricia GIVELET, la librairie la Parade n'a de cesse de se diversifier afin de satisfaire pleinement tous ses clients : presse, papeterie, librairie, LOTO, PMU, point de vente RTM, confiserie etc. C'est dans cet état d'esprit, que nous avons la joie de vous présenter les nouveaux services en ligne !<br><br></p>
            <img id="imageDevanture" src="images/devanture.jpg"></img>
         </div>
         <div id="presentationService" class="row">
            <div id="presentationReservation" class="card col white">
               <h5>Reservation de livres</h5>
               <img id="imageLivre" src="images/livre.jpg"></img>
               <p>Grace a l'onglet <a href="reservation.html">RESERVATION</a>, vous pouvez désormais réserver vos livres en replissant simplement le formulaire.Votre bon et dévoué librairie validera alors votre commande et vous contactera lors de l'arrivée de vos livres !</p>
            </div>
            <div id="presentationNews"class="card col teal white">
               <h5>News</h5>
               <img id="imageNews" src="images/news.jpg"></img>
               <p>Afin de vous tenir informés de toutes les dernières nouveautés de votre libraire, des news apparaissent à gauche de votre écran.</p>
            </div>
             <div id="presentationContact" class="card col white">
               <h5>Contact</h5>
               <img id="imageContact" src="images/contact.jpg"></img>
               <p>Pour toutes questions, vous pouvez contacter votre librairie grâce à l'onglet <a href="contact.html">CONTACT</a>.</p>
            </div>
         </div>
      </section>

      <!-- cards pour les news -->
      <aside class="container-cards"> <!-- ajout d'une nouvelle news -> dans cette div -->
            <div class="col s3 m3">
               <div class="card orange darken-2">
                  <div class="card-content white-text">
                     <span>News 1 du 16 janvier 2016</span>
                     <p>Voici la dernière nouveauté à la Librairie la Parade ! Nous vous invitons à venir achter des livres, pleins de livres blablabla. Venez nombreux ! Café offert ! COULEUR : orange darken-2</p>
                     <a href="#">LIEN</a>
                  </div>
               </div>
            </div>
            <div class="col s3 m3">
               <div class="card orange">
                  <div class="card-content white-text">
                     <span>News 2 du 16 janvier 2016</span>
                     <p>Nous vous souhaitons une bonne année ! COULEUR : orange</p>
                     <a href="#">LIEN</a>
                  </div>
               </div>
            </div>
            <div class="col s3 m3">
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
