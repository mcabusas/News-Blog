<?php

    require("sql_connect.php");
    session_start();
?>

<html>
<head>
<title>Trending</title>
<link rel = "stylesheet" href = "bootstrap/css/bootstrap.css">
<link rel = "stylesheet" type = "text/css" href="style.css">
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
h4{
    font-weight: bold;
    color:black;
}
</style>
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
        <h2>World</h2>
            <hr style = "border: solid black 1px;">
    </div>
    
<?php
    

    //$topics = array("Asia", "Middle Eastern", "Australia", "America", "Europe");
    $topics = array("Asia", "America", "Australia", "Europe", "Middle Eastern");
    echo"
            <div class = 'subTitles'>
                <ul class = 'nav navbar-nav' id  = 'subTitlesNav'>
                    <li><a href= 'categories.php?cat=Europe'>Europe</a></li>
                    <li><a href= 'categories.php?cat=Asia'>Asia</a></li>
                    <li><a href= 'categories.php?cat=Middle Eastern'>Middle Eastern</a></li>
                    <li><a href= 'categories.php?cat=Americas'>Americas</a></li>
                    <li><a href= 'categories.php?cat=Australia'>Australia</a></li>
                </ul>
                <br>
                 <hr style = 'border: solid black 0.5px;'>
        </div>
        ";
    
    
    foreach($topics as $topic){

        $query = "SELECT * FROM articles AS a
                INNER JOIN user AS u
                ON u.user_id = a.user_id
                WHERE topic = '{$topic}' 
                ORDER BY article_id DESC LIMIT 4";
        
        $ret = mysqli_query($db, $query);
        
        echo "
        
                <div class = 'row'>
                    <div class = 'col-md-9'>
                        <div class = 'mainHeader'>
                            <h4>{$topic}</h4>
                        </div>
                    </div>
                    <div class = 'col-md-offset-9'>
                        <a href = 'categories.php?cat={$topic}'><h6 style = 'color:black'>More of {$topic}</h6></a>    
                    </div>
                </div>
                <hr style = 'border: solid black 0.5px';>
                
                <div class = 'row'>
                ";
                    
            
            while($row = mysqli_fetch_assoc($ret)){
                $temp = strtotime($row['date']);
				$saveDate = date("F j, Y", $temp);
                echo" 
                        <div class = 'col-md-3'>
                            <a href = 'article.php?artID={$row['article_id']}'><img src='{$row['image']}' style = 'width:150px;'></a>
                            <h4>Title: {$row['title']}</h4>
                            <p style = 'font-size: 8px; color: darkgray'>{$saveDate} by: {$row['username']}</p>
                        </div>
                ";
                    
            }
                
            echo"    
                    </div>
            <hr style = 'border: solid black 0.5px';>";
        
    }
?>
</div>
        