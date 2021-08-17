<?php

require("sql_connect.php");
session_start();
    
    $sql = "SELECT *
            FROM articles AS a
            INNER JOIN user AS u
            ON a.user_id = u.user_id
            ORDER BY article_id DESC LIMIT 15";

    $return = mysqli_query($db,$sql);

?>




<html>
<head>
<style>
#footer{
    background-color: #B0C4DE;
    color: black;
}
.mainButton{
    font-size:15px;
    border-radius: 7px;
    color: black;
    background-color:white;
    transition-duration: 0.4s;
}
.mainButton:hover{
    color:white;
    background-color:green;
}
#articleBtn{
    width: 340px;
}
</style>
<title>Home</title>
<link rel = "stylesheet" type = "text/css" href="style.css">
<link rel = "stylesheet" type = "text/css" href="style1.css">
<link rel = "stylesheet" href = "bootstrap/css/bootstrap.css">
<script src = "jquery/jquery-3.2.1.min.js"></script>
<script src = "bootstrap/js/bootstrap.min.js"></script>

    

</head>
<header>
    <nav class = "nav navbar-default-top2">
        <div class="container-fluid">
                
                
                <?php if((isset($_SESSION['username']))){ ?>
                    <div class = "col-md-1">
                        <a href = "profile.php"><button type="button" class = "btn btn-success"  style = "margin-top: 20px;">Profile</button></a>
                    </div>
                <?php } ?>


                <?php if(!(isset($_SESSION['username']))){?>
                           <div class = 'col-md-2'>
                                <button type='button' name = 'logRegBtn' class = 'btn btn-success' style = 'margin-top: 20px;' data-toggle = 'modal' data-target = '#loginModal'>Login/Register</button>
                            </div>
                

                 <?php } ?>


                    <form action = "home.php" method = "POST">
                        <div class="col-md-2" style = "margin-top: 25px;">
                             <input type="text" name="search" placeholder="Search.." style = "border-radius: 6px;">
                            <button type = "submit" name = "submitSearch" style = "display: none;"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                        </div>  
                    </form>

                <?php
                    if(isset($_POST['submitSearch'])){
                        $search = mysqli_real_escape_string($db, $_POST['search']);
                        $sqlSearch = "SELECT *
                                   SELECT *
                                    FROM articles AS a
                                    INNER JOIN user AS u
                                    ON a.user_id = u.user_id;
                                    WHERE a.title LIKE '%{$search}%'
                                    OR a.topic LIKE '%{$search}%'
                                    OR a.content LIKE '%{$search}%'
                                    OR u.username LIKE '%{$search}%'
                                    ";
                        $ret = mysqli_query($db, $sqlSearch);
                        header("location:search.php?index={$search}");
                    }
                ?>
                
                <?php if(isset($_SESSION['username'])){ ?>
                    <div class = "col-md-2 col-md-offset-1">
                        <a href = "articlesubmission.php"><button type = "button" class = "mainButton" id = "articleBtn" style = "margin-top: 8px;">SUBMIT YOUR OWN ARTICLE</button></a>
                    </div>
                    
            <?php } ?>

                    <div class = "col-md-offset-9">
                        <ul class = "nav navbar-nav">
                        <li><a href= "Trending.php">Trending</a></li>
                        <li><a href= "social.php">Social</a></li>
                        </ul>
                    </div>
                
                <?php if((isset($_SESSION['username']))){ ?>
                    <div class = "col-md-1">
                        <a href = "logout.php"><button type="button" class = "btn btn-success" style = "margin-top: 5px;">Logout</button></a>
                    </div>
            <?php } ?>
        </div>
    </nav>
    <img src = "banner.jpg" style = "margin-top: 80px; width: 100%;">
    <hr style = 'border: solid black 1px;'>
