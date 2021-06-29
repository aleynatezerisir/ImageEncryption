
<?php
require "AES_CBC.php";
session_start();
error_reporting(E_ERROR | E_PARSE);
if(isset($_FILES['image'])){
    $errors= array();
    $file_name = $_FILES['image']['name'];
    $file_size =$_FILES['image']['size'];
    $file_tmp =$_FILES['image']['tmp_name'];
    $file_type=$_FILES['image']['type'];

    //$file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));

    $extensions= array("jpeg","jpg","png");

    /*
    if(in_array($file_ext,$extensions)=== false){
        $errors[]="extension not allowed, please choose a JPEG or PNG file.";
    }
    */

    if($file_size > 2097152){
        $errors[]='File size must be excately 2 MB';
    }
    if(mime_content_type($file_tmp) == "image/png" || mime_content_type($file_tmp) == "image/jpeg" || mime_content_type($file_tmp) == "image/svg"){

    }
    else{
        $errors[]='Wrong Type';
    }

    if(empty($errors)==true){
        $user_id = 0;
        $name = $_POST['username'];
        $conn = mysqli_connect('localhost', 'root', '', 'salam');
        if ($conn === false) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT * FROM users";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                if ($row["USER_USERNAME"] == $name) {
                    $user_id = $row["USER_ID"];
                    break;
                }
            }
        }
        $path = "img/u".$user_id."/locked";
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $file_name = 1;


        $query = "SELECT * FROM u". $user_id;
        $result = mysqli_query($conn, $query);

        if(empty($result)) {
            $query = "CREATE TABLE u".$user_id." (
                          FOLDER_ID int(11) AUTO_INCREMENT,
                          PATH varchar(255) NOT NULL,
                          LOCKED int(2) NOT NULL,
                          PRIMARY KEY  (FOLDER_ID)
                          )";
            $result = mysqli_query($conn, $query);
        }

        $query2 = "SELECT FOLDER_ID FROM u". $user_id." ORDER BY FOLDER_ID DESC";
        $result2 = mysqli_query($conn, $query2);
        while ($row = mysqli_fetch_array($result2)) {
            $file_name = $row['FOLDER_ID']+1;
            break;
        }
        $path2 = $path."/".$file_name;

        $query = "INSERT INTO u".$user_id." (
                      PATH,
                      LOCKED) VALUES ('".$path2."',1)";
        $result = mysqli_query($conn, $query);

        //move_uploaded_file($file_tmp,$path."/".$file_name);

        AES_CBC::encryptFile($_POST['sifre'], $file_tmp, $path."/".$file_name);
        echo "Message sent successfully to ".$_POST['username']." File Name: ". $file_name;
    }else{
        print_r($errors);
    }
}
?>
<html>
<body>

<form action="" method="POST" enctype="multipart/form-data">
    <br/> <br/>
    <input type="file" name="image" />
    <br/> <br/>
    <br/> <br/>
    Receivers Username :
    <input type="text" name="username" />
    <br/>
    <br/>
    Decrypter Key :
    <input type="password" name="sifre" />
    <br/>
    <br/>
    <input type="submit"/>
</form>

</body>
</html>
