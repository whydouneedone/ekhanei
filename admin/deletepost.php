<?php
// Include necessary files
include_once '../lib/Database.php';  // Database connection file
include_once '../helpers/format.php';    // Corrected the file name for 'format.php'

// Include the database configuration (assuming config.php defines DB_HOST, DB_USER, etc.)
include_once '../config/config.php';  // Ensure this file exists and contains your DB constants

$db = new Database();

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $post_id = $_GET['id'];

    // Fetch the post to get the image path
    $query = "SELECT * FROM tbl_post WHERE id = '$post_id'";
    $post = $db->select($query)->fetch_assoc();

    if ($post) {
        // Delete the post image from the server (if the image exists)
        if (!empty($post['image']) && file_exists('../' . $post['image'])) {
            unlink('../' . $post['image']); // Remove the file
        }

        // Delete the post from the database
        $query = "DELETE FROM tbl_post WHERE id = '$post_id'";
        $delete_row = $db->delete($query);

        if ($delete_row) {
            echo "<script>alert('Post deleted successfully'); window.location = 'postlist.php';</script>";
        } else {
            echo "<script>alert('Post not deleted'); window.location = 'postlist.php';</script>";
        }
    } else {
        echo "<script>alert('Post not found'); window.location = 'postlist.php';</script>";
    }
} else {
    echo "<script>alert('Invalid post ID'); window.location = 'postlist.php';</script>";
}
?>
