<?php include "checker.php"; ?>
<?php
require("sql_connect.php");

$user = $_SESSION['username'];


if(isset($_POST['imageBtn'])){
        $imageDirectory = "uploads/";
        $imageUpload = $imageDirectory . basename($_FILES['file']['name']);
        $path = "uploads/".$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $path);
        $imageType = pathinfo($imageUpload, PATHINFO_EXTENSION);
    
         if($imageType != "jpg" && $imageType != "png" && $imageType != "jpeg" && $imageType != "gif" ){
                $message = "Please upload a file that is a Picture";
                echo "<script type='text/javascript'>alert('$message');</script>";
         }else{
             $sql = "UPDATE images AS i
                    INNER JOIN user AS u 
                    ON u.user_id=i.user_id
                    SET image = '$imageUpload'";
             
             mysqli_query($db, $sql);
                $message = "Update successful!";
                echo "<script type='text/javascript'>alert('$message');</script>";
             
         }
    
}

if(isset($_POST['submitBtn'])){
		$current = md5($_POST['current_password']);
        $password = md5($_POST['password']);
        $confirmpass = md5($_POST['new_password']);
		
		
        
        $catch = "SELECT password 
				  FROM user 
				  WHERE username = '$user'"
				  ;
		
		$oldpass = mysqli_query($db, $catch);
		$row =  mysqli_fetch_assoc($oldpass);
		$oldpassworddb = $row['password'];
		
		if($current==$oldpassworddb){
			
			if($password!=$confirmpass){
				$message = "Password do not match!";
                echo "<script type='text/javascript'>alert('$message');</script>";
			}else{
				$sql="UPDATE user SET password = '$password' WHERE username = '$user'";
				mysqli_query($db,$sql);  
				// $_SESSION['username'] = $username;
				$message = "Password has been changed!";
				echo "<script type='text/javascript'>alert('$message');</script>";
				
				header("refresh:0; url:profile.php");
			}
			
		}else{
            echo "<script type='text/javascript'>alert('The current password typed in is not found in the database');</script>";
		}
}
?>

<html>
<head>
<style>
#footer{
    background-color: #B0C4DE;
    color: black;
}
li>a{
    color: black;
    text-align: left;
}
#imageBtn{
    background-color: white; 
    margin-top: 5px; 
    transition-duration: 0.4s;
}
#imageBtn:hover{
    background-color: black;
    color: white;
}
</style>
<title>Profile</title>
<link rel = "stylesheet" href = "bootstrap/css/bootstrap.css">
<link rel = "stylesheet" type = "text/css" href="style.css">

</head>
<body>
<header>
    <nav class = "nav navbar-default-top2">
        
            <div class="container-fluid">
                
                <form action = "home.php" method = "POST">
                        <div class="col-md-5" style = "margin-top: 25px;">
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
    
    <div class = "col-md-6 col-md-offset-3" style = "margin-top: 100px; background-color: #7BB2CD; border-radius: 20px;">
            <div class="col-md-9 col-md-offset-5">
                <h3><strong>Profile</strong></h3>
            </div> 
            <hr style = "border: solid black 1px;">
                    <div class = "col-md-12" style = "margin-top: 30px;">
                            <div class = "row">
                                <div class = "col-md-4">
                                <?php
                                    $ret = mysqli_query($db, "SELECT image FROM images as i INNER JOIN user as u ON i.user_id = u.user_id WHERE username = '$user'");
                                        while($row = mysqli_fetch_assoc($ret)){
                                            $image = $row['image'];
                                            echo "<img src='$image' style = 'width:200px'>";
                                        }
                                   ?>
                                   <form action="profile.php" method="post" enctype="multipart/form-data">
                                        Select image to upload:
                                        <input type="file" name="file" id="fileToUpload">
                                        <button type = "submit" name = "imageBtn" id = imageBtn>Change Picture!</button>
                                </div>
                                <?php  
                                        
                                        $result = mysqli_query($db, "SELECT * FROM user WHERE username = '$user'");
                                        while($row = mysqli_fetch_array($result)){
                                            echo "
                                                <div class = 'col-md-offset-5'>
                                                    <strong> Username : {$row['username']}</strong>
                                                </div>
                                                <div class = 'col-md-offset-5' style = 'margin-top:5px';>
                                                    <a href='mailto:'{$row['email']}' class='special'>{$row['email']}</a>
                                                </div>
                                                ";
                                        }
                                ?>

                                <div class = "col-md-offset-5" style = "margin-top:15px;">
                                    <input type="password" name="current_password" style = "border-radius: 6px;" placeholder="Current Password">
                                </div>
                                <div class = "col-md-offset-5" style = "margin-top: 15px;">
                                    <input type="password" name="password" style = "border-radius: 6px;" placeholder="New Password">
                                </div>
                                <div class = "col-md-offset-5" style = "margin-top: 15px;">
                                    <input type="password" name="new_password" style = "border-radius: 6px;" placeholder="Confirm Password">
                                </div>
                                <div class = "col-md-offset-5" style = "margin-top: 15px;">
                                    <button class="btn btn-success" name = "submitBtn" style = "margin-bottom: 10px;">Submit</button>
                                </div>
                            </div>
                    </div>
                </form>

    </div>
    
    
</body>
</html>