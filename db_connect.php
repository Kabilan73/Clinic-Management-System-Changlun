<?php
$host = '172.20.10.3';
$user = 'clinicuser';
$pass = 'clinic123';
$db   = 'clinic_db';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
