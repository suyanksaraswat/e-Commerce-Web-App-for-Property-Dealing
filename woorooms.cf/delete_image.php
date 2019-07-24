<?php 
	include_once('connect.php');
?>
<?php
	if(!isset($_GET['id']) || !isset($_SESSION['user_id']))
	{
		header("location:profile.php");
	}
	$id=$_GET['id'];
	if(!(int)$id)
	{
		header("location:profile.php");
	}
	$user_id=$_SESSION['user_id'];
	mysqli_query($conn,"delete from listing_image where id='$id' ");
	header("location:".$_SERVER["HTTP_REFERER"]);
?>