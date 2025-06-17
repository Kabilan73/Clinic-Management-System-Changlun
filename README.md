
# Clinic Appointment Management System (Changlun Branch)

This is a simple web-based system developed using PHP and MySQL to manage patient appointments with doctors at a clinic. It provides separate dashboards for patients and doctors, allowing patients to book, edit, and delete appointments, and doctors to view and manage their assigned appointments.

---

## ✨ Features

- **User Authentication**: Secure login and registration for both patients and doctors.
- **Role-Based Access**: Separate dashboards and functionalities based on user roles (Patient, Doctor).

### Patient Dashboard
- View all their booked appointments.
- Book new appointments with available doctors and sickness types.
- Edit existing pending appointments.
- Delete appointments.

### Doctor Dashboard
- View all appointments assigned to them.
- Accept or reject pending appointments.

- **Responsive Design**: Utilizes Bootstrap 5 for a mobile-friendly interface.
- **Basic Redundancy (Experimental)**: Includes a `ping.php` and JavaScript logic for a simple primary/backup server redirect (as seen in `index.php`).

---

## 🛠 Technologies Used

- **Backend**: PHP
- **Database**: MySQL
- **Frontend**: HTML5, CSS3 (Custom styles and Bootstrap 5)
- **Client-side Scripting**: JavaScript (for experimental redirect)

---

## 📁 Project Structure

```
.
├── assets/
│   └── images/
│       ├── clinic-bg.jpg
│       └── image1.jpg
├── includes/
│   ├── db_connect.php
│   └── functions.php
├── index.php
├── login.php
├── register.php
├── dashboard_patient.php
├── dashboard_doctor.php
├── book_appointment.php
├── edit_appointment.php
├── delete_appointment.php
├── logout.php
└── ping.php
```

---

## ⚙️ Setup Instructions

### ✅ Prerequisites

- A web server (e.g., Apache, Nginx) with PHP installed (PHP 7.4+ recommended)
- MySQL database server
- Composer (optional)

### 📌 Step 1: Database Configuration

Create a database for the project (e.g., `clinic_db`) and use the following **example SQL** (replace with actual structure as needed):

```sql
CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('patient', 'doctor') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE sickness_types (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE appointments (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    patient_id INT(11) NOT NULL,
    doctor_id INT(11) NOT NULL,
    sickness_id INT(11) NOT NULL,
    appointment_time DATETIME NOT NULL,
    status ENUM('pending', 'accepted', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (sickness_id) REFERENCES sickness_types(id) ON DELETE CASCADE
);

INSERT INTO sickness_types (name) VALUES ('Fever'), ('Cold');
```

### 📌 Step 2: Configure Database Connection

Edit `includes/db_connect.php`:

```php
<?php
$servername = "localhost";
$username = "your_db_username";
$password = "your_db_password";
$dbname = "clinic_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
```

### 📌 Step 3: Add Helper Functions

In `includes/functions.php`:

```php
<?php
function redirectIfNotLoggedIn() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}

function isPatient() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'patient';
}

function isDoctor() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'doctor';
}
?>
```

### 📌 Step 4: Place Project Files

Place all files into your web server’s root directory (e.g., `htdocs` or `www`).

### 📌 Step 5: Access the Application

Open browser:

```
http://localhost/
```

Or if using the experimental redundancy logic:

```
http://172.20.10.4:8000/
```

---

## 🧭 Usage

- **Register**: Users register as a Patient or Doctor via `register.php`.
- **Login**: Existing users log in via `login.php`.

### Role-based Dashboards

- **Patients**: Redirected to `dashboard_patient.php` to manage appointments.
- **Doctors**: Redirected to `dashboard_doctor.php` to manage incoming appointments.

- **Logout**: Available on each dashboard.

---

## 👤 Author

Developed by Mr. Aliff Ramadhan (Changlun Branch Project)
