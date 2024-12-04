<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Add New Post</h2>
        <?php 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = mysqli_real_escape_string($db->link, $_POST['title']);
            $cat = mysqli_real_escape_string($db->link, $_POST['cat']);
            $body = mysqli_real_escape_string($db->link, $_POST['body']);
            $tags = mysqli_real_escape_string($db->link, $_POST['tags']);
            $author = mysqli_real_escape_string($db->link, $_POST['author']);
            $meta_keywords = mysqli_real_escape_string($db->link, $_POST['meta_keywords']);
            $meta_description = mysqli_real_escape_string($db->link, $_POST['meta_description']);
            
            // File upload handling
            $permited  = array('jpg', 'jpeg', 'png', 'gif');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];
            
            // Get file extension
            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
            $uploaded_image = "upload/" . $unique_image;
            
            // Validation
            if ($title == "" || $cat == "" || $body == "" || $tags == "" || $author == "" || $file_name == "" || $meta_keywords == "" || $meta_description == "") {
                echo "<span class='error'>All fields are required!</span>";
            } elseif (in_array($file_ext, $permited) === false) {
                echo "<span class='error'>You can upload only: " . implode(', ', $permited) . "</span>";
            } else {
                // Move uploaded image to folder
                if (move_uploaded_file($file_temp, $uploaded_image)) {
                    // Insert post into the database
                    $query = "INSERT INTO tbl_post (cat, title, body, image, author, tags, meta_keywords, meta_description) 
                            VALUES ('$cat', '$title', '$body', '$uploaded_image', '$author', '$tags', '$meta_keywords', '$meta_description')";
                    $inserted_rows = $db->insert($query);
                    if ($inserted_rows) {
                        echo "<span class='success'>Post inserted successfully!</span>";
                    } else {
                        echo "<span class='error'>Post not inserted!</span>";
                    }
                } else {
                    echo "<span class='error'>Failed to upload the image.</span>";
                }
            }
        }
        ?>

        <div class="block">
            <form action="addpost.php" method="post" enctype="multipart/form-data">
                <table class="form">
                    <tr>
                        <td><label>Title</label></td>
                        <td><input type="text" name="title" placeholder="Enter Post Title..." class="medium" required /></td>
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
                                        echo "<option value='" . $result['id'] . "'>" . $result['name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Upload your image</label></td>
                        <td><input type="file" name="image" required /></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; padding-top: 9px;"><label>Content</label></td>
                        <td><textarea class="tinymce" name="body" required></textarea></td>
                    </tr>
                    <tr>
                        <td><label>Tags</label></td>
                        <td><input type="text" name="tags" placeholder="Enter tags..." class="medium" required /></td>
                    </tr>
                    <tr>
                        <td><label>Author</label></td>
                        <td><input type="text" name="author" placeholder="Enter author..." class="medium" required /></td>
                    </tr>
                    <!-- New Fields for Meta Keywords and Meta Description -->
                    <tr>
                        <td><label>Meta Keywords</label></td>
                        <td><input type="text" name="meta_keywords" placeholder="Enter meta keywords..." class="medium" required /></td>
                    </tr>
                    <tr>
                        <td><label>Meta Description</label></td>
                        <td><textarea name="meta_description" placeholder="Enter meta description..." class="medium" required></textarea></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="submit" value="Save" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<!-- Load TinyMCE -->
<script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        tinymce.init({
            selector: 'textarea.tinymce',
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save(); // Sync TinyMCE content with the underlying <textarea>
                });
            }
        });
        setDatePicker('date-picker');
        $('input[type="checkbox"]').fancybutton();
        $('input[type="radio"]').fancybutton();
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        setupLeftMenu();
        setSidebarHeight();
    });
</script>

<style type="text/css">
    #tinymce { font-size: 15px !important; }
</style>

<?php include 'inc/footer.php'; ?>
