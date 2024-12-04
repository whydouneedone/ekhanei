<?php 
include 'inc/header.php';
include 'inc/sidebar.php';
include '../lib/Database.php'; // Ensure Database is included

$db = new Database();

// Fetch unread messages count for notification
$query = "SELECT COUNT(*) AS unread_count FROM messages WHERE status = 'unread'";
$unread_messages = $db->select($query)->fetch_assoc();
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Inbox</h2>
        <div class="block">
            <!-- Notification for Unread Messages -->
            <?php if ($unread_messages['unread_count'] > 0): ?>
                <div class="notification">
                    <p>You have <?php echo $unread_messages['unread_count']; ?> new unread message(s).</p>
                </div>
            <?php else: ?>
                <div class="notification">
                    <p>No new unread messages.</p>
                </div>
            <?php endif; ?>

            <table class="data display datatable" id="example">
                <thead>
                    <tr>
                        <th>Serial No.</th>
                        <th>Sender</th>
                        <th>Message</th>
                        <th>Status</th> <!-- Added column for status -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM messages ORDER BY created_at DESC";
                    $messages = $db->select($query);
                    
                    if ($messages) {
                        $i = 1;
                        while ($message = $messages->fetch_assoc()) {
                            // Determine if message is unread or read
                            $status_class = ($message['status'] == 'unread') ? 'class="unread"' : 'class="read"';
                            $status_text = ($message['status'] == 'unread') ? 'Unread' : 'Read';
                    ?>
                        <tr <?php echo $status_class; ?>>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $message['sender_name']; ?></td>
                            <td><?php echo substr($message['message'], 0, 50); ?>...</td>
                            <td><?php echo $status_text; ?></td> <!-- Display message status -->
                            <td>
                                <a href="view_message.php?id=<?php echo $message['id']; ?>">View</a> || 
                                <a href="reply_message.php?id=<?php echo $message['id']; ?>">Reply</a> || 
                                <a href="delete_sent_message.php?id=<?php echo $message['id']; ?>" onclick="return confirm('Are you sure you want to delete this message?')">Delete</a>
                            </td>
                        </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='5'>No messages found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
    setupLeftMenu();
    $('.datatable').dataTable();
    setSidebarHeight();
});
</script>

<?php include 'inc/footer.php'; ?>

<style>
/* Unread message styling */
.unread {
    background-color: #f1f1f1; /* Light grey for unread */
    font-weight: bold;
}

/* Read message styling */
.read {
    background-color: #ffffff; /* White for read messages */
}

/* Notification styling */
.notification {
    background-color: #f9c74f;
    color: #333;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 5px;
}
</style>
