<!-- begin:navbar -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-top">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index-2.html"><span>Woo<strong>rooms.</strong></span></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-top">
          <ul class="nav navbar-nav navbar-right">
            <li ><a href="index.php">Home</a></li>
            <li class="dropdown">
              <a href="index.php" class="dropdown-toggle" data-toggle="dropdown">About <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="aboutus.php">about</a></li>
                <li><a href="team.php">team</a></li>
                <li><a href="mission.php">mission</a></li>
              </ul>
            </li>
						<li><a href="post.php" class="signup" >Post Your Room </a></li>

            <!--<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pages <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="blog.html">Blog Archive</a></li>
                <li><a href="blog_single.html">Blog Single</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="contact.html">Contact</a></li>
              </ul>
            </li>-->
			<?php
				if(!isset($_SESSION['username']))
				{
			?>
            <li><a href="login.php" class="signin" >Sign in</a></li>
            <li><a href="register.php" class="signup" >Sign up</a></li>

			<?php
				}
				else
				{
			?>
			<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">My Account <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="profile.php">Profile</a></li>
                <li><a href="setting.php">Setting</a></li>
                <li><a href="logout.php">Logout</a></li>
              </ul>
			  </li> 
       <?php
				}
	   ?>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container -->
    </nav>
    <!-- end:navbar -->
