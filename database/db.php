<?php 
$host = "localhost";
$username = "root";
$password = "";
$dbname = "gorder";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>