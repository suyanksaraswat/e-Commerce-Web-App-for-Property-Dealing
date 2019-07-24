<?php
	include_once('connect.php');
?>
<?php
	include_once('header.php');
?>
<?php
	include_once('nav.php');
?>
<!-- begin:header -->
    <div id="header" class="header-slide">
      <div class="container">
        <div class="row">
          <div class="col-md-5">
            <div class="quick-search">
              <div class="row">
                <form role="form" action="search.php" method="GET">
                <div class="form-group">
                 <label for="location">State</label>
				 <select class="form-control" id="state" onchange="get_city(this.value)" name="state">
				 <option value=0></option>
                 <?php
								$state_query=mysqli_query($conn,"select * from state");
								while ($row=mysqli_fetch_object($state_query))
								{
									$sel="";
									if(get_value('state')==$row->id) $sel="selected";
									echo "<option value='$row->id' $sel>$row->state</option>";
								}
				 ?>
				</select>
                </div>
				<div class="form-group">
                  <label for="location">City</label>
                  <select class="form-control" id="city" name="city" >
							<option></option>
							<?php
								if(isset($_GET['state']))
								{
											$query=mysqli_query($conn,"select * from city where state_id=('".$_GET['state']."')");
											while ($city=mysqli_fetch_object($query))
											{
												$sel="";
												if($city->id==get_value('city'))$sel="selected";
												echo "<option value='$city->id' $sel>$city->city</option>";
									
											}
								}
							?>
						</select>
                </div>
				<div class="form-group">
                  <label for="type">Search Type</label>
                  <select class="form-control" name="searchtype">
				  <option></option>
                    <option value="sell" <?php if(get_value('searchtype')=="sell"){echo 'selected';}?>>Sell</option>
                    <option  value="rent" <?php if(get_value('searchtype')=="rent"){echo 'selected';}?>>Rent</option>
                    <option  value="hostel" <?php if(get_value('searchtype')=="hostel"){echo 'selected';}?>>hostel</option>
                    <option  value="roommate" <?php if(get_value('searchtype')=="roommate"){echo 'selected';}?>>Roommate</option>
							
				
                  </select>
                </div>
                
                <div class="form-group">
                  <label for="type">Property Type</label>
                  <select class="form-control" name="propertytype">
				  <option></option>    
				  <?php
							$cats=mysqli_query($conn,"select * from property_type");
							while($cat=mysqli_fetch_object($cats))
							{
								$sel="";
								if($cat->id==get_value('propertytype'))$sel="selected";
								echo "<option value='$cat->id' $sel>$cat->name</option>";
								
							}
				 ?>
						
				  </select>
                </div>
                <div class="form-group">
                  <label for="min-price">Min Price</label>
				  <input type="text" name="minprice" value="" class="form-control">
				  
                    </div>
                <div class="form-group" >
                  <label for="max-price">Max Price</label>
				  <input type="text"  name="maxprice"  value="" class="form-control">
                </div>
                 <input type="submit" name="" value="Search" class="btn btn-warning btn-block">
              </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end:header -->
		<div id="content">
      <div class="container">
	 <!-- begin:latest -->
        <div class="row">
          <div class="col-md-12">
            <div class="heading-title">
              <h2>LATEST PROPERTY</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <?php
				$sql="select * from listing limit 4";
				$query=mysqli_query($conn,$sql);
				while($row=mysqli_fetch_object($query))
				{
			?>
							<div class="col-md-3 col-sm-6 col-xs-12">
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
                        
						</small>
                  </div>
                </div>
				</div>
				<?php
				}
				?>
            </div>
        <!-- end:latest -->
	</div>
	</div>
	
<?php
	include_once('footer.php');
?>
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