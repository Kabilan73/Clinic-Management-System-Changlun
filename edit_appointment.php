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

// Fetch existing appointment
$stmt = $conn->prepare("SELECT * FROM appointments WHERE id = ? AND patient_id = ?");
$stmt->bind_param("ii", $appointment_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows !== 1) {
    echo "Appointment not found.";
    exit();
}
$appointment = $result->fetch_assoc();

// Update action
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doctor_id = $_POST['doctor_id'];
    $sickness_id = $_POST['sickness_id'];
    $appointment_time = $_POST['appointment_time'];

    $update = $conn->prepare("UPDATE appointments SET doctor_id = ?, sickness_id = ?, appointment_time = ?, status = 'pending' WHERE id = ? AND patient_id = ?");
    $update->bind_param("iisii", $doctor_id, $sickness_id, $appointment_time, $appointment_id, $_SESSION['user_id']);
    
    if ($update->execute()) {
        header("Location: dashboard_patient.php?updated=1");
        exit();
    } else {
        echo "Failed to update appointment.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Edit Appointment</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>Edit Appointment</h2>
  <form method="POST">
    <div class="mb-3">
      <label for="doctor_id" class="form-label">Doctor</label>
      <select name="doctor_id" id="doctor_id" class="form-select" required>
        <?php
        $doctors = $conn->query("SELECT * FROM users WHERE role = 'doctor'");
        while ($doc = $doctors->fetch_assoc()) {
            $selected = $doc['id'] == $appointment['doctor_id'] ? 'selected' : '';
            echo "<option value='{$doc['id']}' $selected>" . htmlspecialchars($doc['name']) . "</option>";
        }
        ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="sickness_id" class="form-label">Sickness</label>
      <select name="sickness_id" id="sickness_id" class="form-select" required>
        <?php
        $sicknesses = $conn->query("SELECT * FROM sickness_types");
        while ($s = $sicknesses->fetch_assoc()) {
            $selected = $s['id'] == $appointment['sickness_id'] ? 'selected' : '';
            echo "<option value='{$s['id']}' $selected>" . htmlspecialchars($s['name']) . "</option>";
        }
        ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="appointment_time" class="form-label">Appointment Time</label>
      <input type="datetime-local" name="appointment_time" id="appointment_time" class="form-control"
             value="<?php echo date('Y-m-d\TH:i', strtotime($appointment['appointment_time'])); ?>" required>
    </div>

    <button type="submit" class="btn btn-success">Update Appointment</button>
    <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>
</body>
</html>
