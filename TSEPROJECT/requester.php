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

$stmt = $conn->prepare("INSERT INTO requester (name, age, email, tel, bloodtype, message) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sissss", $name, $age, $email, $tel, $bloodtype, $message);

$name = $_POST['name'];
$age = intval($_POST['age']);
$email = $_POST['email'];
$tel = $_POST['tel'];
$bloodtype = $_POST['bloodtype'];
$message = $_POST['message'];

if ($stmt->execute()) {
    $_SESSION['success_message'] = "New requester recorded successfully";
} else {
    $_SESSION['success_message'] = "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

header("Location: request.php");
exit();
?>
