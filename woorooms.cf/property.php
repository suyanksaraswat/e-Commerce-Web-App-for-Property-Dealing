<?php
	include_once('connect.php');
	$id=$_GET['id'];
	if(!(int)$id)
	{
		header('location:index.php');
	}
	$l_id=mysqli_query($conn,"select * from listing where id='$id'");
	if(mysqli_num_rows($l_id)==0)
	{
				header('location:index.php');

	}
	$listing=mysqli_fetch_object($l_id);
	mysqli_query($conn,"update listing set views=(views+1) where id='$id'");
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
          <!-- begin:article -->
		  <div class="col-md-3 col-md-pull-9 sidebar">
            <div class="widget-white favorite">
              <a href="#"><i class="fa fa-heart"></i> Add to favorite</a>
            </div>
            <!-- break -->
            
            <!-- break -->
            <div class="widget widget-sidebar widget-white">
              <div class="widget-header">
                <h3>Property Type</h3>
              </div>    
              <ul class="list-check">
                <li><a href="#">Rooms</a>&nbsp;</li>
                <li><a href="#">Flats</a>&nbsp;</li>
                <li><a href="#">Apartments</a>&nbsp;</li>
                <li><a href="#">Shops</a>&nbsp;</li>
                <li><a href="#">PG/Hostel</a>&nbsp;</li>
              </ul>
            </div>
           
          <div class="col-md-9 col-md-push-3">
            <div class="row">
              <div class="col-md-12 single-post">
                <ul id="myTab" class="nav nav-tabs nav-justified">
                  <li class="active"><a href="#detail" data-toggle="tab"><i class="fa fa-university"></i> Property Detail</a></li>
                  <li><a href="#location" data-toggle="tab"><i class="fa fa-paper-plane-o"></i> Property Location</a></li>
                </ul>

                <div id="myTabContent" class="tab-content">
                  <div class="tab-pane fade in active" id="detail">
                    <div class="row">
                      <div class="col-md-12">
                        <h2><?php echo $listing->title;?></h2>
                        <div id="slider-property" class="carousel slide" data-ride="carousel">
							<?php
							$sql_img=mysqli_query($conn,"select * from listing_image where list_id='$listing->id'");
							if(mysqli_num_rows($sql_img)>0)
							{
							?>
								<ol class="carousel-indicators">
								<?php
								$i=0;
								while($img=mysqli_fetch_object($sql_img))
								{
								?>
									<li data-target="#slider-property" data-slide-to="<?php echo $i;?>" class="">
									  <img src="img/<?php echo $img->image;?>" alt="">
									</li>
									
								<?php
									$i++;
								}	
								?>
									
									
								</ol>
							<?php	
							}	
							?>
							<?php
							$sql_img=mysqli_query($conn,"select * from listing_image where list_id='$listing->id'");
							if(mysqli_num_rows($sql_img)>0)
							{
							?>
								<div class="carousel-inner">
								<?php
								$i=0;
								while($img=mysqli_fetch_object($sql_img))
								{
								?>
									<div class="item <?php if($i==0){echo "active";}?>">
									  <img src="img/<?php echo $img->image;?>" alt="">
									</div>
									
								<?php
									$i++;
								}	
								?>
									
								<a class="left carousel-control" href="#slider-property" data-slide="prev">
								<span class="glyphicon glyphicon-chevron-left"></span>
							  </a>
							  <a class="right carousel-control" href="#slider-property" data-slide="next">
								<span class="glyphicon glyphicon-chevron-right"></span>
							  </a>	
								</div>
							<?php	
							}	
							?>
							
                        </div>
                        <h3>Property Overview</h3>
                        <table class="table table-bordered">
                          <tr>
                            <td width="20%"><strong>Id</strong></td>
                            <td>
							<?php
							
								echo $listing->id;
							?>
							
							</td>
                          </tr>
                          <tr>
                            <td><strong>type</strong></td>
                            <td>
							<?php
							$cats=mysqli_query($conn,"select * from property_type where id=$listing->category");
							$cat=mysqli_fetch_object($cats);
							
								echo $cat->name;
							?>
							</td>
                          </tr>
                          <tr>
                            <td><strong>state</strong></td>
                            <td>
								<?php
									$state_query=mysqli_query($conn,"select * from state where id=$listing->state") or die(mysqli_error($conn));
									$row=mysqli_fetch_object($state_query);
									echo $row->state;
								?>
							</td>
                          </tr>
                          <tr>
                            <td><strong>city</strong></td>
                            <td>
							<?php
									$query=mysqli_query($conn,"select * from city where id=$listing->city") or die(mysqli_erroe($conn));
									$city=mysqli_fetch_object($query);
									echo ucfirst ($city->city);
								?>
							</td>
                          </tr>
                          <tr>
                            <td><strong>locality</strong></td>
                            <td>
							<?php
								echo $listing->locality;
							?>
							</td>
                          </tr>
						  <tr>
                            <td><strong>Want</strong></td>
                            <td>
							<?php
								echo $listing->want;
							?>
							</td>
                          </tr>
						  <?php
						  if($listing->want=='sell')
						  {
							?>
                          <tr>
                            <td><strong>area</strong></td>
                            <td>
							<?php
								echo $listing->area;
							?>
							</td>
                          </tr>
						  <?php
						  }
						  else
						  {
							?>
							<tr>
                            <td><strong>deposit price</strong></td>
                            <td>
							<?php
								echo $listing->deposite;
							?>
							</td>
                          </tr>
							<?php  
						  }
						  ?>
						  <tr>
                            <td><strong>price</strong></td>
                            <td>
							<?php
								echo $listing->price;
							?></td>
                          </tr>
                        </table>
                        <h3>Property features</h3>
                        
						  <div class="row">
                          <?php
						  $am=explode(",",$listing->ammenities);
						  $sql_amm=mysqli_query($conn,"select * from ammenities");
						  while($amnt=mysqli_fetch_object($sql_amm))
						  {
							 
						  ?>
						  <div class="col-sm-4">
						  <ul>
						  <li>
						  <?php
							 if(in_array($amnt->id,$am))
							 {
								 echo "<i class='fa fa-check'></i> ";
							 }
							 else
								 echo "<i class='fa fa-times'></i> ";
								echo $amnt->name;
							
						  ?>
						  </ul>
						  </li>
						  </div>
						  <?php
						  }
						  ?>
						  </div>

                        <h3>Property Description</h3>
                        <p><?php echo $listing->description;?></p>
                      </div>
                    </div>

                    
                  </div>
                  <!-- break -->
                  <div class="tab-pane fade" id="location">
                    <div class="row">
                      <div class="col-md-12">
                        <div id="map-property"></div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <h3>Contact Agent</h3>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="team-container team-dark">
                          <div class="team-image">
                            <img src="img/team01.jpg" alt="the team - mikha realestate theme">
                          </div>
                          <div class="team-description">
                            <h3>Katty Sharon</h3>
                            <p><i class="fa fa-phone"></i> Office : 021-234-5678<br>
                            <i class="fa fa-mobile"></i> Mobile : +62-3456-78910<br>
                            <i class="fa fa-print"></i> Fax : 021-234-5679</p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua.</p>
                            <div class="team-social">
                              <span><a href="#" title="Twitter" rel="tooltip" data-placement="top"><i class="fa fa-twitter"></i></a></span>
                              <span><a href="#" title="Facebook" rel="tooltip" data-placement="top"><i class="fa fa-facebook"></i></a></span>
                              <span><a href="#" title="Google Plus" rel="tooltip" data-placement="top"><i class="fa fa-google-plus"></i></a></span>
                              <span><a href="#" title="Email" rel="tooltip" data-placement="top"><i class="fa fa-envelope"></i></a></span> 
                              <span><a href="#" title="LinkedIn" rel="tooltip" data-placement="top"><i class="fa fa-linkedin"></i></a></span> 
                            </div>                       
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6">
                        <form>
                          <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control input-lg" placeholder="Enter name : ">
                          </div>
                          <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control input-lg" placeholder="Enter email : ">
                          </div>
                          <div class="form-group">
                            <label for="telp">Mobile</label>
                            <input type="text" class="form-control input-lg" placeholder="Enter phone number : ">
                          </div>
                          <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control input-lg" rows="7" placeholder="Type a message : "></textarea>
                          </div>
                          <div class="form-group">
                            <input type="submit" name="submit" value="Send Message" class="btn btn-warning btn-lg">
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end:article -->

          <!-- begin:sidebar -->
           <!-- break -->
            
            <!-- break -->
          </div>
          <!-- end:sidebar -->
          
        </div>
      </div>
    </div>
    <!-- end:content -->
