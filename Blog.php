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


    if (isset($_POST["submit"])) {
        $db->add_blog();   
    }

    if (isset($_POST["edit_submit"])) {
        $db->edit_blog();
    }

    if (isset($_POST["delete_submit"])) {
      $db->delete_blog();
  }
  
/*
            if($_SESSION['isAdmin']==0)
            {
        ?>
        <form action = 'movies.php' method='POST'>
            <button type='submit' >Add Movie</button>
        </form>
        <?php
            }
*/
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
    <script src="https://cdn.tiny.cloud/1/j7h1ur9suftcycc6u484xmet01mditssg597az4c44dy6i4z/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <style>
    #textarea-decription{
   
    } 
    #textare-editDescription{

    }
    </style>
  
  <script src="https://cdn.tiny.cloud/1/j7h1ur9suftcycc6u484xmet01mditssg597az4c44dy6i4z/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    
    <title>Blogs</title>
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

            <!-- Fucking Content -->
        <!-- Fucking Forms -->
    <main class="mt-4 pt-3 ml-2">
        <div class="card">
        <div class="card-body">
                <?php
      if(isset($_SESSION['isAdmin'])){
        if($_SESSION['isAdmin']==1)
         {?>
            <h4>Create Blogs </h4>
         <?php 
         }else{

          echo "<h4>Blogs</h4>";
         }
        }
         ?>     
          
      <?php
        if(isset($_SESSION['isAdmin'])){
         
         if($_SESSION['isAdmin']==1)
         {
      ?>
            <form action="" method="POST">
            <div class="mb-3">
                <label class="form-label">Headline Title</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="headline_title" required>
            </div>

            <div class="mb-3">
            <label for="textarea-decription" class="form-label">Description</label>
            <textarea name="content" class="form-control" id="textarea-decription" rows="3" required>
              
            </textarea>
            <script>
              tinymce.init({
              forced_root_block : "",
              selector: "#textarea-decription",
              toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent'
              }); 

            </script>
            <!-- <textarea name="content" class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea> -->
            </div>

            <div class="mb-3">
                <label class="form-label">Awards</label>
                <select name="awards" class='form-control' required>
                    <option value="gold">Gold Medal</option>
                    <option value="silver">Silver Medal</option>
                    <option value="bronze">Bronze Medal</option>
                </select>
            </div>
              
            <div style="text-align:right">
            <button type="submit" name="submit" class="btn btn-primary" value="">Submit</button>
            <button type="button" class="btn btn-default">Go Back</button>
            </div>
        </form>
        <br>
       <!-- End of Fucking Forms -->
      <?php
         }
         else{


         }
       }
       ?>
        


      <!-- Fucking Table -->
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                    <th scope="col">#Blog id</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Awards</th>

                    <?php
                        if(isset($_SESSION['isAdmin'])){
                        
                        if($_SESSION['isAdmin']==1)
                        {
                    ?>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                    <?php
                        }
                        else{


                        }
                      }
                    ?>
                    </tr>
                </thead>
                <tbody>
                  <?php
                     //readAll fuckign blogs
                     $result = $db->blog_view();
                     while($row = mysqli_fetch_array($result)){
                  ?>
                    <tr>
                    <th scope="row"><?php echo $row['blogID'];?></th>
                    <th scope="row"><?php echo $row['title'];?></th>
                    <th scope="row"><?php echo $row['content'];?></th>
                    <th scope="row"><?php echo $row['awards'];?></th>

                    <?php
                        if(isset($_SESSION['isAdmin'])){
                        
                        if($_SESSION['isAdmin']==1)
                        {
                    ?>
                    <th scope="row">         
                    <button type="button" class="btn btn-labeled btn-primary"
                    onClick="openEditModal()" id="editButton"
                      data-blogID = '<?php echo $row['blogID'];?>'
                      data-title = '<?php echo $row['title'];?>'
                      data-content = '<?php echo $row['content'];?>'
                      data-awards = '<?php echo $row['awards'];?>'
                    >
                   <span class="btn-label"><i hidden class="fa fa-trash"
                      data-blogID = '<?php echo $row['blogID'];?>'
                      data-title = '<?php echo $row['title'];?>'
                      data-content = '<?php echo $row['content'];?>'
                      data-awards = '<?php echo $row['awards'];?>'>

                    </i></span>Edit
                    </button>
                    </th>
                    <th scope="row">
                    <button type="button" onClick="openDeleteModal()"
                    data-blogID = '<?php echo $row['blogID'];?>'
                    id="deleteButton"
                    class="btn btn-labeled btn-danger">
                    <span class="btn-label">
                     <i class="fa fa-trash"
                     data-blogID = '<?php echo $row['blogID'];?>'
                     ></i>
                    </span>Trash
                    </button>
                    </th>
                    </tr>
                    <?php
                        }
                        else{


                        }
                      }
                    ?>
                  <?php
                    }
                  ?>
                </tbody>
            </table>
        </div>
        </div>
    <!-- End of Fucking Table -->
    </main>

                

       <!-- Success Modal.. it prints the fucking data if it added successfully-->
    <?php

        if( isset($_SESSION['blog_success']) || isset($_SESSION['edit_blog_success']) || isset($_SESSION['delete_blog_success']) ){
        if($_SESSION['blog_success']=="true" || $_SESSION['edit_blog_success']=="true" || $_SESSION['delete_blog_success']=="true"){
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
               if( isset($_SESSION['blog_success'])){
                if($_SESSION['blog_success']=="true"){
                   echo "Added Successfully";
                }
              }
               if( isset($_SESSION['delete_blog_success']) ){
                 if($_SESSION['delete_blog_success']=="true"){
                    echo "Delete Successfully";
                }
              }
               if( isset(  $_SESSION['edit_blog_success'])) {
                if($_SESSION['edit_blog_success']=="true"){
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
            $_SESSION['delete_blog_success']="false";
            $_SESSION['blog_success']="false";
            $_SESSION['edit_blog_success']="false";
        }
      }
    ?>
       <!-- End Success Modal -->

  <!-- Edit fucking Modal -->
      <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">New message</h5>
            <button type="button" class="btn-close" onClick="closeEditModal()"></button>
          </div>
          <div class="modal-body">

          <form action="" method="POST">
            <div class="mb-3">
                <label class="form-label">ID</label>
                <input type="text" class="form-control" id="id" name="id" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Headline Title</label>
                <input type="text" class="form-control" id="title" name="headline_title">
            </div>

            <div class="mb-3">
           <label for="textare-editDescription" class="form-label">Description</label>
            <textarea name="content" class="form-control" id="edit_textare-editDescription" rows="3" required>
              
            </textarea>
            <script>
              tinymce.init({
              forced_root_block : "",
              selector: "#edit_textare-editDescription",
              toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent'
              }); 

            </script>
            </div>

            <div class="mb-3">
                <label class="form-label">Awards</label>
                <select name="awards" class='form-control' id="awards">
                    <option value="gold">Gold Medal</option>
                    <option value="silver">Silver Medal</option>
                    <option value="bronze">Bronze Medal</option>
                </select>
            </div>

            <div style="text-align:right">
            <button type="submit" name="edit_submit" class="btn btn-primary" value="">Submit</button>
            <button type="button" class="btn btn-default" onClick="closeEditModal()">Go Back</button>
            </div>
        </form>


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
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Do you want to delete this Blog?
          </div>
          <div class="modal-footer">
           <form action="" method="POST">
             <p hidden> <input type="text" id="deleteIDTExt" name="deleteIDTExt"/> </p>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit"  class="btn btn-primary" name="delete_submit">Delete</button>
          </form>
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
      

   <!--End of Delete Modal -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script type="text/javascript">
            $(window).on('load', function() {
                $('#successModal').modal('show');
            });

            function closeModal(){
                $('#successModal').modal('hide');
            }

            function openEditModal(){
              $('#editModal').modal('show');
            }
            
            function closeEditModal(){
                $('#editModal').modal('hide');
            }
            
            function openDeleteModal(){
              $('#deleteModal').modal('show');
            }

            $(document).on('click','#editButton',function(e){
                  var id =  e.target.getAttribute('data-blogID');
                  var title =  e.target.getAttribute('data-title');
                  var content =  e.target.getAttribute('data-content');
                  var awards =  e.target.getAttribute('data-awards');

                    $('#id').val(id);
                    $('#title').val(title);
              
                    tinymce.get('edit_textare-editDescription').setContent(content);
                    $('#awards').val(awards);
            });

                 
            $(document).on('click','#deleteButton',function(e){
                var id =  e.target.getAttribute('data-blogID');
                $('#deleteIDTExt').val(id);
                console.log(id);
            });

            $(document).on('click','#deleteButtons',function(e){
                var id =  e.target.getAttribute('data-blogID');
                $('#deleteIDTExt').val(id);
              
                console.log(id);
            });


    </script>
</body>

</html>