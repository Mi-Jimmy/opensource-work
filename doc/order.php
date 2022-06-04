<?php include('partials-front/menu.php');?>

<?php

        //check whether food id is set or not
        if(isset($_GET['food_id']))
        {
            //get the food id and  details of selected food
            $food_id=$_GET['food_id'];

            //Get the details of selected food
            $sql="SELECT * FROM tbl_food WHERE id=$food_id";
            //Execute the Query
            $res=mysqli_query($conn,$sql);
            //count the rows
            $count=mysqli_num_rows($res);
            //check whether the data available
            if($count==1)
            {
                //we have data
                //get the data  from database
                $row=mysqli_fetch_assoc($res); 
                $title=$row['title'];
                $price=$row['price'];
                $image_name=$row['image_name'];
            }
            else 
            {
                //food not available
                //redirect to home page
                header("location:".SITEURL);
            }

        }
        else 
        {
            //redirect to homepage
            header("location:".SITEURL);
        }



?>
    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>
                    
                    <?php
                        
                         //check whether image available or not
                                     if($image_name=="")
                                     {
                                         echo"<div class='error'>Image not available</div>";
                                     }
                                     else 
                                     {
                                         ?>
                                         <div class="food-menu-img">
                                          <img src="<?php echo SITEURL?>images/food/<?php echo $image_name;?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                          </div>
                                         <?php
                                     }
                                 

                                

                    ?>


                    
    
                    <div class="food-menu-desc">
                        <h3><?php echo $title?></h3>
                        <input type="hidden" name="food" value="<?php echo $title;?>">
                        <p class="food-price"><?php echo $price?>NTD</p>
                         <input type="hidden" name="price" value="<?php echo $price;?>">
                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Jimmy" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 09xxxxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. sewq@gmail.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>
            <?php

                    //check whether  submit button exsit or not
                    if(isset($_POST['submit']))
                    {
                        //Get all the detail from the form
                        $food=$_POST['food'];
                        $price=$_POST['price'];
                        $qty=$_POST['qty'];
                        $total=$price * $qty;
                        $order_date=date("Y-m-d h:i:sa");

                        $status="Ordered";//ordered  ,on delivery,canceled
                        $customer_name=$_POST['full-name'];
                        $customer_contact=$_POST['contact'];
                        $customer_email=$_POST['email'];
                        $customer_address=$_POST['address'];

                        //create sql to save at data
                        $sql2="INSERT INTO tbl_order SET
                            food='$food',
                            price=$price,
                            qty=$qty,
                            total=$total,
                            order_date='$order_date',
                            status='$status',
                            customer_name='$customer_name',
                            customer_contact='$customer_contact',
                            customer_email='$customer_email',
                            customer_address='$customer_address'
                             ";
                         
                        $res2=mysqli_query($conn,$sql2);
                        if($res2==true)
                        {
                            //query Execute
                            $_SESSION['order']="<div class='success text-center'>Food order successfully </div>";
                            header("location:".SITEURL);
                        }
                        else
                        {
                            //failed to save order
                             $_SESSION['order']="<div class='error text-center'>Failed to food order </div>";
                            header("location:".SITEURL);
                        }

                    }

            ?>
        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

<?php include('partials-front/footer.php');?>
