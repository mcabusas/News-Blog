<!DOCTYPE html>
<?php
require("sql_connect.php");
    
    if(isset($_POST['forgotbtn'])){
        
        $username = $_POST['username'];
		$current = md5($_POST['current']);
        $password = md5($_POST['newpass']);
        $confirmpass = md5($_POST['newconfirm']);
		
		
        
        $catch = "SELECT password 
				  FROM user 
				  WHERE username = '$username'"
				  ;
		
		$oldpass = mysqli_query($db, $catch);
		$row =  mysqli_fetch_assoc($oldpass);
		$oldpassworddb = $row['password'];
		
		if($current == $oldpassworddb){
			
			
			if($password != $confirmpass){
				$message = "Incorrect Input!";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}else{
				$sql="UPDATE user SET password = '$password' WHERE username = '$username'";
				mysqli_query($db,$sql);  
				// $_SESSION['username'] = $username;
				$message = "Password has been changed!";
				echo "<script type='text/javascript'>alert('$message');</script>";
				
				header("refresh: 0; URL = home.php");
			}
			
		}else{
			    $message = "Passwords don' match!";
				echo "<script type='text/javascript'>alert('$message');</script>";
		}
	}

?>
<html>
<head>
<style>
</style>
  <meta charset="UTF-8">
  <title>Forgot Password</title>
    <meta charset="UTF-8">
  
<link rel = "stylesheet" href = "bootstrap/css/bootstrap.css">
<link rel = "stylesheet" type = "text/css" href="style1.css">
    
</head>
    
    <nav class = "nav navbar-default-top2">
         <div class="container-fluid">
                
                <form action = "home.php" method = "POST">
                        <div class="col-md-3" style = "margin-top: 15px;">
                             <input type="text" name="search" placeholder="Search.." style = "border-radius: 6px;">
                             <button type = "submit" name = "submitSearch" style = "display: none;"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                        </div>  
                    </form>
            
            <?php
                if(isset($_POST['submitSearch'])){
                    $search = mysqli_real_escape_string($db, $_POST['search']);
                    $sqlSearch = "SELECT *
                                FROM articles AS a
                                WHERE title LIKE '%{$search}%'";
                    $ret = mysqli_query($db, $sqlSearch);
                    header("location:search.php?title={$search}");
                }
            ?>

                         <div class = "col-md-offset-9">
                            <ul class = "nav navbar-nav">
                                <li><a href= "Trending.php">Trending</a></li>
                                <li><a href= "social.php">Social</a></li>
                            </ul>
                    </div>
                <div class="col-md-offset-11">
                    <a href = "home.php"><button type="button" class="btn btn-success" style="margin-top: 8px;">Home</button> </a> 
                </div>
            </div>
    </nav>

<body>
  
<div id="login" style = "margin-top: 40px;">   
        <div class = "col-md-12">
            <div class = "row">
                <h1 style = "text-align:center;">Change your Password</h1>
          
                  <form action="forgotpassword.php" method="post">
                      <div class = "col-md-offset-4 col-md-4 changePassBox">

                            <div class="field-wrap">
                              <label>
                                <span class="req"></span>
                              </label>
                              <input type="text" name = "username" id = "username" placeholder="username" class = "inputBox" />
                            </div>

                             <div class="field-wrap">
                            <label>
                              <span class="req"></span>
                            </label>
                            <input type="password" name = "current" placeholder = "Current Password" class = "inputBox"/>
                          </div>

                          <div class="field-wrap">
                            <label>
                              <span class="req"></span>
                            </label>
                            <input type="password" class = "inputBox" name = "newpass" placeholder = "New Password"/>
                            </div>

                        <div class="field-wrap">
                            <label>
                              <span class="req"></span>
                            </label>
                            <input type="password" class = "inputBox" name = "newconfirm" placeholder = "Confirm New Password"/>
                          </div>
                          
                          <p class="forgot"><a href = "home.php">Back to login/register</a></p>

                          <button type = "submit" class="chgepassBtn" name = "forgotbtn">Change Password</button>
                    </div>

                </form>
            </div>
        </div>
    
</div>

</body>
</html>

