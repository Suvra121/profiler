<?php
session_start();
if(isset($_SESSION["user"]))
{
    header("Location: index.php");
}
?>
<?php include 'conn.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Registration</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body> 
    <div class="container">
<!-- =================================PHP CODE=================================================================================================================================== -->
<?php
if(isset($_POST["reg"]))
{
    $name = $_POST['fullname'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $pass = $_POST['password'];
    $pass2 = $_POST['password2'];

    $hpass = password_hash($pass,PASSWORD_DEFAULT);
    $errors=array();
    if(empty($name) OR empty($email) OR empty($dob) OR empty($pass) OR empty($pass2))
    {
        array_push($errors,"All fields are required");
    }
    if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        array_push($errors,"Email is not valid");
    }
    if(strlen($pass)>8)
    {
        array_push($errors,"Password must be 5 characters or less");
    }
    if($pass!==$pass2)
    {
        array_push($errors,"Confirm password is not same");
    }
    require_once "conn.php";
    $sql = "SELECT * FROM users WHERE email='$email';";
    $res = mysqli_query($con,$sql);
    $rowsnum = mysqli_num_rows($res);
    if($rowsnum>0)
    {
        array_push($errors,"Email is already registered");
    }
    if(count($errors)>0)
    {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }
    else
    {
        $sql = "INSERT INTO users (fullname,email,dob,password) VALUES (?,?,?,?);";
        $stmt = mysqli_stmt_init($con);
        $pstmt = mysqli_stmt_prepare($stmt,$sql);
        if($pstmt)
        {
            mysqli_stmt_bind_param($stmt,'ssis',$name,$email,$dob,$hpass);
            mysqli_stmt_execute($stmt);
            echo "<div class='alert alert-success'>Registration Successfull...</div>";
        }
        else
        {
            echo "<div class='alert alert-danger'>Registration failed...</div>";
        }
        
        
    }
}


?>
 
<!-- =========================================REGISTRATION FORM================================================================================================================ -->
<div class="form-container">
            <form id="register-form"  method="post">
                <h2>Register</h2>
                <div class="form-group">
                    <label for="register-username">Fullname</label>
                    <input type="text" class="form-control" id="register-username" name="fullname">
                </div>
                <div class="form-group">
                    <label for="register-email">Email</label>
                    <input type="email" class="form-control" id="register-email" name="email">
                </div>
                <div class="form-group">
                    <label for="register-email">Year of birth</label>
                    <input type="number" class="form-control" id="register-dob" name="dob">
                </div>
                <div class="form-group">
                    <label for="register-password">Password</label>
                    <input type="password" class="form-control" id="register-password" name="password">
                </div>
                <div class="form-group">
                    <label for="register-email">Confirm password</label>
                    <input type="password" class="form-control" id="register-email" name="password2">
                </div>
                <button type="submit" class="regbutton" name="reg">Register</button>
                <p class="message">Already registered? <a href="login.php" id="show-login">Sign In</a></p>
            </form>

            
        </div>
</div>
<!-- =============================================================================================================================================================== -->
    <script src="scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>

