<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check-Out Equipment</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        .container {
            flex: 1;
            padding: 30px;
            background-color: #fff;
            margin: 20px auto;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            width: 80%;
            max-width: 800px;
        }

        .header {
            background-color: #242f4b; /* Single color for the entire header */
            text-align: center;
            color: white;
            padding: 15px 0;
        }
        .header h1 {
            margin: 0; /* Remove default margin */
            padding: 10px; /* Padding to match button and make it visually appealing */
            background-color: #242f4b; /* Same color as header */
            color: white; /* Text color for header */
            border-radius: 5px; /* Rounded corners */
        }
        .header .btn-light {
            background-color: #242f4b; /* Button background color matching header */
            color: white; /* Button text color */
        }
        .header .btn-light:hover {
            background-color: #1b1a6d; /* Button hover color */
            color: white;
        }
        .footer {
            text-align: center;
            padding: 20px 0;
            background-color: #b52233; /* Updated footer background color */
            color: white;
        }
        .footer a {
            color: white; /* Ensure icons and email link are visible on red background */
        }
        .fetch-button {
            background-color: #242f4b; /* Button background color matching header */
            color: white; /* Button text color */
        }
        .fetch-button:hover {
            background-color: #1b1a6d; /* Button hover color */
            color: white;
        }
    </style>
</head>
<body>
    <header class="header">
            <h1>American Corner Management System</h1>
            <a href="dashboard.php" class="btn btn-light">HOME</a>
    </header>

    <div class="container mt-5">
        <h1 class="mb-4">Check-Out Equipment</h1>

        <!-- Equipment Check-Out Form -->
        <form method="post" action="">
            <div class="form-group">
                <label for="client_id_fetch">Client ID:</label>
                <input type="text" id="client_id_fetch" name="client_id_fetch" class="form-control" value="<?php echo htmlspecialchars($selected_client_id); ?>" required>
            </div>
            <button type="submit" name="fetch_equipment" class="btn fetch-button mt-3">Fetch Equipment</button>
        </form>

        <?php if ($selected_client_id): ?>
            <h3 class="mt-5">Select equipment to check out:</h3>
            <form method="post" action="" id="check-out-form">
                <input type="hidden" name="client_id" value="<?php echo htmlspecialchars($selected_client_id); ?>">
                <?php
                if ($equipment_result->num_rows > 0) {
                    while ($row = $equipment_result->fetch_assoc()) {
                        echo '<div class="form-check">';
                        echo '<input type="checkbox" class="form-check-input" name="equipment[]" value="' . htmlspecialchars($row['type']) . '">';
                        echo '<label class="form-check-label">Type: ' . htmlspecialchars($row['type']) . ', Serial Number: ' . htmlspecialchars($row['serial_number']) . ', Model: ' . htmlspecialchars($row['model']) . '</label>';
                        echo '<input type="hidden" name="serial_number[]" value="' . htmlspecialchars($row['serial_number']) . '">';
                        echo '<input type="hidden" name="model[]" value="' . htmlspecialchars($row['model']) . '">';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No available equipment for this client.</p>";
                }
                ?>
                <button type="submit" name="check_out" class="btn btn-primary mt-3">Check Out</button>
            </form>
        <?php endif; ?>

        <?php if (isset($message)): ?>
            <div class='alert alert-success mt-3' role='alert'>
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
    </div>

    <footer class="footer">
        <p>&copy; <?php echo date("Y"); ?> <a href="https://wa.me/0758882563">Pandomi Tech Innovations</a></p>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

