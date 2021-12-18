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

    
    // if(isset($_POST['signup'])){
    //     header("Location: signup.php");
    // }
    // if(isset($_POST['login'])){
    //     header("Location: login.php");
    // }
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
                header("Location: index.php");
                exit;
            }else{
                header("Location: index.php");
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
           header("Location: index.php");
           echo '<script>confirm("Nice!")</script>';
            exit;
        } else
        {
          $_SESSION['signup_fail']= "true";
        }
    }
    //
?>
<!DOCTYPE html>
<html lang="en">
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
</head>

<header>
            <?php
                     //readAll fuckign Movies
            $result = $db->movie_view();
            $i=0;
            while($row = mysqli_fetch_array($result)){
            ?>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="5000">
      <ol class="carousel-indicators">
         <?php if($i==0){ ?>
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <?php 
         }
        ?>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
      </ol>
      <?php
            }
      ?>
      <div class="carousel-inner" role="listbox">
        <!-- Slide One - Set the background image for this slide in the line below -->
        <div class="carousel-item active" style="background-image: url('https\:\/\/terrigen-cdn-dev\.marvel\.com\/content\/prod\/1x\/theavengers_lob_mas_mob_02_1\.jpg')">
          <div class="carousel-caption p-0 rounded-pill d-md-block">
            <h2 class="p-3">Avengers</h2>
            
          </div>
        </div>
        <!-- Slide Two - Set the background image for this slide in the line below -->
        <div class="carousel-item" style="background-image: url('img/3161663.jpg'); ">
          <div class="carousel-caption p-0 rounded-pill d-md-block">
            <h2 class="p-3">Sinister</h3>

          </div>
        </div>
        <!-- Slide Three - Set the background image for this slide in the line below -->
        <div class="carousel-item" style="background-image: url('img/star-is-born-web.jpg')">
          <div class="carousel-caption p-0 rounded-pill d-md-block">
            <h2 class="p-3">Star is Born</h3>

          </div>
        </div>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </header>

<body>

<style>
body {
  display: flex;
  min-height: 100vh;
  flex-direction: column;
  padding-top: 56px;
}

.carousel-item {
  height: 65vh;
  min-height: 300px;
  background: no-repeat center center scroll;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
  background-position: center 20%;
}

.portfolio-item {
  margin-bottom: 30px;
  max-width: 300px;
}

.portfolio-item .card-img-top {
  max-height: 397px;
}

.search-poster {
  height: 200px;
  min-width: 128px;
}

.poster-col {
  flex: 0 0 170px;
} 

.toast {
  z-index: 2;
}

/* flex MAGIC */
.container {
  flex: 1 0 auto;
}

.profile-col {
  flex: 0 0 250px;
} 

.tech .card-img-top{
  height: 268px;
  width: 268px;
  object-fit: contain;
}

.popcorn-icon {
  object-fit: contain;
  height: 30px;
}

.carousel-control-prev , .carousel-control-next {
  background-color: rgba(52, 58, 64, 0);
}

.carousel-control-prev:hover , .carousel-control-next:hover, .carousel-caption {
  background-color: black;
  opacity:80%;
  transition: background-color 300ms ease-in;
}

.carousel-caption {
  width: 500px;
  margin: 0 auto;
}

@media screen and (max-width: 768px) {
  .carousel-caption {
    width: 100%;
    margin: 0%;
    left: 0;
    right: 0;
  }
  .carousel-caption h3 {
    font-size: 1.25rem;
  }
}

.filter-btn .dropdown-menu {
  min-width: 0;
  padding: 5px;
  padding-left: 1.5rem;
  padding-right: 1.5rem;
}

    </style>
</head>

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
                <form action="index.php" method="post" id="logoutid">
                  <input type="hidden" name="auth-end">
                  <a class="dropdown-item" href="javascript:{}" onclick="document.getElementById('logoutid').submit(); return false;">Logout</a>
                </form>
              
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
    <div>

    <form action="index.php" method="post" id="logoutid">
                  <input type="hidden" name="auth-end">

<main class="mt-4 pt-3 ml-2">
<div class="card">
  <h5 class="card-header">Featured</h5>

  </div>

  <div style="display:flex">
        <img src="movies/uploads/IMG-616aba7daa6616.18788788.jpg" style="height:450px; width:450px;
         padding:20px
        ">

        <?php
            if(isset($_SESSION['username']))
            {
           ?>
        <div>
                <br>
                <div class="card"  style="" >
                <img class="card-img-top" src="img/—Pngtree—vector add user icon_3773557.png" alt="Card image cap" style="height:180px; width:240px">
                <div class="card-body">
                    <h5 class="card-title">Welcome <?php echo $printName?>!</h5>
                    <p class="card-text">
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur eum quasi sapiente nesciunt? Voluptatibus sit, repellat </p>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet  </p>
                    </p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
                </div>

        </div>
            <?php
            }
            else
            {
            ?>
     
               <!-- Pag kaclick ng login or signup pagawan ng modal HAHA ung login at signup -->
            <div style="padding:20px">
                   <p> For Easy Reservations click login</p>
                  
                        <button type="button" class="btn btn-primary" 
                        data-bs-toggle="modal" data-bs-target="#loginModal"
                         >Login</button>

                    <br>
                    <br>
                   <p> If you don't have an account click Sign-up</p>
                  
                        <button type= "button" class="btn btn-danger" 
                        data-bs-toggle="modal" data-bs-target="#signupModal"
                        >Sign-up</button>
                    
               
            </div>

       
            <?php
            }
            ?>
        
         </div>

        </div>
    </div>
           <!-- <?php echo $_SESSION['signup_success']; ?> -->
        </main>
    
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

            <form method="post" action="index.php">
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
          
 
            
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="./js/jquery-3.5.1.js"></script>
    <script src="./js/jquery.dataTables.min.js"></script>
    <script src="./js/dataTables.bootstrap5.min.js"></script>
    <script src="./js/script.js"></script>

    <script src="indexjs/vendor/jquery/jquery.min.js"></script>
    <script src="indexjs/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


    <script type="module" src="indexjs/js/index.js"></script>
    <script src="indexjs/js/global.js"></script>

    <script>
           $(window).on('load', function() {
                    $('#successModal').modal('show');
          });
    </script>
</body>
</html>
