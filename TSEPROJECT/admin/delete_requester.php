<?php
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM requester WHERE id = $id";
    $conn->query($sql);
    
    $conn->close();
}

header("location: /TSEPROJECT/admin/manage_requester.php");
exit;
?>
