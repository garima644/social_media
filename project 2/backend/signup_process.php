<?php
require_once '../inc/connection.php' ;

$user = $_REQUEST['username'] ;
$pass = $_REQUEST['password'] ;


$sql = "INSERT INTO `users` ( `username` , `password` ) VALUES ( '$user' , '$pass' )" ;
$res = mysqli_query( $con , $sql ) ;

if ( $res ) {
    header('location:../index.php');
} else {
    header('location:../signup.php?msg=error !!! try again') ;
}

?>