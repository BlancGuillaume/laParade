<?php 
$var = basename($_FILES["fileToUpload"]["name"]);
if (!empty($var)) {
	$target_dir = "galerie/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

	// Check if image file is a actual image or fake image
	if (isset($_POST["submit"])) {
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if ($check !== false) {
			echo "Le fichier est une image - " . $check["mime"] . ".";
			$uploadOk = 1;
		}
		else {
			echo "Le fichier n'est pas une image";
			$uploadOk = 0;
		}
	}

	// Vérifie que le fichier n'existe pas déja
	if (file_exists($target_file)) {
		echo "Désolé le fichier existe déja";
		$uploadOk = 0;
	}

	// Vérifie la taille du fichier
	if ($_FILES["fileToUpload"]["size"] > 500000) {
		echo "Désolé, votre image est trop volumineuse";
		$uploadOk = 0;
	}

	// N'autorise que les extensions d'images
	if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
		echo "Désolé, seul les fichiers JPG, JPEG, PNG & GIF files sont autorisés.";
		$uploadOk = 0;
	}

	if ($uploadOk == 0) {
		echo "Désolé votre image n'a pas été uploadé";
		// Si OK, on essaye d'uploader l'image
	}
	else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " a ete uploade.";

			// redirection sur la même page
			header('Location: index.php');
			exit();
		}
		else {
			echo "Désolé, il y a eu une erreur pendant l'upload de l'image";
		}
	}
}
else {
	echo "rien a uploader";
	header('Location: index.php');
	exit();
}
?>