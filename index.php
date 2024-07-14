
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiler</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
<nav class="navbar bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand"><h2>Profiler</h2></a>
    <form class="d-flex" role="search" method="post">
    <?php
        session_start();
        if(!isset($_SESSION["user"]))
        {
            //header("Location: login.php");
            echo "<button name='login' class='btn btn-outline-success'>Login</button>&nbsp&nbsp";
            echo "<button name='regis' class='btn btn-outline-success'>Register</button>";

        }
        else if(isset($_SESSION["user"]))
        {
            echo "<button class= 'btn btn-warning' name='logout'>Logout</button>&nbsp&nbsp";
            echo "<button class= 'btn btn-danger' name='delete'>Delete Ac</button>";
        }

        if(isset($_POST['login']))
        {
            header("Location: login.php");
        }
        if(isset($_POST['regis']))
        {
            header("Location: register.php");
        }
        if(isset($_POST['logout']))
        {
            session_start();
            session_destroy();
            header("Location: index.php");
        }
        if(isset($_POST['delete']))
        {
            header("Location: delete.php");
        }
        
    ?>
    </form>
  </div>
</nav>
</div>



<h3>Welcome to Home</h3>
<?php
if(isset($_SESSION["user"]))
{
    $n = $_SESSION['name'];
    $d = $_SESSION['dob'];
    $a = 2024-$_SESSION['dob'];
    echo "<div class='card'>
            <h5 class='card-header'>Hello $n</h5>
            <div class='card-body'>
            <h5 class='card-title'>Your Year of Birth is $d</h5>
            <h5 class='card-title'>Your age is $a</h5>
            </div>
            </div>";
    
}


?>
    
<!-- =======================START CONTENT==================== -->
 

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>