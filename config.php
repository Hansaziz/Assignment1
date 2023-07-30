<?php
//Farhans aziz hermansya-2440044251
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'dbasg';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
