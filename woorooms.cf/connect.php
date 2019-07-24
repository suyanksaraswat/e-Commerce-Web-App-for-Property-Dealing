<?php
	Session_start();
	$conn=mysqli_connect("localhost","woorooms","rooms@123","rooms");
	if(!$conn)
	{
		die("unable to connect");
	}
	else 
	{
		//echo "successfully connected";
	}
	function base_url()
	{
		return"http://localhost/project/";
	}
	function set_value($name)
	{
		if(isset($_POST[$name]))
		{
			return $_POST[$name];
		}
		else
		{
			return "";
		}
	}
	function get_value($name)
	{
		if(isset($_GET[$name]))
		{
			return $_GET[$name];
		}
		else
		{
			return "";
		}
	}
?>