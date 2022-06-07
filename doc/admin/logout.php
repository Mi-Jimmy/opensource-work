<?php
	//Include constants.php
	include('../config/constants.php');
	//1. Destory the Session

	//Redirect to login page
	header("location:".SITEURL.'admin/login.php');
?>
