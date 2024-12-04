<?php
include '../config/config.php';
include '../lib/Database.php'; // Database connection

// Initialize the database connection
$db = new Database();

if (isset($_GET['id'])) {
    $message_id = $_GET['id'];

    // First, ensure the message exists and is marked as "seen"
    $query = "SELECT * FROM messages WHERE id = $message_id AND status = 'seen'";
    $message = $db->select($query)->fetch_assoc();

    if ($message) {
        // If message is found and status is 'seen', delete the message
        $delete_query = "DELETE FROM messages WHERE id = $message_id";
        $db->select($delete_query);

        echo "Message deleted successfully!";
        header("Location: inbox.php"); // Redirect back to inbox after deletion
        exit;
    } else {
        echo "Message not found or it is not marked as 'seen'.";
    }
} else {
    echo "Invalid request.";
}
?>
