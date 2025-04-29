<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bb";

// Establish connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

// Initialize error message variable
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = htmlspecialchars($_POST['username']);
    $pass = htmlspecialchars($_POST['password']);

    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ? AND is_admin = 1");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Admin user found, verify password
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        if (password_verify($pass, $hashed_password)) {
            // Password correct, start session
            $_SESSION['username'] = $user;
            $_SESSION['id'] = $id;
            $stmt->close();
            $conn->close();
            header("Location: admindashboard.php"); // Redirect to admin dashboard
            exit();
        } else {
            // Incorrect password
            $error_message = "Invalid username or password. Please try again.";
        }
    } else {
        // No admin user found with provided username
        $error_message = "Invalid username or password. Please try again.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Blood Bank</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Poetsen One", sans-serif;
            background: linear-gradient(rgba(4,9,30,0.7),rgba(4,9,30,0.7)), url('/TSEPROJECT/image/background2.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 40px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            text-align: center;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .login-container h2 {
            margin-bottom: 30px;
            font-size: 32px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        .form-group input {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-group input:focus {
            border-color: #ff8080;
            box-shadow: 0 0 8px rgba(255, 128, 128, 0.5);
            outline: none;
        }

        button {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 5px;
            background: #ff8080;
            color: white;
            font-family: "Poetsen One", sans-serif;
            font-size: 18px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background: #ff4c4c;
        }

        footer {
            background-color: #ff4c4c;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Login to Blood Bank</h2>
        
        <?php if(!empty($error_message)): ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>
        
        <form id="loginForm" action="adminlogin.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <p>Are you a regular user? <a href="/TSEPROJECT/signin.php">User login</a></p>
    </div>

    <footer>
        &copy;NELYS 2024 Blood Bank. All rights reserved.
    </footer>

</body>
</html>
