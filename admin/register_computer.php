<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Computer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            margin: 0 auto;
            width: 300px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: #f9f9f9;
        }
        .form-group label {
            display: block;
            margin: 10px 0 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }
        .btn-primary {
            width: 100%;
        }
        .footer {
            background-color: #b52233; /* Footer color */
            color: white;
            padding: 10px;
            text-align: center;
            width: 100%;
            position: fixed;
            bottom: 0;
            left: 0;
        }
        .footer a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
<header style="background-color: #2D2C8E; text-align: center; color: white;">
    <h1>American Corner Management System</h1>
</header>
<section>
    <div class="container">
        <h1>Register Assets</h1>
        <form method="post" action="register_computer_process.php">
            <div class="form-group">
                <label for="comp_name">Asset Name:</label>
                <input type="text" id="comp_name" name="comp_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="serial_no">Serial No:</label>
                <input type="text" id="serial_no" name="serial_no" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</section>
<footer class="footer">
    <p>&copy; <span id="year"></span> Developed by <a href="https://wa.me/+254758882563" target="_blank">Pandomi Tech Innovations</a></p>
</footer>

<script>
    // Get the current year
    var currentYear = new Date().getFullYear();
    // Set the year in the HTML
    document.getElementById('year').textContent = currentYear;
</script>
</body>
</html>

