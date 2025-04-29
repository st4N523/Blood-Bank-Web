<?php
$name = "";
$age = "";
$weight = "";
$height = "";
$email = "";
$phone = "";
$bloodtype = "";
$donation_history = "";
$tattooing = "";
$piercing = "";
$dental_extraction = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST["name"];
    $age = $_POST["age"];
    $weight = $_POST["weight"];
    $height = $_POST["height"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $bloodtype = $_POST["bloodtype"];
    $donation_history = $_POST["donation_history"];
    $tattooing = isset($_POST["tattooing"]) ? $_POST["tattooing"] : "";
    $piercing = isset($_POST["piercing"]) ? $_POST["piercing"] : "";
    $dental_extraction = isset($_POST["dental_extraction"]) ? $_POST["dental_extraction"] : "";

    // Validation
    if (empty($name) || empty($age) || empty($weight) || empty($height) || empty($email) || empty($phone) || empty($bloodtype) ||
        empty($donation_history) || $tattooing === "" || $piercing === "" || $dental_extraction === "") {
        $errorMessage = "All fields are required";
    } else {
        // Database connection
        $conn = mysqli_connect("localhost", "root", "", "bb");

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Insert data into the database
        $sql = "INSERT INTO donor (name, age, weight, height, email, phone, bloodtype, donation_history, tattooing, piercing, dental_extraction) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "siiissssiii", $name, $age, $weight, $height, $email, $phone, $bloodtype, $donation_history, $tattooing, $piercing, $dental_extraction);

        if (mysqli_stmt_execute($stmt)) {
            $successMessage = "Donor successfully added!";
            // Clear form values after successful insertion
            $name = $age = $weight = $height = $email = $phone = $bloodtype = $donation_history = $tattooing = $piercing = $dental_extraction = "";
        } else {
            $errorMessage = "Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Donor</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #ff8484;;
            padding-top: 20px;
        }
        .container {
            max-width: 600px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        .form-control {
            border-radius: 4px;
        }
        .btn-primary {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-primary:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: #fff;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4">New Donor</h2>
        <?php if (!empty($errorMessage)) : ?>
            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
        <?php endif; ?>
        <?php if (!empty($successMessage)) : ?>
            <div class="alert alert-success"><?php echo $successMessage; ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($name); ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Age</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="age" value="<?php echo htmlspecialchars($age); ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Weight</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="weight" value="<?php echo htmlspecialchars($weight); ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Height</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="height" value="<?php echo htmlspecialchars($height); ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Phone</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Blood Type</label>
                <div class="col-sm-9">
                    <select class="form-control" name="bloodtype" id="bloodtype" required>
                        <option value="">Select your blood type</option>
                        <option value="A+" <?php if ($bloodtype == "A+") echo "selected"; ?>>A+</option>
                        <option value="A-" <?php if ($bloodtype == "A-") echo "selected"; ?>>A-</option>
                        <option value="B+" <?php if ($bloodtype == "B+") echo "selected"; ?>>B+</option>
                        <option value="B-" <?php if ($bloodtype == "B-") echo "selected"; ?>>B-</option>
                        <option value="O+" <?php if ($bloodtype == "O+") echo "selected"; ?>>O+</option>
                        <option value="O-" <?php if ($bloodtype == "O-") echo "selected"; ?>>O-</option>
                        <option value="AB+" <?php if ($bloodtype == "AB+") echo "selected"; ?>>AB+</option>
                        <option value="AB-" <?php if ($bloodtype == "AB-") echo "selected"; ?>>AB-</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Donation History</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="donation_history" value="<?php echo htmlspecialchars($donation_history); ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Tattooing</label>
                <div class="col-sm-9">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tattooing" value="1" <?php if ($tattooing == "1") echo "checked"; ?>>
                        <label class="form-check-label">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tattooing" value="0" <?php if ($tattooing == "0") echo "checked"; ?>>
                        <label class="form-check-label">No</label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Piercing</label>
               
                <div class="col-sm-9">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="piercing" value="1" <?php if ($piercing == "1") echo "checked"; ?>>
                        <label class="form-check-label">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="piercing" value="0" <?php if ($piercing == "0") echo "checked"; ?>>
                        <label class="form-check-label">No</label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Dental Extraction</label>
                <div class="col-sm-9">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="dental_extraction" value="1" <?php if ($dental_extraction == "1") echo "checked"; ?>>
                        <label class="form-check-label">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="dental_extraction" value="0" <?php if ($dental_extraction == "0") echo "checked"; ?>>
                        <label class="form-check-label">No</label>
                    </div>
                </div>
            </div>
            <!-- Submit and Cancel buttons -->
            <div class="form-group row">
                <div class="col-sm-9 offset-sm-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="donor-list.php" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

