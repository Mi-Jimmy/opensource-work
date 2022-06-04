<?php include('partials/menu.php');?>
			
		<!--Main Content Starts-->
		<div class="main-content">
			<div class="wrapper">
				<h1>DASHBOARD</h1>
				<br>
				<?php
				if(isset($_SESSION['login']))
				{
					echo $_SESSION['login'];
					unset($_SESSION['login']);
				}
				?>
				<br><br>

				<div class='col-4 text-center'>
					<?php
						//sql Query
						$sql="SELECT * FROM tbl_category";
						//Execute Query
						$res=mysqli_query($conn,$sql);

						$count=mysqli_num_rows($res);
					?>
					<h1><?php echo $count;?></h1>
					<br/>
					Categories
				</div>

				<div class='col-4 text-center'>
					
					<?php
						//sql Query
						$sql2="SELECT * FROM tbl_food";
						//Execute Query
						$res2=mysqli_query($conn,$sql2);

						$count2=mysqli_num_rows($res2);
					?>
					<h1><?php echo $count2?></h1>
					<br/>
					Foods
				</div>

				<div class='col-4 text-center'>
					<?php
						//sql Query
						$sql3="SELECT * FROM tbl_order";
						//Execute Query
						$res3=mysqli_query($conn,$sql3);

						$count3=mysqli_num_rows($res3);
					?>
					<h1><?php echo $count3;?></h1>
					<br/>
					Total Orders
				</div>

				<div class='col-4 text-center'>
					<?php
						//create sql query to get revenue Generated
						$sql4="SELECT SUM(total)AS Total FROM tbl_order WHERE status='Delivered'";

						$res4=mysqli_query($conn,$sql4);

						//get the value
						$row4=mysqli_fetch_assoc($res4);

						//get the total revenue
						$total_revenue=$row4['Total'];
					
					?>
					<h1><?php if($total_revenue==0)echo 0;else{echo $total_revenue;}?></h1>
					<br/>
					Revenue Generated
				</div>

				<div class= "clearfix"></div>

			</div>
			
		</div>
<?php include('partials/footer.php');?>

