<?php
// index.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Clinic Management System - Changlun</title>
  <!-- ✅ Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(rgba(255,255,255,0.95), rgba(255,255,255,0.95)), url('assets/images/clinic-bg.jpg') no-repeat center center fixed;
      background-size: cover;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', sans-serif;
    }

    .welcome-card {
      background-color: white;
      border-radius: 20px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.2);
      padding: 40px;
      text-align: center;
      max-width: 700px;
    }

    .welcome-card h1 {
      font-size: 2.8rem;
      color: #007bff;
      font-weight: bold;
    }

    .welcome-card small {
      font-size: 1.2rem;
      color: #555;
    }

    .welcome-card img {
      max-width: 50%;
      height: auto;
      border-radius: 15px;
      margin-top: 20px;
      margin-bottom: 20px;
    }

    .btn-book {
      background-color: #28a745;
      color: white;
      font-size: 1.1rem;
      padding: 10px 30px;
      border-radius: 50px;
      transition: all 0.3s ease-in-out;
      text-decoration: none;
    }

    .btn-book:hover {
      background-color: #218838;
      transform: scale(1.05);
    }
  </style>

  <!-- ✅ Auto Redirect JS -->
  <script>
    const currentHost = window.location.hostname;
    const currentPort = window.location.port;
    const primary = "172.20.10.4";
    const backup = "172.20.10.6";
    const port = currentPort || "8000";

    if (currentHost !== primary) {
      // We are not on the primary server — no need to redirect
    } else {
      // Ping self to see if still alive
      fetch(`http://${primary}:${port}/ping.php`, { mode: "no-cors" })
        .catch(() => {
          // If unreachable, redirect to backup server
          window.location.href = `http://${backup}:${port}/`;
        });
    }
  </script>
</head>

<body>

  <div class="welcome-card">
    <h1>Welcome to <br>Clinic Management System</h1>
    <small class="d-block mb-3">Changlun Branch</small>
    <img src="image1.jpg" alt="Clinic Entrance">
    <p class="lead">Need to see a doctor? Book your appointment now!</p>
    <a href="register.php" class="btn btn-book mt-3">Book an Appointment</a>
  </div>

</body>
</html>
