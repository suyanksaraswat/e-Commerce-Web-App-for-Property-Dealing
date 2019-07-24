<?php include_once('connect.php');?>
	<?php 
	if(isset($_POST['submit']))
	{
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
		if(isset($_SESSION["user_id"]))
		{
			$user_id=$_SESSION["user_id"];
			$name="";
			$email="";
			$mobile="";
			
		}	
		else
		{
			$user_id="";
			$name=$_POST['name'];
			$email=$_POST['email'];
			$mobile=$_POST['mobile'];
		}
		
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
		
		if(!isset($_SESSION["id"]))
		{	
			if($name==""){$error[]="your name should not be blank";}
			if($mobile==""){$error[]="your mobile no.should not be blank";}
			if($email==""){$error[]="your email no.should not be blank";}
			$user_id="";
		}
		if($want!="sell")
		{
			$price=$type;
		}	
		if(count($error)==0)
		{	
			$create_at=date("Y-m-d");
			
			$sql="INSERT INTO `listing` (`category`, `type`, `want`, 
				`title`, `description`, `terms`, `state`, `city`, `locality`, `accomo_for`, 
				`ammenities`, `deposite`, `price`, `area`, `name`, `mobile`, `email`, 
				`is_active`, `is_premium`, `create_at`, `user_id`) 
				VALUES ('$category', '$type', '$want', 
				'$title', '$description', '$terms','$state', '$city', '$locality', '$accomo_for',
				'$ammenities', '$deposite', '$price', '$area', '$name', '$mobile', '$email',
				'1', '0', '$create_at', '$user_id');";
				mysqli_query($conn,"$sql");
				$list_id=mysqli_insert_id($conn);
				$i=0;
				foreach($_FILES['photo']['name'] as $name)
				{
					$allowed_ext=array("jpg","jpeg","png");
					$ext_arr=explode(".",$name);
					$ext=strtolower(end($ext_arr));
					if(in_array($ext,$allowed_ext)&& $_FILES['photo']['size'][$i]<=20000000)
					{
						move_uploaded_file($_FILES['photo']['tmp_name'][$i],"img/$name");
						mysqli_query($conn,"insert into listing_image(list_id,images) values('$list_id','$name')");
					}
					$i++;
				}
			
		}
	}
?>
<?php include_once('header.php');?>
<?php include_once('nav.php');?>
<div id="content">
	<div class="container">
		<form method="POST" enctype="multipart/form-data">
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
								if($cat->id==set_value('category'))$sel="selected";
								
								echo "<option value='$cat->id' $sel>$cat->name</option>";
								
							}
						?>
						</select>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>You are </label><br>
						<label><input type="radio" name="user" value="owner"  <?php if(set_value('user')=="owner"){echo 'checked';}?>>Owner</label>
						<label><input type="radio" name="user" value="agent" <?php if(set_value('user')=="agent"){echo 'checked';}?>>Agent</label>
						
					</div>
				</div>
			</div>
			<div class="row">	
				<div class="col-sm-6">
					<div class="form-group">
						<label>I want </label><br>
						<label><input type="radio" name="users" value="sell" <?php if(set_value('users')=="sell"){echo 'checked';}?> onclick="show_sell(this.checked)" >Sell</label>
						<label><input type="radio" name="users" value="rent" <?php if(set_value('users')=="rent"){echo 'checked';}?> onclick="show_status(this.checked)">Rent </label>
						<label><input type="radio" name="users" value="hostel" <?php if(set_value('users')=="hostel"){echo 'checked';}?> onclick="show_status(this.checked)">PG/Hostel</label>
						<label><input type="radio" name="users" value="roommate" <?php if(set_value('users')=="roommate"){echo 'checked';}?> onclick="show_status(this.checked)">Roommate</label>
						
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>Title of your property</label>
						<input type="text" class="form-control" name="title" value="<?php echo set_value('title');?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label>Description:</label><br>
						<textarea name="description" class="form-control" ></textarea>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>Terms:</label><br>
						<textarea name="terms" class="form-control" ></textarea>
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
									if(set_value('state')==$row->id) $sel="selected";
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
									if(isset($_POST['state']))
									{
										$query=mysqli_query($conn,"select * from city where state_id='$state'");
										while ($row=mysqli_fetch_object($query))
										{
											$sel="";
											if(set_value('city')==$row->id) $sel="selected";
											echo "<option value='$row->id' $sel>$row->city</option>";
										}
							
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
						<input type="text" name="locality" class="form-control">
					</div>
				</div>
				
				<div class="col-sm-6">
					<div class="form-group">
						<label>Accomodation for:</label><br>
						<label><input type="radio" name="for" value="male" >Male</label>
						<label><input type="radio" name="for" value="female" >Female</label>
						<label><input type="radio" name="for"  value="co-ed">Co-ed</label>
					</div>
				</div>
			</div>
			<?php
			if(set_value("users")=="rent" || set_value("users")=="hostel" || set_value("users")=="roommate") $class_a="block";
			else $class_a="none";
			
			?>
			<div class="row" style="display:<?php echo $class_a;?>" id="status_row">
				<div class="col-sm-6" >
					<div class="form-group">
						<label>Deposite:</label><br>
						<input type="text" name="deposite" class="form-control" value="<?php echo set_value('deposite');?>">
					</div>
				</div>
				<div class="col-sm-6"  >
					<div class="form-group">
						<label>Rent/month:</label><br>
						<input type="text" name="rent_month" class="form-control" value="<?php echo set_value('rent_month');?>">
					</div>
				</div>
			</div>
			<?php
			if(set_value("users")=="sell") $class="block";
			else $class="none";
			
			?>
			<div class="row" style="display:<?php echo $class;?>" id="sell_row">
				<div class="col-sm-6"  >
					<div class="form-group">
						<label>Price:</label><br>
						<input type="text" name="price" class="form-control" value="<?php echo set_value('price');?>">
					</div>
				</div>
				<div class="col-sm-6"  >
					<div class="form-group">
						<label>Area.:</label><br>
						<input type="text" name="area" class="form-control" value="<?php echo set_value('area');?>">
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
								$i=0;
								if(set_value('ammenities'))
								{
									$amm=set_value('ammenities');
								}
								else $amm=array();	
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
			if(!isset($_SESSION["userid"]))
			{	
			?>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label>Share your contact:</label><br>
						Name:<input type="text" name="name" class="form-control" >
						Mobile:<input type="text" name="mobile" class="form-control" >
						Email:<input type="text" name="email" class="form-control" >
					</div>
				</div>
			</div>
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
			<center><input type="submit" name="submit" class="btn btn-primary btn-lg btn-block"></center>
		</br></form>
	</div>		
		
	<script>
	function get_city(state_id)
	{
		$.ajax({
					type:'POST',
					url:'get_city_by_state.php',
					data:{'state':state_id},
					beforeSend:function()
					{
						$("#state_loading").show();
					},
					success:function(response)
					{
						$("#state_loading").hide();
						$("#city").html(response);
		}
		});
	}
</script>

<script>
	function show_sell(status)
	{
		if(status)
		{
			
			$("#sell_row").css("display","block");
			$("#status_row").hide();
			//$("input[name=deposite_price]").val("");
		}
		else
		{
			$("#sell_row").hide();
		}
	}
	function show_status(status)
	{
		if(status)
		{
			$("#status_row").show();
			$("#sell_row").hide();
		}
		else
		{
			$("#status_row").hide();
		}
	}
</script>
<?php
if(set_value('users')=="sell")
{
?>
<script>
	
//show_sell('checked');
</script>
<?php	
}	
?>
				
	
<?php include_once('footer.php');?>