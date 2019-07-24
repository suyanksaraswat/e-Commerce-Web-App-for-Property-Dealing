<?php
	include_once('connect.php');
	if(!isset($_SESSION['userid']))
	{
		header('location:login.php');
		
	}
	if(!isset($_GET['page']) || !is_numeric($_GET['page']))
	{
		$page=1;
	}
	else $page=$_GET['page'];
	
	$limit=3;
	$start=($page-1)*$limit;
	$user_id=$_SESSION['userid'];
	$sql_total=mysqli_query($conn,"select * from listing where user_id='$user_id'");
	$total_page=ceil(mysqli_num_rows($sql_total)/$limit);
	$sql_listing=mysqli_query($conn,"select * from listing where user_id='$user_id' limit $start,$limit" );
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
		 <div class="row container-realestate">
			
			<?php
			while($row=mysqli_fetch_object($sql_listing))
				{
			?>
							<div class="col-md-4 col-sm-6 col-xs-12">
							<div class="property-container">
							<div class="property-image">
							<?php
								$sql_img=mysqli_query($conn,"select * from listing_image where list_id='$row->id' limit 1") or die(mysqli_error($conn));
								if(mysqli_num_rows($sql_img)>0)
								{	 
									$img=mysqli_fetch_object($sql_img);
									$img_name=$img->image;
								}
								else $img_name='HOME.jpg';	
							?>
							<a href="property.php?id=<?php echo $row->id;?>"><img src="img/<?php echo $img_name;?>" alt="<?php echo $row->title;?>"></a>
							<div class="property-price">
							<?php
								$sql_type=mysqli_query($conn,"select * from property_type where id='$row->category' ");
								$type=mysqli_fetch_object($sql_type);
							?>
								<h4><?php echo $type->name;?></h4>
								
							
							<span><i class="fa fa-inr"></i>
							<?php echo $row->price?></span>						
							</div>
							<div class="property-status">
							<span><?php echo ucfirst($row->type);?></span>
							</div>
							</div>
							<!--<div class="property-features">
							<span><i class="fa fa-home"></i> 5,000 m<sup>2</sup></span>
							<span><i class="fa fa-hdd-o"></i> 2 Bed</span>
							<span><i class="fa fa-male"></i> 2 Bath</span>
							</div>-->
							<div class="property-content">
							
							<h3><a href="property.php?id=<?php echo $row->id;?>"><?php echo $row->title;?></a> <br>
						<small>
						<span><?php echo ucfirst($row->locality);?></span>
						<?php
							$sql_city=mysqli_query($conn,"select * from city where id='$row->city'") or die(mysqli_error($conn));
							if(mysqli_num_rows($sql_city))
							{
								$city=mysqli_fetch_object($sql_city);
								echo ",".ucfirst($city->city);
							}	
							$sql_state=mysqli_query($conn,"select * from state where id='$row->state'");
							if(mysqli_num_rows($sql_state)>0)
							{
								$state=mysqli_fetch_object($sql_state);
								echo ",".ucfirst($state->state);
							}	
						?>
                        
						</small><br/>
						<a href="edit.php?id=<?php echo $row->id;?>">edit</a>
						<a href="delete.php?id=<?php echo $row->id;?>" onclick="return confirm('are you shure')">delete</a>
                  </div>
                </div>
				</div>
				<?php
				}
				
				?>
				
              </div>
			<ul class="pagination">
				<?php
					$i=1;
					while($i<=$total_page)
					{
				?>
				<li <?php if($page==$i){ echo 'class="active"';}?>> 
				
				<a href="my_listing.php?page=<?php echo $i;?>"><?php echo $i;?></a>
				</li>
				<?php
						$i++;
					}
				?>
				</ul>
		
		</div>
		</div>
	</div>
	</div>
<?php
	include_once('footer.php');
?>
