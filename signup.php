<?php

// For PHPMailer
require ('vendor/autoload.php'); 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

// If user is logged in, header them away
if(isset($_SESSION["username"])){
	header("location: users.php?u=".$_SESSION["username"]);
    exit();
}
?><?php
// Ajax calls this NAME CHECK code to execute
if(isset($_POST["usernamecheck"])){
	include_once("php_includes/db_conx.php");
	$username = preg_replace('#[^a-z0-9]#i', '', $_POST['usernamecheck']);
	$sql = "SELECT id FROM users WHERE username='$username' LIMIT 1";
    $query = mysqli_query($db_conx, $sql); 
    $uname_check = mysqli_num_rows($query);
    if (strlen($username) < 3 || strlen($username) > 16) {
	    echo '<p style="color:#F00;">3-16 Characters</p>';
	    exit();
    }
	if (is_numeric($username[0])) {
	    echo '<p style="color:#F00;">Usernames must begin with a letter</p>';
	    exit();
    }
    if ($uname_check < 1) {
	    echo '<p style="color:#9bc100; font-weight:bold;">' . $username . ' is OK</p>';
	    exit();
    } else {
	    echo '<p style="color:#FD3163;font-weight:bold;">' . $username . ' is taken</p>';
	    exit();
    }
}
?><?php
// Ajax calls this REGISTRATION code to execute

