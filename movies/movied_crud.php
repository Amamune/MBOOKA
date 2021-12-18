<?php
       require_once('../operations.php');
       $db = new operations();

       
       if(isset($_SESSION['isAdmin'])){
        
        if($_SESSION['isAdmin']==1)
        {

        }else{

          header("Location: index.php");
        }

       }else{
        header("Location: index.php");
       }


       $printName = "";

       if(isset($_SESSION['username']) && isset($_SESSION['isAdmin']))
       {
           $printName = $_SESSION['username'];
       }else{
   
            $printName = "No User";
       }
   
     

       if (isset($_POST["submit"])) 
       {
       
        /*
       echo "<pre>";
       print_r($_FILES['image_poster']);
       echo "</pre>";
        */
       $img_name = $_FILES['image_poster']['name'];
       $img_size = $_FILES['image_poster']['size'];
       $tmp_name = $_FILES['image_poster']['tmp_name'];
       $error = $_FILES['image_poster']['error'];
       
     


                if($error === 0 )
                {
                  if ($img_size >= 5000000) 
                    {
                        $em = "Sorry, your file is too large.".$img_size = $_FILES['image_poster']['size'];;
                   
                       echo $em;
                    }else 
                    {
                        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                        $img_ex_lc = strtolower($img_ex);
            
                        $allowed_exs = array("jpg", "jpeg", "png"); 

                    
                        if (in_array($img_ex_lc, $allowed_exs)) {
                            $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                            $img_upload_path = 'uploads/'.$new_img_name;
                            move_uploaded_file($tmp_name, $img_upload_path);
                            
                         
                            // Insert into Database
                            $db->add_movie($new_img_name);
                         
                           
                        }else {
                            $em = "You can't upload files of this type";
                         //   header("Location: index.php?error=$em");
                        }
                    }
          
                }
        }

//edit submit
        if (isset($_POST["edit_submit"])) 
       {
        
        /*
       echo "<pre>";
       print_r($_FILES['image_poster']);
       echo "</pre>";
        */
       $img_name = $_FILES['image_poster']['name'];
       $img_size = $_FILES['image_poster']['size'];
       $tmp_name = $_FILES['image_poster']['tmp_name'];
       $error = $_FILES['image_poster']['error'];
       
     


                if($error === 0 )
                {
                  if ($img_size >= 5000000) 
                    {
                        $em = "Sorry, your file is too large.";
                       echo $em;
                    }else 
                    {
                        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                        $img_ex_lc = strtolower($img_ex);
            
                        $allowed_exs = array("jpg", "jpeg", "png"); 

                    
                        if (in_array($img_ex_lc, $allowed_exs)) {
                            $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                            $img_upload_path = 'uploads/'.$new_img_name;
                            move_uploaded_file($tmp_name, $img_upload_path);
            
                         
                            
                            //delete old name
                            unlink('uploads/'.$_POST['filename']);

                               // Insert into Database
                            $db->edit_movie($new_img_name);
                         
                           
                        }else {
                            $em = "<main class='mt-4 pt-3 ml-2'>You can't upload files of this type</main>";
                         //   header("Location: index.php?error=$em");
                        }
                    }
          
                }else{

                    $new_img_name = "SHIT";
                    $db->edit_movie($new_img_name);

                }
        }

//delete submit
        if (isset($_POST["delete_submit"])) 
        {
            //delete old name
            unlink('uploads/'.$_POST['filenames']);
            $db->delete_movie();
        }
?>

