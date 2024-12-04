<?php include 'assignment1/header.php'; ?>
<?php include 'assignment1/slider.php'; ?>

<?php 
$db = new Database();
$fm = new format();
?>

<div class="contentsection contemplete clear">
    <div class="maincontent clear">
        <!-- Pagination setup -->
        <?php
        $per_page = 3;
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $start_from = ($page - 1) * $per_page;

        // Check if a category is selected
        $categoryFilter = isset($_GET['category']) ? intval($_GET['category']) : null;

        if ($categoryFilter) {
            $query = "SELECT * FROM tbl_post WHERE cat='$categoryFilter' LIMIT $start_from, $per_page";
        } else {
            $query = "SELECT * FROM tbl_post LIMIT $start_from, $per_page";
        }

        $post = $db->select($query);
        ?>

        <?php 
        if ($post) {
            while ($result = $post->fetch_assoc()) { 
        ?>

            <div class="samepost clear">
                <!-- Post Title -->
                <h2><a href="post.php?id=<?php echo $result['id']; ?>">
                <?php echo $result['title']; ?></a></h2>

                <!-- Post Meta Info -->
                <h4><?php echo $fm->formatDate($result['date']); ?>, By <a href="#"><?php echo $result['author']; ?></a></h4>

                <!-- Post Image -->
                <a href="post.php?id=<?php echo $result['id']; ?>">
                    <img src="admin/<?php echo $result['image']; ?>" alt="post image" />
                </a>

                <!-- Post Excerpt -->
                <?php echo $fm->textShorten($result['body'], 100); ?>

                <div class="readmore clear">
                    <a href="post.php?id=<?php echo $result['id']; ?>">Read More</a>
                </div>
            </div>

        <?php 
            } 
        ?>

        <!-- Pagination -->
        <?php
        if ($categoryFilter) {
            $query = "SELECT * FROM tbl_post WHERE cat='$categoryFilter'";
        } else {
            $query = "SELECT * FROM tbl_post";
        }

        $result = $db->select($query);
        $total_rows = mysqli_num_rows($result);
        $total_pages = ceil($total_rows / $per_page);

        echo "<span class='pagination'><a href='index.php?page=1" . ($categoryFilter ? "&category=$categoryFilter" : "") . "'>First Page</a>";

        for ($i = 1; $i <= $total_pages; $i++) {
            echo "<a href='index.php?page=$i" . ($categoryFilter ? "&category=$categoryFilter" : "") . "'>$i</a>";
        }

        echo "<a href='index.php?page=$total_pages" . ($categoryFilter ? "&category=$categoryFilter" : "") . "'>Last Page</a></span>";
        ?>

        <?php 
        } else { 
            echo "<p>No posts found.</p>";
        } 
        ?>
    </div>

    <!-- Sidebar -->
    <?php include 'assignment1/sidebar.php'; ?>
</div>

<?php include 'assignment1/footer.php'; ?> 