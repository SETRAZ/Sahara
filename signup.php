<?php 

$showAlert = false;
$showError = false;

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    include 'partials/_dbconnect.php';
    $user = $_POST['username'];
    $password = $_POST['pass'];
    $cpassword = $_POST['cpass'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    $existSql = "SELECT * FROM `user_login` WHERE `user_email` = '$email'";
    $result = mysqli_query($conn, $existSql);
    $numExistRows = mysqli_num_rows($result);
    echo $numExistRows;

    if($numExistRows > 0)
    {
        $showError = "This account already exists. Try logging in to the website"; 
    }
    else
    {
        if($password == $cpassword)
        {
            // $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `user_login` (`user_email`, `username`, `password`, `contact`) VALUES ('$email', '$user', '$password', '$contact')";
            $result = mysqli_query($conn, $sql);

            if($result)
            {
                $showAlert = true;
            }
        }
        else 
        {
            $showError = "Passwords do not match.";
        }
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
            <?php require 'partials/_nav.php' ?>
            <?php 
            
            if($showAlert)
            {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                You have successfully signed up to our website.<strong><a href="/dbms/login.php">Click here</a></strong> to login to your account.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }

            if($showError)
            {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error! </strong>'.$showError.'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
            
            ?>
            <div class="form-group">
                <form action="/dbms/signup.php" method="POST">
                    <h1>Signup to our website today!</h1>
                    <div class="input-box">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username">
                    </div>
                    <div class="input-box">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email">
                    </div>
                    <div class="input-box">
                        <label for="contact">Contact</label>
                        <input type="tel" maxlength="10" name="contact" id="contact">
                    </div>
                    <div class="input-box">
                        <label for="pass">Password</label>
                        <input type="password" name="pass" id="pass">
                    </div>
                    <div class="input-box">
                        <label for="cpass">Confirm Password</label>
                        <input type="password" name="cpass" id="cpass">
                    </div>

                    <button type="submit" class="btn">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <?php require 'partials/_footer.php' ?>
</body>

</html>