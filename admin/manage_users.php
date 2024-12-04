<?php
session_start();
include 'config.php';  // Include database connection

// Fetch users from the database
$query = "SELECT * FROM tbl_users";
$getUsers = $db->select($query);

if ($getUsers) {
    echo "<table>";
    echo "<thead><tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Action</th></tr></thead><tbody>";

    while ($result = $getUsers->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $result['id'] . "</td>";
        echo "<td>" . $result['username'] . "</td>";
        echo "<td>" . $result['email'] . "</td>";
        echo "<td>" . $result['role'] . "</td>";
        echo "<td>
                <a href='edit_user.php?id=" . $result['id'] . "'>Edit</a>
                <a href='delete_user.php?id=" . $result['id'] . "'>Delete</a>
              </td>";
        echo "</tr>";
    }

    echo "</tbody></table>";
} else {
    echo "No users found.";
}
?>
