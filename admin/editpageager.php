<?php
// Include necessary files for database connection
include_once '../config/config.php';
include_once '../lib/Database.php';

// Initialize the database connection
$db = new Database();

// Check if the page ID is provided
if (isset($_GET['id'])) {
    $page_id = $_GET['id'];

    // Query to fetch the page details from the database based on the ID
    $query = "SELECT * FROM tbl_pages WHERE id = '$page_id' LIMIT 1";
    $page = $db->select($query);

    // If page exists, fetch its details
    if ($page && $page->num_rows > 0) {
        $page_data = $page->fetch_assoc();
    } else {
        // If page does not exist, redirect back to page list
        header('Location: page_list.php');
        exit();
    }
} else {
    // If no ID is provided, redirect back to page list
    header('Location: page_list.php');
    exit();
}

// Process the form submission for updating the page
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Query to update the page in the database
    $update_query = "UPDATE tbl_pages SET title = '$title', content = '$content' WHERE id = '$page_id'";

    // Execute the update
    $update_result = $db->update($update_query);
    
    // Check if update was successful
    if ($update_result) {
        header('Location: page_list.php?msg=Page updated successfully');
    } else {
        $error = "Error updating page.";
    }
}
?>

<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Edit Page</h2>
        <div class="block">
            <?php if (isset($error)) { echo '<span class="error">' . $error . '</span>'; } ?>

            <form method="POST">
                <table class="form">
                    <tr>
                        <td>
                            <label>Title</label>
                        </td>
                        <td>
                            <input type="text" name="title" value="<?php echo htmlspecialchars($page_data['title']); ?>" class="large" required />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Content</label>
                        </td>
                        <td>
                            <textarea name="content" class="large" required><?php echo htmlspecialchars($page_data['content']); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="update" value="Update Page" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
