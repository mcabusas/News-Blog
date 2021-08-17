<?php include "checker.php"; ?>
<?php

$user = $_SESSION['username'];

require("sql_connect.php");

if(isset($_POST['submitBtn'])){
    
    $title = mysqli_real_escape_string($db,$_POST['artName']);
    $content = mysqli_real_escape_string($db, $_POST["artContent"]);
    $imageDirectory = "uploads/";
    $imageUpload = $imageDirectory . basename($_FILES['image']['name']);
    $path = "uploads/".$_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], $path);
    $imageFileType = pathinfo($imageUpload, PATHINFO_EXTENSION);
    
    if(!empty($title) && !empty($content)){
           if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "png" && $imageFileType != "PNG" && $imageFileType != "jpeg" && $imageFileType != "JPEG" && $imageFileType != "gif" && $imageFileType != "GIF" ){
            
            $message = "Please upload a file that is a Picture";
            echo "<script type='text/javascript'>alert('$message');</script>";
               $uploadOk = 0;

        }else{
               
            if(isset($_POST['topic'])){
                $topic = $_POST['topic'];
                
                $sql = "INSERT INTO articles (article_id, title, content, date, image, user_id, topic) 
                    VALUES(null, '$title', '$content', CURRENT_TIMESTAMP,'$imageUpload', (SELECT user_id FROM user WHERE username = '$user'), '$topic')";
               

                mysqli_query($db, $sql);
                $uploadOk = 1;
                $message = "Article Submited";
                echo "<script type='text/javascript'>alert('$message');</script>";

                
                if($_POST['topic'] == "social"){
                    header("refresh: 0; URL = social.php");
                }else{
                    header("refresh: 0; URL = Trending.php");
                }
           }
            
        }
    }else{
            $message = "missing info";
            echo "<script type='text/javascript'>alert('$message');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<style>

#artName{
    width: 350px;
    height: 30px;
    font-size: 15px;
}
#topicName{
    width: 350px;
    height: 30px;
    font-size: 15px;
}
#submitBtn{
     margin-top: 25px;
}
#title{
    width: 400px;
    background-color: #cee3f8;
    border-radius: 4px;
    padding: 10px 10px 10px 10px;
}
#topic{
    width: 400px;
    background-color: #cee3f8;
    border-radius: 4px;
    padding: 10px 10px 10px 10px;
    margin-top: 20px;
    margin-bottom: 10px;
}
#articleSection{
    margin-top: 80px;
}
#content{
    width: 500px;
    background-color: #cee3f8;
    border-radius: 4px;
    padding: 20px 10px 20px 10px;
    margin-top: 25px;
    margin-top: 20px;;
    
}
#fileToUpload{
    margin-top: 10px;
    margin-left: -13px;
}
#submitBtn{
    font-size: 20px;
    border-radius: 5px;
    padding: 5px 10px;
    margin-left: -27px;
    transition-duration: 0.4s
}
#submitBtn:hover{
    background-color: #4CAF50; /* Green */
    color: white;
}
</style>

<link rel = "stylesheet" href = "bootstrap/css/bootstrap.css">
<link rel = "stylesheet" type = "text/css" href="style.css">

</head>
<header>
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
</header>
    
<body style = "#d4dff1">
<form action="articlesubmission.php" method="post" enctype="multipart/form-data">
        <div class = "container-fluid">
            <div class = "col-md-6 col-md-offset-4" id = "articleSection">
                <div class = "row" id = "title">
                    <textarea name = "artName" rows = "2" cols = "50" placeholder = "Name of your Article..." id = "artText"></textarea>
                </div>
                <div class = "row" id = "topic">
                    <select name = "topic">
                        <option value="social">Social</option>
                        <option value="america">America</option>
                        <option value="australia">Australia</option>
                        <option value="asia">Asia</option>
                        <option value="Europe">Europe</option>
                        <option value="middle eastern">Middle Eastern</option>
                    </select>
                </div>
                <div class = "row" id = "content">
                    <textarea name = "artContent" rows = "6" cols = "60" placeholder = "Enter your article..." id = "artText"></textarea>
                </div>
                <div id = "image">
                    <input type="file" name="image" id="fileToUpload">
                </div>
                <div class = "col-md-2" id = "submit">
                    <button type="submit" id = "submitBtn" name = "submitBtn">Submit</button>
                </div>
            </div>
        </div>
</form>
    
</body>
</html>