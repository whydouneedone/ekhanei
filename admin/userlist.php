<?php
include 'inc/header.php';
include 'inc/sidebar.php';
include '../lib/Database.php';

$db = new Database();
$query = "SELECT * FROM tbl_users ORDER BY created_at DESC";
$users = $db->select($query);
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>User List</h2>
        <div class="block">
            <table class="data display datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($users): ?>
                        <?php while ($user = $users->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $user['id']; ?></td>
                                <td><?php echo $user['username']; ?></td>
                                <td><?php echo $user['email']; ?></td>
                                <td><?php echo ucfirst($user['role']); ?></td>
                                <td>
                                    <a href="edituser.php?id=<?php echo $user['id']; ?>">Edit</a> |
                                    <a href="deleteuser.php?id=<?php echo $user['id']; ?>">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No users found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
