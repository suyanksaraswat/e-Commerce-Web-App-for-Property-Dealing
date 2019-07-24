<?php
	include_once('connect.php');
	$id=$_GET['id'];
	if(!isset($_SESSION['userid']))
	{
		header('location:login.php');
	}
	if(!isset($_GET['id']))
	{
		header('location:index.php');
	}
	if(!(int)$id)
	{
		header('location:index.php');
	}
?>
<?php 
	
	if(isset($_POST['submit']))
		
	{
		$list_id=$_POST['id'];
		$category=$_POST['category'];
		if(isset($_POST["users"]))
		{	
			$type=$_POST['user'];
		}
		else $type="";
		if(isset($_POST["users"]))
		{			
			$want=$_POST['users'];
		}
		else $want="";
		$title=$_POST['title'];
		$description=$_POST['description'];
		$terms=$_POST['terms'];
		$state=$_POST['state'];
		$city=$_POST['city'];
		$locality=$_POST['locality'];
		if(isset($_POST['for']))
		{	
			$accomo_for=$_POST['for'];
		}
		else $accomo_for="";	
		$deposite=$_POST['deposite'];
		$rent_month=$_POST['rent_month'];
		$price=$_POST['price'];
		$area=$_POST['area'];
		if(isset($_POST['ammenities']))
		{
			$ammenities=implode(",",$_POST['ammenities'] );
		}
		else $ammenities="";
		$error=array();
		if($category==""){$error[]="your category should not be blank";}
		if($type==""){$error[]="your type should not be blank";}
		if($want==""){$error[]="you should wirte what you want";}
		if($title==""){$error[]="your title should not be empty";}
		if($description==""){$error[]="you should write description of your property";}
		if($terms==""){$error[]="please write terms";}
		if($state==""){$error[]="you should write state";}
		if($city==""){$error[]="you should write city ";}
		if($locality==""){$error[]="you shoild mention your locality";}
		if($accomo_for==""){$error[]="you should mention for whom you are giving accomodation";}
		if($want=="rent")
		{
			if($deposite==""){$error[]="you have to write price to be deposite";}
			if($type==""){$error[]="you should write rent";}
		}
		if($want=="sell")
		{
			if($price==""){$error[]="you have to write price ";}
			if($area==""){$error[]="you should write area";}
		}
		
		
		if($want!="sell")
		{
			$price=$type;
		}	
		if(count($error)==0)
		{	
			$create_at=date("Y-m-d");
			
			$sql="update listing set category='$category', type='$type', want='$want', 
				title='$title', description='$description', terms='$terms', state='$state', city='$city', locality='$locality', accomo_for='$accomo_for', 
				ammenities='$ammenities', deposite='$deposite', price='$price', area='$area' where id='$list_id'";
				mysqli_query($conn,"$sql")or exit(mysqli_error($conn));
				$i=0;
				foreach($_FILES['photo']['name'] as $name)
				{
					$allowed_ext=array("jpg","jpeg","png");
					$ext_arr=explode(".",$name);
					$ext=strtolower(end($ext_arr));
					$name=hash("sha256",$name).".$ext";
					
					if(in_array($ext,$allowed_ext)&& $_FILES['photo']['size'][$i]<=20000000)
					{
						move_uploaded_file($_FILES['photo']['tmp_name'][$i],"img/$name");
						mysqli_query($conn,"insert into listing_image(list_id,image) values('$list_id','$name')") or die(mysqli_error($conn));
					}
					$i++;
				}
			
		}
	}
	
	$sql_listing=mysqli_query($conn,"select * from listing where id='$id'");
	$listing=mysqli_fetch_object($sql_listing );
	if($listing->user_id!=$_SESSION['userid'])
	{
		header('location:profile.php');
	}
		$user_id=$_SESSION['userid'];
		$sql_user=mysqli_query($conn,"select * from users where id=$user_id");
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
				<div class="widget widget-sidebar widget-white">
					<div class="widget-header">
						<h3>edit your listing</h3>
					</div>
									<form method="POST" enctype="multipart/form-data">
									<input type="hidden" name="id" value="<?php echo $listing->id;?>">
			<?php
					if(isset($error))
					{
						foreach ($error as $err)
						{
							echo ($err)."<br>";
						}
					}
			?>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label>Category</label>
						<select name="category" class="form-control">
						<option></option>
						<?php
							$cats=mysqli_query($conn,"select * from property_type");
							while($cat=mysqli_fetch_object($cats))
							{
								$sel="";
								if($cat->id==$listing->category) $sel="selected";
								echo "<option value='$cat->id' $sel>$cat->name</option>";
								
							}
						?>
						</select>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>You are </label><br>
						<label><input type="radio" name="user" value="owner"  <?php if($listing->type=="owner"){echo 'checked';}?>>Owner</label>
						<label><input type="radio" name="user" value="agent" <?php if($listing->type=="agent"){echo 'checked';}?>>Agent</label>
						
					</div>
				</div>
			</div>
			<div class="row">	
				<div class="col-sm-6">
					<div class="form-group">
						<label>I want </label><br>
						<label><input type="radio" name="users" value="sell" <?php if($listing->want=="sell"){echo 'checked';}?> onclick="show_sell(this.checked)" >Sell</label>
						<label><input type="radio" name="users" value="rent" <?php if($listing->want=="rent"){echo 'checked';}?> onclick="show_status(this.checked)">Rent </label>
						<label><input type="radio" name="users" value="hostel" <?php if($listing->want=="hostel"){echo 'checked';}?> onclick="show_status(this.checked)">PG/Hostel</label>
						<label><input type="radio" name="users" value="roommate" <?php if($listing->want=="roommate"){echo 'checked';}?> onclick="show_status(this.checked)">Roommate</label>
						
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>Title of your property</label>
						<input type="text" class="form-control" name="title" value="<?php echo $listing->title;?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label>Description:</label><br>
						<textarea name="description" class="form-control" ><?php echo $listing->description;?></textarea>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
					<div class="form-group">
						<label>Terms:</label><br>
						<textarea name="terms" class="form-control" ><?php echo $listing->terms;?></textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label>state</label>
						<select class="form-control" id="state" onchange="get_city(this.value)" name="state">
							<option value=0></option>
							<?php
								$state_query=mysqli_query($conn,"select * from state");
								while ($row=mysqli_fetch_object($state_query))
								{
									$sel="";
									if($listing->state==$row->id) $sel="selected";
									echo "<option value='$row->id' $sel>$row->state</option>";
								}
							?>
						</select>	
					</div>
				</div>
					
				<div class="col-sm-6">
					<div class="form-group">
						<label>city</label>
						<select class="form-control" id="city" name="city" >
							<option value=0></option>
							<?php
										$query=mysqli_query($conn,"select * from city where state_id='$listing->state'");
										while ($row=mysqli_fetch_object($query))
										{
											$sel="";
											if($listing->city==$row->id) $sel="selected";
											echo "<option value='$row->id' $sel>$row->city</option>";
										}
							?>
						</select>	
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label>Locality:</label><br>
						<input type="text" name="locality" class="form-control" value="<?php echo $listing->locality;?>">
					</div>
				</div>
				
				<div class="col-sm-6">
					<div class="form-group">
						<label>Accomodation for:</label><br>
						<label><input type="radio" name="for" value="male"<?php if($listing->accomo_for=="male"){echo 'checked';}?> >Male</label>
						<label><input type="radio" name="for" value="female"<?php if($listing->accomo_for=="female"){echo 'checked';}?> >Female</label>
						<label><input type="radio" name="for"  value="co-ed"<?php if($listing->accomo_for=="co-ed"){echo 'checked';}?>>Co-ed</label>
					</div>
				</div>
			</div>
			
			<?php
			if($listing->want!="sell") $class_a="block";
			else $class_a="none";
			
			?>
			<div class="row" style="display:<?php echo $class_a;?>" id="status_row">
			
				<div class="col-sm-6" >
					<div class="form-group">
						<label>Deposite:</label><br>
						<input type="text" name="deposite" class="form-control" value="<?php echo $listing->deposite;?>">
					</div>
				</div>
				<div class="col-sm-6"  >
					<div class="form-group">
						<label>Rent/month:</label><br>
						<input type="text" name="rent_month" class="form-control" value="<?php echo $listing->price;?>">

					</div>
				</div>
			</div>
			<?php
			if($listing->want=="sell") $class="block";
			else $class="none";
			
			?>
			<div class="row" style="display:<?php echo $class;?>" id="sell_row">
				<div class="col-sm-6"  >
					<div class="form-group">
						<label>Price:</label><br>
						<input type="text" name="price" class="form-control" value="<?php echo $listing->price;?>">
					</div>
				</div>
				<div class="col-sm-6"  >
					<div class="form-group">
						<label>Area.:</label><br>
						<input type="text" name="area" class="form-control" value="<?php echo $listing->area;?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					<label>Ammenities</label><br>
						
							<?php
							$query=mysqli_query($conn,"select * from ammenities");
							if(mysqli_num_rows($query)>0)
							{
								{
									$amm=explode(",",($listing->ammenities));
								}
								$i=0;	
								while($row=mysqli_fetch_object($query))
								{
									$i++;
									if($i%3==1)
									{
										echo "<div class='row'>";
									}	
									$checked="";
									if(in_array($row->id,$amm)) $checked="checked";
									echo "<div class='col-sm-4'><input type='checkbox' name='ammenities[]' $checked value='$row->id'>&nbsp;$row->name </div>";
									if($i%3==0)
									{
										echo "</div>";
									}	
								}
								if($i%3!=0)
								{
									echo "</div>";
								}	
							}
							?>
						
					</div>
				</div>
			</div>
			<?php
			if(!isset($_SESSION["user_id"]))
			{	
			?>
			<?php
			}
			?>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<b>Upload Photo</b><br/>
						
						<input type="file" name="photo[]"><br/>
						<input type="file" name="photo[]"><br/>
						<input type="file" name="photo[]"><br/>
						<input type="file" name="photo[]"><br/>
						<input type="file" name="photo[]"><br/>
						
						
					</div>
				</div>
			</div>
			<div class="row">
			<?php
							$query=mysqli_query($conn,"select * from listing_image where list_id='$listing->id'");
							while($row=mysqli_fetch_object($query))
							{
								echo "<div class='col-sm-3'><img src='img/$row->image' class='img-thumbnil' style='width:200px;height:200px'>
							<center><a href='delete_image.php?id=$row->id&list_id=$listing->id' onclick='return confirm(\"Are you sure\")'><i class='fa fa-times'></i>delete</a></center>
							</div>";

							}
						?>
			</div>
			<center><input type="submit" name="submit" class="btn btn-primary btn-lg btn-block"></center>
		</form>
					
				</div>
		</div>
		</div>
	</div>
	</div>
	</div>
<?php
	include_once('footer.php');
?>
