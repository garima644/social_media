<?php
session_start();
require_once 'inc/session.php';
require_once 'inc/connection.php';
require_once 'inc/header.php';

$user_id = $_SESSION['user_id'];       //current logged-in user ka ID nikale.

// Fetch logged-in user's name
$sql = "SELECT username FROM users WHERE id = '$user_id'";
$res = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($res);
$username = $row["username"];

// Fetch posts from the database
//  Post kis user ne likha hai uska naam dikhane ke liye JOIN use kiye hai.
// ORDER BY posts.created_at DESC ➝ Naye posts sabse upar dikhane ke liye descending order me sort kiye hai.

$post_query = "SELECT posts.content, users.username, posts.created_at 
               FROM posts 
               JOIN users ON posts.user_id = users.id                         
               ORDER BY posts.created_at DESC";
$post_result = mysqli_query($con, $post_query);
?>

<div class="profile-container">
    <div class="profile-header">
        <strong>Welcome <?php echo htmlspecialchars($username); ?></strong>
        <div class="profile-actions">
        <a href="friends.php"><button class="btn btn-secondary">Friends</button></a>
            <a href="backend/logout_process.php" class="btn-danger">Logout</a>
        </div>
    </div>

    <div class="updates-section">
        <h3>Updates</h3>
        <div class="updates-list">
            <?php 
            if (mysqli_num_rows($post_result) > 0) { 
                while ($post = mysqli_fetch_assoc($post_result)) { 
                    ?>
                    <div class="update-box">
                        <strong>Update from <?php echo htmlspecialchars($post['username']); ?></strong>
                        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                        <small><?php echo $post['created_at']; ?></small>
                    </div>
            <?php 
                } 
            } else {
                echo "<p>No updates found.</p>";
            }
            ?>
        </div>
    </div>

    <div class="post-update">
        <h3>Post a new update</h3>
        <form action="backend/post_update.php" method="POST">
            <textarea name="update_text" placeholder="Type your status update here..." required></textarea>
            <button type="submit">Post</button>
        </form>
    </div>
</div>

<?php require_once 'inc/footer.php'; ?>
