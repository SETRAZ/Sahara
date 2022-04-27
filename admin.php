<?php 

session_start();
$add = false;
$showError = false;

if(!isset($_SESSION['logged']) || $_SESSION['logged'] != true)
{
    header("location: admin_login.php");
    exit;
}
else
{
    include 'partials/_dbconnect.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {

        if(isset($_POST['addCat']))
        {
            $catId = $_POST['catID'];
            $catName = $_POST['catName'];
            $catDesc = $_POST['catDesc'];
            $admin_email = $_SESSION['adminemail'];

            $existSql = "SELECT * FROM `category` WHERE `CAT_ID` = '$catId'";
            $result = mysqli_query($conn, $existSql);
            $num = mysqli_num_rows($result);
            
            if($num == 0)
            {
                $sql = "INSERT INTO `category` VALUES ('$catId', '$catName', '$catDesc', '$admin_email')";
                $result = mysqli_query($conn, $sql);

                if($result)
                {
                    $add = 'A new Category has been added successfully.';
                }
                else
                {
                    $showError = 'Something went wrong! Please try again.';
                }
            }
            else
            {
                $showError = 'This Category already exists.';
            }
        }
        else if(isset($_POST['addProduct']))
        {
            $productId = $_POST['productId'];
            $productName = $_POST['productName'];
            $existingCatId = $_POST['existingCatId'];
            $productDesc = $_POST['productDesc'];
            $image1 = $_POST['image1'];
            $image2 = $_POST['image2'];
            $image3 = $_POST['image3'];

            $existSql = "SELECT * FROM `product` WHERE `PRODUCT_ID` = '$productId'";
            $result = mysqli_query($conn, $existSql);
            $num = mysqli_num_rows($result);
            
            if($num == 0)
            {
                $sql = "INSERT INTO `product` VALUES ('$productId', '$productName', '$productDesc', '$image1', '$image2', '$image3', '$existingCatId')";
                $result = mysqli_query($conn, $sql);

                if($result)
                {
                    $add = 'A new Product has been added successfully.';
                }
                else
                {
                    $showError = 'Something went wrong! Please try again.';
                }
            }
            else
            {
                $showError = 'This Product already exists.';
            }
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
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <title>Document</title>
</head>

<body>
    <?php require 'partials/_admin_nav.php' ?>
    <?php 
    
    if($add)
    {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success! </strong>'.$add.' 
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
        <div class="container d-flex flex-row">
            <div class="container mt-4">
                <h2 class="mb-3">Add a Category</h2>
                <form action="admin.php" method="POST">
                    <div class="mb-3">
                        <label for="catID" class="form-label ms-3">Category ID</label>
                        <input type="text" class="form-control rounded-pill" id="catID" name="catID"
                            aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-3">
                        <label for="catName" class="form-label ms-3">Category Name</label>
                        <input type="text" class="form-control rounded-pill" id="catName" name="catName"
                            aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-3">
                        <label for="catDesc" class="form-label ms-3">Add a Description</label>
                        <textarea name="catDesc" id="catDesc" cols="30" rows="10"
                            class="form-control rounded"></textarea>
                    </div>
                    <button type="submit" name="addCat" id="addCat" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="container mt-4">
                <h2 class="mb-3">Add a Product</h2>
                <form action="admin.php" method="POST">
                    <div class="mb-3">
                        <label for="productId" class="form-label ms-3">Product ID</label>
                        <input type="email" class="form-control rounded-pill" id="productId" name="productId"
                            aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-3">
                        <label for="productName" class="form-label ms-3">Product Name</label>
                        <input type="email" class="form-control rounded-pill" id="productName" name="productName"
                            aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-3">
                        <label for="existingCatId" class="form-label ms-3">Category ID</label>
                        <select class="form-select rounded-pill" name="existingCatId" id="existingCatId" aria-label="Default select example">
                             <?php 
                            
                            $sql = "select * from category";
                            $result = mysqli_query($conn, $sql);
                            $num = mysqli_num_rows($result);
                            echo $num;
                            
                            echo '<option selected>Select a category</option>';
                            while($row = mysqli_fetch_assoc($result))
                            {
                                echo '<option value="'.$row['CAT_ID'].'">'.$row['CAT_ID'].'</option>';
                            }
                            
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="productDesc" class="form-label ms-3">Add a Description</label>
                        <textarea name="productDesc" id="productDesc" cols="30" rows="10"
                            class="form-control rounded"></textarea>
                    </div>
                    <h3>Add some Product Images:</h3>
                    <div class="mb-3">
                        <label for="image1" class="form-label ms-3">Image 1</label>
                        <input type="email" class="form-control rounded-pill" id="image1" name="image1"
                            aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-3">
                        <label for="image2" class="form-label ms-3">Image 2</label>
                        <input type="email" class="form-control rounded-pill" id="image2" name="image2"
                            aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-3">
                        <label for="image3" class="form-label ms-3">Image 3</label>
                        <input type="password" class="form-control rounded-pill" id="image3" name="image3" aria-describedby="emailHelp" required>
                    </div>
                    <button type="submit" name="addProduct" id="addProduct" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <div class="container my-4 py-2 header">
        <h2 class="mt-3">List of Orders</h2>
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">Sno</th>
                    <th scope="col">Order ID</th>
                    <th scope="col">Product ID</th>
                    <th scope="col">User Email</th>
                    <th scope="col">Street</th>
                    <th scope="col">City</th>
                    <th scope="col">Zipcode</th>
                </tr>
            </thead>
            <tbody>
                <?php 
          
                    $sql = "SELECT * FROM `cart_order` NATURAL JOIN `cart_order1`";
                    $result = mysqli_query($conn, $sql);
                    $sno = 1;

                    while($row = mysqli_fetch_assoc($result))
                    {
                        echo "<tr>
                        <th scope='row'>".$sno."</th>
                        <td>".$row['ORDER_ID']."</td>
                        <td>".$row['PRODUCT_ID']."</td>
                        <td>".$row['USER_EMAIL']."</td>
                        <td>".$row['STREET']."</td>
                        <td>".$row['CITY']."</td>
                        <td>".$row['ZIPCODE']."</td>
                        </tr>";
                        $sno += 1;
                    }
                    ?>
            </tbody>
        </table>
    </div>
    <?php require 'partials/_footer.php' ?>
    <script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</body>

</html>