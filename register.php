<?php

include 'connect.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $password = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpassword = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $user_type = $_POST['user_type'];

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$password'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'user already exist!';
   }else{
      if($password != $cpassword){
         $message[] = 'confirm password not matched!';
      }else{
         mysqli_query($conn, "INSERT INTO `users`(name,email,password,user_type) VALUES('$name', '$email', '$password', '$user_type')") or die('query failed');
         $message[] = 'registered successfully!';
         header('location:signin.php');
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
   <title>register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style1.css">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

</head>
<body>
<section  class="sign"> 


<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   

   <div class="signin">
   <form action="" method="post">
      <h3>register now</h3>
      <table class="tab">
         <tr>
            <td>Name:</td> 
            <td><input type="text" name="name" placeholder="enter name" required class="box3" ><br></td>
          </tr>
         <tr> 
            <td>Email:</td> 
            <td><input type="email" name="email" placeholder="enter your email" required class="box3" ></td> 
         </tr>
         <tr> 
            <td>Password:</td> 
            <td> <input type="password" name="password" placeholder="enter your password" required  class="box3"></td> 
         </tr>
         <tr> 
            <td>Confirm:</td> 
            <td><input type="password" name="cpassword" placeholder="confirm your password" required  class="box3"></td> 
         </tr>
      
      
      </table>
      <select name="user_type" >
         <option value="user">user</option>
         <option value="admin">admin</option>
      </select>
      <input type="submit" name="submit" value="register now" class="btn">
      <p>already have an account? <a href="signin.php">login now</a></p>
   </form>
</div>
</div>
</section>

</body>
</html>