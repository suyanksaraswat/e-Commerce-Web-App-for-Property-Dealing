<?php
	include_once('connect.php');
	if(isset($_GET['page']) && is_numeric($_GET['page']))
	{
		$page=$_GET['page'];
		
	}
	else $page=1;
	$query_string=$_SERVER['QUERY_STRING'];
	$query_string_array=explode("&",$query_string);
	$last=end($query_string_array);
	$last_array=explode("=",$last);
	if(strpos($last,"page")!==FALSE)
	{
		array_pop($query_string_array);
	}
	$query_string=implode("&",$query_string_array);
	$previous_link="search.php?".$query_string."&page=".($page-1);
	$next_link="search.php?".$query_string."&page=".($page+1);

	$limit=12;
	$start=($page-1)*$limit;
	$link="search.php?";
	$sql="select * from listing where is_active=1 ";
		if(isset($_GET['searchtype'])&&($_GET['searchtype']!=""))
		{
			$searchtype=trim($_GET['searchtype']);
			$link.="&searchtype=$searchtype";
			$sql.=" and want='$searchtype'";
		}
			if(isset($_GET['propertytype'])&&($_GET['propertytype']!=""))
		{
			$propertytype=trim($_GET['propertytype']);
			$link.="&propertytype=$propertytype";
			$sql.=" and category='$propertytype'";
		}
		if(isset($_GET['state'])&&($_GET['state']!=""))
		{
			$state=trim($_GET['state']);
			$link.="&state=$state";
			$sql.=" and state='$state'";
		}
		if(isset($_GET['city'])&&($_GET['city']!=""))
		{
			$city=trim($_GET['city']);
			$link.="&city=$city";
			$sql.=" and city='$city'";
		}
		if(isset($_GET["minprice"]) && isset($_GET["maxprice"]))
		{
			$min=$_GET["minprice"];
			$max=$_GET["maxprice"];
			$link.="&minprice=$min&maxprice=$max";
			
			if($min!="" && $max!="")
			{
				$sql.=" and price>='$min'";
				
			
			}	
			if($min!="" && $max!="")
			{
				$sql.=" and price<='$max'";
				
			}
		}
		 //echo $sql;
		$t_sql=mysqli_query($conn,$sql);
		
		$t_rows=mysqli_num_rows($t_sql);
		$sql.="limit $start,$limit";
		//echo $sql;
		$t_page=ceil($t_rows/$limit);
?>
<?php
	include_once('header.php');
	
?>
<?php
	include_once('nav.php');
?>
<div id="header" class="heading" style="background-image: url(img/img01.jpg);">
      <div class="container">
        <div class="row">
          <div class="col-md-10 col-md-offset-1 col-sm-12">
            <div class="page-title">
              <h2>Search</p>
            </div>
            <ol class="breadcrumb">
              <li><a href="index.php">Home</a></li>
              <li class="active">Search</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
 <!-- begin:content -->
    <div id="content">
      <div class="container">
        <div class="row">
          <!-- begin:article --><!-- begin:sidebar -->
          <div class="col-md-3  sidebar">
            <div class="widget widget-white">
              <div class="widget-header">
                <h3>Advance Search</h3>
				<?php
					
				?>
              </div>    
              <form role="form" class="advance-search" method="GET">
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
            <!-- break -->
          </div>
          <!-- end:sidebar -->
          
          <div class="col-md-9 ">


            <!-- begin:product -->
            <div class="row container-realestate">
			<?php
				$query=mysqli_query($conn,$sql);
				while($row=mysqli_fetch_object($query))
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
							<span><?php echo ucfirst($row->want);?></span>
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
                          <!-- end:product -->

            <!-- begin:pagination -->
            <div class="row">
              <div class="col-md-12">
			  <ul class="pager">
			  <?php
				if($page>1)
					{
			  ?>
              <li class="previous"><a href="<?php echo $previous_link;?>">Previous</a></li>
              <?php
					}  
					if($page<$t_page)
					{
				?>
				  <li class="next"><a href="<?php echo $next_link;?>">Next</a></li>
                <?php
					}
				?>
				</ul>
              </div>
            </div>
            <!-- end:pagination -->
          </div>
          <!-- end:article -->  
        </div>
      </div>
    </div>
    <!-- end:content -->

    
    <!-- begin:subscribe -->
    <div id="subscribe">
      <div class="container">
        <div class="row">
          <div class="col-md-5 col-md-offset-2 col-sm-8 col-xs-12">
            <h4>Get Newsletter Update</h4>
          </div>
          <div class="col-md-3 col-sm-4 col-xs-12">
            <div class="input-group">
              <input type="text" class="form-control input-lg" placeholder="Enter your mail">
              <span class="input-group-btn">
                <button class="btn btn-warning btn-lg" type="submit"><i class="fa fa-envelope"></i></button>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end:subscribe -->
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
<?php
if(get_value('users')=="sell")
{
?>

<script>
//show_sell('checked');

</script>

<?php	
}	
?>
				

<?php
include_once('footer.php');
?>