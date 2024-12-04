<?php
include 'config.php';  // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $roleName = mysqli_real_escape_string($db->link, $_POST['role_name']);
    $permissions = mysqli_real_escape_string($db->link, $_POST['permissions']);  // comma separated permissions

    // Convert permissions to JSON
    $permissionsArray = explode(',', $permissions);
    $permissionsJson = json_encode($permissionsArray);

    // Insert role into database
    $query = "INSERT INTO tbl_roles (role_name, permissions) VALUES ('$roleName', '$permissionsJson')";
    $db->insert($query);

    echo "Role added successfully!";
}
?>

<form method="post" action="add_role.php">
    <label for="role_name">Role Name:</label>
    <input type="text" name="role_name" id="role_name" required />
    
    <label for="permissions">Permissions (comma separated):</label>
    <input type="text" name="permissions" id="permissions" required />
    
    <button type="submit">Add Role</button>
</form>
