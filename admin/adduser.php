<?php
include 'inc/header.php';
include 'inc/sidebar.php';
include '../lib/Database.php';

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($db->link, $_POST['username']);
    $email = mysqli_real_escape_string($db->link, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = mysqli_real_escape_string($db->link, $_POST['role']);

    if (empty($username) || empty($email) || empty($password) || empty($role)) {
        echo "<span class='error'>All fields must be filled!</span>";
    } else {
        $query = "INSERT INTO tbl_users (username, email, password, role) 
                  VALUES ('$username', '$email', '$password', '$role')";
        $inserted = $db->insert($query);

        if ($inserted) {
            echo "<span class='success'>User added successfully!</span>";
        } else {
            echo "<span class='error'>Failed to add user!</span>";
        }
    }
}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Add New User</h2>
        <div class="block">
            <form action="adduser.php" method="post">
                <table class="form">
                    <tr>
                        <td><label>Username</label></td>
                        <td><input type="text" name="username" class="medium" /></td>
                    </tr>
                    <tr>
                        <td><label>Email</label></td>
                        <td><input type="email" name="email" class="medium" /></td>
                    </tr>
                    <tr>
                        <td><label>Password</label></td>
                        <td><input type="password" name="password" class="medium" /></td>
                    </tr>
                    <tr>
                        <td><label>Role</label></td>
                        <td>
                            <select name="role" class="medium">
                                <option value="admin">Admin</option>
                                <option value="editor">Editor</option>
                                <option value="subscriber">Subscriber</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Add User" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
