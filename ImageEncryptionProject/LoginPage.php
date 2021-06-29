<?php
session_start();
?>
<html>
<head>

    <title>Register Page</title>
    <script>
        function ValidationEvent() {
            var name = document.getElementById("username").value;
            var email = document.getElementById("email").value;
            var pass1 = document.getElementById("password1").value;
            var pass2 = document.getElementById("password2").value;

            if (name != '' && email != '' && pass1 != '' && pass2 != '') {
                if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(document.getElementById("email").value)) {
                    if(pass1 != pass2){
                        alert("Passwords do not match ! ");
                        return false;
                    }else if(name.length < 8){
                        alert("The username must be at least 8 characters ! ");
                        return false;
                    }else if(pass1.length < 1 || pass2.length < 1){
                        alert("The password must be at least 8 characters ! ");
                        return false;
                    }
                    return true;
                } else {
                    alert("Invalid Email Address ! ");
                    return false;
                }
            } else {
                alert("All fields are required ! ");
                return false;
            }
        }
    </script>
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
        .btn-sp2{
            font-size: 14px;
            padding: 2px;
            color: #fff;
            background-color: #0275d8;
            border-color: #357ebd; /*set the color you want here*/
            float: left;
            width: 45%;
            margin: 1px;
            border-radius: 10px;
        }
        .btn-sp3{
            font-size: 14px;
            padding: 2px;
            color: #fff;
            background-color: #0275d8;
            border-color: #357ebd; /*set the color you want here*/
            width: 45%;
            margin: 1px;
            border-radius: 10px;
        }

        .btn-sp2:hover, .btn-sp2:focus, .btn-sp2:active, .btn-sp2.active, .open>.dropdown-toggle.btn-sp2 {
            color: #fff;
            background-color: #00b3db;
            border-color: #285e8e; /*set the color you want here*/
        }
        .btn-sp3:hover, .btn-sp3:focus, .btn-sp3:active, .btn-sp3.active, .open>.dropdown-toggle.btn-sp3 {
            color: #fff;
            background-color: #00b3db;
            border-color: #285e8e; /*set the color you want here*/
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body class="bodyArea">
<?php
    ob_start();
    error_reporting(E_ERROR | E_PARSE);

    $nameErr = $emailErr = $passErr = $dbUserPass = "";
    $name = $email = $pass  = "";
    $flag = 0;
    $errCode = $success = 0;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["username"])) {
            $nameErr = "Username is required";
            $errCode = 1;
        } else {
            $name = test_input($_POST["username"]);
        }
        if (empty($_POST["password"])) {
            $passErr = "Password is required";
            $errCode = 1;
        } else {
            $pass = hash('sha256', test_input($_POST["password"]));
        }
        if( strlen($name) < 5 || strlen($_POST["password"]) < 8){
            $errCode = 1;
            $success =0;
        }
        else{
            $conn = mysqli_connect('localhost', 'root', '', 'salam');
            if ($conn === false) {
                die("Connection failed: " . mysqli_connect_error());
                $success = 2;
            }

            $sql = "SELECT * FROM users";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    if ($row["USER_USERNAME"] == $name) {
                        $dbUserPass = $row["USER_PASSWORD"];
                        $flag = 1;
                        break;
                    } else if ($row["USER_EMAIL"] == $name) {
                        $dbUserPass = $row["USER_PASSWORD"];
                        $flag = 1;
                        break;
                    }
                }
            }
            if($dbUserPass == $pass && $flag == 1)
                $success=1;
            $conn->close();
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
            LOGIN
        </h1>
        <div style="padding:10px 0px;">
            <div class="form-group">
                <div style="min-width: 350px;color: darkgreen;font-weight: bold">
                    <label>Username</label>
                </div>
                <div>
                    <input type="text" name="username" class="form-control" id="username" placeholder="Enter Username or Email">
                </div>
            </div>
        </div>
        <div style="padding:10px 0px;">
            <div class="form-group">
                <label style="min-width: 350px;color: darkgreen;font-weight: bold">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password">
            </div>
        </div>
        <div style="padding:10px 0px;">
            <small style= "color:lightseagreen; display: block;font-weight: bold; font-family: 'Arial Narrow'; font-size: medium; text-align: center; text-decoration: none;">
                <?php
                if($errCode == 1){
                    echo "Wrong username or password !";
                    $success = 0;
                }
                else if($success == 2){
                    echo "Error: " . $sql . "<br>" . $conn->error;;
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
                <button type="submit" name="submit" value="Submit" class="btn btn-success btn-sp1" >Login</button>
            </div>
        </div>
        <div style="padding:50px 0px 0px 0px;">
            <div class="col-md-12 text-center">
                <a type="submit" href="ForgetPassPage.php" class="btn-sp2" >Forget Password</a>
                <a type="submit" href="RegisterPage.php" class="btn-sp3" >Register</a>
            </div>
        </div
        <?php
        if($success == 1){
            $_SESSION['user_username'] = $name;
            sleep(2);
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