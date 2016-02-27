<?php 
	session_start();

	// RECUPERATION DU CHEMIN DU FICHIER A UPLOADER
	$var = basename($_FILES["fileToUpload"]["name"]);

	/************* UPLOAD DE L'IMAGE *************/
	if (!empty($var)) {
		// Dossier dans lequel est stocké l'image
		$imageGalerie = "galerie/"; 
		$imageGalerie.= $var;
		$typeImage = strtolower(pathinfo($imageGalerie, PATHINFO_EXTENSION));

		// Vérifier si l'image est bien une image (pas de fichier texte, musique etc)
		// TO DO : je comprends pas ce qu'est ce $_POST["submit"] ???? Et en plus pourquoi tu utilises getimagesize ? 
		// 		   ça permet de Retourner la taille d'une image donc je vois pas le rapport là 
		if (isset($_POST["submit"])) {
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if ($check == false) {
				$_SESSION['erreurGalerie'] = "notImage";
			}
		}

		// ERREUR : image est déjà présente dans galerie
		 if (file_exists($imageGalerie)) {
		 	$_SESSION['erreurGalerie'] = "existeDeja";
		}

		// ERREUR : image trop grande
		if ($_FILES["fileToUpload"]["size"] > 500000) {
	        $_SESSION['erreurGalerie'] = "taille";
		}

		// ERREUR : mauvais format d'image
		if ($typeImage != "jpg"  && $typeImage != "jpe" && $typeImage != "png" && $typeImage != "jpeg" && $typeImage != "gif") {
			$_SESSION['erreurGalerie'] = "format";
		}

		// il n'y a pas d'erreur donc on upload l'image dans le dossier uploads
		if (empty($_SESSION['erreurGalerie'])) {
			// ERREUR : lors du téléchargement de l'image dans galerie
			if(!(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $imageGalerie))) {
				$_SESSION['erreurGalerie'] = "upload";
			}
			// PAS D'ERREUR
			else {
				$_SESSION['erreurGalerie'] = "no";
			}

		}
	}

	// ERREUR : champ(s) non rempli(s)
	else {
		$_SESSION['erreurGalerie'] = "champs";
	}

	// REDIRECTION VERS PAGE D'ACCUEIL
	header('Location: index.php');
	exit;

?>