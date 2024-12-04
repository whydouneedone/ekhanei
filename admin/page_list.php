<?php
// Include necessary files for database connection
include_once '../config/config.php';
include_once '../lib/Database.php';

// Initialize the database connection
$db = new Database();

// Query to fetch all pages from the database
$query = "SELECT * FROM tbl_pages";
$pages = $db->select($query);

// Debugging: Check if pages are being fetched
var_dump($pages); // Remove after testing
?>

<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Page List</h2>
        <div class="block">
            <?php if ($pages): ?>
                <table class="data display datatable" id="example">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        while ($page = $pages->fetch_assoc()) {
                            $i++;
                        ?>
                            <tr class="odd gradeX">
                                <td><?php echo $i; ?></td>
                                <td><?php echo htmlspecialchars($page['title']); ?></td>
                                <td><?php echo htmlspecialchars(substr($page['content'], 0, 50)); ?>...</td>
                                <td>
                                    <a href="editpage.php?id=<?php echo $page['id']; ?>">Edit</a> | 
                                    <a href="deletepage.php?id=<?php echo $page['id']; ?>" onclick="return confirm('Are you sure you want to delete this page?');">Delete</a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No pages found in the database.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'inc/footer.php';?>
