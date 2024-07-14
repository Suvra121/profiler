<?php
session_start();
if(isset($_SESSION["user"]))
{
    header("Location: index.php");
}
?>
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
if(isset($_POST["log"]))
{ 
    $email = $_POST['email'];
    $pass = $_POST['password'];
    if(empty($email) OR empty($pass))
    {
        echo "<div class='alert alert-danger'>All fields are required</div>";
    }
    require_once "conn.php";
    $sql = "SELECT * FROM users WHERE email='$email';";
    $res = mysqli_query($con,$sql);
    $user = mysqli_fetch_array($res);
    if($user)
    {
        $hpass = $user['password'];
        //password_verify($hpass, $user['password'])
        if(password_verify($_POST['password'], $user['password']))
        {
            session_start();
            $_SESSION['id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['name'] = $user['fullname'];
            $_SESSION['dob'] = $user['dob'];
            $_SESSION['pass'] = $user['password'];
            $_SESSION["user"] = "yes";
            //echo "<script>alert('Login Successful...')</script>";
            header("Location: index.php");
            die();
        }
        else
        {
            echo "<div class='alert alert-danger'>Password does not match</div>";
        } 
    }
    else
    {
        echo "<div class='alert alert-danger'>Email is not registered</div>";
    }

}
?>
<!-- ================================LOGIN FORM============================================================================================================================ -->
        <div class="form-container">
            <form id="login-form" method="post">
                <h2>Login</h2>
                <div class="form-group">
                    <label for="login-username">Email</label>
                    <input type="text" class="form-control" id="login-username" name="email">
                </div>
                <div class="form-group">
                    <label for="login-password">Password</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <button class="regbutton" type="submit" name="log">Login</button>
                <p class="message">Not registered? <a href="register.php">Create an account</a></p>
            </form>  

            
        </div>
</div>
<!-- =============================================================================================================================================================== -->
    <script src="scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>

