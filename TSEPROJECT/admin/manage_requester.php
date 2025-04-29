<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Requester</title>
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
        .table thead th {
            background-color: #ff8080;
            color: white;
        }
        .btn-primary {
            background-color: #ff8080;
            border-color: #ff8080;
        }
        .btn-primary:hover {
            background-color: #ff6666;
            border-color: #ff6666;
        }
        .btn-edit {
            background-color: #ff9999;
            border-color: #ff9999;
            width: 80px;
            color: white;
        }
        .btn-edit:hover {
            background-color: #ff6666;
            border-color: #ff6666;
        }
        .btn-delete {
            background-color: #cc0000;
            border-color: #cc0000;
            width: 80px;
            color: white;
        }
        .btn-delete:hover {
            background-color: #b30000;
            border-color: #b30000;
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
            <h2>List of Requester</h2>
            <a class="btn btn-primary" href="/TSEPROJECT/admin/add_requester.php" role="button">New Requester</a>
            <br><br>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Age</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Bloodtype</th>
                        <th>Message</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "bb";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT * FROM requester";
                    $result = $conn->query($sql);

                    if (!$result) {
                        die("Invalid query: " . $conn->error);
                    }

                    while ($row = $result->fetch_assoc()) {
                        echo "
                        <tr>
                            <td>{$row['id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['age']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['tel']}</td>
                            <td>{$row['bloodtype']}</td>
                            <td>{$row['message']}</td>
                            <td>
                                 <a class='btn btn-edit btn-sm' href='/TSEPROJECT/admin/edit_requester.php?id={$row['id']}'>Edit</a>
                                 <a class='btn btn-delete btn-sm' href='/TSEPROJECT/admin/delete_requester.php?id={$row['id']}'>Delete</a>
                            </td>
                        </tr>
                        ";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
