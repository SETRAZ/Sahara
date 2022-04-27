<?php 

if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true)
{
  $login = true;
}
else
{
  $login = false;
}

function get_category($conn,$limit='',$cat_id=''){
  $sql="select * from category where CAT_NAME IS NOT NULL";
  if($cat_id!=''){
      $sql.=" and CAT_ID=$cat_id ";
  }
  $sql.=" order by CAT_ID desc";
  if($limit!=''){
      $sql.=" limit $limit";
  }
  
  $result=mysqli_query($conn,$sql);
  $data=array();
  while($row=mysqli_fetch_assoc($result)){
      $data[]=$row;
  }
  return $data;
}

echo '<div class="navbar header">
<div class="logo">
    <img src="images/sahra_logo.png" alt="logo of webseite" width="125px">

</div>
<nav class="mt-3">
    <ul>
      <li ><a href="/dbms/index.php">Home</a></li>
      <li><a href="/dbms/product.html">Search</a></li>
      <li><a href="">About</a></li>
      <li><a href="/dbms/cart.php">Cart</a></li>';

      
      
    
      if(!$login)
      {echo '<li><a href="/dbms/login.php">Login</a></li>
      <li><a href="/dbms/signup.php">Signup</a></li>';}
      
      if($login)
      {
        echo '<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Categories
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
          $get_category = get_category($conn);
          foreach($get_category as $item)
          {
            echo '<li><a class="dropdown-item" href="product.php?id='.$item['CAT_ID'].'">'.$item['CAT_NAME'].'</a></li>';
          }

        echo '</ul>
        </li>';
        echo '<li><a href="/dbms/logout.php">Logout</a></li>';
      }

    
    echo '</ul>
</nav>
<img src="images/cart.png" width="30px" height="30px" alt="cart logo">
<img src="images/menu.png" alt="" class="menu-icon">
</div>';

?>