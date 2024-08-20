<?php
session_start();
include 'db.php'; // Include your database connection file

if (isset($_SESSION['loggedin']) && isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $logout_time = date('Y-m-d H:i:s'); // Current date and time

    // Update the user's session record with the logout time
    $sql_update = "UPDATE user_sessions SET logout_time = ? WHERE username = ? AND logout_time IS NULL";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param('ss', $logout_time, $username);
    
    if ($stmt->execute()) {
        // Destroy the session
        session_unset();
        session_destroy();
        header('Location: login.php');
        exit;
    } else {
        // Handle errors if the update fails
        echo "Error updating session record: " . $stmt->error;
    }
    
    $stmt->close();
} else {
    // If session data is not set, redirect to login page
    header('Location: login.php');
    exit;
}

// Close the database connection
$conn->close();
?>
