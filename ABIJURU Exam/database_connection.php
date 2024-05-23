<?php
// Connection details
$host = "localhost";
$user = "Louange";
$pass = "Abijuru";
$database = "art_marketplace";

// Creating connection
$connection = new mysqli($host, $user, $pass, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>