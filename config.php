<?php

$conn = mysqli_connect('localhost','root','','booking_hotel') or die('connection failed');


try{
    $conn = new PDO("mysql:host={localhost}; dbname={root}",'','booking_hotel');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOEXCEPTION $e){
    $e->getMessage();
}

?>