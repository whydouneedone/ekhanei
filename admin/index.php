<?php
// Include necessary files for the database connection
include_once '../config/config.php';  // For DB connection settings
include_once '../lib/Database.php';  // For Database class

// Create a new Database object (optional, if no DB actions are needed, you can skip this line)
$db = new Database();
?>

<?php include 'inc/header.php';  // Include header ?>
<?php include 'inc/sidebar.php';  // Include sidebar ?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Dashboard</h2>
        <div class="block">
            <!-- Welcome message -->
            <h3>Welcome Back to the Admin Panel!</h3>
        </div>
    </div>
</div>

<?php include 'inc/footer.php';  // Include footer ?>
