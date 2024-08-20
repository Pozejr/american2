<?php
session_start();
include 'db.php'; // Ensure this includes your database connection script

// Check if the user is logged in and is authorized
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'user') {
    // Redirect to login if not logged in or not authorized
    header('Location: login.php');
    exit;
}

if (isset($_POST['register_client'])) {
    // Escape variables for security
    $client_name = $conn->real_escape_string($_POST['client_name']);
    $phone_no = $conn->real_escape_string($_POST['phone_no']);
    $id_no = $conn->real_escape_string($_POST['id_no']);
    $user_id = isset($_SESSION['id']) ? $conn->real_escape_string($_SESSION['id']) : null;

    // Insert client into database
    $sql = "INSERT INTO clients (name, phone_no, id_no, id) VALUES ('$client_name', '$phone_no', '$id_no', '$user_id')";
    if ($conn->query($sql) === TRUE) {
        echo "Client registered successfully";
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_POST['search_client'])) {
    $search_name = $conn->real_escape_string($_POST['search_name']);
    $sql = "SELECT * FROM clients WHERE name LIKE '%$search_name%'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $client = $result->fetch_assoc();
    } else {
        $client = null; // No client found
    }
}

if (isset($_POST['update_client'])) {
    $client_id = $conn->real_escape_string($_POST['client_id']);
    $client_name = $conn->real_escape_string($_POST['client_name']);
    $phone_no = $conn->real_escape_string($_POST['phone_no']);
    $id_no = $conn->real_escape_string($_POST['id_no']);

    // Update client details
    $sql = "UPDATE clients SET name='$client_name', phone_no='$phone_no', id_no='$id_no' WHERE id='$client_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Client updated successfully";
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 20px;
        }
        .form-container {
            background-color: #ebebeb;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        header {
            background-color: #2D2C8E;
            padding: 20px;
            text-align: center;
            color: white;
        }
        footer {
            background-color: #F48312;
            height: 100px;
            text-align: center;
            color: white;
            padding: 20px 0;
        }
        .row {
            display: flex;
            justify-content: space-around;
        }
        .col-md-6 {
            flex: 1;
            margin: 0 10px;
        }
        .form-group {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <header>
        <h1>American Corner Management System</h1>
    </header>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="form-container">
                    <h2 class="text-center">Register Client</h2>
                    <form method="post" action="">
                        <div class="form-group">
                            <label for="client_name">Client Name:</label>
                            <input type="text" class="form-control" id="client_name" name="client_name" required>
                        </div>
                        <div class="form-group">
                            <label for="phone_no">Phone Number:</label>
                            <input type="text" class="form-control" id="phone_no" name="phone_no" required>
                        </div>
                        <div class="form-group">
                            <label for="id_no">ID Number:</label>
                            <input type="text" class="form-control" id="id_no" name="id_no" required>
                        </div>
                        <button type="submit" name="register_client" class="btn btn-primary btn-block">Register Client</button>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-container">
                    <h2 class="text-center">Search and Update Client</h2>
                    <form method="post" action="">
                        <div class="form-group">
                            <label for="search_name">Search by Client Name:</label>
                            <input type="text" class="form-control" id="search_name" name="search_name" required>
                        </div>
                        <button type="submit" name="search_client" class="btn btn-primary btn-block">Search Client</button>
                    </form>
                    <?php if (isset($client) && $client): ?>
                        <form method="post" action="">
                            <input type="hidden" name="client_id" value="<?php echo htmlspecialchars($client['id']); ?>">
                            <div class="form-group">
                                <label for="client_name">Client Name:</label>
                                <input type="text" class="form-control" id="client_name" name="client_name" value="<?php echo htmlspecialchars($client['name']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="phone_no">Phone Number:</label>
                                <input type="text" class="form-control" id="phone_no" name="phone_no" value="<?php echo htmlspecialchars($client['phone_no']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="id_no">ID Number:</label>
                                <input type="text" class="form-control" id="id_no" name="id_no" value="<?php echo htmlspecialchars($client['id_no']); ?>" required>
                            </div>
                            <button type="submit" name="update_client" class="btn btn-success btn-block">Update Client</button>
                        </form>
                    <?php elseif (isset($client) && !$client): ?>
                        <p class="text-danger">No client found with that name.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> KNLSATTACHEES</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
