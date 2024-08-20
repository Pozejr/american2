<?php
include 'admin_session.php';
include 'db.php';
require_once('tcpdf/tcpdf.php');

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

// Get filter value from POST request
$filter = isset($_POST['filter']) ? $_POST['filter'] : 'day';
$filter_query = '';

// Determine the date range based on filter
switch ($filter) {
    case 'week':
        $start_date = date('Y-m-d', strtotime('monday this week'));
        $end_date = date('Y-m-d', strtotime('sunday this week'));
        $filter_query = "WHERE check_in_time BETWEEN '$start_date' AND '$end_date'";
        break;
    case 'month':
        $start_date = date('Y-m-01'); // First day of the current month
        $end_date = date('Y-m-t');    // Last day of the current month
        $filter_query = "WHERE check_in_time BETWEEN '$start_date' AND '$end_date'";
        break;
    case 'day':
    default:
        $start_date = date('Y-m-d');
        $end_date = date('Y-m-d');
        $filter_query = "WHERE DATE(check_in_time) = '$start_date'";
        break;
}

// Create new PDF document
$pdf = new TCPDF();

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('American Corner Management System');
$pdf->SetTitle('Check-ins Report');
$pdf->SetSubject('Check-ins Report');

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

// Fetch check-in data with filtering
$sql_checkins = "SELECT name, check_in_time, check_out_time
                 FROM check_ins
                 $filter_query";
$result_checkins = $conn->query($sql_checkins);

// Table headers
$html = '<h2>Check-ins Report</h2>';
$html .= '<table border="1" cellpadding="4">
            <thead>
                <tr>
                    <th>Client Name</th>
                    <th>Check-in Time</th>
                    <th>Check-out Time</th>
                </tr>
            </thead>
            <tbody>';

// Table rows
if ($result_checkins->num_rows > 0) {
    while ($row = $result_checkins->fetch_assoc()) {
        // Ensure the keys exist before accessing them
        $client_name = isset($row['name']) ? htmlspecialchars($row['name']) : 'N/A';
        $check_in_time = isset($row['check_in_time']) ? htmlspecialchars($row['check_in_time']) : 'N/A';
        $check_out_time = isset($row['check_out_time']) ? htmlspecialchars($row['check_out_time']) : 'N/A';

        $html .= '<tr>
                    <td>' . $client_name . '</td>
                    <td>' . $check_in_time . '</td>
                    <td>' . $check_out_time . '</td>
                  </tr>';
    }
} else {
    $html .= '<tr><td colspan="3">No check-ins found for the selected period.</td></tr>';
}

$html .= '</tbody></table>';

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('checkins_report.pdf', 'D');
?>
