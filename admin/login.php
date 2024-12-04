<?php
include '../lib/session.php';
Session::init();
?>
<?php include '../config/config.php';?>
<?php include '../lib/Database.php';?>
<?php include '../helpers/format.php';?>

<?php  
  $db = new Database();
  $fm = new format();
?>

<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>Login</title>
<link rel="stylesheet" type="text/css" href="css/stylelogin.css" media="screen" />
</head>
<body>
<div class="container">
  <section id="content">
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      
        $username = $fm->validation($_POST['username']);
        $password = $fm->validation(md5($_POST['password']));  // Encrypt the password
        $username = mysqli_real_escape_string($db->link, $username);
        $password = mysqli_real_escape_string($db->link, $password);

        // Query to fetch user with matching username and password
        $query = "SELECT * FROM tbl_users WHERE username='$username' AND password='$password'";
        $result = $db->select($query);
        
        if ($result) {
            $value = mysqli_fetch_array($result);
            $row  = mysqli_num_rows($result);

            if ($row > 0) {
                // Set session variables
                Session::set("login", true);
                Session::set("username", $value['username']);
                Session::set("userid", $value['id']);
                Session::set("role", $value['role']);  // Set role in session

                // Redirect based on the role
                if ($value['role'] == 'admin') {
                    header("Location:admin_dashboard.php");
                } elseif ($value['role'] == 'editor') {
                    header("Location:editor_dashboard.php");
                } else {
                    header("Location:user_dashboard.php");
                }
            } else {
                echo "<span style='color:red; font-size:20px;'>Opps! No result matched.</span>";
            }
        } else {
            echo "<span style='color:red; font-size:20px;'>Username or password invalid!</span>";
        }
    }
    ?>
    <form action="" method="post">
      <h1>Admin Login</h1>
      <div>
        <input type="text" placeholder="Username" required="" name="username"/>
      </div>
      <div>
        <input type="password" placeholder="Password" required="" name="password"/>
      </div>
      <div>
        <input type="submit" value="Log in" />
      </div>
    </form><!-- form -->
    <div class="button">
      <a href="#">Training with live project</a>
    </div><!-- button -->
  </section><!-- content -->
</div><!-- container -->
</body>
</html>
