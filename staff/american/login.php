<?php
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

            // Insert or update session information in user_sessions table
            $sql_session = "INSERT INTO user_sessions (username, last_activity) VALUES (?, NOW()) 
                            ON DUPLICATE KEY UPDATE last_activity = NOW(), logout_time = NULL";
            $stmt_session = $conn->prepare($sql_session);
            $stmt_session->bind_param("s", $username);
            $stmt_session->execute();
            $stmt_session->close();

            // Redirect user based on role
            if ($_SESSION['role'] == 'admin') {
                header('Location: admin.php');
            } else {
                header('Location: dashboard.php');
            }
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



<link rel="stylesheet" type="text/css" href="styles.css">
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .log {
            background-image: url(images/download.png);
            height: 750px;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            opacity: .6;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            
        }
        form
        {
            background-color: grey;
        }
        .admin-login {
            margin-top: 20px;
            text-align: center;
        }
        .admin-login a {
            color: #007bff;
            text-decoration: none;
        }
        .admin-login a:hover {
            text-decoration: underline;
        }
        footer {
            background-color: #F48312;
            height: 110px;
            text-align: center;
            color: white;
            
        }
        .form-group
        {
            color: black;
        }
    </style>
</head>
<body>
<header style="background-color: #242f4b; text-align: center; color: white;">
        <h1>American Corner Management System</h1>
    </header>
    <section class="log">
        <div class="form-container">
            <h2>User Login</h2>
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
        <div class="form-container admin-login">
            <a href="admin_Login.php">Admin Login</a>
        </div>
        <div class="reset-password-link">
            <a href="request_reset.php">Forgot your password?</a>
        </div>
        <div>
            <a href="/index.php" class="btn btn-secondary mt-3">Go to Main Page</a>
        </div>
    </section>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> KNLSATTACHEES</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
