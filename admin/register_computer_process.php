<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comp_name = $_POST['comp_name'];
    $serial_no = $_POST['serial_no'];

    // Check if the computer name already exists (but allow duplicate serial numbers)
    $check_sql = "SELECT * FROM computer WHERE comp_name = ?";
    $stmt = $conn->prepare($check_sql);
    if ($stmt === false) {
        echo "Error preparing statement: " . $conn->error;
        exit();
    }

    $stmt->bind_param("s", $comp_name);
    if ($stmt->execute() === false) {
        echo "Error executing statement: " . $stmt->error;
        exit();
    }

    $result = $stmt->get_result();
    if ($result === false) {
        echo "Error getting result: " . $stmt->error;
        exit();
    }

    if ($result->num_rows > 0) {
        echo "This computer name already exists. Please choose a different one.";
    } else {
        // SQL to insert computer name and serial number into the table
        $sql = "INSERT INTO computer (comp_name, serial_no) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            echo "Error preparing statement: " . $conn->error;
            exit();
        }

        $stmt->bind_param("ss", $comp_name, $serial_no);
        if ($stmt->execute() === TRUE) {
            echo "Computer registered successfully.";
        } else {
            echo "Error executing statement: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();

    // Redirect back to the form page after processing
    header("Location: admin.php");
    exit();
}
?>
