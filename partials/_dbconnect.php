<?php 

$servername = "localhost";
$username = "root";
$password = "Mufaddal@24";
$database = "website";

$conn = mysqli_connect($servername, $username, $password, $database);

if(!$conn)
{
    die("Error".mysqli_connect_error());
}

?>