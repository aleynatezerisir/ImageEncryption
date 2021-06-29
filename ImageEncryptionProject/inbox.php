<?php
require "AES_CBC.php";
session_start();
ob_start();
$flg=0;
error_reporting(E_ERROR | E_PARSE);
AES_CBC::encryptFile("asd","img/asd.PNG","img/newasd");
AES_CBC::decryptFile("asd","img/newasd","img/asd2.PNG");

$user_id = 0;
$name = $_SESSION['user_username'];
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
$sql = "SELECT * FROM u".$user_id;
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        if ($row["LOCKED"] == 1) {
            $dilim = explode("/",$row['PATH']);
            echo "  Folder Id => ".$row['FOLDER_ID']."\t  Folder Name  =>".$dilim[count($dilim)-1];
            echo "<br/>";
        }
    }
}
else{
    $query = "CREATE TABLE u".$user_id." (
                          FOLDER_ID int(11) AUTO_INCREMENT,
                          PATH varchar(255) NOT NULL,
                          LOCKED int(2) NOT NULL,
                          PRIMARY KEY  (FOLDER_ID)
                          )";
    $result = mysqli_query($conn, $query);
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $cachePAth = "";
    $sql = "SELECT * FROM u".$user_id;
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            if ($row["FOLDER_ID"] == $_POST['folderId'] && $row["LOCKED"] == 1) {
                $cachePAth = $row["PATH"];
            }
        }
    }
    $path22 = "img/u".$user_id."/".$_POST['folderId'];
    if($cachePAth != ""){
        AES_CBC::decryptFile($_POST['password'],$cachePAth,$path22);
        try {
            if(mime_content_type($path22) == "image/png" || mime_content_type($path22) == "image/jpeg" || mime_content_type($path22) == "image/svg"){
                $arr = explode("/",mime_content_type($path22));
                AES_CBC::decryptFile($_POST['password'],$cachePAth,$path22.".".$arr[1]);
                unlink($path22);
                $flg=1;
            }
        }catch (Exception $e){
            echo "Wrong Password";
        }


    }
}

?>
<?php
if($flg==1){
    header( "Location:MainPage.php" );
    ob_end_flush();
    exit;
}

?>
<html>
<head>
</head>
<body>
<form name="form" id="form" method="POST">
    <br/>Folder Id:
    <input type="text" name="folderId"> </input>
    Password:
    <input type="password" name="password"> </input>
    <button type="submit" name="submit" value="submit" > Decrypte </button>
</form>
</body>
</html>

