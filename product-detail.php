<?php 

session_start();
$success = false;
$error = false;

function get_product($conn,$limit='',$cat_id='',$product_id='')
{
    $sql="select product.*,category.CAT_NAME from product NATURAL JOIN category where product.PRODUCT_NAME IS NOT NULL ";
    if($cat_id!='')
    {
        $sql.=" and product.CAT_ID= '$cat_id' ";
    }
    if($product_id!='')
    {
        $sql.=" and product.PRODUCT_ID= '$product_id' ";
    }
    $sql.=" order by product.PRODUCT_ID desc";
    if($limit!='')
    {
        $sql.=" limit $limit";
    }
    
    $result=mysqli_query($conn,$sql);
    $data=array();
    while($row=mysqli_fetch_assoc($result))
    {
        $data[]=$row;
    }
    return $data;
}

include 'partials/_dbconnect.php';
if(!isset($_GET['id']))
{
    header('location: index.php');
}
else
{
    
    $product_id=mysqli_real_escape_string($conn,$_GET['id']);
	if($product_id>0)
    {
		$get_product=get_product($conn,'','',$product_id);
	}
    else
    {
        header('location: index.php');
	}

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $size = $_POST['size'];
        $quantity = $_POST['quantity'];

        $existSql = "select * from cart where PRODUCT_ID = '$product_id' and SIZE = '$size'";
        $result = mysqli_query($conn,$existSql);
        $num = mysqli_num_rows($result);

        if($num == 0)
        {
            $sql = "insert into cart values('$product_id',0,'$size', $quantity)";
            $result = mysqli_query($conn,$sql);

            if($result)
            {
                $success = true;
            }
            else
            {
                $error = "Something went wrong. Please try again.";
            }
        }
        else
        {
            $error = "This item already exist in your cart.";
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://use.fontawesome.com/c621d4c42a.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" integrity="sha384-ejwKkLla8gPP8t2u0eQyL0Q/4ItcnyveF505U0NIobD/SMsNyXrLti6CWaD0L52l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" integrity="sha384-jLKHWM3JRmfMU0A5x5AkjWkw/EYfGUAGagvnfryNV3F9VqM98XiIH7VBGVoxVSc7" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather&family=Montserrat&family=Poppins:wght@300;400;500;600;700&family=Sacramento&display=swap" rel="stylesheet">
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
            <?php 
            
            if($success)
            {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Your item has been added to the cart.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
            }
            if($error)
            {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error! </strong>'.$error.'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
            
            ?>
        </div>
    </div>

    <!------single product detail-------->
    <div class="small-container single-product">
        <div class="row">
            <?php 
            
            $get_product = get_product($conn,1,'',$_GET['id']);
            $product_id = $_GET['id'];
            
            foreach($get_product as $item)
            {
                echo '<div class="col-2">
                <img src="'.$item['IMAGE1'].'" alt="" width="100%" id="product-img">
                <div class="small-img-row mt-1">
                    <div class="small-img-col"><img src="'.$item['IMAGE1'].'" width="100%" class="small-img"></div>
                    <div class="small-img-col"><img src="'.$item['IMAGE2'].'" width="100%" class="small-img"></div>
                    <div class="small-img-col"><img src="'.$item['IMAGE3'].'" width="100%" class="small-img"></div>
                </div>
                </div>
                <div class="col-2">
                
                <h1>'.$item['PRODUCT_NAME'].'</h1>
                <h4>$69.69</h4>
                <form action="/dbms/product-detail.php?id='.$item['PRODUCT_ID'].'" method="POST">
                <select name="size" id="size">
                    <option value="">Select Size</option>
                    <option value="XXL">XXL</option>
                    <option value="XL">XL</option>
                    <option value="L">Large</option>
                    <option value="M">Medium</option>
                    <option value="S">Small</option>
                </select>
                <input type="number" value="1" min="1" name="quantity" id="quantity">
                <button type="submit" class="btn">Add To Cart</button>
                </form>
                <h3>Product Detail <i class="fa fa-indent"></i></h3>
                <br>
                <p>'.$item['PRODUCT_DESC'].'</p>

            </div>';
            }
            
            ?>
        </div>
    </div>
    <!------------featured products------------->
    <div class="small-container">
        <h4 class="mt-4">Other products you might like</h4>
        <div class="row">
            <div class="col-4">
                <img src="images/product-1.jpg" alt="">
                <h4>Red Printed T-shirt</h4>
                <div class="rating">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star-o" aria-hidden="true"></i>
                </div>
                <p>$50.00</p>
            </div>
            <div class="col-4">
                <img src="images/product-2.jpg" alt="">
                <h4>Red Printed T-shirt</h4>
                <div class="rating">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star-o" aria-hidden="true"></i>
                </div>
                <p>$50.00</p>
            </div>
            <div class="col-4">
                <img src="images/product-3.jpg" alt="">
                <h4>Red Printed T-shirt</h4>
                <div class="rating">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star-o" aria-hidden="true"></i>
                </div>
                <p>$50.00</p>
            </div>
            <div class="col-4">
                <img src="images/product-4.jpg" alt="">
                <h4>Red Printed T-shirt</h4>
                <div class="rating">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star-o" aria-hidden="true"></i>
                </div>
                <p>$50.00</p>    
            </div>
        </div>
        <!------Add More Products Here-------->
    </div> 
<!-------footer---------->
    <?php require 'partials/_footer.php' ?>
    
    <script src="product-detail.js"></script>


</body>
</html>