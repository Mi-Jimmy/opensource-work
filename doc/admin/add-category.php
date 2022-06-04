<?php include('partials/menu.php');?>

<div class="main-content">
	<div class=wrapper>
		<h1>Add Category</h1>

		<br><br>
		<?php
		
			if(isset($_SESSION['add']))
			{
				echo $_SESSION['add'];
				unset($_SESSION['add']);
			}
			if(isset($_SESSION['upload']))
			{
				echo $_SESSION['upload'];
				unset($_SESSION['upload']);
			}
		?>

		<br><br>
		<!--addcategory start here-->
		<form action="" method="POST" enctype="multipart/form-data">
			<table class="tbl-30">
				<tr>
					<td>Title:</td>
					<td>
						<input type="text" name="title" placeholder="Category Title">
					</td>
				</tr>

				<tr>
					<td>Select Image:</td>
					<td>
						<input type="file" name="image" >
					</td>
				</tr>

				<tr>
					<td>Featured:</td>
					<td>
						<input type="radio" name="featured" value="Yes">Yes
						<input type="radio" name="featured" value="No">No
					</td>
				</tr>

				<tr>
					<td>Active:</td>
					<td>
						<input type="radio" name="active"  value="Yes">Yes
						<input type="radio" name="active" value="No">No
					</td>
				</tr>

				<tr>
					<td colspan="2">	
						<input type="submit" name="submit" value="Add Category" class="btn-secondary">
					</td>		
				</tr>
			</table>
		<form>
		<!--addcategory ends here-->
		<?php
			//Check whether the submit button is clicked or not
			if(isset($_POST['submit']))
			{
				//get the value from category form
				$title=$_POST['title'];

				//For Radio input,we need to check wheter the button is selected or not
				if(isset($_POST['featured']))
				{
					// Get the value from form
					$featured=$_POST['featured'];
				}
				else
				{
					//Set the Default value
					$featured="No";
				}

				if(isset($_POST['active']))
				{
					$active=$_POST['active'];
				}
				else
				{
					$active="No";
				}

				//checl wheter image is selected or not and set the value for image name accordingly
				//print_r($_FILES['image']);

				//die();//break the code here


				if(isset($_FILES['image']['name']))
				{
					//upload Image
					//to upload image we need image name,source path and destination path
					$image_name=$_FILES['image']['name'];
					//upload the image only if image is selected
					if($image_name!="")
					{

					
						//Auto Rename our Image
						//Get the Extension of our Image
						$ext= end(explode('.',$image_name));

						//Rename the Image 
						$image_name="Food_Category_".rand(000,999).'.'.$ext;//e.g. food_category_834.jpg


						$source_path=$_FILES['image']['tmp_name'];
						$destination_path="../images/category/".$image_name;

						//finally upload image
						$upload =move_uploaded_file($source_path,$destination_path);

						//check whether the image is uploaded or not
						//adn if the image is not uploaded then we will stop the process and redirect with error message
						if($upload==false)
						{
							$_SESSION['upload']="<div class='error'>failed to upload image</div>";
							//Redirect
							header("location:".SITEURL.'admin/add-category.php');
							//stop the process
							die();
						}
					}
				}
				else
				{
					//do not upload
					$image_name="";
				}

				//create SQL Query to Insert Category into Database
				$sql="INSERT INTO tbl_category Set
					title='$title',
					image_name='$image_name',
					featured='$featured',
					active='$active';
				";

				//excute the query  and save in Database
				$res=mysqli_query($conn,$sql);

				//check whether the query executed or not and data added or not
				if($res==true)
				{
					//Query Executed and Category added
					$_SESSION['add']="<div class='success'>Category Added Successfully</div>";
					//Redirect
					header("location:".SITEURL.'admin/manage-category.php');
				}
				else 
				{
					
					//Failed to Add Category
					$_SESSION['add']="<div class='error'>Failed to add Category Added </div>";
					//Redirect
					header("location:".SITEURL.'admin/add-category.php');
				}
			}
			?>
	</div>
</div>

<?php include('partials/footer.php');?> 