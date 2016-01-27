<?php 
   include('bd/accessBD.php'); 

   $bd = new accessBD;
   $bd->connect();

   $req = "SELECT * FROM NEWS ORDER BY idNews DESC";
   $news = $bd->get_requete($req);
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
      <header>
         <nav>
            <div class="nav-wrapper">
               <a href="images/blason.gif" class="brand-logo">Librairie la Parade</a>
               <!-- Barre de navigation -->
               <ul id="nav-mobile" class="right hide-on-med-and-down">
                  <li class="active"><a href="index.php">Presentation</a></li>
                  <li><a href="reservation.php">Reservation</a></li>
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
      <?php if (!empty($news)): ?>
         <aside class="container-cards"> <!-- ajout d'une nouvelle news -> dans cette div -->   
         <?php for ($i = 0; $i < 5; $i++) : ?>
               <div class="col s3 m3">
                  <?php if ($news[$i]['idNews']% 2 == 0): ?>
                     <div class="card orange">
                  <?php elseif($news[$i]['idNews']% 3 != 0): ?>
                     <div class="card orange lighten-1">
                  <?php else: ?>
                     <div class="card orange darken-2">
                  <?php endif ?>
                     <div class="card-content white-text">
                        <span><?php echo $news[$i]['nomNews'];?></span>
                        <p><?php echo $news[$i]['contenuNews']; ?></p>
                        <?php if (isset($news[$i]['lienNews'])): ?>
                           <a href=<?php echo "\"" . $news[$i]['lienNews'] . "\""; ?>>LIEN</a>
                        <?php endif ?>
                        <?php if (isset($news[$i]['imageNews'])): ?>
                           <img src=<?php echo "\"" . $news[$i]['imageNews'] . "\""; ?>></img>
                        <?php endif ?>
                     </div>
                  </div>
               </div>
         <?php endfor; ?>
         </aside>
      <?php endif ?>
      
   </body>
</html>
