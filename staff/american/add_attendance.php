<?php
// Include database connection
require_once 'db.php';

$error = '';
$success = '';
$programs = [];
$clients = [];
$trainers = [];
$selectedType = '';
$selectedProgramId = '';
$selectedEntityId = '';

// Fetch programs for dropdown
$programResult = $conn->query("SELECT id, name FROM programs");
if ($programResult->num_rows > 0) {
    while ($row = $programResult->fetch_assoc()) {
        $programs[] = $row;
    }
}

// Fetch clients for dropdown
$clientResult = $conn->query("SELECT id, name FROM clients");
if ($clientResult->num_rows > 0) {
    while ($row = $clientResult->fetch_assoc()) {
        $clients[] = $row;
    }
}

// Fetch trainers for dropdown
$trainerResult = $conn->query("SELECT id, name FROM trainers");
if ($trainerResult->num_rows > 0) {
    while ($row = $trainerResult->fetch_assoc()) {
        $trainers[] = $row;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $program_id = $_POST['program_id'] ?? '';
    $selectedType = $_POST['type'] ?? '';
    $entity_id = $_POST['entity_id'] ?? '';
    $continue = isset($_POST['continue']) ? true : false;

    $selectedProgramId = $program_id;
    $selectedEntityId = $entity_id;

    if (empty($program_id) || empty($selectedType) || empty($entity_id)) {
        $error = 'All fields are required.';
    } else {
        // Prepare SQL and bind parameters based on the selected type
        if ($selectedType == 'client') {
            $stmt = $conn->prepare("INSERT INTO program_attendance (program_id, client_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $program_id, $entity_id);
        } else {
            $stmt = $conn->prepare("INSERT INTO program_attendance (program_id, trainer_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $program_id, $entity_id);
        }

        if ($stmt->execute()) {
            $success = 'Attendance recorded successfully!';
            if (!$continue) {
                $selectedProgramId = ''; // Reset program selection if not continuing
                $selectedType = ''; // Reset type selection if not continuing
                $selectedEntityId = ''; // Reset entity selection if not continuing
            }
        } else {
            $error = 'Error recording attendance: ' . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Program Attendance</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Add any additional CSS -->
</head>
<body>
    <!-- Header Section -->
    <header style="background-color: #242f4b; text-align: center; color: white;">
        <h1>American Corner Management System</h1>
        <a href="view_attendance.php" class="btn btn-light mx-2 my-1">VIEW ATTENDANCE</a>
        <a href="dashboard.php" class="btn btn-light mx-2 my-1">HOME</a>
    </header>

    <section class="container mt-5">
        <h1>Record Program Attendance</h1>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form action="add_attendance.php" method="post">
            <div class="form-group">
                <label for="program_id">Program:</label>
                <select id="program_id" name="program_id" class="form-control" required>
                    <option value="">Select Program</option>
                    <?php foreach ($programs as $program): ?>
                        <option value="<?php echo $program['id']; ?>" <?php echo ($selectedProgramId == $program['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($program['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="type">Select Type:</label>
                <select id="type" name="type" class="form-control" required>
                    <option value="">Select Type</option>
                    <option value="client" <?php echo ($selectedType == 'client') ? 'selected' : ''; ?>>Client</option>
                    <option value="trainer" <?php echo ($selectedType == 'trainer') ? 'selected' : ''; ?>>Trainer</option>
                </select>
            </div>

            <div class="form-group" id="entityContainer">
                <label for="entity_id">Select:</label>
                <select id="entity_id" name="entity_id" class="form-control" required>
                    <option value="">Select</option>
                    <!-- Options will be populated dynamically based on type selection -->
                </select>
            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="continue" name="continue" value="1">
                <label class="form-check-label" for="continue">Continue recording attendance for the same program</label>
            </div>

            <button type="submit" class="btn btn-primary">Record Attendance</button>
        </form>
    </section>

    <!-- Footer Section -->
    <footer class="footer text-center py-3" style="background-color: #b52233; color: white;">
        <p>&copy; <?php echo date("Y"); ?> Developed by Pandomi Tech Innovations</p>
    </footer>

    <!-- Add Bootstrap JS (Optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function populateEntityOptions(type) {
            var entitySelect = document.getElementById('entity_id');
            var clientOptions = <?php echo json_encode($clients); ?>;
            var trainerOptions = <?php echo json_encode($trainers); ?>;

            entitySelect.innerHTML = '<option value="">Select</option>'; // Reset options

            if (type === 'client') {
                clientOptions.forEach(function(client) {
                    var option = document.createElement('option');
                    option.value = client.id;
                    option.textContent = client.name;
                    option.selected = client.id == "<?php echo $selectedEntityId; ?>";
                    entitySelect.appendChild(option);
                });
            } else if (type === 'trainer') {
                trainerOptions.forEach(function(trainer) {
                    var option = document.createElement('option');
                    option.value = trainer.id;
                    option.textContent = trainer.name;
                    option.selected = trainer.id == "<?php echo $selectedEntityId; ?>";
                    entitySelect.appendChild(option);
                });
            }
        }

        document.getElementById('type').addEventListener('change', function() {
            populateEntityOptions(this.value);
        });

        // Populate options on page load if a type is already selected
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('type').value) {
                populateEntityOptions(document.getElementById('type').value);
            }
        });
    </script>
</body>
</html>

