<?php
session_start();
require_once '../inc/session.php';
require_once '../inc/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $content = trim(mysqli_real_escape_string($con, $_POST['update_text']));

    if (!empty($content)) {
        $query = "INSERT INTO posts (user_id, content, created_at) VALUES ('$user_id', '$content', NOW())";
        if (mysqli_query($con, $query)) {
            
            header("Location: ../home.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($con);
        }
    } else {
        echo "Post content cannot be empty.";
    }
}
?>
