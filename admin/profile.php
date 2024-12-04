<?php
include 'inc/header.php';
include 'inc/sidebar.php';
include '../lib/Database.php';

$db = new Database();
$user_id = Session::get("user_id"); // Assuming the session stores user ID

// Fetch user details
$query = "SELECT * FROM tbl_users WHERE id = '$user_id'";
$user = $db->select($query)->fetch_assoc();

// Update profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($db->link, $_POST['username']);
    $email = mysqli_real_escape_string($db->link, $_POST['email']);
    $password = $_POST['password'] ? password_hash($_POST['password'], PASSWORD_BCRYPT) : $user['password']; // Keep the current password if no new password is entered

    $update_query = "UPDATE tbl_users 
                     SET username = '$username', email = '$email', password = '$password'
                     WHERE id = '$user_id'";
    $updated = $db->update($update_query);

    if ($updated) {
        echo "<span class='success'>Profile updated successfully!</span>";
        header("Location: profile.php"); // Refresh the page to reflect changes
    } else {
        echo "<span class='error'>Failed to update profile!</span>";
    }
}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>User Profile</h2>
        <div class="block">
            <form action="profile.php" method="post">
                <table class="form">
                    <tr>
                        <td><label>Username</label></td>
                        <td><input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" class="medium" /></td>
                    </tr>
                    <tr>
                        <td><label>Email</label></td>
                        <td><input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="medium" /></td>
                    </tr>
                    <tr>
                        <td><label>New Password</label></td>
                        <td><input type="password" name="password" placeholder="Leave blank to keep current password" class="medium" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Update Profile" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
