<!DOCTYPE html>

<html>
<body>

<form action="imagepractice.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="file" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>

<?php
session_start();
$db = mysqli_connect("localhost", "root", "","picture");

if(isset($_POST['submit'])){
    $imageDirectory = "uploads/";
    $imageUpload = $imageDirectory . basename($_FILES['file']['name']);
    $path = "uploads/".$_FILES['file']['name'];
    move_uploaded_file($_FILES['file']['tmp_name'], $path);
    $imageType = pathinfo($imageUpload, PATHINFO_EXTENSION);
     if($imageType != "jpg" && $imageType != "png" && $imageType != "jpeg" && $imageType != "gif" ){
            
            $message = "Please upload a file that is a Picture";
            echo "<script type='text/javascript'>alert('$message');</script>";
     }else{
         $sql = "INSERT INTO picture(id, image) VALUES(null, '$imageUpload')";
         mysqli_query($db, $sql);
            $message = "Submited";
            echo "<script type='text/javascript'>alert('$message');</script>";
            header("refresh: 0; URL = social.php");
         
     }
    
    
}
?>