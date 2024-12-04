<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<style>
    .leftside { float: left; width: 70%; }
    .rightside { float: left; width: 20%; }
    .rightside img { height: 160px; width: 170px; }
</style>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Update Site Title and Description</h2>
        <?php
       if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = mysqli_real_escape_string($db->link, $_POST['title']);
        $slogan = mysqli_real_escape_string($db->link, $_POST['slogan']);
    
        $logo = $_FILES['logo']['name'];
        $logo_tmp = $_FILES['logo']['tmp_name'];
        $upload_dir = "../upload/";
    
        if (!empty($logo)) {
            $uploaded_logo = $upload_dir . basename($logo);
    
            // Check if the upload directory exists, if not, create it
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
    
            // Move uploaded file to the directory
            if (move_uploaded_file($logo_tmp, $uploaded_logo)) {
                // Update with new logo path
                $query = "UPDATE title_slogan SET title='$title', slogan='$slogan', logo='upload/$logo' WHERE id=1";
            } else {
                echo "<span style='color: red;'>Failed to upload the logo.</span>";
            }
        } else {
            // Update without logo
            $query = "UPDATE title_slogan SET title='$title', slogan='$slogan' WHERE id=1";
        }
    
        $updated = $db->update($query);
    
        if ($updated) {
            echo "<span style='color: green;'>Data updated successfully.</span>";
        } else {
            echo "<span style='color: red;'>Data update failed.</span>";
        }
    }
    

        // Fetch current values
        $query = "SELECT * FROM title_slogan WHERE id=1";
        $blog_title = $db->select($query);
        if ($blog_title) {
            while ($result = $blog_title->fetch_assoc()) {
        ?>
        <div class="block sloginblock">
            <div class="leftside">
                <form action="" method="post" enctype="multipart/form-data">
                    <table class="form">
                        <tr>
                            <td>
                                <label>Website Title</label>
                            </td>
                            <td>
                                <input type="text" value="<?php echo $result['title']; ?>" name="title" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Website Slogan</label>
                            </td>
                            <td>
                                <input type="text" value="<?php echo $result['slogan']; ?>" name="slogan" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Upload Logo</label>
                            </td>
                            <td>
                                <input type="file" name="logo" />
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="submit" name="submit" Value="Update" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>

            <div class="rightside">
                <img src="../<?php echo $result['logo']; ?>" alt="logo" />
                <p>Logo</p>
            </div>
        </div>
        <?php 
            } 
        } 
        ?>
    </div>
</div>
<?php include 'inc/footer.php'; ?>
