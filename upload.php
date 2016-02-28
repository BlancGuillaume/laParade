<?php
session_start();
ini_set('display_errors', 'off'); // Pour ne pas avoir le message d'erreur : The mysql extension is deprecated
include ('bd/accessBD.php');
unset($_SESSION['erreurNews']);
// Les champs nom et contenu news doivent obligatoirement être remplis
if (!empty($_POST['nomNews']) && !empty($_POST['contenuNews'])) {
	/********* AJOUT NEWS DANS LA BASE DE DONNEE *********/
	// Connexion à la base de données
	$bd = new accessBD;
	$bd->connect();
	// Récupération de toutes les informations du formulaire d'ajout de news
	if (isset($_POST['nomNews'])) { $nomNews = addslashes($_POST['nomNews']);} else {$nomNews = NULL;}
	if (isset($_POST['contenuNews'])) {$contenuNews = addslashes($_POST['contenuNews']);} else {$contenuNews = NULL;}
	if (isset($_POST['lienNews'])) {$lienNews = addslashes($_POST['lienNews']);} else {$lienNews = NULL;}
	$var = basename($_FILES["fileToUpload"]["name"]); 


	if (!empty($var)) { // News avec image
		$imageNews = "uploads/"; // Dossier dans lequel est stocké l'image. On s'en sert pour afficher les cards news
		$imageNews.= basename($_FILES["fileToUpload"]["name"]);
		$reqNews = "INSERT INTO NEWS (nomNews, contenuNews, imageNews,  lienNews)
					VALUES ('" . $nomNews . "','" . $contenuNews . "','" . $imageNews . "','" . $lienNews . "')";
	}
	else { // News sans image
		$reqNews = "INSERT INTO NEWS (nomNews, contenuNews, lienNews)
					VALUES ('" . $nomNews . "','" . $contenuNews . "','" . $lienNews . "')";
	}
	$result = $bd->set_requete($reqNews);
	if ($result == FALSE) {
		$_SESSION['erreurNews'] = "bd";
	}
	$typeImage = pathinfo($imageNews, PATHINFO_EXTENSION);

	/************* UPLOAD DE L'IMAGE *************/
	if (!empty($var)) {
		// $dossier = "uploads/";
		// $target_file = $dir . basename($_FILES["fileToUpload"]["name"]);
		
		var_dump($typeImage);
		// Vérifier si l'image est bien une image (pas de fichier texte, musique etc)
		if (isset($_POST["submit"])) {
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if ($check == false) {
				$_SESSION['erreurNews'] = "notImage";
			}
		}
		// Vérifie que le fichier n'existe pas déja : dans ce cas pas d'erreur annoncé mais pas d'upload d'image
		 if (file_exists($imageNews)) {
		 	$_SESSION['erreurNews'] = "existeDeja";
		}
		// Vérifie la taille du fichier
		if ($_FILES["fileToUpload"]["size"] > 500000) {
	        $_SESSION['erreurNews'] = "taille";
		}
		// N'autorise que les extensions d'images
		if ($typeImage != "jpg" && $typeImage != "png" && $typeImage != "jpeg" && $typeImage != "gif") {
			$_SESSION['erreurNews'] = "format";
		}
		// il n'y a pas d'erreur donc on upload l'image dans le dossier uploads
		if (empty($_SESSION['erreurNews'])) {
			if(!(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $imageNews))) {
				$_SESSION['erreurNews'] = "upload";
			}
			else {
				$_SESSION['erreurNews'] = "no";
			}
		}
	}
	else {
		if (empty($_SESSION['erreurNews'])) {
			$_SESSION['erreurNews'] = "no";
		}
	}
}
else {
	$_SESSION['erreurNews'] = "champs";
}
header('Location: gestionNews.php');
exit;
?>