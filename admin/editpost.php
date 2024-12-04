<?php
// Include necessary files
include 'inc/header.php';
include 'inc/sidebar.php';
include_once '../lib/Database.php';
$db = new Database();

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $post_id = $_GET['id'];

    // Fetch the post details from the database
    $query = "SELECT * FROM tbl_post WHERE id = '$post_id'";
    $post = $db->select($query)->fetch_assoc();

    if ($post) {
        // Post found, proceed to display and update it
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get the updated data from the form
            $title = mysqli_real_escape_string($db->link, $_POST['title']);
            $cat = mysqli_real_escape_string($db->link, $_POST['cat']);
            $body = mysqli_real_escape_string($db->link, $_POST['body']);
            $tags = mysqli_real_escape_string($db->link, $_POST['tags']);
            $author = mysqli_real_escape_string($db->link, $_POST['author']);
            
            // Check if a new image was uploaded
            if (!empty($_FILES['image']['name'])) {
                $file_name = $_FILES['image']['name'];
                $file_size = $_FILES['image']['size'];
                $file_temp = $_FILES['image']['tmp_name'];
                
                $permited  = array('jpg', 'jpeg', 'png', 'gif');
                $div = explode('.', $file_name);
                $file_ext = strtolower(end($div));
                $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
                $uploaded_image = "upload/" . $unique_image;

                if (in_array($file_ext, $permited) === false) {
                    echo "<span class='error'>You can upload only: " . implode(', ', $permited) . "</span>";
                } else {
                    move_uploaded_file($file_temp, $uploaded_image);
                    // Update the post with the new image
                    $query = "UPDATE tbl_post SET cat='$cat', title='$title', body='$body', image='$uploaded_image', author='$author', tags='$tags' WHERE id='$post_id'";
                }
            } else {
                // No new image, update without changing the image
                $query = "UPDATE tbl_post SET cat='$cat', title='$title', body='$body', author='$author', tags='$tags' WHERE id='$post_id'";
            }

            // Execute the update query
            $update_row = $db->update($query);

            if ($update_row) {
                echo "<span class='success'>Post updated successfully!</span>";
            } else {
                echo "<span class='error'>Post not updated!</span>";
            }
        }
    } else {
        echo "<span class='error'>Post not found!</span>";
    }
} else {
    echo "<span class='error'>Invalid Post ID!</span>";
}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Edit Post</h2>
        <div class="block">
            <form action="editpost.php?id=<?php echo $post_id; ?>" method="post" enctype="multipart/form-data">
                <table class="form">
                    <tr>
                        <td><label>Title</label></td>
                        <td><input type="text" name="title" value="<?php echo $post['title']; ?>" class="medium" required /></td>
                    </tr>
                    <tr>
                        <td><label>Category</label></td>
                        <td>
                            <select id="select" name="cat" required>
                                <option value="">Select Category</option>
                                <?php
                                $query = "SELECT * FROM tbl_category";
                                $category = $db->select($query);
                                if ($category) {
                                    while ($result = $category->fetch_assoc()) {
                                        $selected = ($post['cat'] == $result['id']) ? 'selected' : '';
                                        echo "<option value='" . $result['id'] . "' $selected>" . $result['name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Upload your image</label></td>
                        <td><input type="file" name="image" /></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; padding-top: 9px;"><label>Content</label></td>
                        <td><textarea class="tinymce" name="body" required><?php echo $post['body']; ?></textarea></td>
                    </tr>
                    <tr>
                        <td><label>Tags</label></td>
                        <td><input type="text" name="tags" value="<?php echo $post['tags']; ?>" class="medium" required /></td>
                    </tr>
                    <tr>
                        <td><label>Author</label></td>
                        <td><input type="text" name="author" value="<?php echo $post['author']; ?>" class="medium" required /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Update Post" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        setupLeftMenu();
        setSidebarHeight();
    });
</script>

<?php include 'inc/footer.php'; ?>