<!-- begin:news -->
    <div id="news">
      <div class="container">
        <div class="row">
         
          <!-- begin:agent -->
          <div class="col-md-4 col-sm-4">
            <div class="row">
              <div class="col-md-12">
                <div class="heading-title heading-title-sm bg-white">
                  <h2>Our Agents</h2>
                </div>
              </div>
            </div>
            <!-- break -->

            <div class="row">
              <div class="col-md-12">

                <div class="post-container post-noborder">
                  <div class="post-img" style="background: url(img/team03.jpg);"></div>
                  <div class="post-content list-agent">
                    <div class="heading-title">
                      <h2><a href="#">Julia</a></h2>
                    </div>
                    <div class="post-meta">
                      <span><i class="fa fa-envelope-o"></i> johndoe@domain.com</span><br>
                      <span><i class="fa fa-phone"></i> +12345678</span>
                    </div>
                  </div>
                </div>
                <!-- break -->

                <div class="post-container post-noborder">
                  <div class="post-img" style="background: url(img/avatar.png);"></div>
                  <div class="post-content list-agent">
                    <div class="heading-title">
                      <h2><a href="#">John Doe</a></h2>
                    </div>
                    <div class="post-meta">
                      <span><i class="fa fa-envelope-o"></i> johndoe@domain.com</span><br>
                      <span><i class="fa fa-phone"></i> +12345678</span>
                    </div>
                  </div>
                </div>
                <!-- break -->

                <div class="post-container post-noborder">
                  <div class="post-img" style="background: url(img/team01.jpg);"></div>
                  <div class="post-content list-agent">
                    <div class="heading-title">
                      <h2><a href="#">Jane Doe</a></h2>
                    </div>
                    <div class="post-meta">
                      <span><i class="fa fa-envelope-o"></i> johndoe@domain.com</span><br>
                      <span><i class="fa fa-phone"></i> +12345678</span>
                    </div>
                  </div>
                </div>
                <!-- break -->

              </div>
            </div>
            <!-- break -->

          </div>
          <!-- end:agent -->
        </div>
      </div>
    </div>
    <!-- end:news -->

 <!-- begin:subscribe -->
    <div id="subscribe">
      <div class="container">
        <div class="row">
          <div class="col-md-5 col-md-offset-2 col-sm-8 col-xs-12">
            <h3>Get Newsletter Update</h3>
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

    <!-- begin:partner -->
    <div id="partner">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="heading-title bg-white">
              <h2>Our Partnership</h2>
            </div>
          </div>
        </div>
        <!-- break -->

        <div class="row">
          <div class="col-md-12">
            <div class="jcarousel-wrapper">
              <div class="jcarousel">
                <ul>
                  <li><a href="#"><img src="img/img01.jpg" alt="partner of arillo responsive real estate theme"></a></li>
                  <li><a href="#"><img src="img/img02.jpg" alt="partner of arillo responsive real estate theme"></a></li>
                  <li><a href="#"><img src="img/img03.jpg" alt="partner of arillo responsive real estate theme"></a></li>
                  <li><a href="#"><img src="img/img04.jpg" alt="partner of arillo responsive real estate theme"></a></li>
                  <li><a href="#"><img src="img/img05.jpg" alt="partner of arillo responsive real estate theme"></a></li>
                  <li><a href="#"><img src="img/img06.jpg" alt="partner of arillo responsive real estate theme"></a></li>
                </ul>
              </div>
              <a href="#" class="jcarousel-control-prev"><i class="fa fa-angle-left"></i></a>
              <a href="#" class="jcarousel-control-next"><i class="fa fa-angle-right"></i></a>
              <!-- <p class="jcarousel-pagination"></p> -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end:partner -->

<?php
	include_once('footer.php');
?>