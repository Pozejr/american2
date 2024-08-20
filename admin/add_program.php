<?php
// Include database connection
require_once 'db.php';

$error = '';
$success = '';

// Fetch trainers for dropdown
$trainers = [];
$trainerResult = $conn->query("SELECT id, name FROM trainers");
if ($trainerResult->num_rows > 0) {
    while ($row = $trainerResult->fetch_assoc()) {
        $trainers[] = $row;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $allocatedDay = $_POST['allocated_day'] ?? '';
    $trainerId = $_POST['trainer_id'] ?? '';

    if (empty($name)) {
        $error = 'Program name is required.';
    } else {
        // Prepare SQL and bind parameters
        $stmt = $conn->prepare("INSERT INTO programs (name, description, allocated_day, trainer_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $name, $description, $allocatedDay, $trainerId);

        if ($stmt->execute()) {
            $success = 'Program added successfully!';
        } else {
            $error = 'Error adding program: ' . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Program</title>
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
        <h1>Add a New Program</h1>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form action="add_program.php" method="post">
            <div class="form-group">
                <label for="name">Program Name:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="description">Program Description:</label>
                <textarea id="description" name="description" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="allocated_day">Allocated Day:</label>
                <input type="text" id="allocated_day" name="allocated_day" class="form-control" placeholder="Select day">
            </div>

            <div class="form-group">
                <label for="trainer_id">Select Trainer:</label>
                <select id="trainer_id" name="trainer_id" class="form-control">
                    <option value="">Select Trainer</option>
                    <?php foreach ($trainers as $trainer): ?>
                        <option value="<?php echo $trainer['id']; ?>">
                            <?php echo htmlspecialchars($trainer['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Add Program</button>
        </form>
    </section>

    <!-- Footer Section -->
    <footer class="footer text-center py-3" style="background-color: #b52233; color: white;">
        <p>&copy; <?php echo date("Y"); ?> KNLSATTACHEES</p>
    </footer>

    <!-- Add Bootstrap JS (Optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.en-GB.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#allocated_day').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true
            });
        });
    </script>
</body>
</html>
