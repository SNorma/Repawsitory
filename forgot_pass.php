<?php

    include_once("php_includes/check_login_status.php");

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
?>

<?php

if(isset($_POST["e"])){
	
    $e = mysqli_real_escape_string($db_conx, $_POST['e']);
	$sql = "SELECT id, username FROM users WHERE email='$e' AND activated='1' LIMIT 1";
	$query = mysqli_query($db_conx, $sql);
	$numrows = mysqli_num_rows($query);
	
    if($numrows > 0){
		while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
			$id = $row["id"];
			$u = $row["username"];
		}
        
		$emailcut = substr($e, 0, 4);
		$randNum = rand(10000,99999);
		$tempPass = "$emailcut$randNum";
		$hashTempPass = md5($tempPass);
		
        $sql = "UPDATE useroptions SET temp_pass='$hashTempPass' WHERE username='$u' LIMIT 1";
	    $query = mysqli_query($db_conx, $sql);
		
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
            $mail->Subject = 'Repawistory Password Recovery';
            $mail->Body    = '<h2>Hello '.$u.'</h2><p>This is an automated message from Repawsitory. If you did not recently initiate the "Forgot Your Password" process, please disregard this email.</p><p>You indicated that you forgot your login password. We can generate a temporary password for you to log in with, then once logged in you can change your password to anything you like.</p><p>After you click the link below, your password to login will be:<br /><b>'.$tempPass.'</b></p><p><a href="www.repaw.io/forgot_pass.php?u='.$u.'&p='.$hashTempPass.'">Click here now to apply the temporary password shown below to your account</a></p><p>If you do not click the link in this email, no changes will be made to your account. In order to set your login password to the temporary password you must click the link above.</p>';
            $mail->AltBody = 'Alt.';

            $mail->send();
            echo 'A message has been sent to ' . $e . '! <br> Please check your email shortly...';
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
		exit();
    }
}
?>

<?php

    // EMAIL LINK CLICK CALLS THIS CODE TO EXECUTE
    if(isset($_GET['u']) && isset($_GET['p'])){
        $u = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);
        $temppasshash = preg_replace('#[^a-z0-9]#i', '', $_GET['p']);
        if(strlen($temppasshash) < 10){
            exit();
        }
        $sql = "SELECT id FROM useroptions WHERE username='$u' AND temp_pass='$temppasshash' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        $numrows = mysqli_num_rows($query);
        
        if($numrows == 0){
            header("location: message.php?msg=There is no match for that username with that temporary password in the system. We cannot proceed.");
            exit();
        } else {
            $row = mysqli_fetch_row($query);
            $id = $row[0];
            $sql = "UPDATE users SET password='$temppasshash' WHERE id='$id' AND username='$u' LIMIT 1";
            $query = mysqli_query($db_conx, $sql);
            $sql = "UPDATE useroptions SET temp_pass='' WHERE username='$u' LIMIT 1";
            $query = mysqli_query($db_conx, $sql);
            header("location: login.php");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    
    <title> Repaw | Rescue </title>
    <link rel='stylesheet' href='style/fullpage.css'>
    <link rel="stylesheet" href="style/adopt_style.css">
    
    <!-- Font Awesome --> 
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
   
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    
    <!-- Google Font | Give you Glory--> 
    <link href='https://fonts.googleapis.com/css?family=Give You Glory' rel='stylesheet'>

    <script src="js/main.js"></script>
    <script src="js/ajax.js"></script>
    
    <style>
        .top-container {
        background-image: url('imgs/havanese_silk_dog-1280x720.jpg');
        background-color: black;
        min-height: 600px;
        background-attachment: fixed;
        background-position: top;
        background-repeat: no-repeat;
        background-size: cover;
        z-index: 0; 
        margin-left: auto;
	    margin-right: auto;
	    display: block;
        width: 100%;
    }
    </style>
    
    <script>
        function forgotpass(){
            var e = _("email").value;
            if(e == ""){
                _("status").innerHTML = "Type in your email address";
            } else {
                _("forgotpassbtn").style.display = "none";
                _("status").innerHTML = 'please wait ...';
                var ajax = ajaxObj("POST", "forgot_pass.php");
                ajax.onreadystatechange = function() {
                    if(ajaxReturn(ajax) == true) {
                        var response = ajax.responseText;
                        if(response == "success"){
                            _("forgotpassform").innerHTML = '<h3>Please check your email shortly!</h3>';
                        } else if (response == "no_exist"){
                            _("status").innerHTML = "Please check your email shortly!";
                        } else if(response == "email_send_failed"){
                            _("status").innerHTML = "Please check your email shortly!";
                        } else {
                            _("status").innerHTML = "Please check your email shortly!";
                        }
                    }
                }
                ajax.send("e="+e);
            }
        }
    </script>
</head>
    
<body>
 

<div class="top-container"> </div>
    
    
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
  
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="nav nav-tabs mr-auto">
  <li class="nav-item">
    <a class="nav-link" href="index.php">Home</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="petfinder/index.php">Lost &amp; Found</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="rescueme.php">Adoptions</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="signup.php">Sign Up</a>
  </li>
  

</ul>

  </div>
</nav>
    
    <div class="space" style="height:10vh";></div>
    <div class="container">
        <div class="card">
            <div class="card-header"> Generate a temporary log-in password.</div>
            <div class="card-body">
                <form id="forgotpassform" onsubmit="return false;">
                    <input id="email" type="text" onfocus="_('status').innerHTML='';" maxlength="88" placeholder="Email Address">
                    <br /><br />
                    <button class="btn btn-primary" id="forgotpassbtn" onclick="forgotpass()">Submit</button> 
                </form>
            </div>
            <div class="card-footer text-muted">  <p id="status"></p></div>
</div>
      
  
 </div>
</body>
</html>
