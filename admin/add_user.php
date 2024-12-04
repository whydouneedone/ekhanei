<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Add New User</h2>
        <?php
        // Include Database class
        include '../lib/Database.php';  // Adjust the path if necessary
        $db = new Database();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form data
            $username = mysqli_real_escape_string($db->link, $_POST['username']);
            $email = mysqli_real_escape_string($db->link, $_POST['email']);
            $password = mysqli_real_escape_string($db->link, $_POST['password']);
            $role = mysqli_real_escape_string($db->link, $_POST['role']);

            // Validate inputs
            if (empty($username) || empty($email) || empty($password) || empty($role)) {
                echo "<span class='error'>All fields are required!</span>";
            } else {
                // Hash password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insert the new user into the database
                $query = "INSERT INTO tbl_users (username, email, password, role) 
                          VALUES ('$username', '$email', '$hashedPassword', '$role')";
                $insertUser = $db->insert($query);

                if ($insertUser) {
                    echo "<span class='success'>User added successfully!</span>";
                } else {
                    echo "<span class='error'>Failed to add user!</span>";
                }
            }
        }
        ?>
        
        <div class="block">     
            <form action="add_user.php" method="POST">
                <table class="form" style="width: 100%; border: 1px solid #ddd; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            <label>Username</label>
                        </td>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            <input type="text" name="username" placeholder="Enter username..." required />
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            <label>Email</label>
                        </td>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            <input type="email" name="email" placeholder="Enter email..." required />
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            <label>Password</label>
                        </td>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            <input type="password" name="password" placeholder="Enter password..." required />
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            <label>Role</label>
                        </td>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            <select name="role" style="width: 100%; padding: 5px;">
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            <input type="submit" name="submit" value="Add User" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
