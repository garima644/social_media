<?php
session_start();
if ( isset( $_SESSION['status'] ) ) {
  if ( $_SESSION['status'] == 1 ) {
    header('location:home.php');
  }
}
require_once 'inc/header.php' ;
?>


<form class="container myform" action="backend/signup_process.php" method="POST">
    <h1>Signup</h1>
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
    <button type="submit" class="btn btn-success">Signup</button>
    <span>Already a user ? <a href="index.php" class="btn btn-primary">Login</a></span>
  </div>
</form>



<?php
require_once 'inc/footer.php' ;
?>