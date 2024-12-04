<?php 
include 'inc/header.php';
include 'inc/sidebar.php';

// Get the message ID from the URL
$id = $_GET['id'];

// Initialize database connection
$db = new Database();

// Delete the message from the database
$query = "DELETE FROM messages WHERE id = $id";
$delete = $db->delete($query);

if ($delete) {
    header("Location: sent_messages.php");  // Redirect back to sent messages page
    exit();
} else {
    echo "Error deleting message!";
}
?>

<?php include 'inc/footer.php'; ?>
