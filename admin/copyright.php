<?php
// Include necessary files
include_once '../config/config.php';   // Update path if necessary
include_once '../lib/Database.php';    // Update path if necessary
include 'inc/header.php';  // Include header for the admin panel
include 'inc/sidebar.php'; // Include sidebar for the admin panel

// Initialize database object
$db = new Database();

// Handle form submission for updating copyright text
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Get and sanitize the copyright text input
    $copyright_text = $db->link->real_escape_string($_POST['copyright']);

    // Query to update the copyright text in the tbl_footer table
    $updateQuery = "UPDATE tbl_footer SET note = '$copyright_text' WHERE id = 1";
    
    // Execute the update query
    $update_row = $db->update($updateQuery);

    // Check if the update was successful and display an alert
    if ($update_row) {
        echo "<script>alert('Copyright text updated successfully');</script>";
    } else {
        echo "<script>alert('Failed to update copyright text');</script>";
    }
}

// Fetch the current copyright text from the database
$query = "SELECT * FROM tbl_footer WHERE id = 1";
$result = $db->select($query);
$current_copyright_text = '';

if ($result) {
    $current_copyright_text = $result->fetch_assoc()['note'];
}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Update Copyright Text</h2>
        <div class="block copyblock"> 
            <!-- Form to update the copyright text -->
            <form action="copyright.php" method="post">
                <table class="form">
                    <tr>
                        <td>
                            <input type="text" placeholder="Enter Copyright Text..." name="copyright" class="large" value="<?php echo htmlspecialchars($current_copyright_text); ?>" />
                        </td>
                    </tr>
                    <tr> 
                        <td>
                            <input type="submit" name="submit" value="Update" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>  <!-- Include footer for the admin panel -->
