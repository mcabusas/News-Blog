<?php
session_start();
//connect to database
require("sql_connect.php");



if(isset($_POST['registerbtn'])){
    $username=mysqli_real_escape_string($db, $_POST['username']);
    $email=mysqli_real_escape_string($db, $_POST['email']);;
    $password=mysqli_real_escape_string($db, $_POST['password']);
    $passwordcon=mysqli_real_escape_string($db, $_POST['password_confirmation']); 
    
    
    $catch = "SELECT *
            FROM user
            WHERE username  = '$username'";
    
    $existingUser = mysqli_query($db, $catch);
 
    
    if(mysqli_num_rows($existingUser)>0){
        
            $message = "There is already a user with that username!";
            echo "<script type='text/javascript'>alert('$message');</script>";
            header("refresh: 0; URL = home.php");
    }else{
           if($password != $passwordcon){
                $message = "The passwords must match!";
                echo "<script type='text/javascript'>alert('$message');</script>";
               header("refresh: 0; URL = home.php");
            }else{
                $password = md5($password);
                $sql="INSERT INTO user(user_id, password, username, email) 
                    VALUES(null,'$password', '$username', '$email')";

                mysqli_query($db,$sql); 

                $pic = "INSERT INTO images (pictureid, user_id, image)
                VALUES (null, (SELECT user_id FROM user WHERE username = '$username'), 'uploads/images.jpeg')";
                mysqli_query($db,$pic);

                $message = "Successful Registration!";
                echo "<script type='text/javascript'>alert('$message');</script>"; 
                header("refresh: 0; URL = home.php");
        }
    }
    exit();
    
}
if(isset($_POST['loginbtn']))
{
        $username = mysqli_real_escape_string($db, $_POST['user']);
        $password = mysqli_real_escape_string($db, $_POST['userpass']);
        $password = md5($password);
    
        $sql = "SELECT username FROM user WHERE username='$username' AND password='$password'";
        $result = mysqli_query($db,$sql);
        
        if(mysqli_num_rows($result)==1){
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            $message = "Welcome!";
            echo "<script type='text/javascript'>alert('$message');</script>";
            
            header("refresh: 0.01;url=home.php");
            
        }else{
            $message = "Invalid login attempt! Username or password is incorrect!";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }

}

?>

