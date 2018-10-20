<?php
    include("php_includes/check_login_status.php");
    include('php_includes/simple_html_dom.php');

    if($user_ok == true){
        $username = $_SESSION['username'];
    }
?>

<?php

/* Logging in */
if(isset($_POST["e"])){

	include_once("php_includes/db_conx.php");
	
	$e = mysqli_real_escape_string($db_conx, $_POST['e']);
	$p = md5($_POST['p']);
	
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	
	if($e == "" || $p == ""){
		header('location:login.php');
	} 
    
    else {
		$sql = "SELECT id, username, password FROM users WHERE email='$e' AND activated='1' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        $row = mysqli_fetch_row($query);
		
        $db_id = $row[0];
		$db_username = $row[1];
        $db_pass_str = $row[2];
	
        if($p != $db_pass_str){
			header('location:login.php');
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
		  
            header('location:users.php?u=' . $db_username);
		}
	}
	exit();
}


?>

<html>

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
            background-color: white;
        }
        
        .top-container {
            background-image: url('../imgs/banner_2.jpg');
            background-color:black;
            min-height: 600px;
            background-attachment: fixed;
            background-position: top;
            background-repeat: no-repeat;
            background-size: cover;
            z-index: 0; 
            margin-left: auto;
	        margin-right: auto;
	        display: block;
            width: auto;
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
    
<body>
    
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
                    <a class="nav-link " href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="petfinder/index.php">Lost &amp; Found</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="rescueme.php">Adoptions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="signup.php">SignUp</a>
                </li>
            </ul>
            
            <!-- Display Username or Login information --> 
            <?php
                if($user_ok == true){ 
                    echo 'Welcome: ' . $username . '&nbsp; &nbsp;';
                    echo '<a class="btn btn-sm btn-outline-secondary" href="users.php?u=' . $_SESSION["username"] . '" role="button">Profile</a> &nbsp;  <a class="btn btn-sm btn-outline-secondary" href="logout.php"> Logout </a>';
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
    
        <div class="body-container rounded">
            
        <?php
                    
            if(isset($_POST['search'])) {

                $type=$_POST['type'];
                $gender=$_POST['gender'];
                $age=$_POST['age'];
                $size=$_POST['size'];
                $user_zip=$_POST['zipcode'];
                $dfz=$_POST['distance_from_zip']; 
        
                echo '<h2 style="text-align:center;"> Pets found within ' . $dfz . ' miles of ' . $user_zip . '</h2>';
        
                echo '<br><br>  
            
                <div class="container">
                <div class="row">'; 
                    
                    
                // ZIPCODES GENERATOR ===========================
                    
                // URL
                $url = 'https://www.searchbug.com/tools/zip-radius.aspx?TYPE=zipradius&ZIP='.$user_zip.'&DIST='.$dfz.'&submit=Search';

                // Create DOM (document object model) from url 
                $html = file_get_html($url);

                // Array to hold parsed data
                $links = array();

                // Parse HTML and put all elements 'a' into array $links
                foreach($html->find('a') as $a) {
                    $links[] = $a->href; 
                }

                // Remove all elements that do not contain the searchword
                $searchword = 'zip2city';
                $zipstrings = array(); 
                foreach($links as $k=>$v) {
                    if(preg_match("/\b$searchword\b/i", $v)) {
                        $zipstrings[$k] = $v;
                    }
                }

                // Chop the unwanted string, leaving only the zip
                foreach ($zipstrings as &$str) {
                    $str = str_replace('/tools/zip-code-lookup.aspx?TYPE=zip2city&ZIP=', '', $str);
                }

                // Convert strings to ints
                $zips = array_map('intval', $zipstrings);
                    
                    
                // SQL: =======================================
                    
                    
                $sql = "SELECT * FROM pet_adopt WHERE zip IN(".implode(',',$zips).") AND type='$type' AND gender='$gender' AND age='$age' AND size='$size'"; 
                    
                $query = mysqli_query($db_conx, $sql);

                $numrows = mysqli_num_rows($query);

            }

            if(!$numrows == 0) {   

                    $pet_array = array(); 
                    
                    while($row = mysqli_fetch_array($query)) {
                        
                    $pet_array = $row;

                    echo '
                    <div class="col-sm-3" style="margin-top:15px;">
                        <div class="card">

                        <div class="card-header text-center"> ' .$row['name'] . '</div>
                            <br>
                            
                            <div style="text-align:center; margin-left:3px;"> 
                                <img src="orgs/upload/' . $row['image'] . '" class="img-thumbnail center" width="150" height="150" />
                            </div> 
                            <br>
                            <br>

                            <div style="text-align:left; margin-left:3px;"> 
                                <small>Age: ' . $row['age'] . '</small>
                            </div>

                            <div style="text-align:left; margin-left:3px;">
                                <small>Gender: ' . $row['gender'] . '</small>
                            </div>

                            <div style="text-align:left; margin-left:3px;">
                                <small>Size: ' . $row['size'] . '</small>
                            </div>
                            
                            <div style="text-align:center; margin-left:3px;">
                                 <a href="fetch_record.php?pet=' . $row['id'] . '" data-target="#theModal" data-toggle="modal" data-backdrop="static" data-keyboard="false"><small>More Info</small></a>
                            </div>
                            <div class="card-footer text-center">
                                <small class="text-muted"> ' . $row['city'] . ' ' . $row['state'] . ',     ' . $row['zip'] . '</small>
                            </div>
                    </div>
                </div>
                
                '; 
                    }
                } 

                else {
                    
                    $msg = "Sorry no results found";
                }

            ?>
            
            </div> <!-- Close row --> 
        </div> <!-- Close card-columns -->
    </div> <!-- Close body-container --> 


    <!-- MODAL (CONTENT PULLED FROM FETCH_RECORD.PHP) -->
    <div class="modal fade text-center" id="theModal">
        <div class="modal-dialog">
            <div class="modal-content"> </div>
        </div>
    </div>
    
    
    <!-- JavaScript --> 
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.6/jquery.fullpage.min.css'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.6/jquery.fullpage.min.js'></script>

    </body>
</html>

<!--

            // HTML Parser Library
            include('php_includes/simple_html_dom.php');

            // URL
            $url = '';

            // Create DOM (document object model) from url 
            $html = file_get_html($url);

            // Array to hold parsed data
            $links = array();

            // Parse HTML and put all elements 'a' into array $links
            foreach($html->find('a') as $a) {
             $links[] = $a->href; 
            }

            // Remove all elements that do not contain the searchword
            $searchword = 'zip2city';
            $zipstrings = array(); 
            foreach($links as $k=>$v) {
                if(preg_match("/\b$searchword\b/i", $v)) {
                    $zipstrings[$k] = $v;
                }
            }

            // Chop the unwanted string, leaving only the zip
            foreach ($zipstrings as &$str) {
                $str = str_replace('/tools/zip-code-lookup.aspx?TYPE=zip2city&ZIP=', '', $str);
            }

            // Convert strings to ints
            $zips = array_map('intval', $zipstrings);

-->