<?php
session_start();
require("sql_connect.php");


	if(isset($_SESSION['username'])){
        $user = $_SESSION['username'];
    }
	$sql = "SELECT *
			FROM articles
			INNER JOIN user
			ON articles.user_id = user.user_id
            WHERE topic = 'Social'
            ORDER BY article_id DESC";


	$result = mysqli_query($db, $sql);

	
	if(!$result){
		echo mysqli_error($db);
	}

     if(isset($_POST['submitComment'])){
            $comment =  mysqli_real_escape_string($db, $_POST['commentContent']);
            if(!empty($comment)){
                
                $ret = "INSERT INTO comments(comment_id, commentContent, dateCmt, user_id, article_id)
                        VALUES(null, '$comment', CURRENT_TIMESTAMP, (SELECT user_id FROM user WHERE username = '$user'), '".$_POST['art_id']."')";

                $return = mysqli_query($db,$ret);
                $message = "Comment Submitted";
                echo "<script type='text/javascript'>alert('$message');</script>";

            }else{
                $message = "Please fill up the comment field before submitting!!";
                echo "<script type='text/javascript'>alert('$message');</script>";

            }

    }

?>


<html>
<head>
    
<link rel = "stylesheet" type = "text/css" href="style.css">
<link rel = "stylesheet" href = "bootstrap/css/bootstrap.css">
<script src = "jquery/jquery-3.2.1.min.js"></script>
<script src = "bootstrap/js/bootstrap.min.js"></script>
<style>
#mainContainer{
    margin-bottom: 50px;
    padding-bottom: 20px;
}
.mainHeader>h2{
    font-style: italic;
    font-weight: bold;
}

#subTitlesNav > li> a{
    font-size: 10px;
    padding-top: 0px;
    margin: 0px;
}
a> h4{
    color: black;
}
.submitBox{
    display:none;
}
.commentBox{
    display: true;
}
.commentText{
    display: none;
    border-radius: 10px;
}
.hideBox{
    display: none;
}
.commentSection{
    display: none;
}

</style>
<title>Social</title>

</head>
    
<header>
    <nav class = "nav navbar-default-top2">
         <div class="container-fluid">
                
                <form action = "home.php" method = "POST">
                        <div class="col-md-3" style = "margin-top: 25px;">
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
    <hr style = 'border: solid black 1px;'>
</header>

<body>
    
<div class = "container" id = "mainContainer">
    <div class = "mainHeader">
        <h2 style = "margin-top: 30px;;">Social</h2>
        <hr style="border: solid black 1px;">
        <h3>Latest</h3>
        <hr style="border: solid black 1px;">
