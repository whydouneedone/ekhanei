<?php
include '../config/config.php';
include '../lib/Database.php'; // Database connection

// Initialize database connection
$db = new Database();

if (isset($_GET['id'])) {
    $message_id = $_GET['id'];

    // Fetch the message to which the admin is replying
    $query = "SELECT * FROM messages WHERE id = $message_id";
    $message = $db->select($query)->fetch_assoc();

    if (!$message) {
        echo "Message not found.";
        exit;
    }
}

// Handle reply submission
if (isset($_POST['submit_reply'])) {
    $reply_content = $_POST['reply_message'];
    $sender_name = 'Admin'; // The admin sends the reply
    $sender_id = 1; // Admin's sender_id (set to 1 or another valid ID)
    $receiver_id = $message['sender_id']; // The receiver is the original sender of the message

    // Insert the reply into the replies table
    $query = "INSERT INTO replies (message_id, sender_id, sender_name, reply_content, created_at) 
              VALUES ($message_id, $sender_id, '$sender_name', '$reply_content', NOW())";
    $db->select($query);

    echo "Reply sent successfully!";
    header("Location: inbox.php"); // Redirect to inbox after replying
    exit;
}
?>

<!-- HTML for reply form (can be placed in reply_message.php) -->
<form action="" method="POST">
    <textarea name="reply_message" rows="6" cols="50" required></textarea><br>
    <input type="submit" name="submit_reply" value="Send Reply" />
</form>
