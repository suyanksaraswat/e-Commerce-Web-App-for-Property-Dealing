<?php
include_once('connect.php');
if(isset($_POST['state']))
{
	$state_id=$_POST['state'];
	$query=mysqli_query($conn,"select * from city where state_id=$state_id");
	if (mysqli_num_rows($query)>0)
	{
		echo "<option></option>";
	while ($row=mysqli_fetch_object($query))
	{
		echo"<option value='$row->id'>$row->city</option>";
	}
	}
}
?>