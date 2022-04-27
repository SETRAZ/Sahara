<?php 

$adminlogin = false;
$showError = false;

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    include 'partials/_dbconnect.php';
    $admin = $_POST['adminname'];
    $password = $_POST['pass'];
    $email = $_POST['adminemail'];

    $sql = "SELECT * FROM `admin_login` NATURAL JOIN `admin_login1` WHERE `admin_email` = '$email' AND `username` = '$admin'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);

    if($num == 1)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            if($password == $row['PASS'])
            {
                $adminlogin = true;
                session_start();
                $_SESSION['logged'] = true;
                $_SESSION['adminname'] = $admin;
                $_SESSION['adminemail'] = $email;
                header("location: /dbms/admin.php");
            }
            else
            {
                $showError = "Invalid Credentials. You are not a registered admin.";
            }
        }
    }
    else
    {
        $showError = "Invalid Credentials. You are not a registered admin.";
    }
    
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.1.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <script src="bootstrap-5.1.3-dist/js/bootstrap.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="header">
        <div class="container">
            <?php require 'partials/_admin_nav.php' ?>
            <?php 
            
            if($showError)
            {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error! </strong>'.$showError.'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
            
            ?>
            <div class="form-group">
                <form action="/dbms/admin_login.php" method="POST">
                    <h1>Enter details to Login.</h1>
                    <div class="input-box">
                        <label for="adminname">Username</label>
                        <input type="text" name="adminname" id="adminname">
                    </div>
                    <div class="input-box">
                        <label for="adminemail">Email</label>
                        <input type="email" name="adminemail" id="adminemail">
                    </div>
                    <div class="input-box">
                        <label for="pass">Password</label>
                        <input type="password" name="pass" id="pass">
                    </div>
                    
                    <button type="submit" class="btn">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <?php require 'partials/_footer.php' ?>
</body>

</html>