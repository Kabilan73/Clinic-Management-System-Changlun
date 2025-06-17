<?php
session_start();
include 'includes/db_connect.php';
include 'includes/functions.php';
redirectIfNotLoggedIn();
if (!isPatient()) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "Invalid appointment ID.";
    exit();
}

$appointment_id = $_GET['id'];

// Double-check appointment belongs to this user
$stmt = $conn->prepare("DELETE FROM appointments WHERE id = ? AND patient_id = ?");
$stmt->bind_param("ii", $appointment_id, $_SESSION['user_id']);

if ($stmt->execute()) {
    header("Location: dashboard_patient.php?deleted=1");
    exit();
} else {
    echo "Failed to delete appointment.";
}
