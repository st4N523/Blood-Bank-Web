<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['blood_inventory_id'];
    $unitsAvailable = $_POST['Unit_Available'];

    // Automatically set the Available_Status based on the units available
    $availableStatus = $unitsAvailable == 0 ? 'No' : 'Yes';

    $stmt = $conn->prepare("UPDATE bloodinventory SET Unit_Available = ?, Available_Status = ? WHERE blood_inventory_id = ?");
    $stmt->bind_param("isi", $unitsAvailable, $availableStatus, $id);

    if ($stmt->execute()) {
        echo "Inventory updated successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
header("Location: manage-bloodgroup.php");
exit;
?>
