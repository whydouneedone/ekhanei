<?php 
include 'config/config.php';
include 'lib/Database.php';
include 'helpers/format.php';

// Create database and format instances
$db = new Database();
// $fm = new format();

// Ensure 'id' is passed via URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);  // Ensure it's an integer to prevent SQL injection

    // Fetch the page details from the database
    $query = "SELECT * FROM tbl_pages WHERE id = $id";
    echo $query;
    $result = $db->select($query);

    // Check if the page exists
    if ($result) {
        $page = $result->fetch_assoc();
    } else {
        // If the page is not found, display an error message
        echo "<h2>Page Not Found</h2>";
        include 'assignment1/footer.php';
        exit();
    }
} else {
    // If no id is provided, redirect to the homepage
    echo "<h2>No page ID provided!</h2>";
    include 'footer.php';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="language" content="English">
    <meta name="description" content="Page Content">
    <meta name="keywords" content="blog,cms blog">
    <meta name="author" content="samira">
    <title><?php echo $page['title']; ?></title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include 'assignment1/header.php'; ?>

    <div class="contentsection contemplete clear">
        <div class="maincontent clear">
            <h2><?php echo $page['title']; ?></h2>
            <p><?php echo $page['content']; ?></p>
        </div>
    </div>

    <?php include 'footer.php'; ?>

</body>
</html>
