<?php
include 'inc/header.php';
include 'inc/sidebar.php';
include '../lib/Database.php'; // Include Database connection

// Initialize the Database connection
$db = new Database();

if (isset($_GET['id'])) {
    $message_id = $_GET['id'];

    // Fetch the full message from the database
    $query = "SELECT * FROM messages WHERE id = $message_id";
    $message = $db->select($query)->fetch_assoc();

    if ($message) {
        // Check if 'sender_name' exists in the message array
        $sender_name = isset($message['sender_name']) ? htmlspecialchars($message['sender_name']) : 'Unknown Sender';

        // Mark the message as 'seen' once it's viewed
        $update_query = "UPDATE messages SET status = 'seen' WHERE id = $message_id";
        $db->select($update_query);

        // Display the full message
        echo "<h2>" . htmlspecialchars($message['subject']) . "</h2>";
        echo "<p>" . nl2br(htmlspecialchars($message['message'])) . "</p>";
        echo "<p><strong>From:</strong> " . $sender_name . "</p>";
    } else {
        echo "Message not found.";
    }
} else {
    echo "Invalid message ID.";
}

include 'inc/footer.php';
?>
