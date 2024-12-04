<?php
// Include necessary files for database connection
include_once '../config/config.php';
include_once '../lib/Database.php';

// Initialize the database connection
$db = new Database();

// Check if the page ID is provided
if (isset($_GET['id'])) {
    $page_id = $_GET['id'];

    // Query to delete the page from the database
    $delete_query = "DELETE FROM tbl_pages WHERE id = '$page_id'";

    // Execute the delete
    $delete_result = $db->delete($delete_query);

    // Check if deletion was successful
    if ($delete_result) {
        header('Location: page_list.php?msg=Page deleted successfully');
    } else {
        header('Location: page_list.php?msg=Error deleting page');
    }
} else {
    // If no ID is provided, redirect to the page list
    header('Location: page_list.php');
}
?>
