<?php
	// DECONNEXION + DESTRUCTION DES VARIABLES SESSION + REDIRECTION VERS LA PAGE D'ACCUEIL
	session_start();
	session_unset();
	session_destroy();
	header('Location: index.php');
	exit();
?>