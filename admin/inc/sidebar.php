<?php
// Include the necessary files for the database connection
include_once '../config/config.php';  // For DB connection settings
include_once '../lib/Database.php';  // For Database class

// Create a new Database object to interact with DB
$db = new Database();

// Query to fetch all pages from tbl_pages
$query = "SELECT * FROM tbl_pages ORDER BY created_at DESC";
$pages = $db->select($query);

?>

<div class="grid_2">
    <div class="box sidemenu">
        <div class="block" id="section-menu">
            <ul class="section menu">
                <li>
                    <a class="menuitem">Site Option</a>
                    <ul class="submenu">
                        <li><a href="titleslogan.php">Title & Slogan</a></li>
                        <li><a href="social.php">Social Media</a></li>
                        <li><a href="copyright.php">Copyright</a></li>
                    </ul>
                </li>
                <li>
                    <a class="menuitem">Pages</a>
                    <ul class="submenu">
                        <!-- Static Link for Add New Page -->
                        <li><a href="addpage.php">Add new page</a></li>

                        <!-- Dynamically Load Pages from Database -->
                        <?php if ($pages && $pages->num_rows > 0): ?>
                            <?php while ($page = $pages->fetch_assoc()): ?>
                                <li><a href="editpage.php?id=<?php echo $page['id']; ?>"><?php echo htmlspecialchars($page['title']); ?></a></li>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <li>No pages available</li>
                        <?php endif; ?>
                    </ul>
                </li>
                <li>
                    <a class="menuitem">Category Option</a>
                    <ul class="submenu">
                        <li><a href="addcat.php">Add Category</a></li>
                        <li><a href="catlist.php">Category List</a></li>
                    </ul>
                </li>
                <li>
                    <a class="menuitem">Post Option</a>
                    <ul class="submenu">
                        <li><a href="addpost.php">Add Post</a></li>
                        <li><a href="postlist.php">Post List</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
