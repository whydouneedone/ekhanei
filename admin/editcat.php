<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php
// Include Database file
require_once '../lib/Database.php';
$db = new Database();

// Check if a category ID is provided in the URL
if (!isset($_GET['catid']) || $_GET['catid'] == NULL) {
    header("Location: catlist.php"); // Redirect to category list if no ID
    exit();
} else {
    $id = $_GET['catid']; // Get the category ID
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $catName = mysqli_real_escape_string($db->link, $_POST['name']);
    if (empty($catName)) {
        $error = "Category name must not be empty.";
    } else {
        $query = "UPDATE tbl_category SET name = '$catName' WHERE id = '$id'";
        $updated = $db->update($query);
        if ($updated) {
            $success = "Category updated successfully.";
        } else {
            $error = "Category update failed.";
        }
    }
}

// Fetch category details
$query = "SELECT * FROM tbl_category WHERE id = '$id'";
$category = $db->select($query);
if ($category) {
    $result = $category->fetch_assoc();
} else {
    header("Location: catlist.php"); // Redirect to category list if ID is invalid
    exit();
}
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Edit Category</h2>
        <div class="block copyblock"> 
            <?php
            if (isset($error)) {
                echo "<span style='color:red;'>$error</span>";
            } elseif (isset($success)) {
                echo "<span style='color:green;'>$success</span>";
            }
            ?>
            <form action="" method="post">
                <table class="form">					
                    <tr>
                        <td>
                            <input type="text" name="name" value="<?php echo $result['name']; ?>" class="medium" />
                        </td>
                    </tr>
					<tr> 
                        <td>
                            <input type="submit" name="submit" Value="Update" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<div class="clear"></div>
</div>
<div id="site_info">
    <p>
        &copy; Copyright <a href="#">Your Company</a>. All Rights Reserved.
    </p>
</div>
</body>
</html>
