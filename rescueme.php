<?php
    include("php_includes/check_login_status.php");

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
            background-color: #f2f7fc;
        }
        
        .top-container {
            background-image: url('../imgs/lap.jpg');
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
                    <a class="nav-link active" href="#" active>Adoptions</a>
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
                      <button class="btn btn-sm btn-outline-secondary" type="submit">Login </button>
                    </form>'; 
                }
            ?>
    
        </div> <!-- Close out site navigation bar -->  
    </nav> <!-- Close out navigation --> 
    
 
            
            <!-- Search Form / Nav -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">

        <form class="form-inline" method="post" action="rescue_results.php">
            
            <?php
                include('php_includes/db_conx.php');

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
            
            <div class="radio radio-info radio-inline">
                <input type="radio" id="Dog" value="1" onclick="setSelect('dogdd')"  name="type" checked="">
                <label for="Dog"> Dog </label>
            </div>
                <div class="radio radio-danger radio-inline">
                <input type="radio" id="Cat" value="2" onclick="setSelect('catdd')" name="type">
                <label for="Cat"> Cat</label>
            </div>
            
            &nbsp; &nbsp; &nbsp; 

            <select  class="custom-select my-1 mr-sm-2" name="breed" id="breed" style=""  > </select>

            <select class="custom-select my-1 mr-sm-2" id="gender" name="gender" required>
                <option value="">Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female </option>
            </select>     
            &nbsp; &nbsp; &nbsp;

            <select class="custom-select my-1 mr-sm-2" id="age" name="age" required>
                <option value="">Age</option>
                <option value="Young">Young</option>
                <option value="Teen">Teen</option>
                <option value="Adult">Adult</option>
                <option value="Senior">Senior</option>
            </select>      
            &nbsp; &nbsp; &nbsp;

            <select class="custom-select my-1 mr-sm-2" id="size" name="size">
                <option value="">Size</option>
                <option value="XSmall">Extra Small</option>
                <option value="Small">Small</option>
                <option value="Medium">Medium</option>
                <option value="Large">Large</option>
                <option value="XLarge">Extra Large</option>
            </select>      
            &nbsp; &nbsp; &nbsp;

            <input class="form-control" id="zipcode" name="zipcode" type="text" maxlength="5" placeholder="Zipcode">
            &nbsp; &nbsp; &nbsp;
            
            <select class="custom-select my-1 mr-sm-2" id="distance_from_zip" name="distance_from_zip">
                <option value="">Distance</option>
                <option value="1">1 Mile</option>
                <option value="5">5 Miles</option>
                <option value="10">10 Miles</option>
                <option value="25">25 Miles</option>
                <option value="50">50 Miles</option>
            </select>      
            &nbsp; &nbsp; &nbsp;
            
            <button type="submit" name="search" class="btn btn-outline-info float-right">Submit</button>
        </form>
    
    </nav>
 
    <div class="body-container rounded" style="background-color:##f2f7fc;">
        
        <h1 style="text-align:center;"> Available Pets</h1>
        
        <br> 
        
        <div class="container">
            <div class="row">

            <?php 
    
            $sql = "SELECT * FROM pet_adopt LIMIT 8";
            $query = mysqli_query($db_conx, $sql); 

            while($row = mysqli_fetch_array($query)) { 
            
                echo '
                <div class="col-sm-3" style="margin-top:15px;">
                    <div class="card shadow p-3 mb-5 bg-white rounded">

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
                                <small class="text-muted"> ' . $row['city'] . ' ' . $row['state'] . ', ' . $row['zip'] . '</small>
                            </div>
                    </div>
                </div>
          
                
                
                '; 
            }
        ?>
        </div> <!-- Close row --> 
    </div> <!-- Close container --> 
</div> <!-- Close body-container -->

    
<div class="modal fade text-center" id="theModal">
  <div class="modal-dialog">
    <div class="modal-content"> </div>
  </div>
</div>
    
<script>
        
        /* For dynamic drop down menu */ 
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
    
    

    
</script>
    
    
<!-- JavaScript --> 
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.6/jquery.fullpage.min.css'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.6/jquery.fullpage.min.js'></script>

</body>

</html>