if(isset($_POST["u"])){
    
	// CONNECT TO THE DATABASE
	include_once("php_includes/db_conx.php");
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES
	$u = preg_replace('#[^a-z0-9]#i', '', $_POST['u']);
	$e = mysqli_real_escape_string($db_conx, $_POST['e']);
	$p = $_POST['p'];
    $g = $_POST['g'];

	// GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	// DUPLICATE DATA CHECKS FOR USERNAME AND EMAIL
	$sql = "SELECT id FROM users WHERE username='$u' LIMIT 1";
    $query = mysqli_query($db_conx, $sql); 
	$u_check = mysqli_num_rows($query);
    
	// -------------------------------------------
	$sql = "SELECT id FROM users WHERE email='$e' LIMIT 1";
    $query = mysqli_query($db_conx, $sql); 
	$e_check = mysqli_num_rows($query);
    
	// FORM DATA ERROR HANDLING
	if($u == "" || $e == "" || $p == ""){
		echo "The form submission is missing values.";
        exit();
	} else if ($u_check > 0){ 
        echo "The username you entered is alreay taken";
        exit();
	} else if ($e_check > 0){ 
        echo "<p id='error_handling'>That email address is already in use in the system</p>";
        exit();
	} else if (strlen($u) < 3 || strlen($u) > 16) {
        echo "Username must be between 3 and 16 characters";
        exit(); 
    } else if (is_numeric($u[0])) {
        echo 'Username cannot begin with a number';
        exit();
    } else {
        
	// END FORM DATA ERROR HANDLING
	    // Insert Data into DB:
		
        /* ==================== Need to further encrypt and SALT password ========================= */
		$p_hash = md5($p);
        
		// Add user info into the database table for the main site table
		$sql = "INSERT INTO users (username, email, password, userlevel, ip, signup, lastlogin, notescheck)       
		        VALUES('$u','$e','$p_hash','$g','$ip',now(),now(),now())";
		$query = mysqli_query($db_conx, $sql); 
		$uid = mysqli_insert_id($db_conx);
        
    /* Multiquery */
    $sql = "INSERT INTO usersmeta (uid,username) VALUES ('$uid','$u');";
    $sql .= "INSERT INTO useroptions (id,username) VALUES ('$uid','$u')";

    mysqli_multi_query($db_conx, $sql);

        
		// Create directory(folder) to hold each user's files(pics, MP3s, etc.)
		if (!file_exists("user/$u")) {
			mkdir("user/$u", 0755,true);
		}
        
        /* PHP MAILER ===================================================================================== */
        $mail = new PHPMailer(true);   
        
        try {
            //Server settings           
            $mail->SMTPDebug = 0;                                 // 0 = off | 1 = client | 2 = client and server
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'repaw.activation';                 // SMTP username
            $mail->Password = 'logisticsnl';                      // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            /*Recipients*/
            $mail->setFrom('Auto_Response@Repaw.io', 'Repaw Admin');
            $mail->addAddress($e, $username); // Add a recipient
            
            /* Content */
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Repawistory Account Activation';
            $mail->Body    = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Repawsitory Message</title></head><body style="margin:0px; font-family:Tahoma, Geneva, sans-serif;"><div style="padding:10px; background:#333; font-size:24px; color:#CCC;"></a>Repawsitory Account Activation</div><div style="padding:24px; font-size:17px;">Hello '.$u.',<br /><br />Click the link below to activate your account when ready:<br /><br /><a href="www.repaw.io/activation.php?id='.$uid.'&u='.$u.'&e='.$e.'&p='.$p_hash.'">Click here to activate your account now</a><br /><br />Login after successful activation using your:<br />* E-mail Address: <b>'.$e.'</b></div></body></html>';
            $mail->AltBody = 'Alt.';

            $mail->send();
            echo 'A message has been sent to ' . $e . '! <br> Please check your email shortly...';
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
		exit();
    }
	exit();
    header("location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head> 
    <title> Repaw | SignUp</title>
    
    <!-- CSS --> 
    <link rel="stylesheet" href="style/signup_style.css">
    <link rel="stylesheet" href="style/template_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    
    <!-- Bootstrap | CSS --> 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <!-- Bootstrap | Min --> 
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
    
    <!-- Bootstrap | JS --> 
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    
    <script src="js/main.js"></script>
    <script src="js/ajax.js"></script>
    
    <!-- Google Font --> 
    <link href="https://fonts.googleapis.com/css?family=Khand:400,500" rel="stylesheet">    
    
    <script>
        function restrict(elem){
            var tf = _(elem);
            var rx = new RegExp;
            if(elem == "email"){
                rx = /[' "]/gi;
            } else if(elem == "username"){
                rx = /[^a-z0-9]/gi;
            }
            tf.value = tf.value.replace(rx, "");
        }
        function emptyElement(x){
            _(x).innerHTML = "";
        }
        function checkusername(){
            var u = _("username").value;
            if(u != ""){
                _("unamestatus").innerHTML = 'checking ...';
                var ajax = ajaxObj("POST", "signup.php");
                ajax.onreadystatechange = function() {
                    if(ajaxReturn(ajax) == true) {
                        _("unamestatus").innerHTML = ajax.responseText;
                    }
                }
                ajax.send("usernamecheck="+u);
            }
        }
        function signup(){
            var u = _("username").value;
            var e = _("email").value;
            var p1 = _("pass1").value;
            var p2 = _("pass2").value;
            var g = _("org").value;
            var status = _("status");
            if(u == "" || e == "" || p1 == "" || p2 == ""){
                status.innerHTML = "Fill out all of the form data";
            } else if(p1 != p2){
                status.innerHTML = "Your password fields do not match";
            } else {
                _("signupbtn").style.display = "none";
                status.innerHTML = 'please wait ...';
                var ajax = ajaxObj("POST", "signup.php");
                ajax.onreadystatechange = function() {
                    if(ajaxReturn(ajax) == true) {
                        if(ajax.responseText != "signup_success"){
                            status.innerHTML = ajax.responseText;
                            _("signupbtn").style.display = "block";
                        } else {
                            window.scrollTo(0,0);
                            _("signupform").innerHTML = "OK "+u+", check your email inbox and junk mail box at <u>"+e+"</u> in a moment to complete the sign up process by activating your account. You will not be able to do anything on the site until you successfully activate your account.";
                        }
                    }
                }
                ajax.send("u="+u+"&e="+e+"&p="+p1+"&g="+g);
            }
        }

    </script>
    
    <style type="text/css">
        
        * {
          margin: 0;
          padding: 0;
        }

        .content{
          width: 100vw;
          height: 100vh;
        }
        
        #form_text {
            color: black; 
            font-weight: bold; 
        }
        
        #error_handling {
            color:#FD3163;
            font-weight:bold;
        }
    </style>
</head>

<body style="background-image:url('imgs/signup_bg.jpg');">

<div style="height: 150px;"> </div> 
  <section class="intro" style="margin-left:150px">
    <row>
      <div class="col-lg-6 col-sm-12 right">
        <div class="form-group row"> 

            <form name="signupform" id="signupform" onsubmit="return false;" style="border:4px solid white; padding:30px; border-radius: 25px; width:400px; background-color:#e8e8e8; opacity: 0.85;">
                
                <h2 style="text-align:center; color:black; font-family: 'Khand', sans-serif;"> Repawsitory Registration!</h2>
                
                <br />
                <br />
                
                <span id="unamestatus"> </span>
                <input class="form-control form-control-sm" id="username" placeholder="Username" type="text" onblur="checkusername()" onkeyup="restrict('username')" maxlength="16">
                
                <br> 
                <input class="form-control form-control-sm" id="email" placeholder="Email Address" type="text" onfocus="emptyElement('status')" onkeyup="restrict('email')" maxlength="88">
                
                <br> 
                <input class="form-control form-control-sm" id="pass1" placeholder="Password..." type="password" onfocus="emptyElement('status')" maxlength="16">
                
                <br>    
                <input class="form-control form-control-sm" id="pass2" type="password" placeholder="Confirm Password" onfocus="emptyElement('status')" maxlength="16">
                <br />
                
     						<div class="cb">
     						  <lable for="org" id="form_text"> Are you representing an Organization? &nbsp; &nbsp; </lable>
     							<input type="checkbox" id="org" name="permission[]" value="a" onfocus="emptyElement('status')"/>
								</div> 
								
							  <script>
									$("#org").click(function() {

										if($("#org").val()=='a')
										{
										 $("#org").val('b');
										}
										else
										{
										 $("#org").val('a');
										}
									});
								</script>

                <br />
                <br />
                <span> 
                    <button class="btn btn-primary" id="signupbtn" onclick="signup()">Create Account</button>
                    <a class="btn btn-secondary" href="login.php" role="button">Login</a>
                </span>
                <br /> <br />
                <span id="status" style="font-weight:bold; color: #FD3163;"></span>

            </form>
        </div> <!-- Form-group -->
      </div> <!-- Center-left -->
      </div>
    </row>
  </section>
    
    <!-- JavaScript --> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js'></script>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        
    <script src='https://unpkg.com/@reactivex/rxjs/dist/global/Rx.min.js'></script>
    <script src='https://unpkg.com/rxcss@latest/dist/rxcss.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js'></script>
    
</body>
</html>
