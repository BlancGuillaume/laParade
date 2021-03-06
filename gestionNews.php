<?php 
  session_start();

  // PAGE DISPONIBLE UNIQUEMENT PAR L'ADMINISTRATEUR : sinon redirection à la page d'accueil
  if (!isset($_SESSION['login']))
  {
    header('Location: index.php');
  }

  // Pour ne pas avoir le message d'erreur : The mysql extension is deprecated
  ini_set('display_errors','off'); 
  
  // CONNEXION A LA BASE DE DONNEES
  include('bd/accessBD.php'); 
  $bd = new accessBD;
  $bd->connect();

  /* POUR LES NEWS : récupération des images du dossier uploads */
  $dir = 'uploads';
  $photosGalerie = scandir($dir, 1);

  /* POUR LA CONNEXION : affichage alerte si erreur de connexion */
  if ($_SESSION['erreurConnection'] == -1) {
    unset($_SESSION['erreurConnection']);
    echo '<script>alert("Echec de la connection : mail ou mot de passe invalide.");</script>';
  }
   
  // SUPPRESSION NEWS
  if (isset($_POST['idNewsASupprimer'])){
		$idNewsASupprimer = $_POST['idNewsASupprimer'];
		$reqSupprimerNews = "DELETE FROM NEWS
				                 WHERE idNews ='".$idNewsASupprimer."'";
		$supprimerNews = $bd->set_requete($reqSupprimerNews);								
  } 
	
  // Récupération de toutes les news (de la plus récente à la plus ancienne)
	$req = "SELECT * FROM NEWS ORDER BY idNews DESC";
  $news = $bd->get_requete($req);

?>

<!DOCTYPE HTML>
<html>
    <!-- FOOTER -->
    <?php include('html_includes/head.php');?>  
    
   <body>
      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="js/codeAutre/materialize.min.js"></script>
      <script src="js/codeAutre/jquery.lazyload.js"></script>
      <script type="text/javascript" src="js/notreCode/script.js"></script>

      <header>
        <!-- Barre de navigation -->
        <nav id="barreNavigation">
          <div>
            <!-- Titre du site non affiché -->
            <h1 id="titreSite">Librairie La Parade</h1>
            <!-- Logo -->
            <img id="logo" class="imgAsynchrone" data-original="images/logo_laparade.png"></img>
            <!-- Menu -->
            <ul id="menu">
              <li><a href="index.php">Accueil</a></li>
              <li class="active"><a href="gestionNews.php">News</a></li>
              <li><a href="gestionReservation.php">Reservation</a></li>
              <li><a href="gestionContact.php">Messages</a></li>
            </ul>
          </div>
        </nav>
      </header>
      
      <section id="formulaireAjoutNews" class="row"> 
          <form action="upload.php" method="post" enctype="multipart/form-data">
            <div id="cardNews" class="card col white">
               <h5>La news</h5>
               <div class="row">
                  <form class="col s12">
                      <!-- Titre de la news-->
                      <div class="input-field col s12">
                          <i class="material-icons prefix">label</i>
                          <input id="nomNews" name="nomNews" type="text" class="validate">
                          <label for="nomNews">Titre news</label>
                      </div>
                      <!-- Contenu de la news -->
                      <div class="input-field col s12">
                          <i class="material-icons prefix">view_column</i>
                          <input id="contenuNews" name="contenuNews" type="text" class="validate">
                          <label for="contenuNews">Contenu</label>
                      </div>
                      <!-- Lien news -->
                      <div class="input-field col s12">
                          <i class="material-icons prefix">view_column</i>
                          <input id="lienNews" name="lienNews" type="text" class="validate">
                          <label for="lienNews">Lien</label>
                      </div>
                      <div class="input-field col s12">
                          <i class="material-icons prefix">perm_media</i>
                          <input type="file" name="fileToUpload" id="fileToUpload">
                      </div>
               </div>
            </div>

           <button id="boutonAjoutNews" onclick="affichePopUp()" class="btn waves-effect waves-light" type="submit" name="action">uploader
               <i class="material-icons right">send</i>
           </button>

        </form>

        <!-- Affichage de la pop up d'ajout de news (réussi ou non ?)-->
        <?php if ($_SESSION['erreurNews'] != "no") :?>
          <?php if ($_SESSION['erreurNews'] == "champs") : ?>
            <script>
                alert("La news n'a pas été ajouté. Le nom et le contenu de la news sont obligatoires.");
            </script>
          <?php elseif ($_SESSION['erreurNews'] == "bd") : ?>
            <script>
                alert("La news n'a pas été ajouté. Problème lié à la base de données.");
            </script>
          <?php elseif ($_SESSION['erreurNews'] == "notImage") : ?>
            <script>
                alert("La news a été ajouté à la galerie sans image. L'image choisi n'est pas une image.");
            </script>
          <?php elseif ($_SESSION['erreurNews'] == "taille") : ?>
            <script>
                alert("La news a été ajouté à la galerie sans image. L'image est trop grande.");
            </script>
          <?php elseif ($_SESSION['erreurNews'] == "format") : ?>
            <script>
                alert("La news a été ajouté à la galerie sans image. Seuls les formats : jpg, gif, jpeg, png sont acceptés.");
            </script>
          <?php elseif ($_SESSION['erreurNews'] == "upload") : ?>
            <script>
                alert("La news a été ajouté à la galerie sans image. Erreur lors du téléchargement.");
            </script>
          <?php endif;?>
        <?php else : ?>
          <script>
            alert("La news a été ajouté à la galerie");
          </script>
        <?php endif;?>
        <?php unset($_SESSION['erreurNews']); ?>
        <?php unset($_FILES["fileToUpload"]["name"]); ?>
      </section>


      <!-- Affichage de toutes les news -->
      <section id="containerAllNews">
        <?php $couleur=1; ?>
        <?php for ($i = 0; !empty($news[$i]); $i++) : ?>
          <?php if($couleur == 1) : ?>
            <div class="card orangefonce eachNew">
            <?php $couleur++; ?>
          <?php elseif($couleur == 2) : ?>
            <div class="card orange eachNew">
            <?php $couleur++; ?>
          <?php else : ?>
            <div class="card vert eachNew">
            <?php $couleur=1; ?>
          <?php endif; ?>
            <?php $idNews = $news[$i]['idNews']; ?>

            <!-- TITRE NEWS -->
            <p class="titreNews"><?php echo $news[$i]['nomNews'];?></p>

            <!-- CONTENU NEWS -->
            <p><?php echo $news[$i]['contenuNews']; ?></p>

            <!-- IMAGE NEWS -->
            <?php if ($news[$i]['imageNews'] != NULL): ?>
              <img class="imgAsynchrone" data-original=<?php echo "\"" . $news[$i]['imageNews'] . "\""; ?>></img><br />
            <?php endif ?>

            <!-- LIEN NEWS -->
            <?php if ($news[$i]['lienNews'] != NULL): ?>
              <a href=<?php echo "\"" . $news[$i]['lienNews'] . "\""; ?>>LIEN</a><br />
            <?php endif; ?>

  			    <!-- Bouton pour supprimer la news : on envoie par POST l'id de la news à supprimer -->
            <form action="gestionNews.php" method="post">
              <input type="hidden" name="idNewsASupprimer" value=<?php echo $idNews; ?> />  
              <button id="boutonSupprimerNew" type="submit" name="action" class="waves-effect waves-light btn-large">Supprimer</button>
            </form>	 

          </div>
        <?php endfor;?>
      </form>
      </section>

      <!-- FOOTER -->
      <?php include('html_includes/footer.php');?>
   </body> 
</html>
