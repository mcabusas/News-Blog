<?php

require("sql_connect.php");
session_start();

$name = $_GET['index'];


$query = "SELECT *
        FROM articles
        INNER JOIN user
        ON articles.user_id = user.user_id
        WHERE title LIKE '%{$name}%'
        OR topic LIKE '%{$name}%'
        OR user.username LIKE '%{$name}%'
        OR content LIKE '%{$name}%'
        ";
        
        $ret = mysqli_query($db, $query);

?>


<html>
<head>
<style>
</style>
<title>Home</title>
<link rel = "stylesheet" href = "bootstrap/css/bootstrap.css">
<link rel = "stylesheet" type = "text/css" href="style.css">

</head>

<body>
<header>
    <nav class = "nav navbar-default-top2">
         <div class="container-fluid">
                
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
    
    
<div class = "container" id = "mainContainer">
    <div class = "mainHeader">
        <h2 style = "margin-top: 30px;;">Search for <?php echo $name ?></h2>
        <hr style="border: solid black 1px;">
        <h3>Latest</h3>
        <hr style="border: solid black 1px;">
</div>
    
    <?php
    
    
        while($row = mysqli_fetch_assoc($ret)){
            $temp = strtotime($row['date']);
            $saveDate = date("F j, Y", $temp);
            echo"
                <div class = 'row'>
                    <div class = 'col-md-7'>
                        <a href = 'article.php?artID={$row['article_id']}'><img src='{$row['image']}' style = 'width:150px;'></a>
                        <p style = 'font-size: 9px; color: darkgray'>{$saveDate}</p>
                        <h4 style = 'color:black';>Title: {$row['title']}</h4>
                        <h4 style = 'color:black';>Author: {$row['username']}</h4>
                        <h4 style = 'color:black';>Topic: {$row['topic']}</h4>
                    </div>
                </div>
                <hr style='border: solid black 1px;'>
            
            ";
        }
    ?>

</body>
</html>