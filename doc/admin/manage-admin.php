<?php include('partials/menu.php');?>

		
<div class="main-content">
			<div class="wrapper">
				<h1>Manage Admin</h1>

				<br/>

				<!--Button to add admin-->
				<a href="add_admin.php" class="btn-primary">Add Admin</a>

				<br/><br/><br/>

				<?php
					if(isset($_SESSION['add']))
					{
						echo $_SESSION['add'];
						unset($_SESSION['add']);
					}

					if(isset($_SESSION['delete']))
					{
						echo $_SESSION['delete'];
						unset($_SESSION['delete']);
					}

					if(isset($_SESSION['update']))
					{
						echo $_SESSION['update'];
						unset($_SESSION['update']);
					}

					if(isset($_SESSION['user-not-found']))
					{
						echo $_SESSION['user-not-found'];
						unset($_SESSION['user-not-found']);
					}

					
					if(isset($_SESSION['password-not-match']))
					{
						echo $_SESSION['password-not-match'];
						unset($_SESSION['password-not-match']);
					}

					if(isset($_SESSION['change-pwd']))
					{
						echo $_SESSION['change-pwd'];
						unset($_SESSION['change-pwd']);
					}

					
				?>

				<table class="tbl-full">
					
					<tr>
						<th>S.N.</th>
						<th>Full Name</th>
						<th>Username</th>
						<th>Actions</th>
					</tr>

					<?php
						//Query to Get all Admin
						$sql="SELECT * FROM tbl_admin";
						//excute the Query
						$res=mysqli_query($conn,$sql);

						//check whether the	Query is Executed or Not

						if($res==TRUE)
						{
							//Count rows to Check whether we have data in database or not
							$rows=mysqli_num_rows($res);//function to get all rows int database
							
							//Check the num of rows
							if($rows>0)
							{
								$sn=1;

								//We Have data in database
								while($rows=mysqli_fetch_assoc($res))
								{
									//Using while loop to get all the data from database
									//And While loop will run as long as we have data in database

									//Get individual Data
									$id=$rows['id'];
									$full_name=$rows['full_name'];
									$username=$rows['username'];

									//Display the Values in our	Table
									?>

									<tr>
											<td><?php echo $sn++ ; ?></td>
											<td><?php echo $full_name; ?></td>
											<td><?php echo $username; ?></td>
										<td>
											<a href="<?php echo SITEURL;?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
											<a href="<?php echo SITEURL;?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
											<a href="<?php echo SITEURL;?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
										</td>
									</tr>

									<?php
								}
							}
							else
							{
								//We Don't Have data in database
							}

						}
					?>

					

				</table>
			</div>
</div>
<?php include('partials/footer.php');?>