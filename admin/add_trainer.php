<?php
// Include database connection
require_once 'db.php';

$error = '';
$success = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';

    if (empty($name)) {
        $error = 'Trainer name is required.';
    } else {
        // Prepare SQL and bind parameters
        $stmt = $conn->prepare("INSERT INTO trainers (name) VALUES (?)");
        $stmt->bind_param("s", $name);

        if ($stmt->execute()) {
            $success = 'Trainer added successfully!';
        } else {
            $error = 'Error adding trainer: ' . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Trainer</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Add any additional CSS -->
</head>
<body>
    <!-- Header Section -->
    <header style="background-color: #242f4b; text-align: center; color: white;">
        <h1>American Corner Management System</h1>
    </header>

    <section class="container mt-5">
        <h1>Add a New Trainer</h1>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form action="add_trainer.php" method="post">
            <div class="form-group">
                <label for="name">Trainer Name:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Trainer</button>
        </form>
    </section>

    <!-- Footer Section -->
    <footer style="
        background-color: #b52233; /* Background color of the footer */
        color: white; /* Text color */
        text-align: center; /* Center align the text */
        padding: 20px 0; /* Padding for top and bottom */
        position: fixed; /* Fix the footer to the bottom of the viewport */
        bottom: 0; /* Align at the bottom of the viewport */
        width: 100%; /* Full width of the viewport */
        left: 0; /* Align at the left of the viewport */
    ">
        <p>&copy; <span id="year"></span> Developed by Pandomi Tech Innovations</p>
    </footer>

    <!-- Add Bootstrap JS (Optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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

