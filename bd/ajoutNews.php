<?php
	include('accessBD.php'); 

	$bd = new accessBD;
  	$bd->connect();

	$nomNews = "News 1";
	$contenuNews = "Pasta partu ce vendredi 15 avril à la librairie ! Venez nombreux !";
	$imageNews = "images/fraise.jpg";
	$lienNews = "https://www.duolingo.com/";
	$req = "INSERT INTO NEWS (nomNews, contenuNews, imageNews, lienNews) VALUES ('".$nomNews."', '".$contenuNews."', '".$imageNews."', '".$lienNews."')";

	$result = $bd->set_requete($req);
	var_dump($result);

	$nomNews = "News 2";
	$contenuNews = "Pasta partu ce vendredi 15 avril à la librairie ! Venez nombreux !";
	$imageNews = "images/palmier.jpg";
	$lienNews = "";
	$req = "INSERT INTO NEWS (nomNews, contenuNews, imageNews, lienNews) VALUES ('".$nomNews."', '".$contenuNews."', '".$imageNews."', '".$lienNews."')";

	$result = $bd->set_requete($req);
	var_dump($result);

	$nomNews = "News 3";
	$contenuNews = "Pasta partu ce vendredi 15 avril à la librairie ! Venez nombreux !";
	$imageNews = "";
	$lienNews = "";
	$req = "INSERT INTO NEWS (nomNews, contenuNews, imageNews, lienNews) VALUES ('".$nomNews."', '".$contenuNews."', '".$imageNews."', '".$lienNews."')";

	$result = $bd->set_requete($req);
	var_dump($result);

	$nomNews = "News 4";
	$contenuNews = "Pasta partu ce vendredi 15 avril à la librairie ! Venez nombreux !";
	$imageNews = "images/leonardo.jpg";
	$lienNews = "";
	$req = "INSERT INTO NEWS (nomNews, contenuNews, imageNews, lienNews) VALUES ('".$nomNews."', '".$contenuNews."', '".$imageNews."', '".$lienNews."')";

	$result = $bd->set_requete($req);
	var_dump($result);

	$nomNews = "News 5";
	$contenuNews = "Pasta partu ce vendredi 15 avril à la librairie ! Venez nombreux !";
	$imageNews = "";
	$lienNews = "https://www.duolingo.com/";
	$req = "INSERT INTO NEWS (nomNews, contenuNews, imageNews, lienNews) VALUES ('".$nomNews."', '".$contenuNews."', '".$imageNews."', '".$lienNews."')";

	$result = $bd->set_requete($req);
	var_dump($result);

	$nomNews = "News 6";
	$contenuNews = "Pasta partu ce vendredi 15 avril à la librairie ! Venez nombreux !";
	$imageNews = "images/fraise.jpg";
	$lienNews = "https://www.duolingo.com/";
	$req = "INSERT INTO NEWS (nomNews, contenuNews, imageNews, lienNews) VALUES ('".$nomNews."', '".$contenuNews."', '".$imageNews."', '".$lienNews."')";

	$result = $bd->set_requete($req);
	var_dump($result);
?>