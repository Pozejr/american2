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
    // Check if the selected computer is checked in
    $sql = "SELECT COUNT(*) AS count FROM computer_check_in WHERE client_name = ? AND comp_name = ? AND check_out_time IS NULL";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $clientName, $computerName);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] == 0) {
        die("The selected computer is not checked in by this client.");
    }

    // Update check-out time for the computer
    $sql = "UPDATE computer_check_in SET check_out_time = NOW() WHERE client_name = ? AND comp_name = ? AND check_out_time IS NULL";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $clientName, $computerName);
} else {
    // Handle case where no computer was selected
    // Update check-out time for client who was checked in without a computer
    $sql = "UPDATE computer_check_in SET check_out_time = NOW() WHERE client_name = ? AND comp_name IS NULL AND check_out_time IS NULL";
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
