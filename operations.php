<?php 

require_once('PHPMailer/PHPMailer.php');
require_once('PHPMailer/Exception.php');
require_once('PHPMailer/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


    require_once('dbConnect.php');
    $dbase = new dbConnect();
    
    class operations extends dbConnect
    {
        function insert_user()
        {
            if(isset($_POST['submit'])){
                if($_POST['password']==$_POST['conpass'])
                {
                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $this->insertLogin($username,$password,$email);
                }
            }

        }

        function insertLogin($username,$password,$email)
        {
            global $dbase;
            
            try{
                $zero="0";
                $query = $dbase->connection->prepare("INSERT INTO `login` (`uID`, `username`
                , `password`, `email`, `isAdmin`) 
                VALUES (NULL, '$username', '$password', '$email', '$zero')");
                // $query->bind_param("sssb", $username, $password, $email, $zero);
                $query->execute();
                $query->close();
                
            return true;
        }
        catch(mysqli_sql_exception $error)
        {
            return $error;
        }
          
        }

        //Add Blog Function
        public function add_blog(){
            global $dbase;

            $title = $_POST['headline_title'];
            $content = $_POST['content'];
            $awards = $_POST['awards'];

            try{
         
                $query = $dbase->connection->prepare("INSERT INTO `blog` (`blogID`, `title`
                , `content`, `awards`) 
                VALUES (NULL, '$title', '$content', '$awards')");
             
                $query->execute();
                $query->close();
            
                $_SESSION['blog_success']="true";
                header('location: Blog.php');
                exit;
                }
            catch(mysqli_sql_exception $error)
            {
                    echo $error;
            }
          
        }

        //edit blog
        public function edit_blog(){
            global $dbase;

            $id = $_POST['id'];
            $title = $_POST['headline_title'];
            $content = $_POST['content'];
            $awards = $_POST['awards'];

            try{
         
                $query = $dbase->connection->prepare("UPDATE `blog` SET `title` = '$title', 
                `content` = '$content', `awards` = '$awards' 
                WHERE `blog`.`blogID` = $id");
             
                $query->execute();
                $query->close();
            
                $_SESSION['edit_blog_success']="true";
                header('location: Blog.php');
                exit;
                }
            catch(mysqli_sql_exception $error)
            {
                    echo $error;
            }
          
        }

        //delete blog
        public function delete_blog(){
            global $dbase;

            $id = $_POST['deleteIDTExt'];
        

            try{
         
                $query = $dbase->connection->prepare("DELETE FROM `blog` WHERE `blog`.`blogID` = $id");
             
                $query->execute();
                $query->close();
            
                $_SESSION['delete_blog_success']="true";
                header('location: Blog.php');
                exit;
                }
            catch(mysqli_sql_exception $error)
            {
                    echo $error;
            }
          
        }

        //Display fucking Blog Function
        public function blog_view(){
            global $dbase;
            $query = "select * from blog";
            $result =  mysqli_query($dbase->connection,$query);

            return $result;
        }

        //Adding Movie Poster
        public function add_movie($new_file_name){

            global $dbase;

            $movie_title = $dbase->clean($_POST['movie_title']);
            $director = $dbase->clean($_POST['director']);
            $description = $dbase->clean($_POST['description']);
            $price = $dbase->clean($_POST['price']);
            $genre = $dbase->clean($_POST['genre']);
            $seats = $dbase->clean($_POST['seats']);
            $pname = $new_file_name;
            $video_link = $dbase->clean($_POST['video_link']);

            try{
         
                $query = $dbase->connection->prepare("INSERT INTO `movies` (`movieID`, `title`, `director`, `description`, 
                `price`, `genre1`, `seats`, `poster`, `video_link`)
                 VALUES (NULL, '$movie_title','$director','$description', '$price', '$genre', '$seats', '$pname', '$video_link')");
             
                $query->execute();
                $query->close();
                $_SESSION['movie_success']="true";
                header('location: movied_crud.php');
                exit;
                
              
                }
            catch(mysqli_sql_exception $error)
            {
                    echo $error;
            }

        }

        //edit movie poster
        public function edit_movie($new_file_name){

            global $dbase;

            $id = $_POST['id'];
            $movie_title = $dbase->clean($_POST['movie_title']);
            $director = $dbase->clean($_POST['director']);
            $description = $dbase->clean($_POST['description']);
            $price = $dbase->clean($_POST['price']);
            $genre = $dbase->clean($_POST['genre']);
            $seats = $dbase->clean($_POST['seats']);
            $pname = $new_file_name;
            $video_link = $dbase->clean($_POST['video_link']);
            try{

                if (empty($_FILES["image_poster"]["name"])){
                    $query = $dbase->connection->prepare("UPDATE `movies` 
                    SET `title` = '$movie_title',`director` = '$director' ,`description` = '$description', `price` = '$price', `genre1` = '$genre', `seats` = '$seats'
                    , `video_link` = '$video_link'
                     WHERE `movies`.`movieID` = $id");
                }else{
                    $query = $dbase->connection->prepare("UPDATE `movies` 
                    SET `title` = '$movie_title',`director` = '$director', `description` = '$description', `price` = '$price', `genre1` = '$genre', `seats` = '$seats'
                    , `video_link` = '$video_link', 
                    `poster` = '$new_file_name' WHERE `movies`.`movieID` = $id");
                }
         
                
             
                $query->execute();
                $query->close();
                $_SESSION['edit_movie_success']="true";
                header('location: movied_crud.php');
                exit;
                
              
                }
            catch(mysqli_sql_exception $error)
            {
                    echo $error;
            }

        }

        //delete blog
        public function delete_movie(){
            global $dbase;

            $id = $_POST['deleteIDTExt'];
            echo $id;

            try{
         
                $query = $dbase->connection->prepare("DELETE FROM `movies` WHERE `movies`.`movieID` = $id");
             
                $query->execute();
                $query->close();
            
                $_SESSION['delete_movies_success']="true";
                header('location: movied_crud.php');
                exit;
                }
            catch(mysqli_sql_exception $error)
            {
                    echo $error;
            }
          
        }


        public function movie_view(){
            global $dbase;
            $query = "select * from movies";
            $result =  mysqli_query($dbase->connection,$query);

            return $result;
        }
        //end of fucking movie poster
         

        public function bookingPurchaseFunction(){
            global $dbase;

            $id = $_POST['purchase_user_id'];
            $price = $_POST['purchase_price'];
            $emails = $_POST['purchase_email'];
            $summary = $_POST['snacks_text'];

            try{
         
                $query = $dbase->connection->prepare("INSERT INTO `orderhistory` (`orderID`, `summary`, `uID`) 
                VALUES (NULL, '$summary', '$id')");
                
                $query->execute();
                $query->close();

                
                $email = new PHPMailer();
                $email->isSMTP();
                $email->SMTPAuth = true;
                $email->SMTPSecure = 'ssl';
                $email->Host = 'smtp.gmail.com';
                $email->Port = '465';
                $email->isHTML();
                $email->Username = 'torchic1524@gmail.com';
                $email->Password = 'qswgavgxjawnchya';
                $email->SetFrom('torchic1524@gmail.com','Movie Booka'); 
                $email->Subject =  "Subject: Receipt From Movie Booking Adventure (M-BOOKA)";
                $email->Body = "
                <h3>Good day, $emails</h3>
                This is a receipt of the movie you booked to watch at any of our partnered theaters. The content of your receipt are as follows.
                List of what movie the user picked, snacks and total price to be paid.<br>
                $summary
                <br>
                Good day again and thank you for using our service please continue to do so in the future.
                
                ";
                $email->AddAddress( $emails);
            //  $email->AddAddress('torchic1524@gmail.com');
                $email->send();

                $_SESSION['purchase_success']="true";
                header('location: viewMovie.php');
                exit;
                
              
                }
            catch(mysqli_sql_exception $error)
            {
                    echo $error;
            }
            
        }

        public function orderView(){

            if( isset($_SESSION['userID']) ){

                
                global $dbase;
                $query = "select * from orderhistory where uID = ".$_SESSION['userID']." ";
                $result =  mysqli_query($dbase->connection,$query);
    
                return $result;

            }
        }

    }

        //end of fucking blog function



    
?>