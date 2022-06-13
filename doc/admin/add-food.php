<?php include('partials/menu.php');?>
<div class='main-content'>
	<div class='wrapper'>
	<h1>Add Food</h1>

	<br><br>

	<?php
		if(isset($_SESSION['upload']))
			{
				echo $_SESSION['upload'];
				unset($_SESSION['upload']);
			}	
	?>
	<form action=""method="POST"enctype="multipart/form-data">
		<table class tbl-30>
			
			<tr>
				<td>Title:</td>
				<td>
					<input type="text" name="title" placeholder="Food Title">
				</td>
			</tr>
			<tr>
				<td>Description</td>
				<td>
					<textarea name="description" cols="30" rows="5" placeholder="description of the food"></textarea>
				</td>
			</tr>

			<tr>
				<td>Price</td>
				<td>
					<input type="number" name="price" placeholder="price">
				</td>
			</tr>

			<tr>
				<td>Select Image:</td>
				<td>
					<input type="file" name="image">
				</td>
			</tr>

			<tr>
				<td>Category</td>
				<td>
					<select name="category">
						<?php
								//create php code to display categories from database
								//create sql to get all active categories from database
								$sql="SELECT * FROM tbl_category WHERE active='Yes'";
								
								
								$res=mysqli_query($conn,$sql);
								//count rows to check whether we have categories  or not
								$count=mysqli_num_rows($res);

								//if count is greater than zero ,we have categories else we do not have categories
								if($count>0)
								{
									while($row=mysqli_fetch_assoc($res))
									{
										//get the details of categories
										$id=$row['id'];
										$title=$row['title'];
										?>
										<option value="<?php echo $id?>"><?php echo $title ?></option>
										<?php
									}
								}
								else
								{
									?>
									<option value="0">No categories Found </option>
									<?php
								}

								//diplay on drpopdown
						?>
						
					</select>
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
						<input type="submit" name="submit" value="Add Food" class="btn-secondary">
					</td>		
			</tr>
		</table>

		<?php
			//check whether the button is clicked or not
			if(isset($_POST['submit']))
			{
				//add the food in database
				//echo"Clicked";

				//1. get the data from form
				$title=$_POST['title'];
				$description=$_POST['description'];
				$price=$_POST['price'];
				$category=$_POST['category'];

				//check whether radion button for featured and active are cecked or not
				if(isset($_POST['featured']))
				{
					$featured=$_POST['featured'];
				}
				else
				{
					$featured='No';
				}
				if(isset($_POST['active']))
				{
					$active=$_POST['active'];
				}
				else
				{
					$featured='No';
				}

				//2.upload the image if selected
				//check whether the select image is clicked or not and upload the image only if the image is selected

				if(isset($_FILES['image']['name']))
				{
					//Get the details of the selected Image
					$image_name=$_FILES['image']['name'];
					//check whether  the image is selected or not
					if($image_name!="")
					{
						//image selected
						//A. rename the Image

						$ext= end(explode('.',$image_name));
						$image_name="Food-Name-".rand(000,999).'.'.$ext;

						//B.upload image
						//get the src path and destination patH

						
						//source path is the current location of the Image
						$src=$_FILES['image']['tmp_name'];

						//DELETION PATH FO THE IMAGE TO UPLOADD
						$dst="../images/food/".$image_name;

						//Finally
						$upload=move_uploaded_file($src,$dst);

						//check whether image upload or  not
						if($upload==false)
						{
							//failed to upload the IMAGE
							//Redirect to add food page with error message
							$_SESSION['upload']="<div class ='error'>Failed to Upload Image</div>";
							header("location:".SITEURL.'admin/add-food.php');
							//stop process
							die();
						}
					}
				}
				else
				{
					$image_name="";
				}
				//3. insert to  database


				//create a sql query to save and add Food
				//for numerical we do not need to pass value insoide quotes'' but for string value it is compulsory
				$sql2="INSERT INTO tbl_food SET
				title='$title',
				description='$description',
				price='$price',
				image_name='$image_name',
				category_id='$category',
				featured='$featured',
				active='$active'
				";

				//execute
				$res2=mysqli_query($conn,$sql2);
				//4.Redirect
				if($res2==true)
				{
					//data inserted succesfully
					$_SESSION['add']="<div class='success'>Food Added succesfully</div>";
					header("location:".SITEURL.'admin/manage-food.php');
				}
				else
				{
					//failed
					$_SESSION['add']="<div class='error'>Failed to add Food Added </div>";
					header("location:".SITEURL.'admin/manage-food.php');
				}

				
			}
		?>
	</form>
	</div>
</div>
<?php include('partials/footer.php');?>
