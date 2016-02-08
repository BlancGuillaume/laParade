<?php
session_start();
if (!isset($_SESSION['login'])) {
	header ('Location: connexion.php');
	exit();
}
var_dump($_SESSION['login']);
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
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="index.php">Presentation</a>
                    </li>
                    <li class="active"><a href="reservation.php">Reservation</a>
                    </li>
                    <li><a href="contact.php">Contact</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <form action="upload.php" method="post" enctype="multipart/form-data">


        <!-- Page Layout here -->
        <div class="row" id="formulaireReservation">
            <div id="cardNews" class="col s12 m5">
                <div class="card col white">
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
            </div>

        </div>
        </div>

        <button id="boutonAjoutNews" onclick="affichePopUp()" class="btn waves-effect waves-light" type="submit" name="action">uploader
            <i class="material-icons right">send</i>
        </button>

        </form>
        <!-- Affiche PopUp d'ajout de news -->
        <script>
            function affichePopUp() {
                alert("La news a été ajouté à la galerie");
            }
        </script>
</body>

</html>