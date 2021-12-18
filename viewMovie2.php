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
.container {
  flex: 1 0 auto;
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
     >View Movies</a
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

    <!-- Page Content -->
    <main class="mt-4 pt-3 ml-2">
  <div class="container">

<h1 class="display-4" style="text-align:center">Welcome to Movie Site</h1>
<h4 style="text-align:center">To book a movie please click the poster of the preferred movie<h4>
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
                    >
                    </a>
                    <div class="card-body">
                        <h4 class="card-title" >
                        <a href="#" style="text-decoration:none"><?php echo $row['title'];?></a>
                        </h4>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur eum quasi sapiente nesciunt? Voluptatibus sit, repellat sequi itaque deserunt, dolores in, nesciunt, illum tempora ex quae? Nihil, dolorem!</p>
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
                    >
                    </a>
                    <div class="card-body">
                        <h4 class="card-title">
                        <a href="#" style="text-decoration:none"><?php echo $row['title'];?></a>
                        </h4>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos quisquam, error quod sed cumque, odio distinctio velit nostrum temporibus necessitatibus et facere atque iure perspiciatis mollitia recusandae vero vel quam!</p>
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
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="checkingButton" class="btn btn-primary" 
        data-bs-toggle="modal" data-bs-target="#checkingModal">Book Now</button>
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

    <script>
          $(window).on('load', function() {
                    $('#successModal').modal('show');
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

                price = data_price;
                movie_price = price;
                movie_title = title;
                console.log(title);
                $('#nameMovie').html(title);
                $('#seats_id').html("Seat Available: "+seats+"<br>"+"Price:₱"+data_price);
                $('#imagePoster').attr('src','movies/uploads/'+image_name);
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