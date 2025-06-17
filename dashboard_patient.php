<?php
session_start();
include 'includes/db_connect.php';
include 'includes/functions.php';
redirectIfNotLoggedIn();
if (!isPatient()) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Patient Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?> (Patient)</h2>
    <a href="book_appointment.php" class="btn btn-primary mb-3">Book Appointment</a>
    <a href="logout.php" class="btn btn-danger mb-3 float-end">Logout</a>

    <h3>Your Appointments</h3>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Doctor</th>
          <th>Sickness</th>
          <th>Time</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php
        $stmt = $conn->prepare("SELECT a.id, u.name AS doctor_name, s.name AS sickness_name, a.appointment_time, a.status 
                                FROM appointments a
                                JOIN users u ON a.doctor_id = u.id
                                JOIN sickness_types s ON a.sickness_id = s.id
                                WHERE a.patient_id = ? ORDER BY a.appointment_time DESC");
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            echo "<tr><td colspan='5'>No appointments yet.</td></tr>";
        } else {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['doctor_name']) . "</td>
                        <td>" . htmlspecialchars($row['sickness_name']) . "</td>
                        <td>" . htmlspecialchars($row['appointment_time']) . "</td>
                        <td>" . ucfirst($row['status']) . "</td>
                        <td>
                          <a href='edit_appointment.php?id=" . $row['id'] . "' class='btn btn-sm btn-warning'>Edit</a>
                          <a href='delete_appointment.php?id=" . $row['id'] . "' class='btn btn-sm btn-danger' onclick=\"return confirm('Are you sure you want to delete this appointment?');\">Delete</a>
                        </td>
                      </tr>";
            }
        }
      ?>
      </tbody>
    </table>
</div>
</body>
</html>
