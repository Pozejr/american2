<?php
require_once('tcpdf/tcpdf.php'); // Include the TCPDF library

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "client_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$dataCheckedIn = [];
$dataCheckedInOnly = [];
$dataNotCheckedIn = [];
$date = "";
$fetchType = "checked_in"; // Default fetch type

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'] ?? '';
    $fetchType = $_POST['fetch_type'] ?? 'checked_in'; // Get the selected fetch type

    if ($date) {
        if ($fetchType === 'checked_in') {
            // Fetch data for clients who checked in with a computer
            $sql = "SELECT id, comp_name, client_name, check_in_time, check_out_time FROM computer_check_in WHERE DATE(check_in_time) = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $date);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $dataCheckedIn[] = $row;
            }

            $stmt->close();
        } elseif ($fetchType === 'checked_in_only') {
            // Fetch data for clients who checked in without a computer (including those with blank comp_name)
            $sql = "SELECT c.id, c.name AS client_name, ci.check_in_time 
                    FROM clients c
                    JOIN computer_check_in ci ON c.id = ci.client_name AND DATE(ci.check_in_time) = ?
                    WHERE ci.comp_name IS NULL OR ci.comp_name = ''";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $date);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $dataCheckedInOnly[] = $row;
            }

            $stmt->close();
        } else {
            // Fetch data for clients who did not check in with a computer
            $sql = "SELECT c.id, c.name AS client_name 
                    FROM clients c 
                    LEFT JOIN computer_check_in ci ON c.id = ci.client_name AND DATE(ci.check_in_time) = ? 
                    WHERE ci.id IS NULL";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $date);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $dataNotCheckedIn[] = $row;
            }

            $stmt->close();
        }

        // If the user wants to download a PDF
        if (isset($_POST['download_pdf'])) {
            // Create new PDF document
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            // Set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('KNLS');
            $pdf->SetTitle('Check-in and Check-out Records');
            $pdf->SetSubject('Report');
            $pdf->SetKeywords('TCPDF, PDF, report');

            // Set header and footer
            $pdf->setHeaderData('', 0, 'KNLS E-RESOURCE MANAGEMENT SYSTEM', 'Check-in and Check-out Records');
            $pdf->setFooterData([0, 64, 0], [0, 64, 128]);

            // Set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // Set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // Set font
            $pdf->SetFont('helvetica', '', 12);

            // Add a page
            $pdf->AddPage();

            // Prepare HTML content for the PDF
            if ($fetchType === 'checked_in') {
                $html = '<h1>Check-in and Check-out Records for ' . htmlspecialchars($date) . '</h1>';
                $html .= '<table border="1" cellpadding="4">';
                $html .= '<thead><tr><th>ID</th><th>Computer Name</th><th>Client Name</th><th>Check-in Time</th><th>Check-out Time</th></tr></thead><tbody>';

                foreach ($dataCheckedIn as $entry) {
                    $html .= '<tr>';
                    $html .= '<td>' . htmlspecialchars($entry['id']) . '</td>';
                    $html .= '<td>' . htmlspecialchars($entry['comp_name']) . '</td>';
                    $html .= '<td>' . htmlspecialchars($entry['client_name']) . '</td>';
                    $html .= '<td>' . htmlspecialchars($entry['check_in_time']) . '</td>';
                    $html .= '<td>' . htmlspecialchars($entry['check_out_time']) . '</td>';
                    $html .= '</tr>';
                }

                $html .= '</tbody></table>';
            } elseif ($fetchType === 'checked_in_only') {
                $html = '<h1>Clients Checked In (Without Computers) for ' . htmlspecialchars($date) . '</h1>';
                $html .= '<table border="1" cellpadding="4">';
                $html .= '<thead><tr><th>ID</th><th>Client Name</th><th>Check-in Time</th></tr></thead><tbody>';

                foreach ($dataCheckedInOnly as $entry) {
                    $html .= '<tr>';
                    $html .= '<td>' . htmlspecialchars($entry['id']) . '</td>';
                    $html .= '<td>' . htmlspecialchars($entry['client_name']) . '</td>';
                    $html .= '<td>' . htmlspecialchars($entry['check_in_time']) . '</td>';
                    $html .= '</tr>';
                }

                $html .= '</tbody></table>';
            } else {
                $html = '<h1>Clients Who Did Not Check-in for ' . htmlspecialchars($date) . '</h1>';
                $html .= '<table border="1" cellpadding="4">';
                $html .= '<thead><tr><th>ID</th><th>Client Name</th></tr></thead><tbody>';

                foreach ($dataNotCheckedIn as $entry) {
                    $html .= '<tr>';
                    $html .= '<td>' . htmlspecialchars($entry['id']) . '</td>';
                    $html .= '<td>' . htmlspecialchars($entry['client_name']) . '</td>';
                    $html .= '</tr>';
                }

                $html .= '</tbody></table>';
            }

            // Print HTML content
            $pdf->writeHTML($html, true, false, true, false, '');

            // Output PDF document
            $pdf->Output('check_in_out_records_' . $date . '.pdf', 'D');
            exit; // Ensure no further output is sent
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check in and out records</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .header {
            background-color: #2D2C8E;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        .footer {
            background-color: #F48312;
            color: white;
            padding: 10px 0;
            text-align: center;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>
    <header style="background-color: #2D2C8E; text-align: center; color: white;">
        <h1>American Corner Management System</h1>
        <div class="d-flex justify-content-center flex-wrap">
            <a href="admin.php" class="btn btn-light mx-2 my-1">Home</a>
        </div>
    </header>
    <div class="container mt-5 mb-5">
        <div class="filter-container text-center mb-4">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="date">Filter by Date:</label>
                    <input type="date" id="date" name="date" class="form-control" value="<?php echo htmlspecialchars($date); ?>">
                </div>
                <div class="form-group">
                    <label for="fetch_type">Fetch Type:</label>
                    <select id="fetch_type" name="fetch_type" class="form-control">
                    <option value="checked_in" <?php echo ($fetchType === 'checked_in') ? 'selected' : ''; ?>>Checked In (With Computers)</option>
                        <option value="checked_in_only" <?php echo ($fetchType === 'checked_in_only') ? 'selected' : ''; ?>>Checked In Only (Without Computers)</option>
                        <option value="not_checked_in" <?php echo ($fetchType === 'not_checked_in') ? 'selected' : ''; ?>>Not Checked In</option>
                    </select>
                </div>
                <button type="submit" name="fetch_data" class="btn btn-primary">Fetch Data</button>
                <button type="submit" name="download_pdf" class="btn btn-success">Download PDF</button>
            </form>
        </div>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Computer Name</th>
                    <th>Client Name</th>
                    <th>Check-in Time</th>
                    <th>Check-out Time</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($fetchType === 'checked_in' && count($dataCheckedIn) > 0): ?>
                    <?php foreach ($dataCheckedIn as $entry): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($entry['id']); ?></td>
                            <td><?php echo htmlspecialchars($entry['comp_name']); ?></td>
                            <td><?php echo htmlspecialchars($entry['client_name']); ?></td>
                            <td><?php echo htmlspecialchars($entry['check_in_time']); ?></td>
                            <td><?php echo htmlspecialchars($entry['check_out_time']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php elseif ($fetchType === 'checked_in_only' && count($dataCheckedInOnly) > 0): ?>
                    <?php foreach ($dataCheckedInOnly as $entry): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($entry['id']); ?></td>
                            <td colspan="4"><?php echo htmlspecialchars($entry['client_name']); ?> (Checked in Only)</td>
                        </tr>
                    <?php endforeach; ?>
                <?php elseif ($fetchType === 'not_checked_in' && count($dataNotCheckedIn) > 0): ?>
                    <?php foreach ($dataNotCheckedIn as $entry): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($entry['id']); ?></td>
                            <td colspan="4"><?php echo htmlspecialchars($entry['client_name']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No data found for the selected date and type.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="footer">
        <p>&copy; Developed by KNLS Attachés @ May-August 2024</p>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
