<?php include 'assignment1/header.php'; ?>
<div class="contentsection contemplete clear">
<?php  
 if (!isset($_GET['id'])  || $_GET['id'] == NULL) {
    echo "<script>window.location = 'index.php'; </script>";  
 }else {
   $id = $_GET['id'];
 }
?>
	<?php
            $pagequery = "SELECT * FROM tbl_pages WHERE id = '$id'";
            $detailspage = $db->select($pagequery);
            if ($detailspage) {
            while ($result = $detailspage->fetch_assoc()){   ?>  
<div class="maincontent clear">
	<div class="about">
 	<h2><?php echo $result['title']?></h2>
    
 <p><?php echo $result['content']?></p>
 
</div>
</div>
<?php  } } else { header("location:404.php"); } ?>
<!-- <div class="sidebar clear">
	<div class="samesidebar clear">
		<h2>Latest articles</h2>
			<ul>
				<li><a href="#">Category One</a></li>
				<li><a href="#">Category Two</a></li>
				<li><a href="#">Category Three</a></li>
				<li><a href="#">Category Four</a></li>
				<li><a href="#">Category Five</a></li>						
			</ul>
	</div>
</div> -->

<?php include 'assignment1/sidebar.php'; ?>
<?php include 'assignment1/footer.php'; ?>