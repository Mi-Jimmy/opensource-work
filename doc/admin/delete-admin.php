<?php

	//Include constant.php here
	include('../config/constants.php');

	//get the ID of admin to be deleted
	$id=$_GET['id'];
		
	//create SQL Query to Delete Admin
	$sql="Delete FROM tbl_admin WHERE id=$id";

	//Execute the Query
	$res=mysqli_query($conn,$sql);
	//check whether the Query executed sucessfully or not
	if($res==true)
	{
		//Query executed sucessfully and admin deleted
		//echo "Admin Deleted";
		//create Session variable to display message
		$_SESSION['delete']= "<div class='sucess'>Admin Deleted Sucessfully.</div>";
		//Redirect to Manage Admin Page
		header("location:".SITEURL.'admin/manage-admin.php');
	}
	else
	{
		//failed to deleted admin
		//echo "Failed to Delete Admin";
		$_SESSION['delete']="<div class='error'>Failed to Deleted Admin. Try Again</div>";
		header("location:".SITEURL.'admin/manage-admin.php');
	}
	//Redirect to Manage Admin page with message(sucess/error)
?>