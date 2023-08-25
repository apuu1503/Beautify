
<?php

include 'connect.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:signin.php');
}

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'product added to cart!';
   }

}

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style2.css">
    <title>Document</title>
</head>

<body style="background-color: whitesmoke;" >
    <section id="title">
           

       
    <?php include 'header.php'; ?>
        <div id="banner">
            <img id="ear" src="images/earings.png" alt="">
            <h1>BEAUTIFY</h1>
            <h4 >Find Your Style Find Your Sparkle</h4>
        </div>
    
    
</section> 


    
        <div id="ban1">

            <h3>Jewellery <span> Flat 20% OFF</span></h3>

        </div>
        
        <section id="jewellery">
        <div class="box-container">

      <?php  
         $select_products = mysqli_query($conn, "SELECT * FROM `poducts` LIMIT 28") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
   <form action="" method="post" class="box">
      <img class="image"  src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
      <div class="name"><?php echo $fetch_products['name']; ?></div>
      <div class="price">$<?php echo $fetch_products['price']; ?>/-</div>
      <input type="number" min="1" name="product_quantity" value="1" class="qty">
      <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
      <input type="submit" name="add to cart" value="Add" class="btn"><img class="img-cart"  src="images\cart (1).png" alt="cart-img">
     </form>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>
       
    <section id="footer">
        <h6>BEAUTIFY</h6>
        <img class="footerimg" src="images/facebook.png" alt="">
        <img class="footerimg" src="images/instagram.png" alt="">
        <img class="footerimg" src="images/linkedin.png" alt="">
        <img class="footerimg" src="images/twitter.png" alt="">
        <img class="footerimg" src="images/youtube.png" alt="">
        <br>
        <div id="brand">

            <div id="coss">
                <ul>

                    <li>Lakme</li>
                    <li>Sugar</li>
                    <li>Mabelline</li>
                    <li>Matte</li>
                    <li>ADS</li>
                    <li>Beauty</li>
                    <li>Pop up</li>
                    <li>Collosil</li>
                    <li>Loreal</li>
                    <li>MAC</li>
                    <li>Colorbar</li>

                </ul>
            </div>
            <div id="jewel" style="margin-left:2%;">

                <ul>
                    <li>
                        Tanishq
                    </li>
                    <li>Bulgari</li>
                    <li>Cartier</li>
                    <li>Graff</li>
                    <li>Mejuri</li>
                    <li>Amrapali</li>
                    <li>Malabar</li>
                    <li>Chopard</li>
                    <li>Chanel</li>
                </ul>
            </div>
            <div id="support">
                <ul>
                    <li><a href=""> Support</a></li>
                    <li><a href="">Contact</a></li>
                    <li><a href="">Privacy Policy</a></li>
                    <li><a href="">About</a></li>
                </ul>
            </div>
            <div>
                Mail us
                <table>
                    <tr>
                        <td>
                            <input type="textarea" width="50">
                        </td>
                        <td>
                            <input type="submit" value="Submit">
                        </td>
                    </tr>
                </table>
            </div>



        </div>
    </section>









    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js " integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe " crossorigin="anonymous "></script>

</body>

</html>