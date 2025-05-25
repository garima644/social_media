<?php
session_start();
require_once 'inc/connection.php';
require_once 'inc/header.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch logged-in user's name
$user_query = $con->query("SELECT username FROM users WHERE id = '$user_id'");    
$user_data = $user_query->fetch_assoc();
$username = $user_data['username'] ?? 'Unknown User';

// Handle Friend Requests
// $_SERVER["REQUEST_METHOD"] == "POST" – Iska matlab hai ki jab bhi user koi button click karega (Add Friend, Accept, Reject), tabhi yeh code chalega.
// $friend_id = $_POST['friend_id']; – Yeh friend_id fetch karega , jo jis user par action lena hai uska ID hota hai.

if ($_SERVER["REQUEST_METHOD"] == "POST") {            
    $friend_id = $_POST['friend_id'];

    // Jab user "Add Friend" button par click krega , tab POST request jayega.
    // user_id – Jo user request bhej raha hai.
    // friend_id – Jisko request mili hai.status – 'pending' (kyunki abhi request accept nahi hui).

    if (isset($_POST['send_request'])) {
        $con->query("INSERT INTO friends (user_id, friend_id, status) VALUES ($user_id, $friend_id, 'pending')");
        // Friend Request Accept Karna.Jab "Accept" button par click hoga, to status "accepted" me update hojayega.
    } elseif (isset($_POST['accept'])) {
        $con->query("UPDATE friends SET status = 'accepted' WHERE user_id = $friend_id AND friend_id = $user_id");
        // Friend Request Reject Karna.Jab "Reject" button par click hoa, to us request ko database se delete kar dega.
    } elseif (isset($_POST['reject'])) {
        $con->query("DELETE FROM friends WHERE user_id = $friend_id AND friend_id = $user_id");
    }
}

// Fetch Friend Requests list
$requests = $con->query("SELECT users.id, users.username FROM friends 
                          JOIN users ON friends.user_id = users.id 
                          WHERE friends.friend_id = $user_id AND friends.status = 'pending'");

// Fetch Accepted Friends list
$friends = $con->query("SELECT users.id, users.username FROM friends 
                         JOIN users ON (friends.user_id = users.id OR friends.friend_id = users.id) 
                         WHERE (friends.user_id = $user_id OR friends.friend_id = $user_id) 
                         AND friends.status = 'accepted' AND users.id != $user_id");

// Fetch Users to Send Requests list
$all_users = $con->query("SELECT id, username FROM users 
                           WHERE id != $user_id 
                           AND id NOT IN (SELECT friend_id FROM friends WHERE user_id = $user_id)
                           AND id NOT IN (SELECT user_id FROM friends WHERE friend_id = $user_id)");
?>

<div class="friends-container">
    <div class="friends-header">
        <strong><em><?php echo htmlspecialchars($username); ?></em></strong>
        <div class="friends-actions">
            <a href="index.php"><button class="btn btn-secondary">Home</button></a>
            <a href="friends.php"><button class="btn btn-secondary">Friends</button></a>
            <a href="backend/logout_process.php"><button class="btn btn-danger">Logout</button></a>
        </div>
    </div>

    <div class="friends-content">
        <!-- Friend Requests -->
        <div class="section">
            <h3>Friend Requests</h3>
            <!--  Yeh section pending friend requests ko display karega. -->
            <?php while ($row = $requests->fetch_assoc()) { ?>
                <div class="user-row">
                    <span><?php echo htmlspecialchars($row['username']); ?></span>
                    <form method="post">
                        <input type="hidden" name="friend_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="accept" class="btn-yes">Accept</button>
                        <button type="submit" name="reject" class="btn-no">Reject</button>
                    </form>
                </div>
            <?php } ?>
        </div>

        <!-- Friends List -->
        <div class="section">
            <h3>Friends</h3>
            <!-- Yeh section accepted friends list ko display karega.
                    Loop me har friend ka username dikhega. -->
            <?php while ($row = $friends->fetch_assoc()) { ?>
                <div class="user-row">
                    <span><?php echo htmlspecialchars($row['username']); ?></span>
                </div>
            <?php } ?>
        </div>

        <!-- All Users to Send Requests -->
        <div class="section">
            <h3>All Users</h3>
            <?php while ($row = $all_users->fetch_assoc()) { ?>
                <div class="user-row">
                    <span><?php echo htmlspecialchars($row['username']); ?></span>
                    <form method="post">
                        <input type="hidden" name="friend_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="send_request" class="btn-add">Add Friend</button>
                    </form>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php require_once 'inc/footer.php'; ?>
