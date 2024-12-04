<?php
session_start();
include 'config.php';  // Include database connection

function has_permission($permission) {
    $role = $_SESSION['role'];  // Assuming role is stored in session

    // Fetch the permissions for the role
    $query = "SELECT permissions FROM tbl_roles WHERE role_name = '$role'";
    $result = $db->select($query);
    
    if ($result) {
        $permissions = $result->fetch_assoc();
        $permissionsArray = json_decode($permissions['permissions'], true);

        return in_array($permission, $permissionsArray);
    }
    return false;
}

// Example usage:
if (has_permission('can_edit_post')) {
    echo "You have permission to edit posts.";
} else {
    echo "You do not have permission to edit posts.";
}
?>
