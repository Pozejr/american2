<?php
session_start();
include 'db.php';
require_once('tcpdf/tcpdf.php'); // Ensure the path to TCPDF is correct

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

// Check if the user is an admin
$is_admin = ($_SESSION['role'] === 'admin');

// Initialize search query variable
$search_query = "";

// Check if the search form has been submitted
if (isset($_POST['search'])) {
    $search_query = $_POST['search_query'];
    $sql = "SELECT id, name FROM clients WHERE name LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_param = "%" . $search_query . "%";
    $stmt->bind_param("s", $search_param);
} else {
    // If no search query, fetch all clients
    $sql = "SELECT id, name FROM clients";
    $stmt = $conn->prepare($sql);
}

// Execute the statement
$stmt->execute();
$result = $stmt->get_result();

// Check if check-in form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['check_in_name'])) {
    $client_name = $_POST['check_in_name'];

    // Insert the check-in time into the check_ins table
    $sql = "INSERT INTO check_ins (name, check_in_time) VALUES (?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $client_name);

    if ($stmt->execute() === TRUE) {
        echo "<p>Check-in successful for $client_name.</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

// Check if check-out form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['check_out_name'])) {
    $client_name = $_POST['check_out_name'];

    // Update the check-out time in the check_ins table
    $sql = "UPDATE check_ins SET check_out_time = NOW() WHERE name = ? AND check_in_time IS NOT NULL AND check_out_time IS NULL";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $client_name);

    if ($stmt->execute() === TRUE) {
        echo "<p>Check-out successful for $client_name.</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

// Handle PDF download, restricted to admins only
if ($is_admin && isset($_POST['download_pdf'])) {
    // Create new PDF document
    $pdf = new TCPDF();
    $pdf->AddPage();

    // Set title and other properties
    $pdf->SetTitle('Check-Ins List');
    $pdf->SetFont('helvetica', '', 12);

    // Add table header
    $html = '<h2>Check-Ins List</h2>';
    $html .= '<table border="1" cellpadding="5">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Check In Time</th>
                        <th>Check Out Time</th>
                    </tr>
                </thead>
                <tbody>';

    // Fetch and add rows from check_ins table
    $sql = "SELECT name, check_in_time, check_out_time FROM check_ins";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>
                    <td>' . htmlspecialchars($row['name']) . '</td>
                    <td>' . htmlspecialchars($row['check_in_time']) . '</td>
                    <td>' . htmlspecialchars($row['check_out_time']) . '</td>
                  </tr>';
    }

    $html .= '</tbody></table>';

    // Output the HTML content
    $pdf->writeHTML($html);

    // Close and output PDF document
    $pdf->Output('check_ins_list.pdf', 'D'); // 'D' for download
    exit;
}

// Handle logout
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>American Corner Management System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .sec_img {
            min-height: 711px;
            width: 100%;
            background-image: url(images/american.jpg);
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .fa {
            font-size: 24px;
            margin: 10px;
            color: #fff;
        }
        .fa:hover {
            opacity: 0.7;
        }
        .fa-whatsapp {
            background-color: #25D366;
            padding: 10px;
            border-radius: 50%;
        }
        .fa-facebook {
            background-color: #1877F2;
            padding: 10px;
            border-radius: 50%;
        }
        .fa-google {
            background-color: #DB4437;
            padding: 10px;
            border-radius: 50%;
        }
        .fa-instagram {
            background-color: #E4405F;
            padding: 10px;
            border-radius: 50%;
        }
        .footer {
            text-align: center;
            padding: 20px 0;
            background-color: #b52233;
            color: white;
        }
        .footer a {
            color: white;
        }
        .table-responsive {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <header style="background-color: #242f4b; text-align: center; color: white;">
        <h1>AMERICAN CORNER MANAGEMENT SYSTEM</h1>
        <div class="d-flex justify-content-center flex-wrap">
            <a href="register_client.php" class="btn btn-light mx-2 my-1">Register Client</a>
            <a href="check_in_merged.php" class="btn btn-light mx-2 my-1">Check In</a>
            <a href="check_out_merged.php" class="btn btn-light mx-2 my-1">Check Out</a>
            <a href="about.php" class="btn btn-light mx-2 my-1">About us</a>
            <a href="fetch_data.php" class="btn btn-light mx-2 my-1">Records</a>
            <a href="add_attendance.php" class="btn btn-light mx-2 my-1">Program</a>
        </div>
    </header>
    <section class="sec_img">
        <div class="container text-white">
            <h2 class="mb-4">Clients List</h2>
            <!-- Search Bar -->
            <form class="form-inline mb-4" method="post" action="">
                <div class="form-group mr-2">
                    <input type="text" class="form-control" id="search_query" name="search_query" placeholder="Search by Name" value="<?php echo htmlspecialchars($search_query); ?>">
                </div>
                <button type="submit" style="background-color: #242f4b; color: white" name="search">Search</button>
            </form>
            <!-- PDF Download Button (Visible only to admins) -->
            <?php if ($is_admin): ?>
            <form method="post" action="" class="mb-4">
                <button type="submit" name="download_pdf" class="btn btn-primary">Download PDF</button>
            </form>
            <?php endif; ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped bg-white text-dark">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row['name']) . "</td>
                                    <td>
                                        <form method='post' action='' class='d-inline'>
                                            <input type='hidden' name='check_in_name' value='" . htmlspecialchars($row['name']) . "'>
                                            <button type='submit' class='btn btn-success btn-sm'>Check In</button>
                                        </form>
                                        <form method='post' action='' class='d-inline'>
                                            <input type='hidden' name='check_out_name' value='" . htmlspecialchars($row['name']) . "'>
                                            <button type='submit' class='btn btn-danger btn-sm'>Check Out</button>
                                        </form>
                                    </td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- Logout Button -->
            <form method="post" action="" class="mb-4">
                <button type="submit" name="logout" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </section>
    <footer class="footer">
        <p>&copy; <?php echo date("Y"); ?> American Corner. All rights reserved.</p>
    </footer>
</body>
</html>
