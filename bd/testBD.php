<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "laParade_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SHOW TABLES FROM $dbname";
$result = mysql_query($sql);

if (!$result) {
   echo "Erreur DB, impossible de lister les tables\n";
   echo 'Erreur MySQL : ' . mysql_error();
   exit;
}

while ($row = mysql_fetch_row($result)) {
   echo "Table : {$row[0]}\n";
}

mysql_free_result($result);
?>

$conn->close();
?>