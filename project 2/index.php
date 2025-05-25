<?php
session_start();
if ( isset( $_SESSION['status'] ) ) {
  if ( $_SESSION['status'] == 1 ) {
    header('location:home.php');
  }
}
require_once 'inc/header.php' ;
?>


<form class="container myform" action="backend/login_process.php" method="POST">
    <h1>Login</h1>
    <hr>
    <?php
      if ( isset($_GET['msg']) ) {
        echo '<div class="alert alert-danger">
          '.$_GET['msg'].'
        </div>';
      }
    ?>
    
  <div class="mb-3">
    <label class="form-label">Username</label>
    <input type="text" class="form-control" name="username">
  </div>
  <div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" class="form-control" name="password">
  </div>
  <div class="btn-span">
    <button type="submit" class="btn btn-primary">Login</button>
    <span><a href="signup.php" class="btn btn-success">Register</a></span>
  </div>
</form>




<?php
require_once 'inc/footer.php' ;
?>