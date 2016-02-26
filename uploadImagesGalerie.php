<?php 
	session_start();
	$var = basename($_FILES["fileToUpload"]["name"]);
	var_dump($var);
	/************* UPLOAD DE L'IMAGE *************/
	if (!empty($var)) {
		$imageGalerie = "galerie/"; // Dossier dans lequel est stocké l'image. On s'en sert pour afficher les cards news
		$imageGalerie.= $var;
		$typeImage = strtolower(pathinfo($imageGalerie, PATHINFO_EXTENSION));
		var_dump($typeImage);

		// Vérifier si l'image est bien une image (pas de fichier texte, musique etc)
		// TO DO : je comprends pas ce qu'est ce $_POST["submit"] ???? Et en plus pourquoi tu utilises getimagesize ? 
		// 		   ça permet de Retourner la taille d'une image donc je vois pas le rapport là 
		if (isset($_POST["submit"])) {
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if ($check == false) {
				$_SESSION['erreurGalerie'] = "notImage";
			}
		}

		// Vérifie que le fichier n'existe pas déja
		 if (file_exists($imageGalerie)) {
		 	$_SESSION['erreurGalerie'] = "existeDeja";
		}

		// Vérifie la taille du fichier
		if ($_FILES["fileToUpload"]["size"] > 500000) {
	        $_SESSION['erreurGalerie'] = "taille";
		}

		// N'autorise que les extensions d'images
		if ($typeImage != "jpg"  && $typeImage != "jpe" && $typeImage != "png" && $typeImage != "jpeg" && $typeImage != "gif") {
			$_SESSION['erreurGalerie'] = "format";
		}


		// il n'y a pas d'erreur donc on upload l'image dans le dossier uploads
		if (empty($_SESSION['erreurGalerie'])) {
			var_dump($imageGalerie);
			var_dump($_FILES["fileToUpload"]["tmp_name"]);
			if(!(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $imageGalerie))) {
				$_SESSION['erreurGalerie'] = "upload";
			}
			else {
				$_SESSION['erreurGalerie'] = "no";
			}

		}
	}

	else {
		$_SESSION['erreurGalerie'] = "champs";
	}

	header('Location: index.php');
	exit;

?>