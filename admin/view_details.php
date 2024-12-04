<?php
include 'inc/header.php';
include 'inc/sidebar.php';
include '../lib/Database.php';
include_once '../helpers/format.php';

$db = new Database();
$fm = new Format();

// Get the user ID from the URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
} else {
    header("Location: user_list.php"); // Redirect if no user ID is found
}

// Fetch user details from the database
$query = "SELECT * FROM tbl_users WHERE id = '$userId'";
$getUser = $db->select($query);

if ($getUser) {
    $user = $getUser->fetch_assoc();
} else {
    echo "User not found.";
}
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>User Details</h2>
        <div class="block">
            <?php if (isset($user)) { ?>
                <table class="form">
                    <tr>
                        <td><strong>Username</strong></td>
                        <td><?php echo $user['username']; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Email</strong></td>
                        <td><?php echo $user['email']; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Role</strong></td>
                        <td><?php echo $user['role']; ?></td>
                    </tr>
                    <tr>
                       
                        
                    </tr>
                    <tr>
                        <td><strong>Joined</strong></td>
                        <td><?php echo $fm->formatDate($user['created_at']); ?></td>
                    </tr>
                </table>
            <?php } ?>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
