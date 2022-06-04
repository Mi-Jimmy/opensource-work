<?php include('partials/menu.php');?>

<?php
	//check whether id is set or Not
	if(isset($_GET['id']))
	{
		//get all details
		$id=$_GET['id'];
		//sql query to get the select Food

		$sql2="SELECT * FROM tbl_food WHERE id=$id";
		$res2=mysqli_query($conn,$sql2);

		//get the values based on query executed
		$row2=mysqli_fetch_assoc($res2);

		//get the individual values of selected Food
		$title=$row2['title'];
		$description=$row2['description'];
		$price=$row2['price'];
		$current_image=$row2['image_name'];
		$current_category=$row2['category_id'];
		$featured=$row2['featured'];
		$active=$row2['active'];
	}
	else 
	{
		header("location:".SITEURL.'admin/manage-food.php');
	}

?>

<div class="main-cotent">
	<div class=wrapper>
		<h1>Update Food</h1>

		<br><br>

		<form action="" method="POST" enctype="multipart/form-data">
		
		<table class="tbl-30">
			
			<tr>
				<td>Title</td>
				<td>
					<input type="text" name="title" value="<?php echo $title;?>" >
				</td>
			</tr>

			<tr>
				<td>Description</td>
				<td>
					<textarea name="description" cols="30" rows="5" ><?php echo $description;?></textarea>
				</td>
			</tr>

			<tr>
				<td>Price</td>
				<td>
					<input type="number" name="price" value="<?php echo $price;?>" >
				</td>
			</tr>

			<tr>
					<td>Current Image</td>
					<td>
					<?php
						if($current_image!="")
						{
							?>
							<img src="<?php echo SITEURL;?>images/food/<?php echo $current_image; ?>"width="150px">
							<?php
						}
						else 
						{
							echo"<div class='error'>Image not added</div>";
						}
					?>

					</td>
			</tr>

			<tr>
					<td>New Image</td>
					<td>
						<input type="file" name="image" >
					</td>
			</tr>

			<tr>
				<td>Category</td>
				<td>
					<select name="category">
						<?php
							$sql="SELECT * FROM tbl_category WHERE active='Yes'";
							$res=mysqli_query($conn,$sql);

							//count rows
							$count=mysqli_num_rows($res);

							//check whether category available or not 
							if($count>0)
							{
								while($row=mysqli_fetch_assoc($res))
								{
									$category_title=$row['title'];
									$category_id=$row['id'];
									//echo "<option value='$category_id'>$category_title</option>";
									?>
									<option <?php if($current_category==$category_id) {echo "selected";}?>value="<?php echo $category_id?>"><?php echo $category_title?></option>
									<?php
								}
							}

							else
							{
								echo"<option value='0'>Category Not Available</option>";
							}

						?>
					</select>
				</td>
			</tr>

			<tr>
					<td>Featured</td>
					<td>
						<input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
						<input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No">No
					</td>
			</tr>

			<tr>
					<td>Active</td>
					<td>
						<input <?php if($active=="Yes"){echo "checked";}?> type="radio" name="active" value="Yes">Yes
						<input <?php if($active=="No"){echo "checked";}?> type="radio" name="active" value="No">No
					</td>
			</tr>

			<tr>
					<td>
							<input type="hidden" name="id" value="<?php echo $id;?>">
							<input type="hidden" name="current_image" value="<?php echo $current_image;?>">
							<input type="submit" name="submit" value="Update Food" class="btn-secondary">
					</td>		
			</tr>
		</table>
		</form>
		<?php
		
		if(isset($_POST['submit']))
			{
				
				//Get all the values from our  form
				$id=$_POST['id'];
				$title=$_POST['title'];
				$description=$_POST['description'];
				$price=$_POST['price'];
				$current_image=$_POST['current_image'];
				$category=$_POST['category'];

				$featured=$_POST['featured'];
				$active=$_POST['active'];

				if(isset($_FILES['image']['name']))
				{
					//Got The image detail
					$image_name=$_FILES['image']['name'];

					if($image_name != "")
					{
						//image available
						//A.upload your image
						
						//Auto Rename our Image
						//Get the Extension of our Image
						$ext= end(explode('.',$image_name));

						//Rename the Image 
						$image_name="Food_Name_".rand(000,999).'.'.$ext;//e.g. food_category_834.jpg


						$source_path=$_FILES['image']['tmp_name'];
						$destination_path="../images/food/".$image_name;

						//finally upload image
						$upload =move_uploaded_file($source_path,$destination_path);

						//check whether the image is uploaded or not
						//adn if the image is not uploaded then we will stop the process and redirect with error message
						if($upload==false)
						{
							$_SESSION['upload']="<div class='error'>failed to upload image</div>";
							//Redirect
							header("location:".SITEURL.'admin/manage-food.php');
							//stop the process
							die();
						}
						//B.remove the current image
						if($current_image!="")
						{
							$remove_path="../images/food/".$current_image;
							$remove= unlink($remove_path);

							//check whether the image is removed or not
							//if failed to remove them display message and stop the process
							if($remove==false)
							{
								$_SESSION['failed-remove']="<div class='error'>Failed to remove image</div>";
								header("location:".SITEURL.'admin/manage-food.php');
								die();
							}
						}
						

					}
					else
					{
						$image_name=$current_image;
					}

				}
				else
				{
					$image_name=$current_image;
				}
				$sql3=" UPDATE tbl_food SET
					title='$title',
					image_name='$image_name',
					description='$description',
					price='$price',
					category_id='$category',
					featured='$featured',
					active='$active'
					WHERE id=$id
				";
				$res3=mysqli_query($conn,$sql3);

				//redirect
				if($res3==true)
				{
					$_SESSION['update']="<div class='success'>Update Successfully </div>";
					header("location:".SITEURL.'admin/manage-food.php');
				}
				else
				{
					$_SESSION['update']="<div class='error'>Failed to Update Food </div>";
					header("location:".SITEURL.'admin/manage-food.php');
				}

			}
		?>

	</div>
</div>

<?php include('partials/footer.php');?>