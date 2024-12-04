<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>User List</h2>
        <?php
        // Fetch user data
        $query = "SELECT * FROM tbl_users";
        $getUsers = $db->select($query);

        if ($getUsers) {
            echo "<table class='data display datatable' id='example'>";
            echo "<thead><tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Action</th></tr></thead><tbody>";
            
            while ($result = $getUsers->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $result['id'] . "</td>";
                echo "<td>" . $result['username'] . "</td>";
                echo "<td>" . $result['email'] . "</td>";
                echo "<td>" . $result['role'] . "</td>";
                echo "<td>

                        <a href='view_details.php?id=" . $result['id'] . "' class='btn_view'>View Details</a>
                        
                        <a href='?delete=" . $result['id'] . "' class='btn_delete' onclick='return confirm(\"Are you sure you want to delete?\")'>Delete</a>
                      </td>";
                echo "</tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<p>No users found</p>";
        }

        // Handle delete request
        if (isset($_GET['delete'])) {
            $deleteId = $_GET['delete'];

            // Delete user
            $deleteQuery = "DELETE FROM tbl_users WHERE id = '$deleteId'";
            $deleteResult = $db->delete($deleteQuery);

            if ($deleteResult) {
                echo "<span class='success'>User deleted successfully.</span>";
            } else {
                echo "<span class='error'>Failed to delete user.</span>";
            }
        }
        ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // Handling the inline edit functionality
        $('.btn_edit').on('click', function() {
            var userId = $(this).data('id');
            window.location.href = 'profile.php?id=' + userId;  // Redirect to profile page or create inline editing form here
        });
    });
</script>

<?php include 'inc/footer.php'; ?>
