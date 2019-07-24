<?php
	$to="shweta@gmail.com";
	$subject="emailtesting-php";
	$messageg="first php e-mail";
	$headers="MIME-Version-1.0\r\n";
	$headers.="Content-type:text/html;charset=UTF-8";
	$headers.="from:himanshicharan6@gmail.com\r\n";
	$headers.="cc:emailID\r\n";
	$headers.="bcc:emailID\r\n";
	$message="<img src=''>";
	$message="<table></table>";
	mail($to,$subject,$message,$headers);
	
?>