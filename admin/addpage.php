<?php 
// Include the necessary files for database connection and header/footer
include_once '../config/config.php';
include_once '../lib/Database.php';

// Create a new Database object
$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $title = $db->link->real_escape_string($_POST['title']);
    $content = $db->link->real_escape_string($_POST['content']);

    // Query to insert the new page into the database
    $query = "INSERT INTO tbl_pages (title, content) VALUES ('$title', '$content')";
    $insertRow = $db->insert($query); // Using the insert method from Database class

    if ($insertRow) {
        // echo "<script>alert('Page added successfully');</script>";
        echo "<script>window.location = 'addpage.php';</script>"; // Redirect to page list after successful addition
    } else {
        echo "<script>alert('Failed to add page');</script>";
    }
}
?>

<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Add New Page</h2>
        <div class="block"> 
            <form action="" method="post">
                <table class="form">
                    <tr>
                        <td><label>Page Title</label></td>
                        <td><input type="text" name="title" placeholder="Enter Page Title..." class="medium" required /></td>
                    </tr>
                    <tr>
                        <td><label>Page Content</label></td>
                        <td><textarea name="content" class="medium" placeholder="Enter Page Content..." rows="10" required></textarea></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="submit" value="Add Page" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
