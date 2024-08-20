<?php
// Include database connection
require_once 'db.php';
require_once 'tcpdf/tcpdf.php'; // Include the TCPDF library

$attendanceData = [];
$programs = [];
$selectedProgram = '';
$selectedDay = '';
$selectedMonth = '';
$selectedWeekStart = '';
$selectedWeekEnd = '';
$totalClients = 0;

// Fetch programs for dropdown
$programResult = $conn->query("SELECT id, name FROM programs");
if ($programResult->num_rows > 0) {
    while ($row = $programResult->fetch_assoc()) {
        $programs[] = $row;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedProgram = $_POST['program_id'] ?? '';
    $selectedDay = $_POST['day'] ?? '';
    $selectedMonth = $_POST['month'] ?? '';
    $selectedWeekStart = $_POST['week_start'] ?? '';
    $selectedWeekEnd = $_POST['week_end'] ?? '';

    $query = "
        SELECT 
            p.name AS program_name,
            pa.attended_at AS date,
            c.name AS client_name
        FROM 
            program_attendance pa
        JOIN 
            programs p ON pa.program_id = p.id
        JOIN 
            clients c ON pa.client_id = c.id
        WHERE 
            p.id = ?
    ";

    // Add conditions based on filters
    if ($selectedDay) {
        $query .= " AND DATE(pa.attended_at) = ?";
    } elseif ($selectedMonth) {
        $query .= " AND DATE_FORMAT(pa.attended_at, '%Y-%m') = ?";
    } elseif ($selectedWeekStart && $selectedWeekEnd) {
        $query .= " AND pa.attended_at BETWEEN ? AND ?";
    }

    $query .= "
        ORDER BY 
            p.name, pa.attended_at
    ";

    $stmt = $conn->prepare($query);
    if ($selectedDay) {
        $stmt->bind_param("ss", $selectedProgram, $selectedDay);
    } elseif ($selectedMonth) {
        $stmt->bind_param("ss", $selectedProgram, $selectedMonth);
    } elseif ($selectedWeekStart && $selectedWeekEnd) {
        $stmt->bind_param("sss", $selectedProgram, $selectedWeekStart, $selectedWeekEnd);
    } else {
        $stmt->bind_param("s", $selectedProgram);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch attendance data
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $attendanceData[] = $row;
        }
        // Count distinct clients
        $totalClientsQuery = "
            SELECT 
                COUNT(DISTINCT pa.client_id) AS total_clients
            FROM 
                program_attendance pa
            JOIN 
                programs p ON pa.program_id = p.id
            WHERE 
                p.id = ?
        ";
        if ($selectedDay) {
            $totalClientsQuery .= " AND DATE(pa.attended_at) = ?";
        } elseif ($selectedMonth) {
            $totalClientsQuery .= " AND DATE_FORMAT(pa.attended_at, '%Y-%m') = ?";
        } elseif ($selectedWeekStart && $selectedWeekEnd) {
            $totalClientsQuery .= " AND pa.attended_at BETWEEN ? AND ?";
        }

        $totalClientsStmt = $conn->prepare($totalClientsQuery);
        if ($selectedDay) {
            $totalClientsStmt->bind_param("ss", $selectedProgram, $selectedDay);
        } elseif ($selectedMonth) {
            $totalClientsStmt->bind_param("ss", $selectedProgram, $selectedMonth);
        } elseif ($selectedWeekStart && $selectedWeekEnd) {
            $totalClientsStmt->bind_param("sss", $selectedProgram, $selectedWeekStart, $selectedWeekEnd);
        } else {
            $totalClientsStmt->bind_param("s", $selectedProgram);
        }
        $totalClientsStmt->execute();
        $totalClientsResult = $totalClientsStmt->get_result();
        if ($totalClientsResult->num_rows > 0) {
            $totalClientsRow = $totalClientsResult->fetch_assoc();
            $totalClients = $totalClientsRow['total_clients'];
        }
    }

    // Check if the PDF download button was clicked
    if (isset($_POST['download_pdf'])) {
        // Generate PDF using TCPDF
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);

        // Add a title to the PDF
        $pdf->Cell(0, 10, 'Program Attendance Report', 0, 1, 'C');
        $pdf->Ln(10);

        // Add table header
        $pdf->Cell(60, 10, 'Program Name', 1, 0, 'C');
        $pdf->Cell(60, 10, 'Date', 1, 0, 'C');
        $pdf->Cell(60, 10, 'Client Name', 1, 1, 'C');

        // Add table rows
        foreach ($attendanceData as $data) {
            $pdf->Cell(60, 10, $data['program_name'], 1, 0, 'C');
            $pdf->Cell(60, 10, $data['date'], 1, 0, 'C');
            $pdf->Cell(60, 10, $data['client_name'], 1, 1, 'C');
        }

        // Output the PDF
        $pdf->Output('program_attendance_report.pdf', 'D');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Program Attendance</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add Bootstrap Datepicker CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Add any additional CSS -->
    <style>
        .form-container {
            width: 900px; /* Adjust the max-width as needed */
            margin: 0 auto; /* Center-align the container */
            padding: 20px; /* Add padding inside the container */
            min-height: 500px; /* Set a minimum height for the form */
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group input,
        .form-group select {
            width: 100%; /* Ensure input fields and selects take full column width */
            height: 40px; /* Set a fixed height for input fields and selects */
        }
        form {
            width: 900px;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header style="background-color: #242f4b; text-align: center; color: white;">
        <h1>American Corner Management System</h1>
        <a href="admin.php" class="btn btn-light mx-2 my-1">HOME</a>
    </header>

    <section class="container mt-5 form-container">
        <h1>Program Attendance</h1>

        <form action="view_attendance.php" method="post" class="mb-4">
            <div class="row">
                <!-- Program Selection -->
                <div class="col-md-3 form-group">
                    <label for="program_id">Program:</label>
                    <select id="program_id" name="program_id" class="form-control">
                        <option value="">Select Program</option>
                        <?php foreach ($programs as $program): ?>
                            <option value="<?php echo $program['id']; ?>" <?php echo ($selectedProgram == $program['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($program['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Day Selection -->
                <div class="col-md-2 form-group">
                    <label for="day">Day:</label>
                    <input type="text" id="day" name="day" class="form-control" placeholder="Select day" value="<?php echo htmlspecialchars($selectedDay); ?>">
                </div>

                <!-- Month Selection -->
                <div class="col-md-2 form-group">
                    <label for="month">Month:</label>
                    <input type="text" id="month" name="month" class="form-control" placeholder="Select month" value="<?php echo htmlspecialchars($selectedMonth); ?>">
                </div>

                <!-- Week Start Selection -->
                <div class="col-md-2 form-group">
                    <label for="week_start">Week Start:</label>
                    <input type="text" id="week_start" name="week_start" class="form-control" placeholder="Select start date" value="<?php echo htmlspecialchars($selectedWeekStart); ?>">
                </div>

                <!-- Week End Selection -->
                <div class="col-md-2 form-group">
                    <label for="week_end">Week End:</label>
                    <input type="text" id="week_end" name="week_end" class="form-control" placeholder="Select end date" value="<?php echo htmlspecialchars($selectedWeekEnd); ?>">
                </div>

                <!-- Empty Column for Spacing -->
                <div class="col-md-2 form-group"></div>
            </div>

            <button type="submit" class="btn" style="background-color: #242f4b; color: white;">Filter</button>
        </form>

        <!-- PDF Download Section -->
        <?php if (!empty($attendanceData)): ?>
            <form action="view_attendance.php" method="post" class="mb-4">
                <input type="hidden" name="program_id" value="<?php echo htmlspecialchars($selectedProgram); ?>">
                <input type="hidden" name="day" value="<?php echo htmlspecialchars($selectedDay); ?>">
                <input type="hidden" name="month" value="<?php echo htmlspecialchars($selectedMonth); ?>">
                <input type="hidden" name="week_start" value="<?php echo htmlspecialchars($selectedWeekStart); ?>">
                <input type="hidden" name="week_end" value="<?php echo htmlspecialchars($selectedWeekEnd); ?>">
                <button type="submit" name="download_pdf" class="btn btn-success">Download PDF</button>
            </form>
        <?php endif; ?>

        <!-- Total Clients Section -->
        <?php if ($totalClients > 0): ?>
            <div class="alert alert-info">
                <strong>Total Number of Clients Attended:</strong> <?php echo $totalClients; ?>
            </div>
        <?php endif; ?>

        <!-- Table Container with Scrollbar -->
        <div style="max-height: 200px; overflow-y: auto;">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Program Name</th>
                        <th>Date</th>
                        <th>Client Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($attendanceData)): ?>
                        <tr>
                            <td colspan="3" class="text-center">No attendance data available.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($attendanceData as $data): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($data['program_name']); ?></td>
                                <td><?php echo htmlspecialchars($data['date']); ?></td>
                                <td><?php echo htmlspecialchars($data['client_name']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
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
            $('#day').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                startView: 0,
                minViewMode: 0
            });

            $('#month').datepicker({
                format: "yyyy-mm",
                viewMode: "months",
                minViewMode: "months",
                autoclose: true
            });

            $('#week_start').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                startView: 0,
                minViewMode: 0
            });

            $('#week_end').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                startView: 0,
                minViewMode: 0
            });
        });
    </script>
</body>
</html>

