<?php
	include('connect.php');
	if(isset($_POST['submit']))
	{
		$name=trim($_POST['name']);
		$mobile=trim($_POST['mobile']);
		$email=trim($_POST['email']);
		$password=$_POST['password'];
		$error=array();
		if($name==""){$error[]="your name should not be blank";}
		if($mobile==""){$error[]="your mobile should not be blank";}
		if($email==""){$error[]="your email should not be blank";}
		if($password==""){$error[]="your password should not be blank";}
		if(!is_numeric($mobile)||strlen($mobile)!=10)
		{$error[]="your mobile should be numeric and it should be of 10 digit";}
		if(strlen($password)<6){$error[]="your password should be greater than 6 digit";}
		$already_mobile="select * from users where mobile='$mobile'";
		if(count($error)==0)
		{		
			$date=date("Y-m-d H:i:s");
			$password=md5($password);
				$query="insert into users (name,mobile,email,password,create_at,is_active)
				values('$name','$mobile','$email','$password','$date',1)";
				mysqli_query($conn,$query) or die(mysqli_error($conn));
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
					<center>Register</center>
					<form method="POST">
					<div class="form-group">
						<label>Name</label>
							<input type="text" name="name" class="form-control">
					</div>
					<div class="form-group">
						<label>Mobile</label>
							<input type="text" name="mobile" class="form-control">
					</div>
					<div class="form-group">
						<label>Email</label>
							<input type="text" name="email" class="form-control">
					</div>
					<div class="form-group">
						<label>Password</label>
							<input type="text" name="password" class="form-control">
					</div>
					<div class="form-group">
						<label>Confirm password</label>
							<input type="text" name="confirm_password" class="form-control">
					</div>
						<input type="submit" name="submit" value="submit">
		</div>
	</div>
</div>
</div>
<?php
	include_once('footer.php');
?>

