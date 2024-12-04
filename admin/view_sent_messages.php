<?php 
include 'inc/header.php';
include 'inc/sidebar.php';

// Initialize database connection
$db = new Database();

// Fetch the message and replies
if (isset($_GET['id'])) {
    $message_id = $_GET['id'];
    $query = "SELECT * FROM messages WHERE id = $message_id";
    $message = $db->select($query)->fetch_assoc();

    if (!$message) {
        echo "Message not found.";
        exit;
    }

    // Fetch replies to this message
    $query = "SELECT * FROM replies WHERE message_id = $message_id ORDER BY created_at DESC";
    $replies = $db->select($query);
}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Message Details</h2>
        <div class="block">
            <h4><strong>Original Message:</strong></h4>
            <p><?php echo nl2br(htmlspecialchars($message['message'])); ?></p>

            <h4><strong>Replies:</strong></h4>
            <?php
            if ($replies) {
                while ($reply = $replies->fetch_assoc()) {
                    echo "<div class='reply'>";
                    echo "<p><strong>Reply:</strong> " . nl2br(htmlspecialchars($reply['reply_content'])) . "</p>";
                    echo "<p><em>Replied on: " . $reply['created_at'] . "</em></p>";
                    echo "</div><br>";
                }
            } else {
                echo "<p>No replies yet.</p>";
            }
            ?>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
