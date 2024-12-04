<?php include 'assignment1/header.php'; ?>

<?php
// Check if the `id` parameter is set and valid
if (!isset($_GET['id']) || $_GET['id'] == NULL) {
    header("Location: 404.php");
} else {
    $id = intval($_GET['id']); // Sanitize `id`
}
?>
<div class="contentsection contemplete clear">
    <div class="maincontent clear">
        <div class="about">
            <?php
            // Fetch the post details
            $query = "SELECT * FROM tbl_post WHERE id=$id";
            $post = $db->select($query);

            if ($post) {
                while ($result = $post->fetch_assoc()) {
            ?>
                    <!-- Post Title -->
                    <h2><?php echo $result['title']; ?></h2>

                    <!-- Post Metadata -->
                    <h4><?php echo $fm->formatDate($result['date']); ?>, By 
                        <a href="#"><?php echo $result['author']; ?></a>
                    </h4>

                    <!-- Post Image -->
                    <img src="admin/<?php echo $result['image']; ?>" alt="post image" />

                    <!-- Post Content -->
                    <?php echo $result['body']; ?>

                    <!-- Related Articles -->
                    <div class="relatedpost clear">
                        <h2>Related Articles</h2>
                        <?php
                        // Fetch related articles based on category
                        $catid = $result['cat'];
                        $queryrelated = "SELECT * FROM tbl_post WHERE cat='$catid' AND id != $id ORDER BY rand() LIMIT 6";
                        $relatedpost = $db->select($queryrelated);

                        if ($relatedpost) {
                            while ($related = $relatedpost->fetch_assoc()) {
                        ?>
                                <a href="post.php?id=<?php echo $related['id']; ?>">
                                    <img src="admin/<?php echo $related['image']; ?>" alt="post image" />
                                </a>
                        <?php 
                            }
                        } else {
                            echo "<p>No related articles found!</p>";
                        }
                        ?>
                    </div>
            <?php 
                } // End while loop
            } else {
                echo "<p>Post not found!</p>";
            }
            ?>
        </div>
    </div>

    <!-- Sidebar -->
    <?php include 'assignment1/sidebar.php'; ?>
</div>

<?php include 'assignment1/footer.php'; ?>
