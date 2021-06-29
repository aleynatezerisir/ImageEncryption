<?php
session_start();
ob_start();
error_reporting(E_ERROR | E_PARSE);
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

$conn->close();

?>

<html>
<head>
    <style>
        .header {
            overflow: hidden;
            background-color: #f1f1f1;
            padding: 20px 10px;
        }
        .header a {
            float: left;
            color: black;
            text-align: center;
            padding: 12px;
            text-decoration: none;
            font-size: 18px;
            line-height: 25px;
            border-radius: 4px;
        }
        .header a.logo {
            font-size: 25px;
            font-weight: bold;
        }
        .header a:hover {
            background-color: #ddd;
            color: black;
        }
        .header a.active {
            background-color: forestgreen;
            color: white;
        }
        .header-right {
            float: right;
        }
        @media screen and (max-width: 500px) {
            .header a {
                float: none;
                display: block;
                text-align: left;
            }
            .header-right {
                float: none;
            }
        }
    </style>
</head>
<body>
<div class="header">
    <a href="./MainPage.php" class="logo">Image Encrypter</a>
    <div class="header-right">
        <button onClick="window.location='LoginPage.php'"> LogOut </button>
    </div>
</div>
<div style="padding: 20px 10px; background-color: whitesmoke; " >
    <!--
    <img src='img/u1/2.jpg' style="margin: 20px" height='200' width='200'>
    <button>sil</button>
    <button>Gönder</button>
    <input type="file" name="fileToUpload" id="fileToUpload">
    -->
    <button onClick="window.location='sendNewPic.php'"> Send New Picture </button>
    <button onClick="window.location='inbox.php'"> Inbox </button>
</div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    try{
        unlink("img/u".$user_id."/".$_POST['folderId'].".jpeg");
        header("Refresh:0");
    }catch (Exception $e){}
    try{
        unlink("img/u".$user_id."/".$_POST['folderId'].".png");
        header("Refresh:0");
    }catch (Exception $e){}
    try{
        unlink("img/u".$user_id."/".$_POST['folderId'].".svg");
        header("Refresh:0");
    }catch (Exception $e){}

}
?>
<form name="form" id="form" method="POST">
    <br/>File Number:
    <input type="text" name="folderId"> </input>
    <button type="submit" name="submit" value="submit" > Delete </button>
</form>

<?php
$name = $_SESSION['user_username'];
$mydir = "img/u".$user_id;
$myfiles = array_diff(scandir($mydir), array('.', '..'));

foreach ($myfiles as $file){
    $val = $mydir."/".$file;
    $arr = explode(".",$file);
    if(mime_content_type($val) == "image/png" || mime_content_type($val) == "image/jpeg" || mime_content_type($val) == "image/svg"){
        echo "<img src='".$val."'height='200' width='200'>";
        echo "<br/>";
        echo "File Number: ";
        echo $arr[0];
        echo "<br/>";
        echo "File Name: ";
        echo $file;
        echo "<br/>";
    }
}
?>

</body>
</html>
