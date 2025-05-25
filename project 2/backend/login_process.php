<?php
session_start();
require_once '../inc/connection.php' ;

$user = $_REQUEST['username'] ;
$pass = $_REQUEST['password'] ;

$sql = "SELECT `id` , `password` FROM `users` WHERE `username` = '$user' " ;
$res = mysqli_query( $con , $sql ) ;

if ( mysqli_num_rows($res) > 0 ) {
    $row = mysqli_fetch_assoc($res) ;
    $db_pass = $row["password"];
    
    if ( $pass == $db_pass ) {
        $_SESSION["status"] = 1 ;
        $_SESSION["user_id"] = $row["id"] ;
        header('location:../home.php') ;
    } else {
        header('location:../index.php?msg=Wrong password') ;
    }

} else {
    header('location:../index.php?msg=User does not exist') ;
}

?>