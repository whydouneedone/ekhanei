<?php include_once 'inc/header.php'; ?>
<?php include_once 'inc/sidebar.php'; ?>
<?php require_once '../lib/Database.php'; ?>

<?php
// Initialize the Database class
$db = new Database();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($db->link, $_POST['name']);

    if (empty($name)) {
        $message = "<span class='error'>Category name must not be empty.</span>";
    } else {
        $query = "INSERT INTO tbl_category(name) VALUES('$name')";
        $insertResult = $db->insert($query);
        if ($insertResult) {
            $message = "<span class='success'>Category added successfully.</span>";
        } else {
            $message = "<span class='error'>Failed to add category.</span>";
        }
    }
}
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Add New Category</h2>
        <div class="block">
            <?php if (isset($message)) echo $message; ?>
            <form action="addcat.php" method="POST">
                <table class="form">
                    <tr>
                        <td>
                            <input type="text" name="name" placeholder="Enter Category Name..." class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" name="submit" Value="Save" />
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
        &copy; Copyright <a href="http://trainingwithliveproject.com">Training with live project</a>. All Rights Reserved.
    </p>
</div>
</body>
</html>