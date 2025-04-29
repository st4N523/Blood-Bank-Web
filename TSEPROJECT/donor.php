<?php
session_start(); 

$servername = "localhost"; 
$username = "root";  
$password = "";  
$dbname = "bb"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$tattooing = 0;
$piercing = 0;
$dental_extraction = 0;

if (isset($_POST['opt']) && is_array($_POST['opt'])) {
    $tattooing = in_array('Tattooing', $_POST['opt']) ? 1 : 0;
    $piercing = in_array('Piercing', $_POST['opt']) ? 1 : 0;
    $dental_extraction = in_array('Dental Extraction', $_POST['opt']) ? 1 : 0;
}

if ($tattooing || $piercing || $dental_extraction) {
    $_SESSION['error_message'] = "Cannot proceed due to recent Tattooing, Piercing, or Dental Extraction.";
    header("Location: donation.php");
    exit();
}

$stmt = $conn->prepare("INSERT INTO donor (name, age, weight, height, email, phone, bloodtype, tattooing, piercing, dental_extraction) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if ($stmt) {
    $stmt->bind_param("siddsssiis", $name, $age, $weight, $height, $email, $phone, $bloodtype, $tattooing, $piercing, $dental_extraction);

    $name = $_POST['name'];
    $age = intval($_POST['age']);
    $weight = isset($_POST['weight']) ? floatval($_POST['weight']) : 0;
    $height = isset($_POST['height']) ? floatval($_POST['height']) : 0;
    $email = $_POST['email'];
    $phone = $_POST['tel'];
    $bloodtype = $_POST['bloodtype'];

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "New donor recorded successfully";
    } else {
        $_SESSION['error_message'] = "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    $_SESSION['error_message'] = "Error: " . $conn->error;
}

$conn->close();

header("Location: donation.php");
exit();
?>
