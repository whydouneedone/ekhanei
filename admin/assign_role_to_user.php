<?php
include 'config.php';  // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['user_id'];
    $roleName = $_POST['role_name'];

    // Update user role
    $query = "UPDATE tbl_users SET role = '$roleName' WHERE id = '$userId'";
    $db->update($query);
    
    echo "Role assigned to user successfully!";
}
?>

<form method="post" action="assign_role_to_user.php">
    <label for="user_id">User ID:</label>
    <input type="text" name="user_id" id="user_id" required />
    
    <label for="role_name">Role Name:</label>
    <input type="text" name="role_name" id="role_name" required />
    
    <button type="submit">Assign Role</button>
</form>
