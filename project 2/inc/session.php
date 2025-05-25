<?php
// Yeh check karta hai ki agar session abhi start nahi hua hai (PHP_SESSION_NONE), tabhi session_start(); chalaya jaye. 
// Isse multiple baar session start hone ki error nahi aayegi.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}



if (!isset($_SESSION['status']) || $_SESSION['status'] == 0) { //  Yeh check karta hai ki session me status set hai ya nahi.Agar $_SESSION['status'] set nahi hai ya 0 hai, toh iska matlab user logged in nahi hai
    header('Location: index.php');     //Aise me user ko index.php (login page) pe redirect kar dega.
    exit();   //exit(); lagane ka reason hai ki script yahin pe ruk jaye, warna unnecessary code execute hoga.


}


$user_id = $_SESSION['user_id'];   // Jab user login ho jata hai, toh uska user_id session me store hota hai.
?>