<html>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
    />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="../css/style.css" />
    <title>Blogs</title>

    <style>
            .my-custom-scrollbar {
            position: relative;
            height: 500px;
     
            overflow: auto;
            }
            .table-wrapper-scroll-y {
            display: block;
            
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
                <a href="../index.php" class="dropdown-item">Home</a>
              </li>
              <li>
                <a href="../viewMovie.php"class="dropdown-item">Movies</a>
              </li>
              <li>
              <a href="../Contact.php"class="dropdown-item">Contact</a>
              </li>
              <li>
              <a href="../about.php"class="dropdown-item">About</a>
              </li>
              <li>
              <a href="../Blog.php"class="dropdown-item">Blogs</a>
              </li>
              <?php if($printName!="No User"){ ?>
              <li>
                <form action="../index.php" method="post" id="logoutid">
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

    <main class="mt-4 pt-3 ml-2">
        <div class="card">
        <div class="card-body">
            <h4>Upload Movies Poster</h4>
           
          <form action="" method="POST" enctype='multipart/form-data'>
            <div class="mb-3">
                <label class="form-label">Movie Title</label>
                <input type="text" class="form-control" id="movie_title" name="movie_title" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Director</label>
                <input type="text" class="form-control" id="director" name="director" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <input type="text" class="form-control" id="description" name="description" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" step="any" required>
            </div>
       
            <div class="mb-3">
                <label class="form-label">Genre</label>
                <select name="genre" class='form-control' >
                    <option value="Drama">Drama</option>
                    <option value="Comedy">Comedy</option>
                    <option value="Thriller">Thriller</option>
                    <option value="Romance">Romance</option>
                    <option value="Action">Action</option>
                    <option value="Horror">Horror</option>
                    <option value="Crime">Crime</option>
                    <option value="Adventure">Adventure</option>
                    <option value="Mystery">Mystery</option>
                    <option value="Family">Family</option>
                    <option value="Fantasy">Fantasy</option>
                    <option value="Sci-Fi">Sci-Fi</option>
                    <option value="Musical Drama">Musical Drama</option>
                    <option value="Animation">Animation</option>
                    <option value="Biography">Biography</option>
                    <option value="History">History</option>
                    <option value="War">War</option>
                    <option value="Sport">Sport</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Seats Available</label>
                <input type="number" class="form-control" id="seats" name="seats" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Image Poster</label>
                <input type="file" class="form-control" id="image_poster" name="image_poster" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Video Link(Optional)</label>
                <input type="text" class="form-control"  name="video_link" >
            </div>
        

            <div style="text-align:right">
            <button type="submit" name="submit" class="btn btn-primary" value="">Submit</button>
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#search_modal" >View</button>
            </div>
        </form>

    <!--

<div class="modal fade" id="search_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" >
<div class="modal-dialog modal-xl">
   
      <div class="modal-content bigModal">
          
      </div>
    </div>
  </div>
 View Modal -->
  <div class="modal fade" id="search_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title h4" id="exampleModalFullscreenLabel">View Movies</h5>
        <button type="button" class="btn-close" data-target="modal" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="table-wrapper-scroll-y my-custom-scrollbar">
              <table  class="table table-dark table-striped" >
                  <thead>
                  <tr>
                      <th scope="col" hidden>Movie ID</th>
                      <th scope="col">Title</th>
                      <th scope="col">Director</th>
                      <th scope="col">Description</th>
                      <th scope="col">Price</th>
                      <th scope="col">Genre</th>
                      <th scope="col">Seats</th>
                      <th scope="col" style="text-align:center">Poster</th>
                      <th scope="col-1">Video Link</th>
                      <th scope="col">Edit</th>
                      <th scope="col">Delete</th>
         
                  </tr>
                 
                  </thead>
                  <tbody id="table_content">
                  <?php
                     //readAll fuckign blogs
                     $result = $db->movie_view();
                     while($row = mysqli_fetch_array($result)){
                  ?>
                  <tr>
                  <th scope='row' hidden><?php echo $row['movieID'];?></th>
                  <td><?php echo $row['title'];?></td>
                  <td><?php echo $row['director'];?></td>
                  <td><?php echo $row['description'];?></td>
                  <td>$<?php echo $row['price'];?></td>
                  <td><?php echo $row['genre1'];?></td>
                  <td><?php echo $row['seats'];?></td>
                  <td>
                     <img src="uploads/<?php echo $row['poster'];?>" style="height: 160px; width 160px;"/>
                  </td>
                  <td ><?php echo $row['video_link'];?></td>
                  <td><button type="button"  class="btn btn-labeled btn-danger"
                        data-toggle="modal" data-target="#editModal"

                        data-id = "<?php echo $row['movieID'];?>"
                        data-title = "<?php echo $row['title'];?>"
                        data-director = "<?php echo $row['director'];?>"
                        data-description = "<?php echo $row['description'];?>"
                        data-price = "<?php echo $row['price'];?>"
                        data-genre = "<?php echo $row['genre1'];?>"
                        data-seats = "<?php echo $row['seats'];?>"
                        data-file_name = "<?php echo $row['poster'];?>"
                        data-video_link = "<?php echo $row['video_link'];?>"
                        id="editButton"

                  >Edit
                  </button></td>
                  <td><button type="button"  class="btn btn-labeled btn-primary"
                    data-toggle="modal" data-target="#deleteModal"

                    data-id = "<?php echo $row['movieID'];?>"
                    data-file_name = "<?php echo $row['poster'];?>"
                    id="deleteButtons"
                  >
                      
                  
                  Delete</button></td>
                  </tr>
                  <?php
                     }
                  ?>
                  </tbody>
          
   
              </table>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

       <!-- End of Fucking Forms -->

  <!-- Edit fucking Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update Modal</h5>
            <button type="button" class="btn-close" data-dismiss="modal"
            onClick="closeEditModal()"></button>
          </div>
          <div class="modal-body">
             <div class="table-wrapper-scroll-y my-custom-scrollbar">
                <form action="" method="POST" enctype='multipart/form-data'>
                     <div class="mb-3">
                        <label class="form-label">Movie ID</label>
                        <input type="text" class="form-control" id="edit_id" name="id" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Movie Title</label>
                        <input type="text" class="form-control" id="edit_movie_title" name="movie_title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Director</label>
                        <input type="text" class="form-control" id="edit_director" name="director" required>
                    </div>
                 
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <input type="text" class="form-control" id="edit_description" name="description" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" class="form-control" id="edit_price" name="price" step="any" required>
                    </div>
                    <input type="text" class="form-control" id="filename" name="filename" hidden>
                    <div class="mb-3">
                        <label class="form-label">Genre</label>
                        <select name="genre" class='form-control' id="edit_genre">
                            <option value="Drama">Drama</option>
                            <option value="Comedy">Comedy</option>
                            <option value="Thriller">Thriller</option>
                            <option value="Romance">Romance</option>
                            <option value="Action">Action</option>
                            <option value="Horror">Horror</option>
                            <option value="Crime">Crime</option>
                            <option value="Adventure">Adventure</option>
                            <option value="Mystery">Mystery</option>
                            <option value="Family">Family</option>
                            <option value="Fantasy">Fantasy</option>
                            <option value="Sci-Fi">Sci-Fi</option>
                            <option value="Musical Drama">Musical Drama</option>
                            <option value="Animation">Animation</option>
                            <option value="Biography">Biography</option>
                            <option value="History">History</option>
                            <option value="War">War</option>
                            <option value="Sport">Sport</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Seats Available</label>
                        <input type="number" class="form-control" id="edit_seats" name="seats" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Image Poster</label>
                        <input type="file" class="form-control" id="image_poster" name="image_poster">
                    </div>

                    <div class="mb-3">
                    <label class="form-label">Video Link(Optional)</label>
                    <input type="text" class="form-control" id="video_link" name="video_link" >
                    </div>
                

                    <div style="text-align:right">
                    <button type="submit" name="edit_submit" class="btn btn-primary" value="">Submit</button>
                    <button type="button" class="btn btn-default" data-toggle="modal" data-bs-target="#search_modal" >View</button>
                    </div>
                </form>
             </div>

        </div>
      
        </div>
      </div>
    </div>   

      <!-- End of  fucking Edit Modal -->

      <!--Delete Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
            data-toggle="modal" data-target="#deleteModal"
            ></button>
          </div>
          <div class="modal-body">
            Do You want to delete this Movie Poster?
          </div>
          <div class="modal-footer">
           <form action="" method="POST">
             <p hidden> <input type="text" id="deleteIDTExt" name="deleteIDTExt"/> </p>
             <p hidden> <input type="text" id="file_delete_name" name="filenames"/> </p>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
            data-toggle="modal" data-target="#deleteModal"
            >Close</button>
            <button type="submit"  class="btn btn-primary" name="delete_submit">Delete</button>
          </form>
          </div>
        </div>
      </div>
  </div>
   <!--End of Delete Modal -->


            <!-- Success Modal.. it prints the fucking data if it added successfully-->
    <?php
        if(isset($_SESSION['movie_success']) || isset($_SESSION['edit_movie_success']) || isset($_SESSION['delete_movie_success'])  ){
        if($_SESSION['movie_success']=="true" || $_SESSION['edit_movie_success']=="true" || $_SESSION['delete_movies_success']=="true"){
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

              if(isset($_SESSION['movie_success'])){ 
                if($_SESSION['movie_success']=="true"){
                   echo "Added Successfully";
                   
                }
              }

              
              if(isset($_SESSION['delete_movies_success'])){ 
                 if($_SESSION['delete_movies_success']=="true"){
                    echo "Delete Successfully";
                }
              }

              if(isset($_SESSION['edit_movie_success'])){ 
                if($_SESSION['edit_movie_success']=="true"){
                   echo "Edited Successfully";
                }
              }
            ?>
           
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onClick="closeModal()">Close</button>
         
            </div>
            </div>
        </div>
        </div>
    <?php
            $_SESSION['delete_movies_success']="false";
            $_SESSION['movie_success']="false";
            $_SESSION['edit_movie_success']="false";
          }
        }
    ?>


   

    </main>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="../js/jquery-3.5.1.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap5.min.js"></script>
    <script src="../js/script.js"></script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script type="text/javascript">
                $(window).on('load', function() {
                    $('#successModal').modal('show');
                });

                function closeModal(){
                    $('#successModal').modal('hide');
                }

                    
                function closeEditModal(){
                    $('#editModal').modal('hide');
                }

                $(document).on('click','#editButton',function(e){
                  var id =  e.target.getAttribute('data-id');
                  var title = e.target.getAttribute('data-title');
                  var director = e.target.getAttribute('data-director');
                  var description = e.target.getAttribute('data-description');
                  var price = e.target.getAttribute('data-price');
                  var genre = e.target.getAttribute('data-genre');
                  var seats = e.target.getAttribute('data-seats');
                  var filename = e.target.getAttribute('data-file_name'); 
                  var video_link = e.target.getAttribute('data-video_link'); 

                  $('#edit_id').val(id);
                  $('#edit_movie_title').val(title);
                  $('#edit_director').val(director);
                  $('#edit_description').val(description);
                  $('#edit_price').val(price);
                  $('#edit_genre').val(genre);
                  $('#edit_seats').val(seats);
                  $('#filename').val(filename);
                  $('#video_link').val(video_link);
                   
                });

                $(document).on('click','#deleteButtons',function(e){
                var id =  e.target.getAttribute('data-id');
                var filename = e.target.getAttribute('data-file_name'); 
                $('#deleteIDTExt').val(id);
                $('#file_delete_name').val(filename);
              
                console.log(id);
            });

            
    </script>

</body>

</html>