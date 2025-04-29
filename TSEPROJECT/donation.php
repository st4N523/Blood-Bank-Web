<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Donation Request</title>
    <link rel="stylesheet" href="/TSEPROJECT/css/request.css">
    <style>
        .success-message {
            color: green;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .register-container {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .title {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .form-group .checkbox-group {
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        .form-group .checkbox-group label {
            margin-left: 10px;
            margin-right: 20px;
        }
    </style>
</head>
<body>
    <header>
        <div id="navigation"></div>
        <script src="/TSEPROJECT/javascript/loadNavigation.js"></script>
    </header>
    <main>
        <?php
        session_start();
        if (isset($_SESSION['success_message'])) {
            echo "<div class='success-message'>" . $_SESSION['success_message'] . "</div>";
            unset($_SESSION['success_message']); 
        }
        if (isset($_SESSION['error_message'])) {
            echo "<div class='error-message'>" . $_SESSION['error_message'] . "</div>";
            unset($_SESSION['error_message']);
        }
        ?>
        <div class="register-container">
            <div class="title">Register as Blood Donor</div>

            <form action="donor.php" method="post">
                <div class="form-group">
                    <label for="name">Full name:</label>
                    <input type="text" placeholder="Enter your name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="age">Age:</label>
                    <input type="number" placeholder="Enter your age" name="age" required>
                </div>
                <div class="form-group">
                    <label for="height">Height (cm):</label>
                    <input type="number" placeholder="Enter your height in cm" name="height" required>
                </div>
                <div class="form-group">
                    <label for="weight">Weight (kg):</label>
                    <input type="number" placeholder="Enter your weight in kg" name="weight" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address:</label>
                    <input type="text" placeholder="Enter your email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="tel">Phone Number:</label>
                    <input type="text" placeholder="Enter your phone number" name="tel" required>
                </div>
                <div class="form-group">
                    <label for="bloodtype">Blood Type:</label>
                    <select name="bloodtype" id="bloodtype" required>
                        <option value="">Select your blood type</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                    </select>
                </div>
                <div class="form-group checkbox-group">
                    <label for="tattooing">Tattooing</label>
                    <input type="checkbox" name="opt[]" value="Tattooing">
                    <label for="piercing">Piercing</label>
                    <input type="checkbox" name="opt[]" value="Piercing">
                    <label for="dental_extraction">Dental Extraction</label>
                    <input type="checkbox" name="opt[]" value="Dental Extraction">
                </div>
                <div class="form-group">
                    <button type="submit">Submit Request</button>
                </div>
            </form>
        </div>
    </main>
    <div id="footer"></div>
    <script src="/TSEPROJECT/javascript/loadFooter.js"></script>
</body>
</html>
