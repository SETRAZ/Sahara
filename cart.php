<?php 

session_start();
include 'partials/_dbconnect.php';

if(isset($_GET['id']))
{
    $pid = $_GET['id'];
    $size = $_GET['size'];
    $sql = "delete from cart where PRODUCT_ID = '$pid' and SIZE='$size'";
    $result = mysqli_query($conn,$sql);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://use.fontawesome.com/c621d4c42a.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css"
        integrity="sha384-ejwKkLla8gPP8t2u0eQyL0Q/4ItcnyveF505U0NIobD/SMsNyXrLti6CWaD0L52l" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css"
        integrity="sha384-jLKHWM3JRmfMU0A5x5AkjWkw/EYfGUAGagvnfryNV3F9VqM98XiIH7VBGVoxVSc7" crossorigin="anonymous">
    <link
        href="https://fonts.googleapis.com/css2?family=Merriweather&family=Montserrat&family=Poppins:wght@300;400;500;600;700&family=Sacramento&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="bootstrap-5.1.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <script src="bootstrap-5.1.3-dist/js/bootstrap.js"></script>
    <script src="product-detail.js"></script>

    <title>All Products-Sahara Ecommerce</title>
</head>

<body>
    <div class="header">
        <div class="container">
            <?php require 'partials/_nav.php' ?>
        </div>
    </div>
    <!---------cart item details--------->
    <div class="small-container cart-page">
        <div class="container my-4 py-2">
            <h2 class="mt-3">Your Cart</h2>
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">S.No.</th>
                        <th scope="col">Product</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
          
                    $sql = "select * from cart natural join product";
                    $result = mysqli_query($conn, $sql);
                    $num = mysqli_num_rows($result);
                    $sno = 1;
                    $totalprice = 0;
                    
                    if($num == 0)
                    {
                        echo '<h4 class="mt-4 ms-4">Your cart is empty</h4>';
                    }
                    else
                    {
                        while($row = mysqli_fetch_assoc($result))
                        {
                            $price = $row['QUANTITY']*10.00;
                            echo '<tr>
                            <td>'.$sno.'</td>
                            <td>
                                <div class="cart-info">
                                    <img src="'.$row['IMAGE1'].'" alt="">
                                    <div class="product-detail">
                                        <p>'.$row['PRODUCT_NAME'].'</p>
                                        <small>Price; $10.00</small>
                                        <br>
                                        <form action="/dbms/cart.php?id='.$row['PRODUCT_ID'].'" method="GET">
                                        <button type="submit" class="delete cart-button"><a href="/dbms/cart.php?id='.$row['PRODUCT_ID'].'&size='.$row['SIZE'].'">Remove</a></button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                            <td>'.$row['QUANTITY'].'</td>
                            <td>$'.$price.'.00</td>
                        </tr>';
                            $sno += 1;
                            $totalprice += $price;
                        }
                    }
                    ?>
                    
                </tbody>
            </table>
            <div class="total-price">
                <table>
                    <tr>
                        <td>SubTotal</td>
                        <td><?php echo '$'.$totalprice.'.00'; ?></td>
                    </tr>
                    <tr>
                        <td>Tax</td>
                        <td>
                            <?php 
                            
                            $tax = $totalprice/10;
                            echo '$'.$tax.'.00';
                            
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td>
                            <?php 
                            
                            $total = $totalprice + $tax;
                            echo '$'.$total.'.00';
                            
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><a href="/dbms/confirmation.php"><button onclick="displayAlert()" type="button" class="btn btn-success btn-lg btn-block">Proceed</button></a></td>
                    </tr>
                </table>
            </div>
            
        </div>
        
    </div>
    <!-------footer---------->
    <?php require 'partials/_footer.php' ?>
    <script src="cart.js"></script>
    <script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    
    </div>
</body>

</html>