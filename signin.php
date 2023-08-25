<?php

include 'connect.php';
session_start();

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $password = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$password'") or die('query failed');
  
    if(mysqli_num_rows($select_users) > 0){

      $row = mysqli_fetch_assoc($select_users);

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_name'] = $row['name'];
         $_SESSION['admin_email'] = $row['email'];
         $_SESSION['admin_id'] = $row['id'];
         header('location:admin_page.php');

      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_name'] = $row['name'];
         $_SESSION['user_email'] = $row['email'];
         $_SESSION['user_id'] = $row['id'];
         header('location:index.php');

      }

   }else{
      $message[] = 'incorrect email or password!';
   }

}


?>

    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link rel="stylesheet" href="style1.css">
        <title>Document</title>
    </head>

    <body>
        <section  class="sign"> 
         <?php
         
            if(isset($message)){
         foreach($message as $message){
         echo '
            <div class="message">
         <h6>'.$message.'</h6>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
             </div>
                '     ;
             }
            }
        ?>
        

       
        <div class="signin">
            
            <form action="" method="POST">
                <h2 style="font-size: 30px;">SIGN IN</h2>
             <table id="tab">
                <tr>
                    <td> username: </td>
                    <td><input type="email" name="email" placeholder="enter your email" required class="box3"></td>

                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" placeholder="enter your password" required class="box3"></td>
                </tr>
                
            </table><input type="submit" name="submit" value="login now" class="btn">
                    <p>don't have an account? <a href="register.php">register now</a></p>
                    </form>
        </div>
        
        </section>
         
    </body>

    </html>