




<?
function my_simple_crypt( $string, $action = 'e' ) {
    // you may change these values to your own
    $secret_key = 'akjgkflosthgemdjswyag';
    $secret_iv = 'pylofthemcnshwkhrfds';
 
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
 
    if( $action == 'e' ) {
        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
    }
    else if( $action == 'd' ){
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    }
 
    return $output;
}


$dbhost = 'tester.ca4um1hva9qk.us-east-1.rds.amazonaws.com';
$dbport = '3306';
$dbname = 'tester';
$charset = 'utf8' ;
$username = 'cis450test';
$password = 'password';

$link = mysqli_connect($dbhost, $username, $password, $dbname, $dbport);

if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }



if (isset($_POST)) {
    if ($_POST['form_name'] == 'login') {
        
        $attemptuser =  $_POST['login_email'];
        $query = "SELECT * FROM  `login` WHERE  `username` = '$attemptuser'";
        $result = mysqli_query($link, $query) or die('Error querying database.');
      
      
      
       
      
        if (mysqli_num_rows($result) > 0) {
             // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                if ($row['password'] == $_POST['login_password']) { // my_simple_crypt( $_POST['login_password'], 'e' )) {
                    session_start();
                    $_SESSION['userid'] = $row['userid'];
                    header('Location: http://cis550-env.us-east-2.elasticbeanstalk.com/movie.php');
                } else {
                    $loginerror = "Error: incorrect password";
                }
            }
        } else {
            $loginerror = "Error: email not registered";
        }
        
    } else if ($_POST['form_name'] == 'registration') {
        if (!(strlen($_POST['registration_first']) > 0)) {
            $registrationerror = "first";
            $errormessage2 = "First name cannot be blank";
        } else if (!(strlen($_POST['registration_last']) > 0)) {
            $registrationerror = "last";
            $errormessage2 = "Last name cannot be blank";
        } else if (!(strlen($_POST['registration_email']) > 0)) {
            $registrationerror = "email";
            $errormessage2 = "Email cannot be blank";
        } else if (!((strlen($_POST['registration_password']) > 7) && (strlen($_POST['registration_password']) < 21))) {
            $registrationerror = "password";
            $errormessage2 = "Password: minimum 8 and maximum 20 characters";
         } else {
        
            // NO REGISTRATION FORM ERROR ------------------------------------------------------
                
                
            

            $query = "SELECT * FROM login";
            $result = mysqli_query($link, $query) or die('Error querying database.');
            $id = mysqli_num_rows($result);
            
            
            
            $first = mysqli_real_escape_string($link, $_POST['registration_first']);
            $last = mysqli_real_escape_string($link, $_POST['registration_last']);
            $name = $first." ".$last;
            $email = mysqli_real_escape_string($link, $_POST['registration_email']);
            $pass = mysqli_real_escape_string($link, $_POST['registration_password']);
            $password = $pass;//$password = my_simple_crypt( $pass, 'e' );
            $verified = "no";
            
            
            
            
            $query = "SELECT * FROM login WHERE `username` = '$email'";
            $result = mysqli_query($link, $query) or die('Error querying database.');
            if (mysqli_num_rows($result) == 0) {
                $query = "INSERT INTO `login`(`userid`, `username`, `password`, `name`)
                        VALUES ( '$id', '$email', '$password', '$name');";
                $result = mysqli_query($link, $query) or die('Error querying database.');
                session_start();
                $_SESSION['userid'] = $id;
                header('Location: http://cis550-env.us-east-2.elasticbeanstalk.com/movie.php');
            } else {
                $registrationerror = "email";
                $errormessage2 = "Error: username already taken";
            }
         }
    }
}



?>

















