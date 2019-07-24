<?php
	include_once('connect.php');
	if(!isset($_SESSION['userid']))
	{
		header('location:login.php');
		
	}
		$userid=$_SESSION['userid'];
		$sql_user=mysqli_query($conn,"select * from users where id=$userid");
		$user=mysqli_fetch_object($sql_user);
	
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
					<table>
					<tr>
					<td>
					<?php
						echo $user->name ;
					?>
					</td>
					</tr>
					<tr>
					<td>
					<?php
						echo $user->mobile ;
					?>
					</td>
					</tr>
					<tr>
					<td>
					<?php
						echo $user->email ;
					?>
					</td>
					</tr>
				</table>
				</div>
			</div>
		</div>
	</div>
<?php
	include_once('footer.php');
?>
