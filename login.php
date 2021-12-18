<?php
    require_once('operations.php');
    $db = new operations();             
    $zero=0;
    if (isset($_SESSION['username']) && isset($_SESSION['is-Admin'])) {
        header("Location: index.php");
    }              
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
            $_SESSION['userID'] = $user['uID'];
            $_SESSION['userEmail'] = $user['email'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['isAdmin'] = $user['isAdmin'];
            if($user['isAdmin']==true){
                header("Location: index.php");
            }else{
                header("Location: index.php");
            }
        } 
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M-BOOKA</title>
</head>

<body style="background:#CCC;">
        <form method="post" action="login.php">
            <input type="text" name="username" id="username" placeholder="User Name" class="form-control mb-3">
            <input type="password" name="password" id="auth-password" placeholder="Password" class="form-control mb-3">
            <button class="btn btn-success float-md-right mr-1" name="login">Login</button>    
         </form>
    </body>
</html>