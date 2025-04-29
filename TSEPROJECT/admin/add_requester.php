<?php
    $servername = "localhost";  
    $username = "root"; 
    $password = ""; 
    $dbname = "bb"; 

    $conn = new mysqli($servername, $username, $password, $dbname);
   
    $name = "";
    $age = "";
    $email = "";
    $tel = "";
    $bloodtype = "";
    $message = "";

    $errorMessage = "";
    $successMessage = "";

    if( $_SERVER['REQUEST_METHOD']== 'POST'){
       $name = $_POST['name'];
       $age = intval($_POST['age']);
       $email = $_POST['email'];
       $tel = $_POST['tel'];
       $bloodtype = $_POST['bloodtype'];
       $message = $_POST['message'];

       do{
          if ( empty($name) || empty($age) || empty($email) ||  empty($tel) ||  empty($bloodtype) ||  empty($message) ){
            $errorMessage = "All the fields are required";
            break;
          }

          $sql = "INSERT INTO requester (name, age, email, tel, bloodtype, message) " .
                 "VALUES ('$name', '$age', '$email', '$tel', '$bloodtype', '$message')";
          $result = $conn->query($sql);

          if (!$result){
            $errorMessage = "Invalid query: " .$connection->error;
            break;
          }


          $name = "";
          $age = "";
          $email = "";
          $tel = "";
          $bloodtype = "";
          $message = "";

          $successMessage = "Requester added correctly";

          header("location: /TSEPROJECT/admin/manage_requester.php");
          exit;

       }while (false);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Requester</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .navbar {
            background-color: #ff8080;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }
        .btn-primary {
            background-color: #ff8080;
            border-color: #ff8080;
        }
        .btn-primary:hover {
            background-color: #ff6666;
            border-color: #ff6666;
        }
        .btn-outline-primary {
            color: #ff8080;
            border-color: #ff8080;
        }
        .btn-outline-primary:hover {
            color: white;
            background-color: #ff6666;
            border-color: #ff6666;
        }
        .form-control:focus {
            border-color: #ff8080;
            box-shadow: 0 0 5px rgba(255, 128, 128, 0.5);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">Blood Bank Admin</a>
    </nav>
    <div class="container">
        <div class="card">
            <h2 class="card-title text-center">New Requester</h2>
        <?php
        if ( !empty($errorMessage) ){
            echo"
            <div class='alert alert warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'</button>
            </div>
            ";
        }
        ?>

        <form method="post">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                </div> 
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Age</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="age" value="<?php echo $age; ?>">
                </div> 
            </div> 
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email" value="<?php echo $email; ?>">
                </div> 
            </div> 
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Phone Number</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="tel" value="<?php echo $tel; ?>">
                </div> 
            </div> 
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Bloodtype</label>
                <div class="col-sm-6">
                <select name="bloodtype" class="form-control" required>
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
            </div>        
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Message</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="message" value="<?php echo $message; ?>">
                </div> 
            </div>
            

            <?php
                if ( !empty($successMessage) ){
                    echo "
                    <div class = 'row mb-3'>
                        <div class='offset-sm-3 col-sm-6'>
                            <div class='alert alert warning alert-dismissible fade show' role='alert'>
                                 <strong>$successMessage</strong>
                                 <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'</button>
                            </div>
                        </div>
                    </div>
                    ";
                }
            ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                     <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                     <a class="btn btn-outline-primary" href="/TSEPROJECT/admin/manage_requester.php" role="button">Cancel</a>
                </div> 
            </div>
        </form>
      </div>
    </div>
</body>
</html>