</header>
    
    
<body>
    
    
    <div class='modal fade' id="loginModal" role='dialog'>
        <div class='modal-dialog modal-lg'>

            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    <h4 class='modal-title'>Register/Login</h4>
                </div>


                <div class='modal-body' style = 'background-color: #B0C4DE'>
                    
                            <div class = "row">
                                <div class = "col-md-offset-1 col-md-4 signUpInBox">   
                                      <h1>Sign Up for Free</h1>

                                      <form action="register.php" method="post">

                                        <div class = "row registerRow">
                                            <div class = "col-md-4">
                                                <div class="field-wrap">
                                                      <label>
                                                        Username<span class="req">*</span>
                                                      </label>
                                                </div>
                                            </div>

                                            <div class = 'col-md-4'>
                                                    <input type="text" class = "inputBox" name = "username" id = "username">
                                            </div>
                                      </div>
                                    <hr>


                                    <div class = "row registerRow">   
                                        <div class = "col-md-4">
                                                <div class="field-wrap">
                                                      <label>
                                                        Email Address<span class="req">*</span>
                                                      </label>
                                                </div>
                                        </div>
                                        <div class = "col-md-4">
                                            <input type="email"  class = "inputBox" name = "email" id = "email" />
                                        </div>
                                    </div>
                                    <hr>

                                    <div class = "row registerRow">   
                                        <div class = "col-md-4">
                                                <div class="field-wrap">
                                                    <label>
                                                      Set A Password<span class="req">*</span>
                                                    </label>
                                                </div>
                                        </div>
                                        <div class = "col-md-4">
                                            <input type="password" class = "inputBox" name = "password" id = "password"/>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class = "row registerRow">   
                                        <div class = "col-md-4">
                                                <div class="field-wrap">
                                                    <label>
                                                      Confirm Password<span class="req">*</span>
                                                    </label>
                                                </div>
                                        </div>
                                        <div class = "col-md-4">
                                            <input type="password" class = "inputBox" name = "password_confirmation" id = "password_confirmation" />
                                        </div>
                                    </div>
                                    <hr>

                                      <button type="submit" class = "registerBtn" name = "registerbtn" class="button button-block">Get Started</button>

                                    </form>
                                </div>


                                <!-- login -->  
                                    <div class = "col-md-4 col-md-offset-2 signUpInBox">
                                          <h1>Welcome Back!</h1>

                                          <form action="register.php" method="post">
                                              <div class = "field-wrap">
                                                  <label>
                                                    Username<span class="req">*</span>
                                                  </label>
                                                  <input type="text" name = "user" id = "username" class = "inputBox" />
                                                </div>
                                              <hr>

                                              <div class="field-wrap">
                                                    <label>
                                                      Password<span class="req">*</span>
                                                    </label>
                                                    <input type="password" class = "inputBox" name = "userpass"/>
                                              </div>
                                              <hr>

                                              <p class="forgot"><a href="forgotpassword.php" name = "forgot">Forgot Password?</a></p>

                                              <button class="loginBtn" name = "loginbtn">Log In</button>

                                          </form>
                                    </div>
                                </div>
                        
                </div>

            </div>

        </div>
    
    </div>
    


	
<div class="container-fluid">
    <?php
        while($row = mysqli_fetch_assoc($return)){
             $temporary = strtotime($row['date']);
             $newDate = date("F j, Y", $temporary);
            echo"
                <div class='row'>
                    <div class = 'col-md-1'>
                        <a href = 'article.php?artID={$row['article_id']}'><img src='{$row['image']}' style = 'width:100px;height: 80px;'></a>
                    </div>
                    <div class = 'col-md-5'>
                        
                        <a href = 'article.php?artID={$row['article_id']}'><p>Title: {$row['title']}</p></a>
                        <p>Topic: {$row['topic']}</p>
                        <h4 style = 'color:black;'>Author: {$row['username']}</h4>
                        <p style = 'font-size: 8px; color: darkgray'>{$newDate}</p>
                        
                    </div>
                    
                </div>
                 <hr style = 'border: solid black 0.5px;'>
            
            ";
            
        }
        
    ?>
</div>
</body>
</html>
