<?php
    require_once('operations.php');
    $db = new operations();


    if(isset($_SESSION['username']) && isset($_SESSION['isAdmin']))
    {
        $printName = $_SESSION['username'];
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>M-BOOKA Movie Booking Adventure</title>
    </head> 
<body>
    <div>
        BANNER HERE
    </div>
    <div>
        
            <?php
            if(isset($_SESSION['username']))
            {
           ?>
           <span>
            Welcome <?php echo $printName?>!
            </span>
            <?php
            }
            else
            {
            ?>
                
               <!-- Pag kaclick ng login or signup pagawan ng modal HAHA ung login at signup -->
                <div>
                   <p> For Easy Reservations click login</p>
                    <form action="index.php" method="post">
                        <button  name="login" >Login</button>
                    </form>
                    <br>
                   <p> If you don't have an account click Sign-up</p>
                    <form action="index.php" method="post">
                        <button  name="signup">Sign-up</button>
                    </form>
                </div>
            <?php
            }
            ?>
        
    </div>

    <div>
        <!-- Highlights if un ung page na nakaopen -->
        <a href=index.php >HOME</a> 
        <a href=Movies.php>MOVIES</a>
        <a href=Blog.php>BLOGS</a>
        <a href=Contact.php>CONTACT</a>
        <a href=About.php>ABOUT</a>
        <a href=user.php>USER</a>

        <div>
            <!-- Theater 1 -->
        </div>
        <div>
            <!-- Theater 2 -->
        </div>
        <div>
            <!-- Theater 3 -->
        </div>
        <div>
            <!-- Theater 4 -->
        </div>
        <div>
            <!-- Theater 5 -->
        </div>
            
    </div>
    

</body>
</html>