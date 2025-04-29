<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data
$donors_query = "SELECT COUNT(*) as count FROM DONOR";
$requester_query = "SELECT COUNT(*) as count FROM requester"; // Assuming 'requester' table contains the count of requests
$users_query = "SELECT COUNT(*) as count FROM users";
$blood_stock_query = "SELECT bloodtype, Unit_Available FROM bloodinventory WHERE bloodtype IN ('O+', 'O-', 'AB+', 'AB-', 'A+', 'A-', 'B+', 'B-')";

$donors_result = $conn->query($donors_query);
$requester_result = $conn->query($requester_query);
$users_result = $conn->query($users_query);
$blood_stock_result = $conn->query($blood_stock_query);

$donors_count = $donors_result->fetch_assoc()['count'];
$requester_count = $requester_result->fetch_assoc()['count'];
$users_count = $users_result->fetch_assoc()['count'];

$blood_stock = [];
while ($row = $blood_stock_result->fetch_assoc()) {
    $blood_stock[$row['bloodtype']] = $row['Unit_Available'];
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Blood Bank</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
        }
        .sidebar {
            width: 250px;
            background: #ff8080;
            color: white;
            min-height: 100vh;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
        }
        .sidebar a:hover {
            background: #ff6666;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
        .navbar {
            background: #ff8080;
            color: white;
        }
        .dashboard-widgets {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }
        .widget {
            width: 30%;
            padding: 20px;
            background: #f8f9fa;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .widget h3 {
            margin-bottom: 20px;
        }
        .widget .value {
            font-size: 2em;
            color: #333;
        }
        .blood-stock {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }
        .blood-group {
            width: 18%;
            padding: 15px;
            background: #f8f9fa;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .blood-group h4 {
            margin-bottom: 10px;
        }
        .blood-group .value {
            font-size: 1.5em;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2 class="text-center py-3">Admin Dashboard</h2>
        <a href="/TSEPROJECT/admin/admindashboard.php">Dashboard</a>
        <a href="/TSEPROJECT/admin/donor-list.php">Manage Donors</a>
        <a href="/TSEPROJECT/admin/manage-bloodgroup.php">Blood Inventory</a>
        <a href="/TSEPROJECT/admin/manage_requester.php">Blood Requests</a>
        <a href="/TSEPROJECT/signin.php">Logout</a>
    </div>
    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <a class="navbar-brand" href="#">Blood Bank Admin</a>
        </nav>
        <div class="container mt-4">
            <div id="dashboard">
                <h2>Dashboard</h2>
                <div class="dashboard-widgets">
                    <div class="widget">
                        <h3>Donors</h3>
                        <div class="value"><?php echo $donors_count; ?></div>
                    </div>
                    <div class="widget">
                        <h3>Requester</h3>
                        <div class="value"><?php echo $requester_count; ?></div>
                    </div>
                    <div class="widget">
                        <h3>Users</h3>
                        <div class="value"><?php echo $users_count; ?></div>
                    </div>
                </div>
                <h2 class="mt-4">Blood Stock</h2>
                <div class="blood-stock">
                    <?php foreach (['O+', 'O-', 'AB+', 'AB-', 'A+', 'A-', 'B+', 'B-'] as $blood_type): ?>
                        <div class="blood-group">
                            <h4><?php echo $blood_type; ?></h4>
                            <div class="value"><?php echo isset($blood_stock[$blood_type]) ? $blood_stock[$blood_type] : 0; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
