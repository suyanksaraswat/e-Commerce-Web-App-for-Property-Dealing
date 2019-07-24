<?php
	include_once('connect.php');
	 if(isset($_POST['login']))
	 {
		 $username=$_POST['name'];
		 $password=$_POST['password'];
		 $password=md5($password);
		 $already_email="select * from users where email='$username' and password='$password'";
		 $email_result=mysqli_query($conn,$already_email);
		 if(mysqli_num_rows($email_result)>0)
		 {
			$user=mysqli_fetch_object($email_result);
			$_SESSION["userid"]=$user->id;
			$_SESSION['username']=$username;
			header("location: index.php");
			
		 }
			else
			{
				$error[]="username or password did not match";
			}
	 }	 

?>
<?php
	include_once('header.php');
?>
<?php
	include_once('nav.php');

?>
<div id="content">
	<div class="container">
		<div class="row" >
			<div class="col-sm-offset-4 col-sm-4"style="background-color:#Ec7063; border:1px solid color; padding:10px; border-radius:5px">
					<center><h1>Register</h1></center>
					<form method="POST">
						<div class="form-group">
							<label>Name</label>
							<input type="text" name="name" class="form-control">
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="text" name="password" class="form-control">
						</div>
						<input type="submit" name="login" value="submit">
					</form>
			</div>
		</div>
	</div>	
</div>
<?php
	include_once('footer.php');
?>

