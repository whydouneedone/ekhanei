<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Post List</h2>
        <div class="block">
            <table class="data display datatable" id="example">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Post Title</th>
                        <th width="15%">Description</th>
                        <th width="10%">Category</th>
                        <th width="10%">Image</th>
                        <th width="15%">Author</th>
                        <th width="15%">Tags</th>
                        <th width="15%">Date & Time</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Include the database connection
                    include_once '../lib/Database.php'; 
                    $db = new Database();

                    // Fetch posts from the database including author and tags
                    $query = "SELECT tbl_post.*, tbl_category.name AS category_name, tbl_post.author, tbl_post.tags 
                              FROM tbl_post 
                              LEFT JOIN tbl_category ON tbl_post.cat = tbl_category.id
                              ORDER BY tbl_post.id DESC";
                    $posts = $db->select($query);

                    if ($posts) {
                        $counter = 1; // Counter for the "No" column
                        while ($result = $posts->fetch_assoc()) {
                            // Format the date to a more readable format
                            $created_at = date("F j, Y, g:i a", strtotime($result['created_at'])); // Example format: January 1, 2024, 2:30 pm
                            
                            // Prepare the image path (admin/upload/)
                            $imagePath = "../admin/"  . $result['image'];

                            // Debug: Output the image path to check if it's correct
                            // echo "Image Path: " . $imagePath . "<br>"; //

                            echo "<tr class='odd gradeX'>";
                            echo "<td>" . $counter++ . "</td>"; // Display the counter for post number
                            echo "<td>" . $result['title'] . "</td>";
                            echo "<td>" . substr($result['body'], 0, 50) . "...</td>"; // Show a snippet of the post body
                            echo "<td>" . $result['category_name'] . "</td>";
                            
                            // Check if the image exists and display it
                            if (file_exists($imagePath) && !empty($result['image'])) {
                                echo "<td style='text-align: center; class='center'><img src='" . $imagePath . "' width='100' height='100' alt='Image'></td>";
                            } else {
                                echo "<td style='text-align: center; class='center'>No Image Available</td>";
                            }

                            echo "<td>" . $result['author'] . "</td>"; // Display author
                            echo "<td>" . $result['tags'] . "</td>"; // Display tags
                            echo "<td>" . $created_at . "</td>"; // Display the formatted date and time
                            echo "<td><a href='editpost.php?id=" . $result['id'] . "'>Edit</a> || <a href='deletepost.php?id=" . $result['id'] . "' onclick='return confirm(\"Are you sure?\")'>Delete</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No posts available.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        setupLeftMenu();
        $('.datatable').dataTable();
        setSidebarHeight();
    });
</script>

<?php include 'inc/footer.php'; ?>
