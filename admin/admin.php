<?php
session_start();
include 'db.php';

// Check if the user is logged in and has admin privileges
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'admin') {
    header('Location: admin_login.php');
    exit;
}

// Process user deletion request
if (isset($_POST['delete_user'])) {
    $user_id = intval($_POST['user_id']);
    // Delete the user from the database
    $sql_delete_user = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql_delete_user);
    $stmt->bind_param('i', $user_id);
    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully.'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('Error deleting user.'); window.location.href='admin.php';</script>";
    }
    $stmt->close();
}

// Process user addition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];
    
    // Validate passwords
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.'); window.location.href='admin.php';</script>";
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Handle profile picture upload
    $profile_pic = null;
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $profile_pic = $upload_dir . basename($_FILES['profile_pic']['name']);
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], $profile_pic);
    }

    // Insert new user into the database
    $sql_add_user = "INSERT INTO users (username, email, password, role, profile_pic) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_add_user);
    $stmt->bind_param('sssss', $username, $email, $hashed_password, $role, $profile_pic);
    if ($stmt->execute()) {
        echo "<script>alert('User added successfully.'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('Error adding user.'); window.location.href='admin.php';</script>";
    }
    $stmt->close();
}

// Fetch logged-in users with additional details including login and logout times
$sql_sessions = "SELECT us.id, us.username, us.login_time, us.logout_time, u.email, u.role 
                  FROM user_sessions us
                  JOIN users u ON us.username = u.username
                  ORDER BY us.login_time DESC";
$result_sessions = $conn->query($sql_sessions);

// Fetch all users
$sql_users = "SELECT id, username, role FROM users";
$result_users = $conn->query($sql_users);

// Fetch all clients
$sql_clients = "SELECT id, name, phone_no, id_no FROM clients";
$result_clients = $conn->query($sql_clients);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        header {
            background-color: #242f4b;
            color: white;
            padding: 20px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }
        header .logo {
            background-image: url('images/images.jpeg'); /* Adjust the path to your logo image */
            background-size: cover;
            background-position: center;
            height: 100px; /* Adjust as needed */
            width: 100px; /* Adjust as needed */
            border-radius: 50%;
            display: inline-block;
        }
        header .header-text {
            text-align: center;
            flex: 1;
        }
        .table-container {
            overflow-x: auto;
            max-height: 300px; /* Adjusted to fit more data */
        }
        .action-links, .logout-link {
            text-align: center;
            margin-top: 20px;
        }
        footer {
            background-color: #b52233;
            height: 130px;
            text-align: center;
            color: white;
            padding: 20px 0;
        }
        .form-container, .form-container1 {
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: white;
        }
        section {
            background-color: white;
        }
    </style>
    <script>
        function togglePasswordVisibility() {
            var password = document.getElementById("password");
            var confirmPassword = document.getElementById("confirm_password");
            if (password.type === "password") {
                password.type = "text";
                confirmPassword.type = "text";
            } else {
                password.type = "password";
                confirmPassword.type = "password";
            }
        }
        // Get the current year for the footer
        function updateYear() {
            var currentYear = new Date().getFullYear();
            document.getElementById('year').textContent = currentYear;
        }
        window.onload = updateYear;
    </script>
