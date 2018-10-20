<?php
    include("../php_includes/check_login_status.php");
    include('../php_includes/simple_html_dom.php');

    if($user_ok == true){
        $username = $_SESSION['username'];
    }
?>

<?php

/* Logging in */
if(isset($_POST["e"])){

	include_once("../php_includes/db_conx.php");
	
	$e = mysqli_real_escape_string($db_conx, $_POST['e']);
	$p = md5($_POST['p']);
	
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	
	if($e == "" || $p == ""){
		header('location:../login.php');
	} 
    
    else {
		$sql = "SELECT id, username, password FROM users WHERE email='$e' AND activated='1' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        $row = mysqli_fetch_row($query);
		
        $db_id = $row[0];
		$db_username = $row[1];
        $db_pass_str = $row[2];
	
        if($p != $db_pass_str){
			header('location:../login.php');
		} 
        
        else {
			// CREATE THEIR SESSIONS AND COOKIES
			$_SESSION['userid'] = $db_id;
			$_SESSION['username'] = $db_username;
			$_SESSION['password'] = $db_pass_str;
			setcookie("id", $db_id, strtotime( '+30 days' ), "/", "", "", TRUE);
			setcookie("user", $db_username, strtotime( '+30 days' ), "/", "", "", TRUE);
    		setcookie("pass", $db_pass_str, strtotime( '+30 days' ), "/", "", "", TRUE); 
		
            // UPDATE THEIR "IP" AND "LASTLOGIN" FIELDS
			$sql = "UPDATE users SET ip='$ip', lastlogin=now() WHERE username='$db_username' LIMIT 1";
            $query = mysqli_query($db_conx, $sql);
			echo $db_username;
		  
            header('location:../users.php?u=' . $db_username);
		}
	}
	exit();
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    
    <title> Repaw | Rescue </title>
    <link rel="stylesheet" href="style/adopt_style.css">
    
    <!-- Font Awesome --> 
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
   
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    
    <style>
        
        body {
            background-image:url('../imgs/pattern.jpg');
        }
        
       .top-container {
            background-image: url('../imgs/bannerex.png');
            background-color:black;
            min-height: 600px;
            background-attachment: fixed;
            background-position: top;
            background-repeat: no-repeat;
            background-size: 1800px 600px; 
            
            z-index: 0; 
            margin-left: auto;
	        margin-right: auto;
	        display: block;
            width: auto;
        }
        
               body {
            background-color: #f2f7fc;
        }

        .btn.active, .btn:active {
            opacity: 1.1;
            background-color: #f5f5f5;
            color: #000000;
            font-weight: bold;
        }

        .radio {
          padding-left: 20px;
        }

        .radio label {
          display: inline-block;
          vertical-align: middle;
          position: relative;
          padding-left: 5px;
        }

        .radio label::before {
          content: "";
          display: inline-block;
          position: absolute;
          width: 17px;
          height: 17px;
          left: 0;
          margin-left: -20px;
          border: 1px solid #cccccc;
          border-radius: 50%;
          background-color: #fff;
          -webkit-transition: border 0.15s ease-in-out;
          -o-transition: border 0.15s ease-in-out;
          transition: border 0.15s ease-in-out;
        }

        .radio label::after {
          display: inline-block;
          position: absolute;
          content: " ";
          width: 11px;
          height: 11px;
          left: 3px;
          top: 3px;
          margin-left: -20px;
          border-radius: 50%;
          background-color: #555555;
          -webkit-transform: scale(0, 0);
          -ms-transform: scale(0, 0);
          -o-transform: scale(0, 0);
          transform: scale(0, 0);
          -webkit-transition: -webkit-transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
          -moz-transition: -moz-transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
          -o-transition: -o-transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
          transition: transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
        }

        .radio input[type="radio"] {
          opacity: 0;
          z-index: 1;
        }

        .radio input[type="radio"]:focus + label::before {
          outline: thin dotted;
          outline: 5px auto -webkit-focus-ring-color;
          outline-offset: -2px;
        }

        .radio input[type="radio"]:checked + label::after {
          -webkit-transform: scale(1, 1);
          -ms-transform: scale(1, 1);
          -o-transform: scale(1, 1);
          transform: scale(1, 1);
        }

        .radio input[type="radio"]:disabled + label {
          opacity: 0.65;
        }

        .radio input[type="radio"]:disabled + label::before {
          cursor: not-allowed;
        }

        .radio.radio-inline {
          margin-top: 0;
        }

        .radio-danger input[type="radio"] + label::after {
          background-color: #d9534f;
        }

        .radio-danger input[type="radio"]:checked + label::before {
          border-color: #d9534f;
        }

        .radio-danger input[type="radio"]:checked + label::after {
          background-color: #d9534f;
        }

        .radio-info input[type="radio"] + label::after {
          background-color: #5bc0de;
        }

        .radio-info input[type="radio"]:checked + label::before {
          border-color: #5bc0de;
        }

        .radio-info input[type="radio"]:checked + label::after {
          background-color: #5bc0de;
        }
        
        form label {
            
            font-weight: bold; 
        }
    
    </style>
    
    <script>

        $(document).ready(function() {
          $('#modal').on('show.bs.modal', function(e) {
            var id = $(e.relatedTarget).data('id');
            alert(id);
          });
        });

    </script>
</head>
    
<body >
    
    <div class="top-container">
    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
        
        <!-- Site navigation button toggles --> 
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            
            <ul class="nav nav-tabs mr-auto">
                <li class="nav-item">
                    <a class="nav-link " href="../index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#" active>Lost &amp; Found</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../rescueme.php">Adoptions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../signup.php">SignUp</a>
                </li>
            </ul>
            
            <!-- Display Username or Login information --> 
            <?php
                if($user_ok == true){ 
                    echo 'Welcome: ' . $username . '&nbsp; &nbsp;';
                    echo '<a class="btn btn-sm btn-outline-secondary" href="../users.php?u=' . $_SESSION["username"] . '" role="button">Profile</a> &nbsp;  <a class="btn btn-sm btn-outline-secondary" href="../logout.php"> Logout </a>';
                }
                else {
                    echo '
                    <form class="form-inline my-2 my-lg-0" method="post">
                      <input class="form-control mr-sm-2" type="text" placeholder="Email" id="e" name="e">
                      <input class="form-control mr-sm-2" type="password" placeholder="Password" id="p" name="p">
                      <button class="btn btn-sm btn-outline-secondary" type="submit">Submit </button>
                    </form>'; 
                }
            ?>
    
        </div> <!-- Close out site navigation bar -->  
    </nav> <!-- Close out navigation --> 
    
    <!-- Block Div --> 
    <div class="nav-space"> </div>
    
    <br> 
    <br> 
    <br> 
    <div class="body-container" style="padding: 20px;">
        
    <form class="lostfound" name="lostfound" id="lostfound" method="POST" style="border:4px solid black; border-radius: 25px; background-color:#8e8d8d; opacity: 0.95; margin: 10px;" enctype="multipart/form-data">
    
    <br> 
    <br> 
    <h1 class="text-center" style="font-family: 'Khand', sans-serif;"> SEARCH | POST</h1>
        
        <br>
        <br> 
     
        <div class="panel-body">
            
            <?php
                include('../php_includes/db_conx.php');

                /* DOG QUERY */

                $sql = "SELECT breed FROM dog_breeds";

                $query = mysqli_query($db_conx, $sql); 

                $column = array();

                while($row = mysqli_fetch_array($query)) {
                    $column[] = $row['breed']; 
                }

                /* CAT QUERY */

                $sql1 = "SELECT breed FROM cat_breeds"; 

                $query1 = mysqli_query($db_conx, $sql1);

                $column1 = array(); 

                while($row1 = mysqli_fetch_array($query1)) {
                    $column2[] = $row1['breed'];

                    $cname = $row1['breed'];
                }

            ?>
            
        <div style="padding:20px">
            <div class="radio radio-info radio-inline">
                <input type="radio" id="Dog" value="1" onclick="setSelect('dogdd')"  name="type" checked="">
                <label for="Dog"> Dog </label>
            </div>
            
            <div class="radio radio-danger radio-inline">
                <input type="radio" id="Cat" value="2" onclick="setSelect('catdd')" name="type">
                <label for="Cat"> Cat</label>
            </div>
            
                <br> 
                <br>
                
            <lable style="font-weight:bold;"> Location:  </lable>
            <div class="row" style="">
                
                <div class="col-md-4 col-sm-4">
                    <div class="input-group" >
                        <input class="form-control" id="city" name="city" type="text" placeholder="City">
                    </div>
                </div>
            
                <div class="col-md-4 col-sm-4">
                    <div class="input-group">
                        <input class="form-control" id="state" name="state" type="text" placeholder="State">
                    </div>
                </div>
                
                <div class="col-md-4 col-sm-4">
                    <div class="input-group">
                        <input class="form-control" id="zipcode" name="zipcode" type="text" maxlength="5" placeholder="Zipcode">
                    </div>
                </div>
            
            </div>
            
                
                <br> 
                <br>
                
            <lable style="font-weight:bold;"> Information:  </lable>
            <div class="row" style="">
                
                <div class="col-md-6 col-sm-6">
                    <div class="input-group" >
                        <select  class="custom-select my-1 mr-sm-2" name="breed" id="breed" style=""  > </select>
                    </div>
                </div>
            
                <div class="col-md-3 col-sm-3">
                    <div class="input-group">
                        <select class="custom-select my-1 mr-sm-2" id="gender" name="gender" >
                            <option value="">Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female </option>
                        </select> 
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-3">
                    <div class="input-group">
                        <select class="custom-select my-1 mr-sm-2" id="age" name="age" >
                            <option value="">Age</option>
                            <option value="Young">Young</option>
                            <option value="Teen">Teen</option>
                            <option value="Adult">Adult</option>
                            <option value="Senior">Senior</option>
                        </select>
                    </div>
                </div>
            
            </div>
                
            <br> 
                
            
            <div class="row" style="">
                
                <div class="col-md-4 col-sm-4">
                    <div class="input-group" >
                         <select name="size" id="size" class="form-control" >  
                            <option value="">Size</option>  
                            <option value="XSmall">Extra Small</option>  
                            <option value="Small">Small</option>
                            <option value="Medium">Medium</option>
                            <option value="Large">Large</option>
                            <option value="XLarge">Extra Large</option>
                        </select> 
                    </div>
                </div>
            
                <div class="col-md-4 col-sm-4">
                    <div class="input-group">
                        <select name="hair" id="hair" class="form-control" >  
                            <option value="">Hair</option>  
                            <option value="Short">Short</option>  
                            <option value="Medium">Medium</option>  
                            <option value="Long">Long</option>  
                        </select>  
                    </div>
                </div>
                
                <div class="col-md-4 col-sm-4">
                    <select name="color" id="color" class="form-control" >  
                        <option value="">Color</option>  
                        <option value="White">White</option>  
                        <option value="Black">Black</option>
                        <option value="Gray">Gray</option>
                        <option value="Brown">Brown</option>
                        <option value="Yellow">Yellow / Orange</option>
                    </select> 
                </div>
            
            </div>
                
            <br> 
            
            <div class="form-group">
                <label for="comment">Comment:</label>
                <textarea class="form-control" rows="5" id="description" name="description"></textarea>
            </div>
                
            <br>
                
            <label>Have a Pic?</label><br>
            <input type='file' name='file' /> 
            <br />
            
            <div style="text-align:center;">
                <button type="submit" name="lost" class="btn btn-success" style="margin:20px;" onclick="submitForm('lost.php')">Search</button>
                <button type="submit" name="found" class="btn btn-danger" style="margin:20px; " onclick="submitForm('thankyou.php')">Post</button>
            </div>
            <br> 
                
        </div>
    </div>
</form>
</div>
<br> 
<br> 
<br> 
        
    
    
    <script>
    
        var dogs = [<?php echo '"'.implode('","', $column).'"' ?>];
        var cats = [<?php echo '"'.implode('","', $column2).'"' ?>];

        function setSelect(v) {
            var x = document.getElementById("breed");
            for (i = 0; i < x.length; ) { 
                x.remove(x.length -1);
            }

            var a;

            if (v=='dogdd'){
                a = dogs;
            } 

            else if (v=='catdd'){
                a = cats
            }

            for (i = 0; i < a.length; ++i) {
                var option = document.createElement("option");
                option.text = a[i];
                x.add(option);
            }
        }

        function load() {
            setSelect('dogdd');
        }

        window.onload = load; 
        
        /* For multi button form */
        function submitForm(action) {
            var form = document.getElementById('lostfound');
            form.action = action;
            form.submit();
        }
        
</script>
    </body>
</html>
    
    
    
