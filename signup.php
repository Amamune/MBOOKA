<?php 
    require_once('operations.php');
    $db = new operations();  
    if(isset($_POST['submit'])){
        if($_POST['password']==$_POST['conpass'])
        {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $db->insert_user();
        //     $toEmail = $email;
        //     $subject = "Welcome To M-BOOKA! " ;
        //     $headers = "MIME-Version: 1.0" . "\r\n";
        //     $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        //     $headers .= 'From: peralta.jonhnixon@clsu2.edu.ph <peralta.jonhnixon@clsu2.edu.ph> '
        //     . "\r\n" . 'Reply-To: peralta.jonhnixon@clsu2.edu.ph'. "\r\n" .'X-Mailer: PHP/' . phpversion();

        //     $message = '<!doctype html>
        //         <html lang = "en">
        //             <head>
        //                 <meta charset="UTF-8">
        //                 <meta name="viewport">
        //                     content = "width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0,
        //                     minimum-scale=1.0">
        //                 <meta http-equiv="X-UA-Compatible" content="ie=edge">
        //                     <title>Document</title>
        //             </head>
        //             <body>
        //                 <span style="color: transparent; display : none; height:0; max-height:0; max-width:0;opacity:0; 
        //                 overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">'.$message.'</span>
        //                 <div class="container">
        //                 '.$message.'<br/>
        //                  Regards<br/>
        //                 '.$fromEmail.'
		// 		</div>
        //             </body>
        //         </html>';

        //    $result = @mail($toEmail, $subject,$message ,$headers );

         
           header("Location: index.php");
           echo '<script>alert("Account Succesfully Made!")</script>';
        } else
        {
            echo '<script>confirm("Password and Confirm Password Does not Match!")</script>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>M-BOOKA Sign Up Page</title>
</head>  
<body>  
    <form action="signup.php" method="post">
        <a href="index.php">Go Back</a> <br>                           
        <label >Username: <input type="text" name="username" required></label> <br>
        <label >Email: <input  type="text" name="email" required></label> <br>
        <label >Password: <input type="password" name="password" required></label> <br>
        <label >Confirm Password: <input type="password" name="conpass" required></label> <br>
        <br>
        <button type="submit" name="submit" >Sign Up</button>
        <br>
        <label>Already have an account? : <a href="login.php">Login</a></label>
        
     </form>
</body>
</html>