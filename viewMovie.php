<?php
       require_once('operations.php');
       $db = new operations();

        $printName = "";

       if(isset($_SESSION['username']) && isset($_SESSION['isAdmin']))
       {
           $printName = $_SESSION['username'];
       }else{

            $printName = "No User";
       }


       if (isset($_POST["purchase_submit"])){
        $db->bookingPurchaseFunction();
       } 

    if (isset($_POST['auth-end'])) {
        unset($_SESSION['username']); 
        unset($_SESSION['isAdmin']);
        header("Location: index.php");
    }   


       //
    if(isset($_POST['login'])){
      // $empty = ""; 
      if (isset($_POST["username"]) && isset($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $query = $db->connection->prepare("SELECT * FROM login WHERE username = ? AND password = ?");
        $query->bind_param("ss", $username, $password);
        $query->execute();

        $result = $query->get_result();
        $query->close();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['successful_login'] = "true";

            $_SESSION['userID'] = $user['uID'];
            $_SESSION['userEmail'] = $user['email'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['isAdmin'] = $user['isAdmin'];
            if($user['isAdmin']==true){
                header("Location: viewMovie.php");
                exit;
            }else{
                header("Location: viewMovie.php");
                exit;
            }
        }
        $_SESSION['wrong_password'] = "true";
    }
  }
    //


    //for signup
    if(isset($_POST['submit'])){
        if($_POST['password']==$_POST['conpass'])
        {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $db->insert_user();

            $_SESSION['signup_success']= "true";
           header("Location: viewMovie.php");
 
            exit;
        } else
        {
          $_SESSION['signup_fail']= "true";
        }
    }
    //
?>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
    />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <title>View Movie</title>

    <style>

body {
  display: flex;
  min-height: 100vh;
  flex-direction: column;
  padding-top: 56px;
}



.portfolio-item {
  margin-bottom: 30px;
  max-width: 300px;
}

.portfolio-item .card-img-top {
  max-height: 397px;
}


/* flex SHIT MAGIC */
.video_container {
  flex: 1 0 auto;
}

/*Video responsive*/
.video_container {
  position: fixed;
  width: 100%;
  /*overflow: hidden;*/
  padding-top: 900px; /* 4:3 Aspect Ratio */
}

.responsive-iframe {
  position: absolute;
  top: 0;
  left: 10px;
  bottom: 0;
  right: 0;
  width: 95%;
  height: 50%;
  border: none;
}





    </style>
</head>

  <body >
   <!-- top navigation bar -->
   <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top"> 
<div class="container-fluid">
   <button
     class="navbar-toggler"
     type="button"
     data-bs-toggle="offcanvas"
     data-bs-target="#sidebar"
     aria-controls="offcanvasExample"
   >
     <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
   </button>
   <a
     class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase fw-bold"
     href="#"
     >Movie Booka</a
   >
   <button
     class="navbar-toggler"
     type="button"
     data-bs-toggle="collapse"
     data-bs-target="#topNavBar"
     aria-controls="topNavBar"
     aria-expanded="false"
     aria-label="Toggle navigation"
   >
     <span class="navbar-toggler-icon"></span>
   </button>
   <div class="collapse navbar-collapse" id="topNavBar">
   <form class="d-flex ms-auto my-3 my-lg-0">
           <a
           class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase fw-bold"
           href="#"
           ><?php echo  $printName;?></a
         >
      
       </form>
   </div>
     <ul class="navbar-nav">
        <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle ms-2"
              href="#"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              <i class="bi bi-person-fill"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a href="index.php" class="dropdown-item">Home</a>
              </li>
              <li>
                <a href="viewMovie.php"class="dropdown-item">Movies</a>
              </li>
              <li>
              <a href="Contact.php"class="dropdown-item">Contact</a>
              </li>
              <li>
              <a href="about.php"class="dropdown-item">About</a>
              </li>
              <li>
              <a href="Blog.php"class="dropdown-item">Blogs</a>
              </li>
              <?php if($printName!="No User"){ ?>
              <li>
               
                  <a class="dropdown-item" href="javascript:{}" onclick="document.getElementById('logoutid').submit(); return false;">Logout</a>
           
              
              </li>
              <li>
              <a href="user.php"class="dropdown-item">User</a>
              </li>
            
              <?php } ?>


         </ul>
       </li>
     </ul>
   </div>
 </div>
</nav>
    <br>

    <!-- Page Content -->
    <main class="mt-4 pt-3 ml-2">
    <form action="index.php" method="post" id="logoutid" hidden>
                  <input type="hidden" name="auth-end">
    </form>
  <div class="container">
  
  <?php if($printName == "No User"){ ?>
<div class="form-control" style="display:flex; align-items: center; padding-left:20px" >
<button class="btn btn-primary" style="margin-right:10px"
data-bs-toggle="modal" data-bs-target="#loginModal"
name="login" >Login</button>

<button class="btn btn-danger" 
data-bs-toggle="modal" data-bs-target="#signupModal"
name="signup">Sign-up</button>
</div>

<?php } ?>

<h1 class="display-4" style="text-align:center">Welcome to Movie Site</h1>
<h4 style="text-align:center">To book a movie please click the poster of the preferred movie</h4>



<hr>

<!-- Portfolio Section -->
<h2>Featured Movies</h2>

            <?php
                     //readAll fuckign Movies
            $result = $db->movie_view();
            $i =0;
            while($row = mysqli_fetch_array($result)){
            $i++;
            if($i==1){
            ?>
                <div class="row d-flex justify-content-around">
                <div class="col-lg-4 col-sm-6 portfolio-item">
                    <div class="card h-100">
                    <a type="button" id="bookingClick" data-bs-toggle="modal" data-bs-target="#exampleModal"
                   
                    >
                    <img class="card-img-top" src="movies/uploads/<?php echo $row['poster'];?>" alt="" style="height:280; width:275;"
                        data-title = "<?php echo $row['title'];?>"
                        data-image_name = "<?php echo $row['poster'];?>"
                        data-seats = "<?php echo $row['seats'];?>"
                        data-price = "<?php echo $row['price'];?>"
                        data-video_link = "<?php echo $row['video_link'];?>"
                    >
                    </a>
                    <div class="card-body">
                        <h4 class="card-title" >
                        <a href="#" style="text-decoration:none"><?php echo $row['title'];?></a>
                        </h4>
                        <p class="card-text"><?php echo $row['description'];?></p>
                    </div>
                    </div>
                </div>
                 <?php
                     }else{

                ?>
                    <div class="col-lg-4 col-sm-6 portfolio-item">
                    <div class="card h-100">
                    <a type="button" id="bookingClick" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <img class="card-img-top" src="movies/uploads/<?php echo $row['poster'];?>" alt="" style="height:280; width:275;"
                        data-title = "<?php echo $row['title'];?>"
                        data-seats = "<?php echo $row['seats'];?>"
                        data-image_name = "<?php echo $row['poster'];?>"
                        data-price = "<?php echo $row['price'];?>"
                        data-video_link = "<?php echo $row['video_link'];?>"
                    >
                    </a>
                    <div class="card-body">
                        <h4 class="card-title">
                        <a href="#" style="text-decoration:none"><?php echo $row['title'];?></a>
                        </h4>
                        <p class="card-text"><?php echo $row['description'];?></p>
                    </div>
                    </div>
      </div>
            <?php     
                     }
           
                    }
             ?>
    <hr>


    </div>

    
 


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="nameMovie">Fucking Movie</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeButton"></button>
      </div>
      <div class="modal-body">
          <div style="display:flex">
          
             <img class="card-img-top" id="imagePoster" src="" alt="" style="height:280; width:275;">
         
                <div style="padding: 5px">
                <h5 class="form-control" id="seats_id"></h5>
          
                <form action="" method="POST" enctype='multipart/form-data'>
                <h5 class="form-control ">Add Snacks
                            <div class="form-check">
                                    <input class="form-check-input" type="radio" name="snack" id="sodaID" value="sodas">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                    SODAS
                                    </label>
                            </div>

                            <div class="form-check">
                                    <input class="form-check-input" type="radio" name="snack" id="popcornID" value="popcorn" >
                                    <label class="form-check-label" for="flexRadioDefault2">
                                    POPCORN
                                    </label>
                            </div>

                            <div class="form-check">
                                    <input class="form-check-input" type="radio" name="snack" id="popcorn_sodaID" value="popcorn_soda">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                    POPCORN+SODAS
                                    </label>
                            </div>

                            <div class="form-check">
                                    <input class="form-check-input" type="radio" name="snack" id="noneID" value="none" checked>
                                    <label class="form-check-label" for="flexRadioDefault2">
                                    NONE
                                    </label>
                            </div>
                            </h5>
                </div>
                </form>
              
            </div>
      </div>
      
      <div class="modal-footer">
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#MovieTrailerModal">Open Trailer</button>
        <button type="button" id="checkingButton" class="btn btn-primary" 
        data-bs-toggle="modal" data-bs-target="#checkingModal">Book Now</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!--End of BookingModal -->



<!-- Modal -->
<div class="modal fade" id="checkingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" >
                      <div id="duo">
                            <div class="form-check">
                            <input class="form-check-input" type="radio" name="regular" id="regularCheck" value="sodas" checked>
                                    <label class="form-check-label" for="flexRadioDefault1" id="RegularID">
                                    Regular
                                    </label>
                            </div>

                            <div class="form-check">
                            <input class="form-check-input" type="radio" name="regular" id="largeCheck" value="sodas">
                                    <label class="form-check-label" for="flexRadioDefault1" id="LargeID">
                                    Large
                                    </label>
                            </div>
                  </div>
                            <div id = "anotherExtra">
                            <div class="form-check">
                                    <input class="form-check-input" type="radio" name="regular" id="fuckID" value="sodas">
                                    <label class="form-check-label" for="flexRadioDefault1" id="LargeID">
                                    Popcorn Large + Soda Reg - 130';
                                    </label>
                            </div>
                            </div>

                            <div id="extraContent">

                            </div>

                          
      </div>
      <div class="modal-footer">
      <?php
                    if($printName!="No User"){
                        
      ?>
        <form action="" method="POST">
        <p hidden><input type="text" value="<?php echo $_SESSION['userID']; ?>" name="purchase_user_id"></p>
        <p hidden><input type="text" value="" name="purchase_price" id="purchase_id_price"></p>
        <?php if(isset($_SESSION['userEmail'])){ ?>
        <p hidden><input type="text" value="<?php echo $_SESSION['userEmail']; ?>" name="purchase_email" ></p>
        <?php }?>
        <p hidden><input type="text-area" value="" id="snacks_text" name="snacks_text"> </p>
   
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="purchase_submit">Pay</button>
        </form>
      <?php
          } else{

      ?>
          <form action="" method="POST">
        <p hidden><input type="text" value="0" name="purchase_user_id"></p>
        <p hidden><input type="text" value="" name="purchase_price" id="purchase_id_price"></p>
        <label class="form-check-label">Enter your Email: </label>
        <input class="form-control" type="text" value="" name="purchase_email" >
            <br>
        <p hidden><input type="text-area" value="" id="snacks_text" name="snacks_text"> </p>
   
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="purchase_submit">Pay</button>
        </form>
      <?php
          }
        ?>
      </div>
    </div>
  </div>
</div>

<?php

      if(isset($_SESSION['purchase_success'])){
          if($_SESSION['purchase_success']=="true"){
    ?>
     
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Status:</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <?php
              echo "Your Ticket Successfully Purchased";
            ?>
           
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" 
                data-bs-dismiss="modal"
                data-toggle="modal" data-target="#successModal"
                >Close</button>
         
            </div>
            </div>
        </div>
        </div>
    <?php
           $_SESSION['purchase_success']="false";

        }
      }
    ?>



    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="./js/jquery-3.5.1.js"></script>
    <script src="./js/jquery.dataTables.min.js"></script>
    <script src="./js/dataTables.bootstrap5.min.js"></script>
    <script src="./js/script.js"></script>

    
    </main>

  <!-- Modals -->
  <?php
    if(isset ( $_SESSION['signup_success'] ) || isset($_SESSION['successful_login'])  || isset($_SESSION['wrong_password']) || isset($_SESSION['fail']) ){
    
    if($_SESSION['signup_success']=="true" || $_SESSION['successful_login'] =="true" ||  $_SESSION['wrong_password'] =="true" || $_SESSION['signup_fail'] =="true"){
?>
<!-- Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Status: Message</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php 
             if( isset($_SESSION['successful_login'])  ){	
              if( $_SESSION['successful_login']=="true" ) {
                echo "Welcome ". $printName;
              }
            }
             if( isset($_SESSION['signup_success'])  ){	
              if( $_SESSION['signup_success']=="true" ) {
                echo "Account Successfully Made!";
              }
            }

            if( isset($_SESSION['signup_fail'])  ){	
              if( $_SESSION['signup_fail']=="true" ) {
                echo "Password Mismatched!";
                echo'<br><br>
                <button type="button" class="btn btn-primary" 
                data-bs-dismiss="modal"
                data-bs-toggle="modal" data-bs-target="#signupModal">
                 Go Back to Signup
                </button>
                ';
              }
            }

            if( isset($_SESSION['wrong_password'])  ){	
              if( $_SESSION['wrong_password']=="true" ) {
                echo "These credentials do not match our records.";
                echo'<br><br>
                <button type="button" class="btn btn-primary" 
                data-bs-dismiss="modal"
                data-bs-toggle="modal" data-bs-target="#loginModal">
                 Go Back to Login
                </button>
                ';
              }
            }
        ?>

       
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#successModal">
                 Close
            </button>
      </div>
    </div>
  </div>
</div>
<?php 
        }
        $_SESSION['successful_login'] = "false";
        $_SESSION['signup_success']= "false";
        $_SESSION['signup_fail']= "false";
        $_SESSION['wrong_password']= "false";
    }
?>


<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

            <form method="post" action="">
                <label>Username</label>
                <input type="text" name="username" id="username" placeholder="User Name" class="form-control mb-3">
                <label>Password</label>
                <input type="password" name="password" id="auth-password" placeholder="Password" class="form-control mb-3">
                
                <button type="submit" class="btn btn-success float-md-right mr-1" name="login">Login</button>    
            </form>
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="MovieTrailerModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
<div class="modal-dialog modal-fullscreen-xxl-down">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title h4" id="exampleModalFullscreenXxlLabel">Movie Trailer</h5>
        <div class="margin-right:100px">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeButton"></button>
      </div>
      </div>
      <div class="modal-body">


      <div class="video_container"> 
      <iframe class="responsive-iframe" src="https://www.youtube.com/embed/6ZfuNTqbHE8"></iframe>
      </div>
     
      </div>
    
    </div>
  </div>
  </div>


<!-- Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Sign-up</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form action="" method="post">
                                      
                    <label >Username: <input class="form-control" type="text" name="username" required></label> <br>
                    <label >Email: <input class="form-control"  type="text" name="email" required></label> <br>
                    <label >Password: <input class="form-control" type="password" name="password" required></label> <br>
                    <label >Confirm Password: <input class ="form-control" type="password" name="conpass" required></label> <br>
                    <br>
                    <button type="submit" class="btn btn-danger" name="submit" >Sign Up</button>
                    <br><br>
                    <label>Already have an account? : <button class="btn btn-primary" 
                    data-bs-dismiss="modal"
                        data-bs-toggle="modal" data-bs-target="#loginModal"
                        name="login" >Login</button></label>
                    
                </form>
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>


  -->

    

    <script>
          $(window).on('load', function() {
                    $('#successModal').modal('show');
          });

          $(document).on('click','#closeButton',function(e){
            $('.video_container').html('<iframe class="responsive-iframe" src=""></iframe>');
          });
        



        var price;
        var regular;
        var large;
        var rlg;
        var snack;
        var movie_title;
        var movie_price;

        var amir = document.getElementById('fuckID');

        if(amir){
            $(document).on('click','#fuckID',function(e){
            var total = parseInt(price) + rlg;
            $('#extraContent').html('Total Price: ₱'+total);
            $('#purchase_id_price').val(total);
            
            if(snack=="Soda"){
              $('#snacks_text').val(snack+": ₱"+rlg+"<br>"+movie_title+": ₱"+movie_price+"<br> Total Price: ₱"+total);
            }
            if(snack=="PopCorn"){
              $('#snacks_text').val(snack+": ₱"+rlg+"<br>"+movie_title+": ₱"+movie_price+"<br> Total Price: ₱"+total);
            }
            if(snack=="PopCorn and Soda"){
              $('#snacks_text').val(snack+": ₱"+rlg+"<br>"+movie_title+": ₱"+movie_price+"<br> Total Price: ₱"+total);
            }
        
        });
        }

        $(document).on('click','#regularCheck',function(e){
            var total = parseInt(price) + regular;
            $('#extraContent').html('Total Price: ₱'+total);
            $('#purchase_id_price').val(total);
            
          
            if(snack=="Soda"){
              $('#snacks_text').val(snack+": ₱"+regular+"<br>"+movie_title+": ₱"+movie_price+"<br> Total Price: ₱"+total);
            }
            if(snack=="PopCorn"){
              $('#snacks_text').val(snack+": ₱"+regular+"<br>"+movie_title+": ₱"+movie_price+"<br> Total Price: ₱"+total);
            }
            if(snack=="PopCorn and Soda"){
              $('#snacks_text').val(snack+": ₱"+regular+"<br>"+movie_title+": ₱"+movie_price+"<br> Total Price: ₱"+total);
            }
    
        });

        $(document).on('click','#largeCheck',function(e){
            var total = parseInt(price) + large;
            $('#extraContent').html('Total Price: ₱'+total);
            $('#purchase_id_price').val(total);

            if(snack=="Soda"){
              $('#snacks_text').val(snack+": ₱"+large+"<br>"+movie_title+": ₱"+movie_price+"<br> Total Price: ₱"+total);
            }
            if(snack=="PopCorn"){
              $('#snacks_text').val(snack+": ₱"+large+"<br>"+movie_title+": ₱"+movie_price+"<br> Total Price: ₱"+total);
            }
            if(snack=="PopCorn and Soda"){
              $('#snacks_text').val(snack+": ₱"+large+"<br>"+movie_title+": ₱"+movie_price+"<br> Total Price: ₱"+total);
            }
          
        });
            
          $(document).on('click','#bookingClick',function(e){
                var title = e.target.getAttribute('data-title');
                var image_name = e.target.getAttribute('data-image_name');
                var data_price = e.target.getAttribute('data-price');
                var seats = e.target.getAttribute('data-seats');
                var video_link = e.target.getAttribute('data-video_link');
                console.log(video_link);
                price = data_price;
                movie_price = price;
                movie_title = title;
                console.log(title);
                $('#nameMovie').html(title);
                $('#seats_id').html("Seat Available: "+seats+"<br>"+"Price:₱"+data_price);
                $('#imagePoster').attr('src','movies/uploads/'+image_name);
                $('.video_container').html('<iframe class="responsive-iframe" src="'+video_link+'"></iframe>');
                snack ="";

                
          });

          $(document).on('click','#checkingButton',function(e){
              //  var snack = document.getElementById("snackID").value;
              radiobtn = document.getElementById("regularCheck");
                radiobtn.checked = true;  
                $('#duo').show();
                if(document.getElementById('noneID').checked) {
                    $('#duo').hide();
                
                    $('#anotherExtra').hide();
                    regular = 50;
                    large = 60; 
                    var total = 0 + parseInt(price);
                    $('#extraContent').html('Total Price: '+total);
                    $('#purchase_id_price').val(total);
                    snack = "Soda";
                     
                
              
                      $('#snacks_text').val(movie_title+": ₱"+movie_price+"<br> Total Price: ₱"+total);
                    
                   
                }

                if(document.getElementById('sodaID').checked) {
                    $('#RegularID').html("Regular - ₱50");
                    $('#LargeID').html("Large - ₱60");
                    $('#anotherExtra').hide();
                    regular = 50;
                    large = 60; 
                    var total = 50 + parseInt(price);
                    $('#extraContent').html('Total Price: '+total);
                    $('#purchase_id_price').val(total);
                    snack = "Soda";
                     
                
                    if(snack=="Soda"){
                      $('#snacks_text').val(snack+": ₱"+regular+"<br>"+movie_title+": ₱"+movie_price+"<br> Total Price: ₱"+total);
                    }
                   
                }
                if(document.getElementById('popcornID').checked) {
                    $('#RegularID').html("Regular - ₱70");
                    $('#LargeID').html("Large - ₱100");
                    $('#anotherExtra').hide();
                    regular = 70;
                    large = 100;
                    var total = 70 + parseInt(price);
                    $('#extraContent').html('Total Price: '+total);
                    $('#purchase_id_price').val(total);
                    snack = "PopCorn";

                    if(snack=="PopCorn"){
                      $('#snacks_text').val(snack+": ₱"+regular+"<br>"+movie_title+": ₱"+movie_price+"<br> Total Price: ₱"+total);
                    }
                }
                if(document.getElementById('popcorn_sodaID').checked) {
               
                    $('#RegularID').html("Both Regular - 100");
                    $('#LargeID').html("Both Large - 140");
                    $('#anotherExtra').show();
                    regular = 100;
                    large = 140;
                    rlg = 130;
                    var total = 100 + parseInt(price);
                    $('#extraContent').html('Total Price: '+total);
                    $('#purchase_id_price').val(total);
                    snack = "PopCorn and Soda";

                    if(snack=="PopCorn and Soda"){
                      $('#snacks_text').val(snack+": ₱"+regular+"<br>"+movie_title+": ₱"+movie_price+"<br> Total Price: ₱"+total);
                    }
                }
          });

    </script>

</body>
</html>