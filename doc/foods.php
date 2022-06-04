<?php include('partials-front/menu.php');?>


    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
            //Getting food from database that are feature and active=
            $sql2="SELECT * FROM tbl_food WHERE active='Yes'";
            $res2=mysqli_query($conn,$sql2);

            //count rows
            $count2=mysqli_num_rows($res2);

            if($count2>0)
            {
                //food available
                while($row=mysqli_fetch_assoc($res2))
                {
                        //get the value=
                        $title=$row['title'];
		                $description=$row['description'];
		                $price=$row['price'];
		                $image_name=$row['image_name'];
                        $id=$row['id'];
		                ?>
                         <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php
                                     //check whether image available or not
                                     if($image_name=="")
                                     {
                                         echo"<div class='error'>Image not available</div>";
                                     }
                                     else 
                                     {
                                         ?>
                                          <img src="<?php echo SITEURL?>images/food/<?php echo $image_name;?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                         <?php
                                     }

                                ?>
                               
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title;?></h4>
                                <p class="food-price"><?php echo $price?>NTD</p>
                                <p class="food-detail">
                                    <?php echo $description;?>
                                </p>
                                <br>

                                <a href="<?php echo SITEURL?>order.php?food_id=<?php echo $id;?>" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>
                        <?php
                }
            }
            else
            {
                echo"<div class='error'>Food not available.</div>";
            }
	

            ?>
          


            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->
<?php include('partials-front/footer.php');?>
