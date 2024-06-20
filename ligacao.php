<?php
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "portal_do_animal_pt";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>