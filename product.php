<?php 

session_start();

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
// else
// {
    
//     $product_id=mysqli_real_escape_string($conn,$_GET['id']);
// 	if($product_id>0)
//     {
// 		$get_product=get_product($conn,'','',$product_id);
// 	}
//     else
//     {
//         header('location: index.php');
// 	}
// }

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
    <title>All Products-Sahara Ecommerce</title>
</head>
<body>
    <div class="header">
        <div class="container">
            <?php require 'partials/_nav.php' ?>
        </div>
    </div>
    <!------------featured products------------->
    <div class="small-container">
        <div class="row row-2">
            <h2>All Products</h2>
        </div>
        <div class="row">
            <?php 
            
            $get_product = get_product($conn,'',$_GET['id']);
            $id = $_GET['id'];
            $sql = "select * from product natural join category where product.CAT_ID = '$id'";
            $result = mysqli_query($conn,$sql);
            $num = mysqli_num_rows($result);

            if($num == 0)
            {
                echo '<h4 class="ms-4" style="margin-bottom:100px">No items exist in this category</h4>';
            }
            else
            {
                foreach($get_product as $item)
                {
                    echo '<div class="col-4">
                    <a href="product-detail.php?id='.$item['PRODUCT_ID'].'"><img src="'.$item['IMAGE1'].'" alt=""></a>
                    <h4><a href="product-detail.php?id='.$item['PRODUCT_ID'].'">'.$item['PRODUCT_NAME'].'</a></h4>
                    <div class="rating">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star-o" aria-hidden="true"></i>
                    </div>
                    <p>$50.00</p>
                    </div>';
                }
            }
            
            
            ?>
            
        </div>
        <!------Add More Products Here-------->
        
        
    </div> 
<!-------footer---------->
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="footer-col-1">
                    <h3>Download our App</h3>
                    <p>Download our App for Android and ios moblie phone</p>
                    <div class="app-logo">
                        <img src="images/app-store.png" alt="">
                        <img src="images/play-store.png" alt="">
                    </div>
                </div>
                <div class="footer-col-2">
                    <img src="images/logo-white.png" alt="">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum cupiditate necessitatibus unde soluta beatae?</p>
                </div>
                <div class="footer-col-3">
                    <h3>Useful Links</h3>
                    <ul>
                        <li>Coupns</li>
                        <li>Blog Post</li>
                        <li>Return Policy</li>
                        <li>Join Affiliate</li>
                    </ul>
                </div>
                <div class="footer-col-4">
                    <h3>Follow Us</h3>
                    <ul>
                        <li>Facebook</li>
                        <li>Twitter</li>
                        <li>Instagram</li>
                        <li>YouTube</li>
                    </ul>
                </div>
            </div>
            <hr>
            <p class="copyright">Copyright @2020</p>
        </div>
    </div>


</body>
</html>