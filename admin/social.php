<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Update Social Media</h2>
        <div class="block"> 
            <?php 
            // Fetch current social media links from the database
            $query = "SELECT * FROM tbl_social WHERE id='1'";
            $socialmedia = $db->select($query);

            if ($socialmedia) {
                $result = $socialmedia->fetch_assoc();
            ?>

            <form action="social.php" method="post">
                <table class="form">					
                    <tr>
                        <td>
                            <label>Facebook</label>
                        </td>
                        <td>
                            <input type="text" name="fb" value="<?php echo $result['fb']; ?>" class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Twitter</label>
                        </td>
                        <td>
                            <input type="text" name="tw" value="<?php echo $result['tw']; ?>" class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>LinkedIn</label>
                        </td>
                        <td>
                            <input type="text" name="ln" value="<?php echo $result['ln']; ?>" class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Google Plus</label>
                        </td>
                        <td>
                            <input type="text" name="gp" value="<?php echo $result['gp']; ?>" class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="submit" value="Update" />
                        </td>
                    </tr>
                </table>
            </form>

            <?php 
            } else {
                echo "<p>No social media data found.</p>";
            }
            ?>

            <?php
            // Handle form submission to update social media links
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Sanitize user input to prevent SQL injection
                $fb = $db->link->real_escape_string($_POST['fb']);
                $tw = $db->link->real_escape_string($_POST['tw']);
                $ln = $db->link->real_escape_string($_POST['ln']);
                $gp = $db->link->real_escape_string($_POST['gp']);

                // Update query to update the social media links
                $updateQuery = "
                    UPDATE tbl_social 
                    SET fb='$fb', tw='$tw', ln='$ln', gp='$gp' 
                    WHERE id='1'
                ";

                // Execute the query
                $updateRow = $db->update($updateQuery);
                if ($updateRow) {
                    echo "<script>alert('Social media links updated successfully');</script>";
                    echo "<script>window.location = 'social.php';</script>";  // Redirect after successful update
                } else {
                    echo "<script>alert('Failed to update social media links');</script>";  // Error message
                }
            }
            ?>
        </div>
    </div>
</div>

<div class="clear"></div>
</div>

<?php include 'inc/footer.php'; ?>
