<?php
session_start();
include 'includes/db_connect.php';
include 'includes/functions.php';
redirectIfNotLoggedIn();
if (!isPatient()) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctor_id = $_POST['doctor_id'];
    $sickness_id = $_POST['sickness_id'];
    $appointment_time = $_POST['appointment_time'];

    // Validate appointment_time is future date/time
    if (strtotime($appointment_time) < time()) {
        $error = "Appointment time must be in the future.";
    } else {
        $stmt = $conn->prepare("INSERT INTO appointments (patient_id, doctor_id, sickness_id, appointment_time) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiis", $_SESSION['user_id'], $doctor_id, $sickness_id, $appointment_time);
        if ($stmt->execute()) {
            $success = "Appointment booked successfully!";
        } else {
            $error = "Error booking appointment: " . $conn->error;
        }
    }
}

// Fetch doctors and sickness types for dropdown
$doctors = $conn->query("SELECT id, name FROM users WHERE role='doctor'");
$sicknesses = $conn->query("SELECT id, name FROM sickness_types");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Book Appointment</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
  <h2>Book an Appointment</h2>
  <?php
    if (isset($error)) echo "<div class='alert alert-danger'>$error</div>";
    if (isset($success)) echo "<div class='alert alert-success'>$success</div>";
  ?>
  <form method="POST" action="">
    <div class="mb-3">
      <label>Doctor</label>
      <select name="doctor_id" class="form-select" required>
        <option value="">Select Doctor</option>
        <?php while ($doc = $doctors->fetch_assoc()) { ?>
          <option value="<?php echo $doc['id']; ?>"><?php echo htmlspecialchars($doc['name']); ?></option>
        <?php } ?>
      </select>
    </div>
    <div class="mb-3">
      <label>Type of Sickness</label>
      <select name="sickness_id" class="form-select" required>
        <option value="">Select Sickness</option>
        <?php while ($sick = $sicknesses->fetch_assoc()) { ?>
          <option value="<?php echo $sick['id']; ?>"><?php echo htmlspecialchars($sick['name']); ?></option>
        <?php } ?>
      </select>
    </div>
    <div class="mb-3">
      <label>Appointment Date & Time</label>
      <input type="datetime-local" name="appointment_time" class="form-control" required />
    </div>
    <button type="submit" class="btn btn-primary">Book</button>
    <a href="dashboard_patient.php" class="btn btn-secondary">Back to Dashboard</a>
  </form>
</div>
</body>
</html>
