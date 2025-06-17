<?php
session_start();
include 'includes/db_connect.php';
include 'includes/functions.php';
redirectIfNotLoggedIn();
if (!isDoctor()) {
    header("Location: login.php");
    exit();
}

// Handle appointment status update (accept/reject)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appt_id = $_POST['appointment_id'];
    $new_status = $_POST['status'];
    if (in_array($new_status, ['accepted', 'rejected'])) {
        $stmt = $conn->prepare("UPDATE appointments SET status=? WHERE id=? AND doctor_id=?");
        $stmt->bind_param("sii", $new_status, $appt_id, $_SESSION['user_id']);
        $stmt->execute();
    }
}

// Fetch appointments assigned to this doctor
$stmt = $conn->prepare("SELECT a.id, u.name AS patient_name, s.name AS sickness_name, a.appointment_time, a.status 
                        FROM appointments a
                        JOIN users u ON a.patient_id = u.id
                        JOIN sickness_types s ON a.sickness_id = s.id
                        WHERE a.doctor_id = ? ORDER BY a.appointment_time DESC");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$appointments = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Doctor Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
  <h2>Welcome, Dr. <?php echo htmlspecialchars($_SESSION['name']); ?></h2>
  <a href="logout.php" class="btn btn-danger float-end mb-3">Logout</a>

  <h3>Appointments</h3>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Patient</th>
        <th>Sickness</th>
        <th>Appointment Time</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($appointments->num_rows == 0): ?>
        <tr><td colspan="5">No appointments yet.</td></tr>
      <?php else: ?>
        <?php while ($row = $appointments->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
            <td><?php echo htmlspecialchars($row['sickness_name']); ?></td>
            <td><?php echo htmlspecialchars($row['appointment_time']); ?></td>
            <td><?php echo ucfirst($row['status']); ?></td>
            <td>
              <?php if ($row['status'] === 'pending'): ?>
                <form method="POST" style="display:inline;">
                  <input type="hidden" name="appointment_id" value="<?php echo $row['id']; ?>">
                  <button type="submit" name="status" value="accepted" class="btn btn-success btn-sm">Accept</button>
                  <button type="submit" name="status" value="rejected" class="btn btn-danger btn-sm">Reject</button>
                </form>
              <?php else: ?>
                <span>-</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>
</body>
</html>
