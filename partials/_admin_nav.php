<?php 

if(isset($_SESSION['logged']) && $_SESSION['logged'] == true)
{
  $adminlogin = true;
}
else
{
  $adminlogin = false;
}

echo '<div class="navbar header">
<div class="logo">
    <img src="images/sahra_logo.png" alt="logo of webseite" width="125px">

</div>
<nav class="mt-3">
    <ul>
      <li ><a href="/dbms/index.php">Home</a></li>';

      
      
    
      if(!$adminlogin)
      {echo '<li><a href="/dbms/admin_login.php">Login</a></li>';}
      
      if($adminlogin)
      {
        echo '<li><a href="/dbms/admin_logout.php">Logout</a></li>';
      }

    
    echo '</ul>
</nav>
<img src="images/cart.png" width="30px" height="30px" alt="cart logo">
<img src="images/menu.png" alt="" class="menu-icon">
</div>';

?>