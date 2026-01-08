<?php
$host = 'localhost';
$user = 'minimal_user';
$pass = 'alma';
$dbname = 'minimal';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>