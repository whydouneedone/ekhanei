<?php include 'assignment1/header.php'; ?>

<?php
// Check if the search query is set
if (isset($_GET['search'])) {
    $search = $db->link->real_escape_string($_GET['search']); // Sanitize the input
} else {
    header("Location: 404.php");
}
?>

<div class="contentsection contemplete clear">
    <div class="maincontent clear">
        <h2>Search Results for "<?php echo $search; ?>"</h2>
        <?php
        // Query to search posts by title or body
        $query = "SELECT * FROM tbl_post WHERE title LIKE '%$search%' OR body LIKE '%$search%' ORDER BY date DESC";
        $searchResults = $db->select($query);

        if ($searchResults) {
            while ($result = $searchResults->fetch_assoc()) {
        ?>
                <div class="samepost clear">
                    <h2><a href="post.php?id=<?php echo $result['id']; ?>"><?php echo $result['title']; ?></a></h2>
                    <h4><?php echo $fm->formatDate($result['date']); ?>, By <a href="#"><?php echo $result['author']; ?></a></h4>
                    <a href="post.php?id=<?php echo $result['id']; ?>">
                        <img src="admin/upload/<?php echo $result['image']; ?>" alt="post image" />
                    </a>
                    <p><?php echo $fm->textShorten($result['body'], 100); ?></p>
                    <div class="readmore clear">
                        <a href="post.php?id=<?php echo $result['id']; ?>">Read More</a>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "<p>No results found for your search query.</p>";
        }
        ?>
    </div>

    <!-- Sidebar -->
    <?php include 'assignment1/sidebar.php'; ?>
</div>

<?php include 'assignment1/footer.php'; ?>
