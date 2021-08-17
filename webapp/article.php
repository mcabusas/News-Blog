<?php
    session_start();
require("sql_connect.php");

$article = $_GET['artID'];


if(isset($_SESSION['username'])){
        $user = $_SESSION['username'];
}

    $query = "SELECT *
            FROM articles AS a
            INNER JOIN user AS u
            ON a.user_id = u.user_id
            WHERE article_id = '$article'";

    $ret = mysqli_query($db, $query);
?>

<html>
<head>
<style>
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
.commentSection{
    
}
</style>
<title>Web App</title>
<link rel = "stylesheet" href = "bootstrap/css/bootstrap.css">
<script src = "jquery/jquery-3.2.1.min.js"></script>
<link rel = "stylesheet" type = "text/css" href="style.css">
</head>
<body>
    
    
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
    <div class = 'container' style = "margin-bottom: 100px;">
        <div class = 'container' style = 'margin-top: 80px;'>
        <?php
            while($row = mysqli_fetch_assoc($ret)){
                $temp = strtotime($row['date']);
                $saveDate = date("F j, Y", $temp);
                echo "

                        <div class = 'articleTitle'>
                            <h1 id = 'articleTitle'>
                                {$row['title']}
                            </h1>
                        </div>
                        <hr style = 'border: solid black 1px;'>
                        <div class = 'articleAuthor'>
                            <h3 style = 'color:black;'>By: <strong>{$row['username']} </strong></h3>
                        </div>
                        <div>
                            <h5 style = 'color:black;'><em>{$saveDate}</em></h5>
                        </div>
                        <hr style = 'border: solid black 1px;'>

                        <div class = 'articleImg'>
                            <img src='{$row['image']}' style = 'width:200px;'>
                        </div>
                        <hr style = 'border: solid black 1px;'>

                        <div class = 'articleContent'>
                            <p>";echo nl2br($row['content']); echo"</p>
                        </div>
                         <hr>";
                ?>
                <?php   
                            if(isset($_SESSION['username'])){
                                echo"
                                <div class = 'col-md-2'>
                                    <button type='button' class='commentBox btn btn-info commentBox{$row['article_id']} ' id = '{$row['article_id']}' style = 'margin-top: 5px; '>Comment</button>
                                    <button type='button' class='hideBox hideBox{$row['article_id']} btn btn-info' id = '{$row['article_id']}'  style = 'margin-top: 5px; display: none;'>Hide</button>
                                 </div>";
                            }
                ?>

                <?php
                     echo"
                         <div class = 'col-md-2'>
                            <button type='button' class='viewComments viewComments{$row['article_id']} btn btn-info' id = '{$row['article_id']}' style = 'margin-top: 5px;'>View/Hide Comments</button>
                        </div>
                    </div>

                        <div class = 'container'>

                        <form method = 'post' action = 'article.php' target = 'frame'>
                              <div id = 'commentTextbox' style = 'margin-top: 5px;'>
                            <input type='hidden' value='{$row['article_id']}' name='art_id'>
                            <textarea name = 'commentContent' rows = '6' cols = '60' placeholder = 'Enter your article...' class = 'commentText commentText{$row['article_id']}' id = '{$row['article_id']}'></textarea>
                            </div>

                            <button type='submit' class='submitBox submit{$row['article_id']}' name = 'submitComment' style = 'margin-top: 5px;'>Submit Comment</button>
                         </form>
                    </div>
                    ";
                ?>
        <?php
            $sql = "SELECT *
                    FROM comments AS c
                    INNER JOIN user AS u
                    ON c.user_id = u.user_id
                    INNER JOIN articles AS a
                    ON c.article_id = a.article_id
                    INNER JOIN images AS i
                    ON u.user_id = i.user_id
                    WHERE a.article_id = '$article'";
            $submit = mysqli_query($db, $sql);

            while($rows = mysqli_fetch_assoc($submit)){
                $temporary = strtotime($rows['dateCmt']);
                $newDate = date("F j, Y", $temporary);
                echo"
                    <div class = 'container'>
                        <div class = 'row'>
                            <div class = 'col-md-6 commentSection commentSection{$rows['article_id']} id = '{$rows['article_id']} style = 'margin-bottom:px;'>
                                <hr style = 'border: solid black 1px;'>
                                <div class = 'col-md-2'>
                                    <img src='{$rows['image']}' style = 'width:150px;'>
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
        <?php
            }


                 if(isset($_POST['submitComment'])){
                $comment =  mysqli_real_escape_string($db, $_POST['commentContent']);
                if(!empty($comment)){

                    $ret = "INSERT INTO comments(comment_id, commentContent, dateCmt, user_id, article_id)
                            VALUES(null, '$comment', CURRENT_TIMESTAMP, (SELECT user_id FROM user WHERE username = '$user'), '".$_POST['art_id']."')";

                    mysqli_query($db,$ret);
                    $message = "Comment Submitted";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                    echo "<script>window.opener.location.reload();</script>";
                    echo "<script>window.close();</script>";
                    header("location: article.php?artID=".$_POST['art_id']."");
                }else{
                    $message = "Please fill up the comment field before submitting!!";
                    echo "<script type='text/javascript'>alert('$message');</script>";

                }

        }
        ?>
    </div>
    
    
    
   
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

$('.hideCmt').click(function(){
   var article_id = $(this).attr('id');
    $(this).hide();
    $(".commentSection"+article_id).slideUp();
	$(".viewComments"+article_id).slideDown();
    
});


    
    
</script>