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
                  header("Location: about.php");
                  exit;
              }else{
                  header("Location: about.php");
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
            header("Location: about.php");
  
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

    <title>About</title>
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
     >About</a
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
           <a href="About.php"class="dropdown-item">About</a>
           </li>
           <?php if($printName!="No User"){ ?>
           <li>
             <form action="index.php" method="post" id="logoutid">
               <input type="hidden" name="auth-end">
               <a class="dropdown-item" href="javascript:{}" onclick="document.getElementById('logoutid').submit(); return false;">Logout</a>
             </form>
           </a>
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

<main class="mt-4 pt-3 ml-2">
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
</main>
<main class="mt-4 pt-3 ml-2">

 <!-- Page Content -->
 <div class="container">

<!-- Page Heading/Breadcrumbs -->
<h1 class="mt-4 mb-3">Team and Stuffs
  <small>and Developers</small>
</h1>

<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="index.php">Home</a>
  </li>
  <li class="breadcrumb-item active">Greet our fellow Developers</li>
</ol>

<!-- Blog Post -->
<div class="card mb-4">
  <div class="card-body">
    <div class="row">
      <div class="col-lg-6">
        <a href="#">
          <img class="img-fluid rounded" src="developers/154234058_5127846577257703_1284861727653106320_n.jpg" alt="" style="height:300px; width:450px;">
        </a>
      </div>
      <div class="col-lg-6">
        <h2 class="card-title">Genelyn Azarcon</h2>
        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla? Quos cum ex quis soluta, a laboriosam. Dicta expedita corporis animi vero voluptate voluptatibus possimus, veniam magni quis!</p>
        <a href="#" class="btn btn-danger">Read More &rarr;</a>
      </div>
    </div>
  </div>
  <div class="card-footer text-muted">
    Posted on October 17, 2021 by
    <a href="#">Anonymous Developers</a>
  </div>
</div>

<!-- Blog Post -->
<div class="card mb-4">
  <div class="card-body">
    <div class="row">
      <div class="col-lg-6">
        <a href="#">
        <img class="img-fluid rounded" src="developers/246387886_188252150022761_3244132457879221728_n.png" alt="" style="height:300px; width:350px;">
        </a>
      </div>
      <div class="col-lg-6">
        <h2 class="card-title">John Nixon Peralta</h2>
        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla? Quos cum ex quis soluta, a laboriosam. Dicta expedita corporis animi vero voluptate voluptatibus possimus, veniam magni quis!</p>
        <a href="#" class="btn btn-danger">Read More &rarr;</a>
      </div>
    </div>
  </div>
  <div class="card-footer text-muted">
  Posted on October 17, 2021 by
    <a href="#">Anonymous Developers</a>
  </div>
</div>

<!-- Blog Post -->
<div class="card mb-4">
  <div class="card-body">
    <div class="row">
      <div class="col-lg-6">
        <a href="#">
          <img class="img-fluid rounded" src="developers/pokemon-journeys-ash-pikachu-anime-1227937.jpeg" alt="">
        </a>
      </div>
      <div class="col-lg-6">
        <h2 class="card-title">Jedidiah Valdez</h2>
        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla? Quos cum ex quis soluta, a laboriosam. Dicta expedita corporis animi vero voluptate voluptatibus possimus, veniam magni quis!</p>
        <a href="#" class="btn btn-danger">Read More &rarr;</a>
      </div>
    </div>
  </div>
  <div class="card-footer text-muted">
  Posted on October 17, 2021 by
    <a href="#">Anonymous Developers</a>
  </div>
</div>

<h1 class="mt-4 mb-3">Our Team would like to
  <small>thank with..</small>
</h1>

<!-- Blog Post -->
<div class="card mb-4">
  <div class="card-body">
    <div class="row">
      <div class="col-lg-6">
        <a href="#">
          <img class="img-fluid rounded" src="misc/bootstrap.png" alt=""  style="height:200px; width:200px;">
        </a>
      </div>
      <div class="col-lg-6">
        <h2 class="card-title">Bootstrap 5</h2>
        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla? Quos cum ex quis soluta, a laboriosam. Dicta expedita corporis animi vero voluptate voluptatibus possimus, veniam magni quis!</p>
        <a href="#" class="btn btn-danger">Read More &rarr;</a>
      </div>
    </div>
  </div>
  <div class="card-footer text-muted">
  Posted on October 17, 2021 by
    <a href="#">Anonymous Developers</a>
  </div>
</div>

<!-- Blog Post -->
<div class="card mb-4">
  <div class="card-body">
    <div class="row">
      <div class="col-lg-6">
        <a href="#">
          <img class="img-fluid rounded" src="misc/html image.png" style="height:220px; width:220px;">
        </a>
      </div>
      <div class="col-lg-6">
        <h2 class="card-title">HTML 5</h2>
        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla? Quos cum ex quis soluta, a laboriosam. Dicta expedita corporis animi vero voluptate voluptatibus possimus, veniam magni quis!</p>
        <a href="#" class="btn btn-danger">Read More &rarr;</a>
      </div>
    </div>
  </div>
  <div class="card-footer text-muted">
  Posted on October 17, 2021 by
    <a href="#">Anonymous Developers</a>
  </div>
</div>

<!-- Blog Post -->
<div class="card mb-4">
  <div class="card-body">
    <div class="row">
      <div class="col-lg-6">
        <a href="#">
          <img class="img-fluid rounded" src="misc/javascript.png" style="height:220px; width:220px;">
        </a>
      </div>
      <div class="col-lg-6">
        <h2 class="card-title">javascript</h2>
        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla? Quos cum ex quis soluta, a laboriosam. Dicta expedita corporis animi vero voluptate voluptatibus possimus, veniam magni quis!</p>
        <a href="#" class="btn btn-danger">Read More &rarr;</a>
      </div>
    </div>
  </div>
  <div class="card-footer text-muted">
  Posted on October 17, 2021 by
    <a href="#">Anonymous Developers</a>
  </div>
</div>

<!-- Blog Post -->
<div class="card mb-4">
  <div class="card-body">
    <div class="row">
      <div class="col-lg-6">
        <a href="#">
          <img class="img-fluid rounded" src="misc/jquery image.png" style="height:220px; width:220px;">
        </a>
      </div>
      <div class="col-lg-6">
        <h2 class="card-title">Jquery</h2>
        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla? Quos cum ex quis soluta, a laboriosam. Dicta expedita corporis animi vero voluptate voluptatibus possimus, veniam magni quis!</p>
        <a href="#" class="btn btn-danger">Read More &rarr;</a>
      </div>
    </div>
  </div>
  <div class="card-footer text-muted">
  Posted on October 17, 2021 by
    <a href="#">Anonymous Developers</a>
  </div>
</div>

<!-- Blog Post -->
<div class="card mb-4">
  <div class="card-body">
    <div class="row">
      <div class="col-lg-6">
        <a href="#">
          <img class="img-fluid rounded" src="misc/css.png" style="height:220px; width:220px;">
        </a>
      </div>
      <div class="col-lg-6">
        <h2 class="card-title">CSS</h2>
        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla? Quos cum ex quis soluta, a laboriosam. Dicta expedita corporis animi vero voluptate voluptatibus possimus, veniam magni quis!</p>
        <a href="#" class="btn btn-danger">Read More &rarr;</a>
      </div>
    </div>
  </div>
  <div class="card-footer text-muted">
  Posted on October 17, 2021 by
    <a href="#">Anonymous Developers</a>
  </div>
</div>






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

                     
  <!-- -->
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