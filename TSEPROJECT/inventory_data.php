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
        <th>Unit Available [per bag (450ml)]</th>
        <th>Available Status</th>
        <th>Requested</th>
    </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["blood_inventory_id"] . "</td>
                <td>" . $row["bloodtype"] . "</td>
                <td>" . $row["Unit_Available"] . "</td>
                <td>" . $row["Available_Status"] . "</td>
                <td>
                    <a href='request.php?id=" . $row["blood_inventory_id"] . "'>
                    <button class='request-button' style='vertical-align:middle'><span>Request</span></button></a>
                </td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No results found</td></tr>";
}

$conn->close();
?>


