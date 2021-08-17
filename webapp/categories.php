<?php
    session_start();
    require("sql_connect.php");

    $topic = $_GET['cat'];

    $sql = "SELECT * 
            FROM articles AS a
            INNER JOIN user AS u
            ON a.user_id = u.user_id
            WHERE topic = '{$_GET['cat']}'
            ORDER BY article_id DESC";
    $ret = mysqli_query($db, $sql);

?>

<html>
<head>
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
#articleTitle{
    color: black;
}
</style>
<title><?php $topic ?></title>
<link rel = "stylesheet" href = "bootstrap/css/bootstrap.css">
<link rel = "stylesheet" type = "text/css" href="style.css">
</head>

<body>
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
    
    
    <div class = "container" id = 'mainContainer'>
        
        <?php
                echo"
                
                    <div class = 'mainHeader'>
                        <h2 style = 'margin-top: 30px;'>$topic</h2>
                        <hr style='border: solid black 1px;'>
                        <h3>Latest</h3>
                        <hr style='border: solid black 0.5px;'>
                    </div>
                    
                    
                    <div class = 'subTitles'>
                        <ul class = 'nav navbar-nav' id  = 'subTitlesNav'>
                            <li><a href= 'categories.php?cat=Europe'>Europe</a></li>
                            <li><a href= 'categories.php?cat=Asia'>Asia</a></li>
                            <li><a href= 'categories.php?cat=Middle Eastern'>Middle Eastern</a></li>
                            <li><a href= 'categories.php?cat=America'>Americas</a></li>
                            <li><a href= 'categories.php?cat=Australia'>Australia</a></li>
                        </ul>
                        <br>
                         <hr style = 'border: solid black 0.5px;'>
                    </div>
        ";
            while($row = mysqli_fetch_assoc($ret)){
                $temp = strtotime($row['date']);
				$saveDate = date("F j, Y", $temp);
                echo"
                    <div class = 'row'>
                        <div class = 'col-md-7'>
                            <p style = 'font-size: 9px; color: darkgray'>{$saveDate}
                            </p>
                            <a href = 'article.php?artID={$row['article_id']}'><h4>Title: {$row['title']}</h4></a>
                            <p>Author: {$row['username']} </p>
                        </div>
                        <div class = 'col-md-3'>
                           <a href = 'article.php?artID={$row['article_id']}'><img src='{$row['image']}' style = 'width:150px;'></a>
                        </div>
                    </div>
                    <hr style = 'border: solid black 0.5px;'>";
            
            
            }
        ?>
        
    </div>
    
    
    
</body>
</html>