</head>
<body>
    <header>
        <a href="/index.php">
            <div class="logo"></div>
        </a>
        <div class="header-text">
            <h1>American Corner Management System</h1>
            <h2>Admin Panel</h2>
        </div>
        <div class="action-links">
            <a href="register_computer.php" class="btn btn-primary">Assets</a>
            <a href="add_program.php" class="btn btn-primary">Program</a>
            <a href="add_trainer.php" class="btn btn-primary">Trainer</a>
            <a href="view_attendance.php" class="btn btn-primary">View Attendance</a>
            <a href="fetch_data.php" class="btn btn-primary">Records</a>
            <a href="download_checkins_pdf.php" class="btn btn-secondary">Download Check-ins PDF</a>
        </div>
    </header>
    <section class="bg-white">
        <div class="container mt-5">
            <div class="row">
                <!-- Filter Form -->
                <div class="col-md-12 mb-4">
                    <div class="form-container">
                        <h2>Filter Check-ins Report</h2>
                        <form method="post" action="download_checkins_pdf.php">
                            <div class="form-group">
                                <label for="filter">Select Date Range:</label>
                                <select class="form-control" id="filter" name="filter">
                                    <option value="day">Today</option>
                                    <option value="week">This Week</option>
                                    <option value="month">This Month</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Download Report</button>
                        </form>
                    </div>
                </div>

                <!-- View Logged-in Users -->
                <div class="col-md-12 mb-4">
                    <h2>Currently Logged-in Users</h2>
                    <div class="table-container">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Login Time</th>
                                    <th>Logout Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result_sessions->num_rows > 0) {
                                    while ($row = $result_sessions->fetch_assoc()) {
                                        $login_time = date('Y-m-d H:i:s', strtotime($row['login_time']));
                                        $logout_time = $row['logout_time'] ? date('Y-m-d H:i:s', strtotime($row['logout_time'])) : 'N/A';
                                        echo "<tr>
                                                <td>{$row['id']}</td>
                                                <td>{$row['username']}</td>
                                                <td>{$row['email']}</td>
                                                <td>{$row['role']}</td>
                                                <td>{$login_time}</td>
                                                <td>{$logout_time}</td>
                                            </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>No logged-in users found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Manage Users -->
                <div class="col-md-6">
                    <h2>Manage Users</h2>
                    <div class="table-container mb-4">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result_users->num_rows > 0) {
                                    while ($row = $result_users->fetch_assoc()) {
                                        echo "<tr>
                                                <td>{$row['id']}</td>
                                                <td>{$row['username']}</td>
                                                <td>{$row['role']}</td>
                                                <td>
                                                    <form method='post' action=''>
                                                        <input type='hidden' name='user_id' value='{$row['id']}'>
                                                        <button type='submit' name='delete_user' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</button>
                                                    </form>
                                                </td>
                                            </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4'>No users found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-container1">
                        <h2>Add New User</h2>
                        <form method="post" action="" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password:</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="show_password" onclick="togglePasswordVisibility()">
                                <label class="form-check-label" for="show_password">Show Password</label>
                            </div>
                            <div class="form-group">
                                <label for="profile_pic">Profile Picture:</label>
                                <input type="file" class="form-control-file" id="profile_pic" name="profile_pic">
                            </div>
                            <div class="form-group">
                                <label for="role">Role:</label>
                                <select class="form-control" id="role" name="role">
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Add User</button>
                        </form>
                    </div>
                </div>

                <!-- Manage Clients -->
                <div class="col-md-6">
                    <h2>Manage Clients</h2>
                    <div class="table-container mb-4">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Phone No</th>
                                    <th>ID No</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result_clients->num_rows > 0) {
                                    while ($row = $result_clients->fetch_assoc()) {
                                        echo "<tr>
                                                <td>{$row['id']}</td>
                                                <td>{$row['name']}</td>
                                                <td>{$row['phone_no']}</td>
                                                <td>{$row['id_no']}</td>
                                                <td>
                                                    <form method='post' action=''>
                                                        <input type='hidden' name='client_id' value='{$row['id']}'>
                                                        <button type='submit' name='delete_client' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this client?\")'>Delete</button>
                                                    </form>
                                                </td>
                                            </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>No clients found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-container1">
                        <h2>Add New Client</h2>
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="client_name">Name:</label>
                                <input type="text" class="form-control" id="client_name" name="client_name" required>
                            </div>
                            <div class="form-group">
                                <label for="phone_no">Phone No:</label>
                                <input type="text" class="form-control" id="phone_no" name="phone_no" required>
                            </div>
                            <div class="form-group">
                                <label for="id_no">ID No:</label>
                                <input type="text" class="form-control" id="id_no" name="id_no" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Client</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <p>&copy; <span id="year"></span> Developed by Pandomi Tech Innovations</p>
    </footer>
    <script>
        // Get the current year for the footer
        function updateYear() {
            var currentYear = new Date().getFullYear();
            document.getElementById('year').textContent = currentYear;
        }
        window.onload = updateYear;
    </script>
</body>
</html>

