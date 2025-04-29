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
            padding: 20px 10px;

        }
        .btn-danger-custom {
            background-color: #ff4d4d;
            border-color: #ff1a1a;
            color: white;
        }
        .btn-danger-custom:hover {
            background-color: #ff3333;
            border-color: #e60000;
        }
        .table-container {
            max-width: 100%;
            overflow-x: auto;
        }
        table {
            width: 100%;
            font-size: 14px;
        }
        th, td {
            white-space: nowrap;
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
                <h2>Donor List</h2>
                <a class="btn btn-primary" href="create.php" role="button">New Donor</a>
                <br><br>
                <div class="table-container"></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Donor_id</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Weight</th>
                                <th>Height</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Bloodtype</th>
                                <th>Donation_History</th>
                                <th>Tattooing</th>
                                <th>Piercing</th>
                                <th>Dental_Extraction</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "bb";

                            $connection = new mysqli($servername, $username, $password, $dbname);

                            if ($connection->connect_error) {
                                die("Connection failed: " . $connection->connect_error);
                            }

                            $sql = "SELECT * FROM donor";
                            $result = $connection->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "
                                    <tr>
                                        <td>" . $row["donor_id"] . "</td>
                                        <td>" . $row["name"] . "</td>
                                        <td>" . $row["age"] . "</td>
                                        <td>" . $row["weight"] . "</td>
                                        <td>" . $row["height"] . "</td>
                                        <td>" . $row["email"] . "</td>
                                        <td>" . $row["phone"] . "</td>
                                        <td>" . $row["bloodtype"] . "</td>
                                        <td>" . $row["donation_history"] . "</td>
                                        <td>" . $row["tattooing"] . "</td>
                                        <td>" . $row["piercing"] . "</td>
                                        <td>" . $row["dental_extraction"] . "</td>
                                        <td>
                                            <a href='edit.php?id=" . $row["donor_id"] . "' class='btn btn-warning btn-sm'>Edit</a>
                                            <a href='delete.php?id=" . $row["donor_id"] . "' class='btn btn-danger-custom btn-sm' onclick='return confirm(\"Are you sure you want to delete this donor?\")'>Delete</a>
                                        </td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='13'>No donors found</td></tr>";
                            }

                            $connection->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
