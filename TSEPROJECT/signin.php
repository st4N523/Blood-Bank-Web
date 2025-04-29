<?php
session_start();
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

// Initialize error message variables
$signin_error = '';
$signup_error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        // Handle Sign-in
        $user = htmlspecialchars($_POST['username']);
        $pass = htmlspecialchars($_POST['password']);

        // Prepare SQL statement
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // User found, verify password
            $stmt->bind_result($id, $hashed_password);
            $stmt->fetch();

            if (password_verify($pass, $hashed_password)) {
                // Password correct, start session
                $_SESSION['username'] = $user;
                $_SESSION['id'] = $id;
                $stmt->close();
                $conn->close();
                header("Location: home.html"); // Redirect to user home
                exit();
            } else {
                // Incorrect password
                $signin_error = "Invalid username or password. Please try again.";
            }
        } else {
            // No user found with provided username
            $signin_error = "Invalid username or password. Please try again.";
        }

        $stmt->close();
    } elseif (isset($_POST['signup'])) {
        // Handle Sign-up
        $user = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $pass = htmlspecialchars($_POST['password']);

        // Check for duplicate username
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $user, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Username or email already exists
            $stmt->bind_result($id);
            $stmt->fetch();
            if ($stmt->num_rows > 0) {
                $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $signup_error = "Email already exists. Please choose another one.";
                } else {
                    $signup_error = "Username already exists. Please choose another one.";
                }
            }
        } else {
            // Insert new user
            $stmt->close();
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $user, $email, $hashed_password);

            if ($stmt->execute()) {
                // Sign-up successful, redirect to sign-in
                $_SESSION['signup_success'] = "Sign-up successful. Please sign in.";
                $stmt->close();
                $conn->close();
                header("Location: signin.php"); // Redirect to sign-in
                exit();
            } else {
                // Error during sign-up
                $signup_error = "Error during sign-up. Please try again.";
            }
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/TSEPROJECT/css/style.css" />
    <title>Sign in & Sign up Form</title>
</head>
<body>
    <div class="container <?php if (!empty($signup_error)) echo 'sign-up-mode'; ?>">
        <div class="forms-container">
            <div class="signin-signup">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="sign-in-form">
                    <h2 class="title">Sign in</h2>
                    <?php
                    if (!empty($signin_error)) {
                        echo '<p style="color: red;">' . $signin_error . '</p>';
                    } elseif (isset($_SESSION['signup_success'])) {
                        echo '<p style="color: green;">' . $_SESSION['signup_success'] . '</p>';
                        unset($_SESSION['signup_success']); // Clear the success message after displaying it
                    }
                    ?>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" placeholder="Username" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Password" required />
                    </div>
                    <input type="submit" name="login" value="Login" class="btn solid" />
                    
                    <div class="admin-link">
                        <p class="admin-text">Admin?</p>
                        <a href="/TSEPROJECT/admin/adminlogin.php">Admin</a> 
                    </div>
                </form>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="sign-up-form">
                    <h2 class="title">Sign up</h2>
                    <?php
                    if (!empty($signup_error)) {
                        echo '<p style="color: red;">' . $signup_error . '</p>';
                    }
                    ?>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" placeholder="Username" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="Email" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Password" required />
                    </div>
                    <input type="submit" name="signup" class="btn" value="Sign up" />
                </form>
            </div>
        </div>
        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Don't have an account?</h3>
                    <p>Sign up your account now</p>
                    <button class="btn transparent" id="sign-up-btn">Sign up</button>
                </div>
                <img src="image/hero.png" class="image" alt="" />
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>Already have an account?</h3>
                    <p>Login to your account now</p>
                    <button class="btn transparent" id="sign-in-btn">Sign in</button>
                </div>
                <img src="image/hero.png" class="image" alt="" />
            </div>
        </div>
    </div>
    <script>
        const sign_in_btn = document.querySelector("#sign-in-btn");
        const sign_up_btn = document.querySelector("#sign-up-btn");
        const container = document.querySelector(".container");

        sign_up_btn.addEventListener("click", () => {
            container.classList.add("sign-up-mode");
        });

        sign_in_btn.addEventListener("click", () => {
            container.classList.remove("sign-up-mode");
        });
    </script>
</body>
</html>
