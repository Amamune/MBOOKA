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
                header("Location: Contact.php");
                exit;
            }else{
                header("Location: Contact.php");
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
          header("Location: Contact.php");

            exit;
        } else
        {
          $_SESSION['signup_fail']= "true";
        }
    }
    //
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
    />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Send Email Example</title>
</head>
<body>
<!-- top navigation bar -->
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

<div class="container">

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

    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h5 class="card-title text-center">Send Email</h5>
                    <form action="email-script.php" method="post" class="form-signin">
                        <div class="form-label-group" hidden>
                            <label for="inputEmail">From <span style="color: #FF0000">*</span></label>
                            <input type="text" name="fromEmail" id="fromEmail" class="form-control"  value="customerconcernmbooka@gmail.com" readonly required autofocus>
                        </div> <br/>
                        <div class="form-label-group">
                            <label for="inputEmail">From <span style="color: #FF0000">*</span></label>
                            <input type="email" name="toEmail" id="toEmail" class="form-control" placeholder="Email address" required autofocus>
                        </div> <br/>
                        <label for="inputPassword">Subject <span style="color: #FF0000">*</span></label>
                        <div class="form-label-group">
                            <input type="text" id="subject" name="subject" class="form-control" placeholder="Subject" required>
                        </div><br/>
                        <label for="inputPassword">Message <span style="color: #FF0000">*</span></label>
                        <div class="form-label-group">
                            <textarea  id="message" name="message" class="form-control" placeholder="Message" required ></textarea>
                        </div> <br/>
                        <button type="submit" name="sendMailBtn" class="btn btn-lg btn-primary btn-block text-uppercase" >Send Email</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




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