<?php
    $db = mysqli_connect("localhost", "root", "","athentication");
    
    if(!$db){
        echo"connecting to the database";
        exit();
    }
?>