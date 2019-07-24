<?php 
	include_once('connect.php');
?><?php
	if(!isset($_GET['id']) || !isset($_SESSION['userid']))
	{
		header("location:profile.php");
	}
	$id=$_GET['id'];
	if(!(int)$id)
	{
		header("location:profile.php");
	}
	$user_id=$_SESSION['userid'];
	mysqli_query($conn,"delete from listing where id='$id' and user_id='$user_id'");
	header("location:".$_SERVER["HTTP_REFERER"]);
?>