<?php
	include_once('connect.php');
	if(!isset($_SESSION['user_id']))
	{
		header('location:login.php');
		
	}
	if(isset($_POST['submit']))
	{	
		$user_id=$_SESSION['user_id'];
		$password=$_POST["password"];
		$confirm_password=$_POST["confirm_password"];
		if($password==$confirm_password)
		{
			$password=md5($password);
			mysqli_query($conn,"update users set password='$password' where id='$user_id'");
		}
		else
		{
			$error[]="password and confirm password does not match";
		}	
	}
?>

<?php
	include_once('header.php');
?>
<?php
	include_once('nav.php');
?>
<!-- begin:content -->
    <div id="content">
		<div class="container">
			<div class="row">   
				<div class="col-md-3  sidebar">
				
					<?php
						include_once('profilesidebar.php');
					?>
				</div>
				<div class="col-md-9">
				<form method="POST">
					<h3>Change Password</h3>
					password:<input type="password" name="password"><br/>
					confirm password:<input type="password" name="confirm_password"><br/>
					<input type="submit" name="submit" value="submit">
				</form>
					
				</div>
			</div>
		</div>
	</div>
<?php
	include_once('footer.php');
?>
