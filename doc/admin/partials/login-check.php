<?php
	//Authorization -Acess Control
	//Check whether the user is logged in or not
	if(!isset($_SESSION['user']))//if user session is not set
	{
		//user is not loged in
		$_SESSION['no-login-message']="<div class='error text-center'>Please login to access Admin Panel.</div>";
		//Redirectt to login page wirh message
		header("location:".SITEURL.'admin/login.php');
	}
?>