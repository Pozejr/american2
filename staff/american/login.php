<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate inputs to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $username);

    // Query to fetch user details based on username
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Verify hashed password
        if (password_verify($password, $row['password'])) {
            // Store data in session variables
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $row['role'];
            $_SESSION['profile_pic'] = $row['profile_pic'];

            // Generate session_id
            $session_id = session_id();

            // Insert or update session information in user_sessions table
            $sql_session = "INSERT INTO user_sessions (session_id, username, last_activity) VALUES (?, ?, NOW()) 
                            ON DUPLICATE KEY UPDATE last_activity = NOW(), logout_time = NULL";
            $stmt_session = $conn->prepare($sql_session);
            $stmt_session->bind_param("ss", $session_id, $username);
            $stmt_session->execute();
            $stmt_session->close();

            // Redirect user to dashboard
            header('Location: dashboard.php');
            exit;
        } else {
            echo "Password incorrect.";
        }
    } else {
        echo "Username not found.";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0; /* Fallback background color */
        }
        header {
            background-color: #242f4b; /* Adjust header background if needed */
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Optional shadow for better visibility */
        }
        .logo {
            background-image: url(images/images.jpeg);
            background-size: cover;
            background-position: center;
            height: 100px; /* Set height */
            width: 100px; /* Set width */
            border-radius: 50%; /* Make the image round */
            background-repeat: no-repeat;
            margin-right: 20px; /* Space between logo and text */
        }
        .header-text {
            color: white;
            font-size: 2rem; /* Responsive font size */
            text-align: center;
        }
        .log {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 200px); /* Full viewport height minus header height */
            padding: 20px;
        }
        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px; /* Adjust as needed */
            text-align: center;
            margin-bottom: 20px; /* Space between form containers */
        }
        .admin-login a, .reset-password-link a {
            color: #007bff;
            text-decoration: none;
        }
        .admin-login a:hover, .reset-password-link a:hover {
            text-decoration: underline;
        }
        footer {
            background-color: #b52233;
            color: white;
            padding: 10px;
            text-align: center;
            width: 100%;
        }
        .staff-login-title {
            font-family: 'Algerian', serif, Arial, sans-serif; /* Fallback fonts */
            font-weight: bold; /* Make the text bold */
            font-size: 2rem; /* Adjust font size as needed */
        }
        .flag-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 20px;
        }
        .flag {
            width: 60px;
            height: 40px;
            background-size: cover;
            background-repeat: no-repeat;
            margin-right: 10px;
        }
        .kenya-flag {
            background-image: url('images/Flag_of_Kenya.gif');
        }
        .usa-flag {
            background-image: url('images/USA2.gif');
        }
    </style>
</head>
<body>
<header class="d-flex align-items-center justify-content-center">
    <a href="/index.php" class="d-flex align-items-center">
        <div class="logo"></div>
    </a>
    <div class="header-text">American Corner Management System</div>
    <div class="flag-container">
        <div class="flag kenya-flag"></div>
        <div class="flag usa-flag"></div>
    </div>
</header>
<main class="container my-5">
    <section class="log">
        <div class="form-container">
            <h2 class="staff-login-title">Staff Login</h2>
            <form method="post" action="">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
            </form>
        </div>
    </section>
</main>
<div class="footer">
    <p>&copy; <span id="year"></span> Developed by Pandomi Tech Innovations</p>
</div>

<script>
    // Get the current year
    var currentYear = new Date().getFullYear();
    // Set the year in the HTML
    document.getElementById('year').textContent = currentYear;
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


