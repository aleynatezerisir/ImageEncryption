<?php
session_start();
?>
<html>
<head>
    <title>Register Page</title>
    <style>
        .mainFormArea{
            max-width: 600px;
            min-width: 400px;
            height: auto;
            border: 2px solid #ccc;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: center;

            background-color: whitesmoke;
            border-radius: 80px;
        }
        .bodyArea{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -webkit-transform: translate(-50%, -50%);
            -moz-transform: translate(-50%, -50%);
            -o-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);

            background: url(bg.jpg) no-repeat center;
            background-size: cover;

            padding: 5px;
            z-index: 100;
        }
        .btn-sp1{
            width: 100%;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body class="bodyArea">
<?php
ob_start();
error_reporting(E_ERROR | E_PARSE);
require 'mailer/a.php';

$nameErr = $emailErr = $passErr = $dbUserMail = "";
$name = $email = $pass  = "";
$flag = 0;
$EnterCode = 0;
$errCode = $success = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["codeInput"])) {
        $nameErr = "Username is required";
        $errCode = 1;
    } else{
        $EnterCode = test_input($_POST["codeInput"]);
    }
    if( strlen($EnterCode) != 6){
        $errCode = 1;
        $success =0;
    }
    elseif($EnterCode != $_SESSION['MailVerCode']){
        $errCode = 1;
    }
    elseif ($EnterCode == $_SESSION['MailVerCode']){
        $success = 1;
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<div class="mainFormArea">
    <form name="registerForm" id="registerForm" action="" method="POST">
        <h1 style=" background-image: linear-gradient(to right, lightskyblue , lightgreen);opacity: 0.7;display: block;text-align: center;color: white;border: 5px hidden red; Margin:10px 10px 50px 10px ;padding: 15px;border-radius: 80px;font-weight:bold;font-family: monospace">
            Forget Password
        </h1>
        <div style="padding:10px 0px;">
            <div class="form-group">
                <div style="min-width: 350px;color: darkgreen;font-weight: bold">
                    <label>Enter Code</label>
                </div>
                <div>
                    <input type="text" name="codeInput" class="form-control" id="codeInput" placeholder="Enter Code Here">
                </div>
            </div>
        </div>
        <div style="padding:10px 0px;">
            <small style= "color:lightseagreen; display: block;font-weight: bold; font-family: 'Arial Narrow'; font-size: medium; text-align: center; text-decoration: none;">
                <?php
                if($errCode == 1){
                    echo "Wrong code !";
                    $success = 0;
                }
                else if($success == 1){
                    echo "Logged In !";
                }
                ?>

            </small>
        </div>
        <div style="padding:0px 0px 0px 0px;">
            <div class="col-md-12 text-center">
                <button type="submit" name="submit" value="Submit" class="btn btn-success btn-sp1">Enter Code</button>
            </div>
        </div>
        <?php
        if($success == 1){
            sleep(1);
            header( "Location:MainPage.php" );
            ob_end_flush();
            exit;
        }
        ?>

    </form>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>