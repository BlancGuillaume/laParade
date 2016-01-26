<?php
$target_dir    = "uploads/";
$target_file   = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk      = 1;
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "Le fichier est une image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "Le fichier n'est pas une image";
        $uploadOk = 0;
    }
}
// V�rifie que le fichier n'existe pas d�ja
if (file_exists($target_file)) {
    echo "D�sol� le fichier existe d�ja";
    $uploadOk = 0;
}
// V�rifie la taille du fichier
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "D�sol�, votre image est trop volumineuse";
    $uploadOk = 0;
}
// N'autorise que les extensions d'images
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "D�sol�, seul les fichiers JPG, JPEG, PNG & GIF files sont autoris�s.";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "D�sol� votre image n'a pas �t� upload�";
    // Si OK, on essaye d'uploader l'image
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " a ete uploade.";
		// redirection sur la m�me page
        header('Location: news.html');
        exit();
    } else {
        echo "D�sol�, il y a eu une erreur pendant l'upload de l'image";
    }
}
?>