</div>
    
    
    <!--- Article  --> 
            <?php
				while($row = mysqli_fetch_array($result)){
					$temp = strtotime($row['date']);
					$saveDate = date("F j, Y", $temp);
					echo "<div class = 'row'>
                                <div class = 'col-md-7'>
                                    <p style = 'font-size: 9px; color: darkgray'>{$saveDate}</p>
                                    <h4 style = 'color:black';>Title: {$row['title']}</h4>
                                     <h4 style = 'color:black';>Author: {$row['username']}</h4>
                                     <h4 style = 'color:black';>Topic: {$row['topic']}</h4>
                                    <div class = 'col-md-2'>
                                        <button type='button' class='btn btn-info' data-toggle='modal' data-target='#contentModal{$row['article_id']}' style = 'margin-top: 5px; margin-left: -18px;'>Content</button>
                                    </div>";
                    
                    ?>
                    <?php   
                        if(isset($_SESSION['username'])){
                            echo"
                                <div class = 'col-md-3'>
                                    <button type='button' class='commentBox btn btn-info commentBox{$row['article_id']} ' id = '{$row['article_id']}' style = 'margin-top: 5px; margin-left: -18px'>Comment</button>
                                    <button type='button' class='hideBox hideBox{$row['article_id']} btn btn-info' id = '{$row['article_id']}'  style = 'margin-top: 5px; display: none; margin-left: -18px'>Hide</button>
                                 </div>";
                        }
                    ?>
                       
                            <?php echo"   
                                    <div class = 'col-md-4'>
                                        <button type='button' class='viewComments viewComments{$row['article_id']} btn btn-info' id = '{$row['article_id']}' style = 'margin-top: 5px; margin-left: -18px;'>View/Hide Comments</button>
                                    </div>
            
                                            <div class='container'>

                                                  <!-- Modal -->
                                                  <div class='modal fade' id='contentModal{$row['article_id']}' role='dialog'>
                                                        <div class='modal-dialog'>

                                                          <!-- Modal content-->
                                                          <div class='modal-content'>
                                                                <div class='modal-header'>
                                                                  <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                                                  <h4 class='modal-title'>{$row['title']}</h4>
                                                            </div>


                                                            <div class='modal-body' style = 'background-color: #B0C4DE'>
                                                                <div class = container>
                                                                    <div class = 'col-md-5'>
                                                                        <p style = 'color:black';>"; echo nl2br($row['content']); echo"</p>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                          </div>

                                                        </div>
                                                  </div>

                                            </div> "; ?>
    
                             <?php echo "<form method = 'post' action = 'social.php' target = 'frame'>
                                       <div id = 'commentTextbox' style = 'margin-top: 5px;'>
                                            <input type='hidden' value='{$row['article_id']}' name='art_id'>
                                            <textarea name = 'commentContent' rows = '6' cols = '60' placeholder = 'Enter your article...' class = 'commentText commentText{$row['article_id']}' id = '{$row['article_id']}'></textarea>
                                       </div>
                                       
                                       <button type='submit' class='submitBox submit{$row['article_id']}' name = 'submitComment' style = 'margin-top: 5px;'>Submit Comment</button>
                                    </form>
                                    ";
                    
                                            $ret = "    SELECT *
                                            FROM comments AS c 
                                            INNER JOIN user AS u 
                                            ON c.user_id = u.user_id
                                            INNER JOIN articles AS a
                                            ON c.article_id = a.article_id
                                            INNER JOIN images as I
                                            ON i.user_id = u.user_id
                                            WHERE a.article_id = '".$row['article_id']."'";
                                
                                            $query = mysqli_query($db, $ret);
                                     while($rows = mysqli_fetch_array($query)){
                                         $temporary = strtotime($rows['dateCmt']);
                                         $newDate = date("F j, Y", $temporary);
                                        echo"
												<div class = 'container'>
                                                    <div class = 'row'>
                                                        <div class = 'col-md-6 commentSection commentSection{$rows['article_id']} id = '{$rows['article_id']} style = 'margin-bottom:px;'>
                                                            <hr style = 'border: solid black 1px;'>
                                                            <div class = 'col-md-2'>
                                                                <img src='{$rows['image']}' style = 'width:100px;'>
                                                            </div>
                                                            <div class = 'col-md-offset-4'>
                                                                <p style = 'font-size: 20px;'>User: {$rows['username']}</p>
                                                                <p style = 'font-size: 10px;'>{$newDate}</p>
                                                                <p>"; echo nl2br($rows['commentContent']); echo"</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                ";
                                     }
                             ?>
                                    
                            </div>
                                <div class = 'col-md-3'>
                                   <img src="<?php echo $row['image']; ?>" style = 'width: 200px'>
                    
                                
                            
                     <?php
                        echo "  </div>
                        </div>
                        <hr style = 'border: solid black 0.5px;'>
						";
				}?>
    
    
<div>
        
</body>
</html>
<script>

    
$('.commentBox').click(function(){
    var article_id = $(this).attr('id');
    $(this).hide();
    $(".commentText"+article_id).slideDown();
    $(".submit"+article_id).show();
    $(".hideBox"+article_id).slideDown();
});
$('.hideBox').click(function(){
    var article_id = $(this).attr('id');
    $(this).hide();
    $(".commentText"+article_id).slideUp();
    $(".submit"+article_id).slideUp();
    $(".hideBox"+article_id).slideUp();
    $('.commentBox'+article_id).slideDown();
});
$('.viewComments').click(function(){
    var article_id = $(this).attr('id');
    $(".commentSection"+article_id).slideToggle();
});
$('.hideCmt').click(function(){
   var article_id = $(this).attr('id');
    $(this).hide();
    $(".commentSection"+article_id).slideUp();
	$(".viewComments"+article_id).slideDown();
    
});

    
    
</script>