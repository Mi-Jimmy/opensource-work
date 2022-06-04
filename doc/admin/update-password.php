<?php include('partials/menu.php');?>

<div class="main-content">
	<div class="wrapper">
		<h1>Change Password</h1>
		<br><br>

		<?php
			if(isset($_GET['id']))
			{
				$id=$_GET['id'];
			}
		?>
		<form action="" method='POST'>
			<table class='tbl-30'>
				<tr>
					<tr>
					<td>Current Password:</td>
					<td>
						<input type="password" name="current_password" placeholder="Old Password">
					</td>
				</tr>

				<tr>
					<tr>
					<td>New Password:</td>
					<td>
						<input type="password" name="new_password" placeholder="New Password">
					</td>
				</tr>

				<tr>
					<tr>
					<td>Confirm Password:</td>
					<td>
						<input type="password" name="confirm_password" placeholder="Confirm Password">
					</td>
				</tr>

				<tr>
					<td colspan="2">		
						<input type="hidden" name="id" value="<?php echo $id;?>" class="btn-secondary">
						<input type="submit" name="submit" value="Change Password" class="btn-secondary">
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>

<?php
		//check whether	the submit Button is clicked or not
		if(isset($_POST['submit']))
		{
			//echo "clicked";

			//Get the data from Form

			$id=$_POST['id'];
			$current_password=md5($_POST['current_password']);
			$new_password=md5($_POST['new_password']);
			$confirm_password =md5($_POST['confirm_password']);
				
			//check whether the user with current ID nad Current Password Exists or NOT
			$sql="SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";
			//check whether the Password and Confirm Password match or not
			$res=mysqli_query($conn,$sql);

			if($res==true)
			{
				//Check whether data is available or not
				$count=mysqli_num_rows($res);
				if($count==1)
				{
					//User Exists and Password can be changed
					//echo "User Found";
					//check whether the new password and confirm match or not
					if($new_password==$confirm_password)
					{
						//update password
						//echo "Password Match";
						$sql2=" UPDATE tbl_admin SET
							password='$new_password'
							WHERE id=$id;
						";
						$res2=mysqli_query($conn,$sql2);
						//check whether the query excuted or not;
						if($res2==TRUE)
						{
							//Display Sucess Message
							$_SESSION['change-pwd']="<div class='success'>Password change sucessfully</div>";
							header("location:".SITEURL.'admin/manage-admin.php');
						}
						else
						{
							//Display Error Message
							$_SESSION['change-pwd']="<div class='error'>Failed change Password</div>";
							header("location:".SITEURL.'admin/manage-admin.php');
						}	
						
					}else
					{
						//Redirect manage faile to updated password
						$_SESSION['password-not-match']="<div class='error'>Password is wrong.</div>";
						header("location:".SITEURL.'admin/manage-admin.php');
					}
					
				}
				else
				{	
					//user does not exist	
					$_SESSION['user-not-found']="<div class='error'>User not found.</div>";
					header("location:".SITEURL.'admin/manage-admin.php');
				}
			}
			//Change Password if all above is true
		}
?>



<?php include('partials/footer.php');?>