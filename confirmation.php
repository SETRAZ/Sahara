<?php 

session_start();
include 'partials/_dbconnect.php';
$showError = false;
$success = false;
$sno = 175;

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zipcode = $_POST['zipcode'];
    $user = $_POST['userEmail'];
    

    
    $existSql = "select * from user_login where USER_EMAIL = '$user'";
    $result = mysqli_query($conn,$existSql);
    $num = mysqli_num_rows($result);

    if($num == 0)
    {
        $showError = "Your email id is wrong. Please insert the correct email.";
    }
    else
    {
        $zipSql = "select * from cart_order1 where ZIPCODE = '$zipcode'";
        $resultZip = mysqli_query($conn, $zipSql);
        $num = mysqli_num_rows($resultZip);

        if($num == 0)
        {
            $sql = "insert into cart_order1 values('$zipcode', '$state', '$city')";
            $result = mysqli_query($conn, $sql);
    
            if($result)
            {
                $productSql = "select * from cart";
                $result = mysqli_query($conn,$productSql);
                $noOfProduct = mysqli_num_rows($result);
    
                while($row = mysqli_fetch_assoc($result))
                {
                    $sno += $noOfProduct+1;
                    $orderId = $sno;
                    $pid = $row['PRODUCT_ID'];
                    $adminSql = "select ADMIN_EMAIL from product natural join category where PRODUCT_ID = '$pid'";
                    $result1 = mysqli_query($conn,$adminSql);
                    $row = mysqli_fetch_assoc($result1);
                    $admin = $row['ADMIN_EMAIL'];
                    $sql = "insert into cart_order(`STREET`,`ZIPCODE`,`PRODUCT_ID`,`ADMIN_EMAIL`,`USER_EMAIL`) values('$street', '$zipcode', '$pid', '$admin', '$user')";
                    $result2 = mysqli_query($conn,$sql);
                    
    
                    if(!$result2)
                    {
                        $showError = "Something went wrong. Please try again.";
                    }
                    $placeSql = "select * from cart_order where PRODUCT_ID = '$pid'";
                    $result3 = mysqli_query($conn,$placeSql);
                    $row = mysqli_fetch_assoc($result3);
    
                    $order = $row['ORDER_ID'];
    
                    $insert = "insert into place values ('$user','$order')";
                    $result4 = mysqli_query($conn,$insert);
                }
                
                
            }
           
        }
        else
        {
            $productSql = "select * from cart";
            $result = mysqli_query($conn,$productSql);
            $noOfProduct = mysqli_num_rows($result);

            while($row = mysqli_fetch_assoc($result))
            {
                $orderId = uniqid();
                $pid = $row['PRODUCT_ID'];
                $adminSql = "select ADMIN_EMAIL from product natural join category where PRODUCT_ID = '$pid'";
                $result1 = mysqli_query($conn,$adminSql);
                $row = mysqli_fetch_assoc($result1);
                $admin = $row['ADMIN_EMAIL'];
                $sql = "insert into cart_order(`STREET`,`ZIPCODE`,`PRODUCT_ID`,`ADMIN_EMAIL`,`USER_EMAIL`) values('$street', '$zipcode', '$pid', '$admin', '$user')";
                $result2 = mysqli_query($conn,$sql);

                if(!$result2)
                {
                    $showError = "Something went wrong. Please try again.";
                }

                $placeSql = "select * from cart_order where PRODUCT_ID = '$pid' order by ORDER_ID desc";
                $result3 = mysqli_query($conn,$placeSql);
                $row = mysqli_fetch_assoc($result3);

                $order = $row['ORDER_ID'];

                $insert = "insert into place values ('$user','$order')";
                $result4 = mysqli_query($conn,$insert);
            }
        }
        
        
    }
    $sql = "truncate table cart";
    $result = mysqli_query($conn,$sql);

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

<body class="form-body">
    <?php require 'partials/_nav.php' ?>
    <?php 
    
    if(!$showError)
    {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success! </strong>Your order has been placed. 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }

    if($showError)
    {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error! </strong>'.$showError.' 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    
    ?>
    <div class="container">
        <h2 class="mt-4">Enter your details</h2>
        <form action="/dbms/confirmation.php" method="POST">
            <div class="mb-3">
                <label for="userEmail" class="form-label ms-3">Email address</label>
                <input type="email" class="form-control rounded-pill" id="userEmail" name="userEmail"
                    aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="street" class="form-label ms-3">Street</label>
                <input type="text" class="form-control rounded-pill" id="street" name="street">
            </div>
            <div class="mb-3 d-flex">
                <div class="mb-3 w-100 ml-2">
                    <label for="city" class="form-label ms-3">City</label>
                    <input type="text" class="form-control rounded-pill" id="city" name="city">
                </div>
                <div class="mb-3 w-100 ms-2">
                    <label for="state" class="form-label ms-3">State</label>
                    <input type="text" class="form-control rounded-pill" id="state" name="state">
                </div>
            </div>

            <div class="mb-3">
                <label for="zipcode" class="form-label ms-3">Zipcode</label>
                <input type="text" class="form-control rounded-pill" id="zipcode" name="zipcode">
            </div>
            <button type="submit" class="btn btn-primary">Place Order</button>
        </form>
    </div>

</body>

</html>