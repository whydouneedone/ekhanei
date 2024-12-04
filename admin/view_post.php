<?php
include '../config/config.php'; // Include the configuration file for database connection
include '../lib/Database.php'; // Include the Database class for handling database operations

$db = new Database();

// Assume you're passing the post ID via the URL (e.g., view_post.php?id=1)
$post_id = $_GET['id'];

// Fetch post details including meta keywords and description
$query = "SELECT title, body, meta_keywords, meta_description FROM tbl_post WHERE id = $post_id";
$post = $db->select($query)->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Title for the page -->
    <title><?php echo htmlspecialchars($post['title']); ?></title>

    <!-- Meta Tags for SEO -->
    <meta name="description" content="<?php echo htmlspecialchars($post['meta_description']); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($post['meta_keywords']); ?>">

    <!-- Add additional meta tags as needed -->
</head>
<body>
    <h1><?php echo htmlspecialchars($post['title']); ?></h1>
    <div class="content">
        <?php echo nl2br(htmlspecialchars($post['body'])); ?>
    </div>
</body>
</html>
