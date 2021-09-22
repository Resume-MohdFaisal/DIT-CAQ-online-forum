<?php
$servername = "localhost";
// Enter your MySQL username below(default=root)
$username = "root";
// Enter your MySQL password below
$password = "";
$dbname = "ditcaq";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  echo "data base not connected";
}
?>