<html>
    <head>
        <meta id="meta" name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0 maximum-scale=1.0" />

        <title>Login Portal</title>
   

        <style>
            * {
                margin: 0px;
                padding: 0px;
                overflow-x: none;
            }
            #loading {
                width: 100%;
                height: 100%;            
                top: 0;
                left: 0;
                position: fixed;
                display: block;
                background-color: #fff;
                z-index: 99;
                text-align: center;
            }
            .loader {
                margin-top: 30vh;
                border: 16px solid #f3f3f3;
                border-radius: 50%;
                border-top: 16px solid #3498db;
                width: 120px;
                height: 120px;
                -webkit-animation: spin 2s linear infinite;
                animation: spin 2s linear infinite;
            }

            @-webkit-keyframes spin {
                0% { -webkit-transform: rotate(0deg); }
                100% { -webkit-transform: rotate(360deg); }
            }
            
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            #loading-image {
                position: absolute;
                top: 100px;
                left: 240px;
                z-index: 100;
            }
            #login {
                z-index: 1;
                overflow-y: auto;
                overflow-x: hidden;
                position: absolute;
                top: 0px;
                right: 0px;
                width: 50vw;
                background-color: #2b3043;
                height: 100vh;
                transition: 1s all;
            }
            #register {
                z-index: 0;
                overflow-y: auto;
                overflow-x: hidden;
                position: absolute;
                top: 0px;
                left: 0px;
                width: calc(50vw + 20px);
                padding-right: 20px;
                background-color: #2b3043;
                height: 100vh;
                transition: 1s all;
            }
            #slider {
                z-index: 2;
                background-image: URL('pic1.jpg');
                background-repeat: none;
                background-size: cover;
                background-position: center;
                position: absolute;
                top: 0;
                left: 0;
                height: 100vh;
                width: 50vw;
                transition: all 1s ease;
            }
            h3 {
                font-family: 'HelveticaNeueLTCom-UltLt', "Helvetica Neue", Helvetica, Arial, sans-serif;
                color: #FFFFFF;
                font-weight: normal;
                font-size: 30px;
                padding: 0 0 44px 90px;
                letter-spacing: 0.7px;
                display: block;
                -webkit-margin-before: 16px;
                -webkit-margin-after: 16px;
                -webkit-margin-start: 0px;
                -webkit-margin-end: 0px;
            }
            h4 {
                font-family: 'HelveticaNeueLTCom-UltLt', "Helvetica Neue", Helvetica, Arial, sans-serif;
                color: red;
                font-weight: normal;
                font-size: 20px;
                padding: 0 0 0px 90px;
                letter-spacing: 0.7px;
                display: block;
                -webkit-margin-before: 16px;
                -webkit-margin-after: 16px;
                -webkit-margin-start: 0px;
                -webkit-margin-end: 0px;
            }
            input[type=text].full, input[type=email].full, input[type=password].full {
                background-color: #2b3043;
                width: 90%;
                color: white;
                box-sizing: border-box;
                display: block;
                font-family: 'HelveticaNeueLTCom-UltLt', "Helvetica Neue", Helvetica, Arial, sans-serif;
                line-height: 50px;
                font-size: 18px;
                border: 0px;
            }
            .half {
                background-color: #2b3043;
                width: 40%;
                color: white;
                font-family: 'HelveticaNeueLTCom-UltLt', "Helvetica Neue", Helvetica, Arial, sans-serif;
                line-height: 50px;
                font-size: 18px;
                border: 0px;
            }
            input[type=submit] {
                font-family: 'HelveticaNeueLTCom-Roman', "Helvetica Neue", Helvetica, Arial, sans-serif;
                text-transform: uppercase;
                background: none;
                color: #f25d59;
                font-size: 18px;
                border: 2px solid #f25d59;
                padding: 16px 64px 16px 64px;
                border-radius: 50px;
                margin-left: 50px;
                transition: all 1s ease;
                cursor: pointer;
            }
            .registerNow {
                font-family: 'HelveticaNeueLTCom-Roman', "Helvetica Neue", Helvetica, Arial, sans-serif;
                text-transform: uppercase;
                background: none;
                color: #f25d59;
                font-size: 18px;
                border: 2px solid #f25d59;
                background-color: white;
                border-radius: 50px;
                padding: 16px 64px 16px 64px;
                width: 300px;
                border-radius: 50px
                transition: all 1s ease;
                cursor: pointer;
            }
            input[type=submit]:hover, .registerNow:hover {
                border: 2px solid #f25d59;
                color: white;
                background-color: #f25d59;
            }
            #password_toggle, .alt_toggle_button {
                font-family: 'HelveticaNeueLTCom-Roman', "Helvetica Neue", Helvetica, Arial, sans-serif;
                text-transform: uppercase;
                background: none;
                color: #f25d59;
                font-size: 14px;
                border: 2px solid rgba(255,255,255,0);
                padding: 8px 16px 8px 16px;
                width: 250px;
                border-radius: 25px;
                transition: all 1s ease;
                cursor: pointer;
            }
            #password_toggle:hover {
                border: 2px solid #f25d59;
            }
            textarea:focus, input:focus {
                outline: none;
            }
            #email_wrap {
                width: 40vw;
                background: transparent url(../images/icn_user_login.png) no-repeat scroll center left;
                background-position: 50px 50%;
            }
            #login_password_wrap {
                width: 40vw;
                background: transparent url(../images/icn_user_pwd.png) no-repeat scroll center left;
                background-position: 50px 50%;
                transition: all 1s ease;
            }
            #password_wrap {
                width: 40vw;
                background: transparent url(../images/icn_user_pwd.png) no-repeat scroll center left;
                background-position: 50px 50%;
                transition: all 1s ease;
            }
            .input_wrap {
                width: 98%;
                background-color: #2b3043;
                padding: 15px 0 15px 64px;
                padding-left: 100px;
                //border-top: 2px solid #3B3F4F;
                border-bottom: 2px solid #3B3F4F;
                border-left: 0px;
                border-right: 0px;
            }
            .notransition {
                -webkit-transition: none !important;
                -moz-transition: none !important;
                -o-transition: none !important;
                transition: none !important;
            }
            
            .alt_toggle_button {
                display: none;
            }
            @media screen and (max-width: 825px) {
                #email_wrap, #login_password_wrap {
                    width: calc(100vw - 150px);
                }
                #slider {
                    display: none;  
                    width: 100vw;
                    height: 300px;
                }
                #login {
                    width: 100vw;          
                    left: 0vw;
                }
                #register {
                    width: 100vw;
                    left: -100vw;
                }
                .alt_toggle_button {
                    display: inline-block;
                    margin: 30px 0px;
                }
                html, body {
                    overflow-x: hidden;
                }
                .half {
                    width: 80%;
                }
            }
            
        </style>
        <script>
            function slideCover() {
                if (document.getElementById('slider').style.left == '50vw') {
                    document.getElementById('slideButton').value = 'Register Now';
                    document.getElementById('slider').style.left = '0';
                    document.getElementById('slider').style.backgroundImage = 'URL(\'pic1.jpg\')';
                } else {
                    document.getElementById('slider').style.left = '50vw';
                    document.getElementById('slideButton').value = 'Sign In';
                    document.getElementById('slider').style.backgroundImage = 'URL(\'pic2.jpg\')';
                }
            }
            function togglePassword() {
                if (document.getElementById('login_password_wrap').style.width == '0px') {
                    document.getElementById('login_password_wrap').style.width = '40vw';
                    document.getElementById('password_toggle').value = 'Forgot Password';
                    document.getElementById('form_name').value = 'login';
                    document.getElementById('login_password_wrap').style.padding = '15px 0 15px 100px';
                    document.getElementById('login_password').required = true;
                } else {
                    document.getElementById('login_password_wrap').style.width = '0px';
                    document.getElementById('password_toggle').value = 'Sign In';
                    document.getElementById('form_name').value = 'forgot';
                    document.getElementById('login_password_wrap').style.padding = '0px';
                    document.getElementById('login_password').required = false;
                }
            }
        </script>
        <script language="javascript" type="text/javascript">
            window.onload = function(){
                var img1 = new Image();
		        img1.src = "http://cis550-env.us-east-2.elasticbeanstalk.com/pic1.jpg";
                var img2 = new Image();
		        img2.src = "http://cis550-env.us-east-2.elasticbeanstalk.com/pic2.jpg";
                document.getElementById("loading").style.display = "none";
                <? if (isset($_POST)) { if ($_POST['form_name'] == 'registration') { echo "slideCover();"; } } ?>
            }  
        </script>
    </head>
    <body>
        <div id="loading">
            <!--
            <center>
                <img id="loading-image" src="https://dreamacinc.com/icons/ajax-loader.gif" alt="Loading..." style="width: 100px; height: 100px; top: calc(50vh  50px);  left: calc(50vw  50px); "/>
                </center>
                -->
                <center>
            <div class="loader"></div></center>
        </div>
        <div id="slider" name="slider"><table style="width: 100%; max-width: 50vw; height: 100%; min-height: 100vh; border: 0px solid red;"><tr><td>
            <center>
                <input type="button" value="Register Now" class="registerNow" id="slideButton" onclick="slideCover();">
            </center>
        </td></tr></table></div>
        <div id="login" name="login"><table style="width: 100%; max-width: 50vw; height: 100%; min-height: 100vh; border: 0px solid red;"><tr><td>
            <h3 id="login_header">Log into your account</h3>
            <h4><? echo $loginerror; ?></h4>            <form method="post">
                <div id="email_wrap" class="input_wrap" style="border-top: 2px solid #3B3F4F;">
                    <input type="text" name="login_email" id="login_email" placeholder="Email"
                        class="full" value="<? echo $_POST['login_email']; ?>" required>
                </div>
                <div id="login_password_wrap" class="input_wrap">
                    <input type="password" name="login_password" id="login_password" placeholder="••••••••"
                        class="full" value="<? echo $_POST['login_password']; ?>" required>
                 </div>
                <br>
                <input type="hidden" name="form_name" id="form_name" value="login">
                <input type="submit" id="login_button" name="login_button" value="Sign In">
                <input type="button" id="password_toggle" name="password_toggle" onclick="togglePassword();" value="Forgot Password">
                <input type="button" class="alt_toggle_button" onclick="document.getElementById('register').style.left = '0'; document.getElementById('login').style.left = '100vw';" value="Not a member?"> 
            </form>
        </td></tr></table></div>
        <div id="register" name="register"><table style="width: 100%; max-width: 50vw; height: 100%; min-height: 100vh; border: 0px solid blue;"><tr><td>
            <h3>Register for an account</h3>
            <h4><? echo $errormessage2; ?></h4>
            <form method="post">
                <div id="email_wrap" class="input_wrap" style="border-top: 2px solid #3B3F4F;">
                    <input type="text" name="registration_first" id="registration_first" placeholder="First"
                        class="half" value="<? echo $_POST['registration_first']; ?>" required>
                    <input type="text" name="registration_last" id="registration_last" placeholder="Last"
                        class="half" value="<? echo $_POST['registration_last']; ?>" required>
                </div>
                <div id="email_wrap" class="input_wrap">
                    <input type="email" name="registration_email" id="registration_email" placeholder="Email"
                        class="full" value="<? echo $_POST['registration_email']; ?>" required>
                </div>
                <div id="password_wrap" class="input_wrap">
                    <input type="password" name="registration_password" id="registration_password" placeholder="••••••••"
                        class="full" value="<? echo $_POST['registration_password']; ?>" required>
                </div>
                <br>
                <input type="hidden" name="form_name" id="form_name" value="registration">
                <input type="submit" id="login_button" name="login_button">
                <input type="button" class="alt_toggle_button" onclick="document.getElementById('register').style.left = '-100vw'; document.getElementById('login').style.left = '0';" value="Already a member?">
            </form>
        </td></tr></table></div>
    </body>
</html>
