<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<div class="grid_10">
<?php  
 if (!isset($_GET['id'])  || $_GET['id'] == NULL) {
    echo "<script>window.location = 'index.php'; </script>";  
 }else {
   $pageid = $_GET['id'];
 }
?>
<div class="box round first grid">
<h2>Edit Page</h2>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = mysqli_real_escape_string($db->link, ($_POST['title']));
    $body = mysqli_real_escape_string($db->link, ($_POST['content']));
 
    if ($name == "" || $body == "") {
      echo "<span class='error'>Filed Must Not be Empty!!</span>";      
     }  else{
 
 //insert content into database 
        $query = "UPDATE tbl_pages SET 
        title = '$name',
        content = '$body'
        WHERE id='$pageid' ";

       $updated_rows = $db->update($query);
       if ($updated_rows) {
        echo "<span class='success'>Page updated Successfully.
        </span>";
       }else {
        echo "<span class='error'>Page Not updated !</span>";
       }
    }
}

?>

<div class="block">     
<?php
            $pagequery = "SELECT * FROM tbl_pages WHERE id = '$pageid'";
            $detailspage = $db->select($pagequery);
            if ($detailspage) {
            while ($result = $detailspage->fetch_assoc()){   ?>  
     <form action="" method="POST">
    <table class="form">
          <tr>
            <td>
                <label>Name</label>
            </td>
            <td>
                <input type="text" name="title" value="<?php echo $result['title']?> " class="medium" />
            </td>
        </tr>

           <tr>
            <td style="vertical-align: top; padding-top: 9px;">
                <label>Content</label>
            </td>
            <td>
                <textarea class="tinymce" name="content">
                <?php echo $result['content']?> 
                </textarea>
            </td>
        </tr>
      
        <tr>
            <td></td>
            <td>
                <input type="submit" name="submit" Value="Update" />
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
            <a onclick="return confirm('Are you sure you want to delete this')" href="deletepage.php?delpage=<?php echo $result['id']?> ">Delete</a>
            </td>
        </tr>
    </table>
    </form>
    <?php }  } ?>          
</div>
</div>
</div>

<!-- Load TinyMCE -->
<script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
    setupTinyMCE();
    setDatePicker('date-picker');
    $('input[type="checkbox"]').fancybutton();
    $('input[type="radio"]').fancybutton();
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
    setupLeftMenu();
    setSidebarHeight();
    });
</script>
<?php include 'inc/footer.php';?>