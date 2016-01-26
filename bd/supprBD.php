<?php
$link = mysql_connect('localhost', 'root', '');
if (!$link) {
die('Impossible de se connecter : ' . mysql_error());
}

$sql = 'DROP DATABASE laParade_db';
if (mysql_query($sql, $link)) {
echo "La base de données my_db a été effacée avec succès.\n";
} else {
echo 'Erreur lors de l\'effacement de la base : ' . mysql_error() . "\n";
}
?>