<?php 
include 'inc/header.php';
include 'inc/sidebar.php';

// Initialize database connection
$db = new Database();

// Assume the logged-in user's ID is stored in the session (e.g., $_SESSION['user_id'])
$sender_id = $_SESSION['user_id']; 

// Fetch sent messages from the database
$query = "SELECT * FROM messages WHERE sender_id = $sender_id ORDER BY created_at DESC";
$sent_messages = $db->select($query);
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Sent Messages</h2>
        <div class="block">        
            <table class="data display datatable" id="example">
                <thead>
                    <tr>
                        <th>Serial No.</th>
                        <th>Receiver</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($sent_messages) {
                        $i = 1;
                        while ($message = $sent_messages->fetch_assoc()) {
                            // Fetch the receiver's name (assuming there's a users table)
                            $receiver_id = $message['receiver_id'];
                            $receiver_query = "SELECT username FROM users WHERE id = $receiver_id";
                            $receiver_result = $db->select($receiver_query);
                            $receiver = $receiver_result ? $receiver_result->fetch_assoc()['username'] : 'Unknown';

                            // Display the message details
                    ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $receiver; ?></td>
                            <td><?php echo $message['subject']; ?></td>
                            <td><?php echo substr($message['message'], 0, 50); ?>...</td>
                            <td>
                                <a href="view_sent_message.php?id=<?php echo $message['id']; ?>">View</a> || 
                                <a href="delete_sent_message.php?id=<?php echo $message['id']; ?>" onclick="return confirm('Are you sure you want to delete this message?')">Delete</a>
                            </td>
                        </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='5'>No sent messages found.</td></tr>";
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
