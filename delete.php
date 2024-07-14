<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>

<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    // User is not logged in, redirect to login page
    header("Location: login.php");
    exit;
}

// Include database connection file
include 'conn.php';

// Get the logged-in user's ID
$user_id = $_SESSION['id'];
$user_email = $_SESSION['email'];
$user_name = $_SESSION['name'];
$user_yob = $_SESSION['dob'];
$user_pass = $_SESSION['pass'];

echo "<div class='card'>
  <div class='card-body'>
  <h3>Email = $user_email</h3><br>
  <h3>Name = $user_name</h3><br>
  <h3>Year of birth = $user_yob</h3><br>
  </div>
</div>";
echo "<form method='post'>
<input type='password' name='pass' placeholder='Enter password' class='form-control'><br>
<h3>Are you sure to delete this account ?</h3><br>
<button name='dbn' class='btn btn-danger'>Confirm Delete</button>
<button name='cbn' class='btn btn-warning'>Cancel</button>
</form>";

if(isset($_POST["dbn"]))
{
    if(password_verify($_POST['pass'], $user_pass))
    {
        $sql = "DELETE FROM users WHERE id = ?";

        if ($stmt = $con->prepare($sql)) 
        {
            // Bind the user ID parameter
            $stmt->bind_param("i", $user_id);
            if ($stmt->execute()) {
                // Account deleted successfully
                // Destroy the session to log out the user
                session_destroy();
                
                // Redirect to the homepage or login page
                header("Location: index.php");
                exit;
            } else {
                // Error occurred while deleting the account
                echo "Error: " . $stmt->error;
            }
        
            // Close the statement
            $stmt->close();
        }
        else
        {
            echo "Error: " . $conn->error;
        }
        $conn->close();
    }
    else
    {
        echo "<div class='alert alert-danger'>Password does not match!!!</div>";

    }
}
if(isset($_POST["cbn"]))
{
    header("Location: index.php");
}

// Prepare the SQL statement to delete the user's account
?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>   
</body>
</html>