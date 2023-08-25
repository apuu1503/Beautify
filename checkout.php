<?php

include 'connect.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['order_btn'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $number = $_POST['number'];
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $method = mysqli_real_escape_string($conn, $_POST['method']);
   $address = mysqli_real_escape_string($conn, 'flat no. '. $_POST['flat'].', '. $_POST['street'].', '. $_POST['city'].', '. $_POST['country'].' - '. $_POST['pin_code']);
   $placed_on = date('d-M-Y');

   $cart_total = 0;
   $cart_products[] = '';

   $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   if(mysqli_num_rows($cart_query) > 0){
      while($cart_item = mysqli_fetch_assoc($cart_query)){
         $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      }
   }

   $total_products = implode(', ',$cart_products);

   $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

   if($cart_total == 0){
      $message[] = 'your cart is empty';
   }else{
      if(mysqli_num_rows($order_query) > 0){
         $message[] = 'order already placed!'; 
      }else{
         mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
         $message[] = 'order placed successfully!';
         mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      }
   }
   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style1.css">

</head>

<body style="background-color: ;">
<?php include 'header.php'; ?>

<div class="heading">
   
   <p> <a href="home.php">home</a> / checkout </p><br>
   
</div>



<section class="checkout" style=" border: 1px solid;
    width: 50%;
    margin: auto;
    padding: 2px;">
    
   <form action="" method="post" >
   <table>
   <h2>Checkout</h2>
      <h3 style="width:50%; margin: auto;"> place your order</h3>
      <div class="flex">
         <div class="inputBox">
            <tr><hr> <td><span>your name :</span></td>
          <td> <input type="text" name="name" required placeholder="enter your name"></td> </tr>
         </div>
         <div class="inputBox">
            <tr><td> <span>your number :</span></td>
         <td><input type="number" name="number" required placeholder="enter your number"></td></tr>
           
            
         </div>
         <div class="inputBox">
            <tr><td><span>your email :</span></td><td> <input type="email" name="email" required placeholder="enter your email"></td></tr>
            
           
         </div>
         <div class="inputBox">
             <tr><td><span>payment method :</span></td><td><select name="method">
               <option value="cash on delivery">cash on delivery</option>
               <option value="credit card">credit card</option>
               <option value="paypal">paypal</option>
               <option value="paytm">paytm</option>
            </select></td></tr>
            
            
         </div>
         <div class="inputBox">
            <tr><td><span>address line 01 :</span></td><td><input type="number" min="0" name="flat" required placeholder="e.g. Flat no."></td></tr>
            
            
         </div>
         <div class="inputBox">
            <tr><td><span>address line 01 :</span></td><td><input type="text" name="street" required placeholder="e.g. Street name"></td></tr>
            
            
         </div>
         <div class="inputBox">
            <tr><td><span>city :</span></td><td> <input type="text" name="city" required placeholder="e.g. Jalna "></td></tr>
            
           
         </div>
         <div class="inputBox">
            <tr><td><span>state :</span></td><td> <input type="text" name="state" required placeholder="e.g. Maharashtra"></td></tr>
            
           
         </div>
         <div class="inputBox">
            <tr><td><span>country :</span></td><td> <input type="text" name="country" required placeholder="e.g. India"></td></tr>
            
           
         </div>
         <div class="inputBox">
            <tr><td> <span>pin code :</span></td>
            <td> <input type="number" min="0" name="pin_code" required placeholder="e.g. 123456"></td></tr>
           
           
         </div>
          <tr><td><input type="submit" value="order now" class="btn" name="order_btn"></td></tr>
      </div>
     
     </table>
   </form>

</section>
<section class="display-order" style="width:50%; margin:auto">

   <?php  
      $grand_total = 0;
      $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select_cart) > 0){
         while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
   ?>
   <p> <?php echo $fetch_cart['name']; ?> <span>(<?php echo '$'.$fetch_cart['price'].'/-'.' x '. $fetch_cart['quantity']; ?>)</span> </p>
   <?php
      }
   }else{
      echo '<p class="empty">your cart is empty</p>';
   }
   ?>
   <div class="grand-total"> grand total : <span>$<?php echo $grand_total; ?>/-</span> </div>

</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>