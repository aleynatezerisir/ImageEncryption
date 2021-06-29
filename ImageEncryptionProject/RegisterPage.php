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
                position: fixed;
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
            .btn-primary {
                color: #fff;
                background-color: #0495c9;
                border-color: #357ebd; /*set the color you want here*/
            }
            .btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active, .open>.dropdown-toggle.btn-primary {
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
    $nameErr = $emailErr = $passErr = $pass2Err = "";
    $name = $email = $pass = $pass2 = $website = "";
    $errCode = $success = 0;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["username"])) {
            $nameErr = "Username is required";
        } else {
            $name = test_input($_POST["username"]);
        }

        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
        } else {
            $email = test_input($_POST["email"]);
        }

        if (empty($_POST["password1"])) {
            $passErr = "Password is required";
        } else {
            $pass = hash('sha256', test_input($_POST["password1"]));
        }
        if (empty($_POST["password2"])) {
            $pass2Err = "Password(again) is required";
        } else {
            $pass2 = hash('sha256',test_input($_POST["password2"]));

            $conn = mysqli_connect('localhost', 'root', '', 'salam');
            if ($conn === false) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $sql = "SELECT * FROM users";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    if ($row["USER_USERNAME"] == $name) {
                        $errCode = 1;
                        break;
                    } else if ($row["USER_EMAIL"] == $email) {
                        $errCode = 2;
                        break;
                    }
                }
            }
            if($pass2 != $pass)
                $errCode = 3;
            if(strlen($name)<5)
                $errCode=4;
            if(strlen($_POST["password1"])<8 || strlen($_POST["password2"])<8)
                $errCode=5;
            if ($errCode == 0) {
                $sql = "INSERT INTO users (USER_USERNAME, USER_EMAIL, USER_PASSWORD) VALUES ('" .$name. "','" .$email. "','" .$pass. "')";

                if ($conn->query($sql) === TRUE) {
                    $success = 1;
                }else{
                    $success = 2;
                }
            }
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
                <h1 style=" background-image: linear-gradient(to right, lightskyblue , lightgreen);opacity: 0.7;display: block;text-align: center;color: white;border: 5px hidden red; Margin:10px 10px 30px 10px ;padding: 15px;border-radius: 80px;font-weight:bold;font-family: monospace">
                    REGISTER
                </h1>
                <div style="padding:10px 0px;">
                    <div class="form-group">
                        <div style="min-width: 350px;color: darkgreen;font-weight: bold">
                            <label>Username</label>
                        </div>
                        <div>
                            <input type="text" name="username" class="form-control" id="username" aria-describedby="emailHelp" placeholder="Enter Username">
                        </div>
                        <div>
                            <!-- <small id="emailHelp" style= "color: #FF4B2B; font-size: small"> <?php echo $nameErr;?> </small> -->
                        </div>
                    </div>
                </div>
                <div style="padding:10px 0px;">
                    <div class="form-group">
                        <label style="min-width: 350px;color: darkgreen;font-weight: bold">Email Address</label>
                        <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter Email">
                        <!-- <small id="emailHelp" style= "color: #FF4B2B; font-size: small"><?php echo $emailErr;?></small> -->
                    </div>
                </div>
                <div style="padding:10px 0px;">
                    <div class="form-group">
                        <label style="min-width: 350px;color: darkgreen;font-weight: bold">Password</label>
                        <input type="password" name="password1" class="form-control" id="password1" placeholder="Enter Password">
                        <!-- <small id="emailHelp" style= "color: #FF4B2B; font-size: small"><?php echo $passErr;?></small> -->
                    </div>
                </div>
                <div style="padding:10px 0px;">
                    <div class="form-group">
                        <label style="min-width: 350px;color: darkgreen;font-weight: bold">Password Again</label>
                        <input type="password" name="password2" class="form-control" id="password2" placeholder="Enter Password Again">
                        <!-- <small id="emailHelp" style= "color: #FF4B2B; font-size: small"><?php echo $pass2Err;?></small> -->
                    </div>
                </div>
                <div style="padding:10px 0px;">
                    <small style= "color:lightseagreen; display: block;font-weight: bold; font-family: 'Arial Narrow'; font-size: medium; text-align: center; text-decoration: none;">
                        <?php
                            if($errCode == 1){
                                echo "Username is already taken !";
                                $success = 0;
                            }
                            else if($errCode == 2){
                                echo "Email is already exist !";
                                $success = 0;
                            }
                            else if( $errCode == 4){
                                echo "The username must be at least 5 characters !";
                                $success = 0;
                            }
                            else if($errCode == 3){
                                echo "Passwords do not match !";
                                $success = 0;
                            }
                            else if($errCode == 5){
                                echo "The password must be at least 8 characters !";
                                $success = 0;
                            }
                            else if($nameErr != "" || $emailErr != "" || $passErr != "" || $pass2Err != "" ){
                                echo "Please fill in all fields.";
                                $success = 0;
                            }
                            else if($success == 2){
                                echo "Error: " . $sql . "<br>" . $conn->error;;
                                $success = 0;
                            }
                            else if($success == 1){
                                echo "New record created successfully !<br>You are being redirected to the login page, please wait ...";

                            }
                        ?>

                    </small>
                </div>
                <div style="padding:30px 0px 0px 0px;">
                    <div class="col-md-12 text-center">
                        <button type="submit" name="submit" value="Submit" class="btn btn-success" >Submit</button>
                    </div>
                </div>
                <?php
                    if($success == 1){
                        sleep(2);
                        header( "Location:LoginPage.php" );
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