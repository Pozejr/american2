<?php
include 'db.php';

// Retrieve form data
$clientName = $_POST['client_name'] ?? '';
$computerName = $_POST['comp_name'] ?? '';

// Validate client name
if (empty($clientName)) {
    die("Client name is required.");
}

// Check if computer name is provided
if (!empty($computerName)) {
    // Check if the selected computer is available
    $sql = "SELECT COUNT(*) AS count FROM computer WHERE comp_name = ? AND comp_name NOT IN (SELECT comp_name FROM computer_check_in WHERE check_out_time IS NULL)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $computerName);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row['count'] == 0) {
        die("The selected computer is not available.");
    }

    // Insert check-in record for the computer
    $sql = "INSERT INTO computer_check_in (client_name, comp_name, check_in_time) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $clientName, $computerName);
} else {
    // Insert check-in record without computer
    $sql = "INSERT INTO computer_check_in (client_name, check_in_time) VALUES (?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $clientName);
}

// Execute the query
if ($stmt->execute()) {
    // Redirect to the dashboard page
    header("Location: dashboard.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
