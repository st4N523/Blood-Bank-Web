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
        table {
            width: 80%;
            margin-bottom: 2.5cm;
            margin-left: auto;
            margin-right: auto;
            color: black;
            border-collapse: collapse; 
            box-shadow: 10px 10px 10px grey;
        }

        th, td {
            text-align: center;
            padding: 15px 35px;
            background-color: #fff;
        }

        th {
            background-color: #EC7B7C;
        }
        .edit-button {
            background-color: #ff9999;
            border-color: #ff9999;
            width: 80px;
            color: white;
        }
        .edit-button:hover {
            background-color: #ff6666;
            border-color: #ff6666;
        }
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.4); 
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 80%; 
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
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
            <a class="navbar-brand" href="#">Blood Inventory</a>
        </nav>
        <div class="inventory">
            <h2>Blood Inventory Stock</h2>
            <table class="inventory-table">
                <tbody id="inventory-table-body">
                <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "bb";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Updated SQL query to handle the condition
                    $sql = "SELECT blood_inventory_id, bloodtype, Unit_Available, 
                            CASE 
                                WHEN Unit_Available = 0 THEN 'No'
                                ELSE Available_Status
                            END AS Available_Status 
                            FROM bloodinventory"; 

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo "
                        <tr>
                            <th>ID</th>
                            <th>Blood Type</th>
                            <th>Unit Available [per bag(450ml)]</th>
                            <th>Available Status</th>
                            <th>Edit</th>
                        </tr>";

                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["blood_inventory_id"] . "</td>
                                    <td>" . $row["bloodtype"] . "</td>
                                    <td>" . $row["Unit_Available"] . "</td>
                                    <td>" . $row["Available_Status"] . "</td>
                                    <td><button class='edit-button' onclick='openEditForm(" . $row["blood_inventory_id"] . ", \"" . $row["bloodtype"] . "\", " . $row["Unit_Available"] . ", \"" . $row["Available_Status"] . "\")'>Edit</button></td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No results found</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>  

        <!-- The Modal -->
        <div id="editModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeEditForm()">&times;</span>
                <form id="editForm" action="update_inventory.php" method="post">
                    <input type="hidden" id="editId" name="blood_inventory_id">
                    <div class="form-group">
                        <label for="editBloodType">Blood Type:</label>
                        <input type="text" id="editBloodType" name="bloodtype" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="editUnitsAvailable">Units Available:</label>
                        <input type="number" id="editUnitsAvailable" name="Unit_Available" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="editAvailableStatus">Available Status:</label>
                        <select id="editAvailableStatus" name="Available_Status" class="form-control">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>   
    </div>
    <script>
        function openEditForm(id, bloodType, unitsAvailable, availableStatus) {
            document.getElementById('editId').value = id;
            document.getElementById('editBloodType').value = bloodType;
            document.getElementById('editUnitsAvailable').value = unitsAvailable;
            document.getElementById('editAvailableStatus').value = availableStatus;
            document.getElementById('editModal').style.display = 'block';
        }

        function closeEditForm() {
            document.getElementById('editModal').style.display = 'none';
        }

        // Close the modal when clicking outside of the modal content
        window.onclick = function(event) {
            if (event.target == document.getElementById('editModal')) {
                closeEditForm();

            }
        }
    </script>
</body>
</html>
