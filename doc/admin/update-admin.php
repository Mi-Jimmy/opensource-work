<?php include ('partials/menu.php')?>

<div class="main-content">
	<div class="wrapper">
		<h1>Update Admin</h1>

		<br><br>

		<?php
			//Get the ID of selected Admin
			$id=$_GET['id'];


			//Create SQL Query to Get the Details
			$sql="SELECT * FROM tbl_admin WHERE id=$id";

			//excute the Query
			$res=mysqli_query($conn,$sql);

			//check whether the query is excuted or not
			if($res==true)
			{
				//check whether the data is avialabe or not
				$count =mysqli_num_rows($res);
				//check whether we have data or not
				if($count==1)
				{
					//Get the details
					$row=mysqli_fetch_assoc($res);

					$full_name=$row['full_name'];
					$username =$row['username'];
				}
				else
				{
					//Redirect to Manage Admin Page
					header('location:'.SITURL.'admin/manage-admin.php');
				}
			}
		?>
		<form action="" method="POST">
			
			<table class="tbl-30">
				<tr>
					<tr>
					<td>Full Name</td>
					<td><input type="text" name="full_name" value="<?php echo $full_name;?>"></td>
				</tr>

				<tr>
					<td>Username:</td>
					<td><input type="text" name="username" value="<?php echo $username;?>"></td>
				</tr>


				<tr>
					<td colspan="2">	
						<input type="hidden" name="id" value="<?php echo $id;?>" class="btn-secondary">
						<input type="submit" name="submit" value="Update Admin" class="btn-secondary">
					</td>		
				</tr>
				</tr>
			</table>
		</form>
	</div>
</div>

<?php

	//check whether the submit button is clicked or not
	if(isset ($_POST['submit']))
	{
		//echo "Button clicked";
		//Get all the values from form to update
		$id=$_POST['id'];
		$full_name=$_POST['full_name'];
		$username=$_POST['username'];

		//craeate SQL Query to update Admin
		$sql ="UPDATE tbl_admin SET
		full_name='$full_name',
		username='$username'
		WHERE id='$id';
		";

		//Execute the Query 
		$res =mysqli_query($conn,$sql);

		//check whether the query executed or not
		if($res==true)
		{
			//Query Executed Admin Updated
			$_SESSION['update']="<div class='success'>Admin Updated Sucessfully</div>";
			header("location:".SITEURL.'admin/manage-admin.php');
		}
		else
		{
			//Failed
			$_SESSION['update']="<div class='error'>Failed to Admin Updated </div>";
			header("location:".SITEURL.'admin/manage-admin.php');
		}
	}

?>

<?php include ('partials/footer.php')?>