<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipment Check-In</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            padding-bottom: 60px; /* Ensure footer is not overlapped by content */
        }
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .btn-submit {
            background-color: #242f4b;
            color: white;
        }
        .footer {
            text-align: center;
            padding: 20px 0;
            background-color: #b52233;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .footer a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Equipment Check-In</h2>
        <form action="checkin_equipment.php" method="POST">
            <div class="form-group">
                <label for="serial_number">Serial Number:</label>
                <input type="text" id="serial_number" name="serial_number" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-submit">Check In</button>
        </form>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $file = 'equipment_data.json';
        $serial_number = htmlspecialchars($_POST['serial_number']);

        if (file_exists($file)) {
            $data = json_decode(file_get_contents($file), true);

            $updated = false;
            foreach ($data as &$entry) {
                if ($entry['serial_number'] == $serial_number && $entry['status'] == 'checked_out') {
                    $entry['status'] = 'checked_in';
                    $updated = true;
                    break;
                }
            }

            if ($updated) {
                file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
                echo "<p class='text-success'>Equipment checked in successfully.</p>";
            } else {
                echo "<p class='text-danger'>Equipment not found or already checked in.</p>";
            }
        } else {
            echo "<p class='text-danger'>No data file found.</p>";
        }
    }
    ?>

    <footer class="footer">
        <p>&copy; <?php echo date("Y"); ?> <a href="https://wa.me/0758882563">Pandomi Tech Innovations</a></p>
    </footer>
</body>
</html>

