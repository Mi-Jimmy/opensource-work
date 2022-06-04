<?php 
	//include constantsfile
	include('../config/constants.php');
	
	//echo"Delete Page"
	//check whether the id and image_name value is set or not
	if(isset($_GET['id']) AND isset($_GET['image_name']))
	{
		//Get the value and Delete
		//echo "Get Value and Delete";
		$id=$_GET['id'];
		$image_name=$_GET['image_name'];

		//Remove th phiscal image files is available
		if($image_name!="")
		{
			//image is available
			$path="../images/food/".$image_name;
			//Remove the image
			$remove=unlink($path);

			if($remove==false)
			{
				//set session message
				$_SESSION['remove']="<div class='error'>Failed to Remove food image</div>";
				//redirect
				header("location:".SITEURL.'admin/manage-food.php');
				//stop the process
				die();
			}
		}
		//Delete Data from database

		//SQL query delete data from database
		$sql="DELETE FROM tbl_food WHERE id=$id";
		//execute
		$res=mysqli_query($conn,$sql);

		//check whether the data is deleted from database or not
		if($res==true)
		{
			//SET successs message direct
			$_SESSION['delete']="<div class='success'>food Delete Successfully </div>";
			//redirect
			header("location:".SITEURL.'admin/manage-food.php');
		}
		else
		{
			$_SESSION['delete']="<div class='error'>Failed to Food Delete </div>";
			//redirect
			header("location:".SITEURL.'admin/manage-food.php');
	
		}

		//redirect
		header("location:".SITEURL.'admin/manage-food.php');
	}
	else 
	{
		//redirect to manage category
		$_SESSION['unauthorize']="<div class='error'>Unauthorized Access</div>";
		header('location:'.SITEURL.'admin/manage-food.php');
	}
 ?>