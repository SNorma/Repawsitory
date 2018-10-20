<?php
    include("php_includes/check_login_status.php");
    
    // If user is already logged in, header that weenis away
    if($user_ok == true){
        $username = $_SESSION['username'];
    }
?>

<?php

if(isset($_POST["e"])){

	include_once("php_includes/db_conx.php");
	
  // GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
	$e = mysqli_real_escape_string($db_conx, $_POST['e']);
	$p = md5($_POST['p']);
	
    // GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	
    // FORM DATA ERROR HANDLING
	if($e == "" || $p == ""){
		header('location:login.php');
	} 
    
    else {
	// END FORM DATA ERROR HANDLING
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
    
    <title> Repawsitory </title>
    <link rel='stylesheet' href='style/fullpage.css'>
    <link rel="stylesheet" href="style/index_style.css">
    <link rel="stylesheet" href="style/scroll.css">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    
    <!-- Google Font | Give you Glory--> 
    <link href='https://fonts.googleapis.com/css?family=Give You Glory' rel='stylesheet'>
    
    <!-- Charts.js --> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
        
    <style>
        
        /* SECTION 1 */ 
        .flex-columns{
          display: flex;
          flex-direction: column;
          justify-content: center;
        }

        /* Pattern styles */
        .container {
            display: flex;
            height: auto;
        }

        .left-half {
          flex: 1;
          padding: 1rem;
          text-align: center;
          background-color: ;
        }

        .right-half {
          flex: 1;
          padding: 1rem;
          text-align: center; 
          background-color: ;
        }
        
        /* ===================================== */
        
        .container-fluid {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
        }

        .card {
            text-align:center; 
            border: 1px solid #000;
            width: 60%;
            padding-left: 20px;
            padding-right:20px;
            padding-top:20px; 
         }
        
        #foo {
            height:200px;
        }
        
        .footer {
           position: fixed;
           left: 0;
           bottom: 0;
           width: 100%;
           background-color: #4f4f4f;
           color: white;
           text-align: center;
        }
        
        /* Icons */
         ul {
            list-style: none;
        }

        ul li {
            margin:5px 20px;
            float:left;
        }

        .wp-icon {
          width: 50px;
          height: 50px;
          border-radius: 50%;
          text-align: center;
          line-height: 50px;
          vertical-align: middle;
          color: #fff;
          margin-right: 5px;
        }

        .fa-facebook-f {
          background: #3B5998;
        }

        .fa-linkedin {
          background: #0077B5;
        }

        .fa-twitter {
          background: #1DA1F2;
        }
        .fa-instagram {
          background: #d6249f;
          background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%,#d6249f 60%,#285AEB 90%);
          box-shadow: 0px 3px 10px rgba(0,0,0,.25);
        }
        .fa-google-plus {
          background: #D04338;
        }
        .fa-youtube {
          background: #FF0000;
        }

        .fa-pinterest {
          background: #BD081C;
        }
        
        
    </style>
    
    <script>
    $('.section-one').hover(function() {
  $('.container').toggleClass('one-is-active');
});

$('.section-two').hover(function() {
  $('.container').toggleClass('two-is-active');
});

$('.scroll').click(function() {
  $('html, body').animate({
        scrollTop: $(".container").offset().top
    }, 800);
});
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
    <a class="nav-link active" href="#">Home</a>
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
              <button class="btn btn-sm btn-outline-secondary" type="submit">Login</button>
            </form>'; 
        }
    ?>
  </div>
</nav>

<div id="fullpage">
    <section id="section0" class="vertical-scrolling section1" style="background-color:#f2f2f2f2;">
        <div id="foo" style="padding:20px;">
            <div class="display-4">Lost &amp; Found</div>
            <p class="lead">Repawsitory offers a fast and convenient way to post and search 
            for lost pets in your area. Everyone has access to reporting and searching for a lost pet. 
            Contact us if you believe you have found your missing pet and we will take the necessary steps to reunite you and your loved one!   </p>
        </div>
        <div class="container-fluid" style="content-align:center;">
            <div class="row">
                <div class="card-deck">

                
                    <?php 

                       include_once("php_includes/db_conx.php");

                        $sql = "SELECT * FROM lost_pets LIMIT 3";

                        $query = mysqli_query($db_conx, $sql); 

                        while ($row = mysqli_fetch_array($query)) {

                            echo '
                                <div class="card" style="float:none";>
                                    <div id="foo"> 
                                        <img src="petfinder/upload/' . $row['image'] . '" class="img-thumbnail center" width="250" height="400" />
                                    </div> 
                                    <div class="card-block">
                                        <h4 class="card-title">'. $row['breed']. '</h4>
                                        <p class="card-text"></p>
                                        
                                        <div style="text-align:left; margin-left:3px;"> 
                                            <small>Age: ' . $row['age'] . '</small>
                                        </div>

                                        <div style="text-align:left; margin-left:3px;">
                                            <small>Gender: ' . $row['gender']. '</small>
                                        </div>

                                        <div style="text-align:left; margin-left:3px;">
                                            <small>Size: ' . $row['size']. '</small>
                                        </div>
                                        
                                        <p class="card-footer"><small class="text-muted"> ' . $row['city'] . ' ' . $row['state'] . ',     ' . $row['zip'] . '</small></p>
                                    </div>
                                </div>
                            '; 
                        }
                    ?>
            </div>
        </div>
    </div>
    
    <br>
    <br>
    </section> <!-- Close section 0 --> 
    
    
    
    
    <section id="section1" class="vertical-scrolling section1 ">
        <div class="parallax"></div>
        <div class="c-text">
            <div class="display-4">Record Keeping</div>
            <p class="lead">Now you can connect your pets caretaker network around a central 
            information source. With Repawsitory you can now conveniently store your pets information
            in one place. Repawsitory makes it easy to manage multiple pets at one time by adding 
            a pets information to your Repawsitory account.  </p>
                
            <section class="container">
                <div class="left-half">
                    <article>
                        <canvas id="myChart" style="max-width: 500px;"></canvas>
                    </article>
                </div>
                <div class="right-half">
                    <article>
                        <canvas id="pieChart"></canvas>
                    </article>
                </div>
            </section>
        </div>
    </section> <!-- Close section 1 --> 
    
    
    <!--




    -->
    <section id="section2" class="vertical-scrolling section2">
        <div class="parallax1"></div>
        <div id="foo" style="padding:20px;">
            <div class="display-4">Adoption Services</div>
                <p class="lead">Ready to adopt a pet? Use our searchable database of animals to find 
                a pet who needs a home. There are so many loving pets near you waiting for a family to 
                call their own. Start searching for your new family member today with Repawsitory. </p>
            
            </div>
        <div class="container-fluid" style="content-align:center;">
            <div class="row">
                <div class="card-deck">

                
                    <?php 

                       include_once("php_includes/db_conx.php");

                        $sql = "SELECT * FROM (SELECT * FROM pet_adopt ORDER BY id DESC LIMIT 3) sub ORDER BY id ASC";

                        $query = mysqli_query($db_conx, $sql); 

                        while ($row = mysqli_fetch_array($query)) {

                            echo '
                                <div class="card" style="float:none";>
                                
                                <div class="card-header text-center"> ' .$row['name'] . '</div>
                                    <div id="foo"> 
                                        <img src="orgs/upload/' . $row['image'] . '" class="img-thumbnail center" width="250" height="250" />
                                    </div> 
                                    <div class="card-block">
                                        <h4 class="card-title">'. $row['breed']. '</h4>
                                        <p class="card-text"></p>
                                        
                                        <div style="text-align:left; margin-left:3px;"> 
                                            <small>Age: ' . $row['age'] . '</small>
                                        </div>

                                        <div style="text-align:left; margin-left:3px;">
                                            <small>Gender: ' . $row['gender']. '</small>
                                        </div>

                                        <div style="text-align:left; margin-left:3px;">
                                            <small>Size: ' . $row['size']. '</small>
                                        </div>
                                        
                                        <p class="card-footer"><small class="text-muted"> ' . $row['city'] . ' ' . $row['state'] . ',     ' . $row['zip'] . '</small></p>
                                    </div>
                                </div>
                                '; 
                            }
                        ?>
                </div>
            </div>
        </div>
    
        <br>
        <br>
    </section>
</div> <!-- End full-page parallex --> 

<!-- TRANSITION AND FOOTER --> 
<div class="section-transition">
    <div class="deck deck1 js-split">
        <div class="bg top">
            <h4 class="split-text">Support your local shelter!</h4>
        </div>
        
        <div class="bg bottom">
            <h1 class="split-text">Support your local shelter!</h1>
        </div>
    </div>
    
    <div class="deck deck2" style="background-image:url('imgs/cat_wallpaper.jpg'); box-shadow: 25px 25px 50px 0 white inset, -25px -25px 50px 0 white inset;height:40vh;"></div>; 
        <h1 class="dark centered"></h1>
            
    
    </div>
    <div class="deck" style="background-color:white; text-align:center;">
        <br>
        <br>
        <img src="imgs/screens.jpg">
        <div class="footer" style="position: absolute; height:40vh"> 
        <section class="container">
                <div class="left-half">
                    <article>
                        
                            <br>
                            <br>
                            <div style="margin-right:20px:">
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/DnX8hXvzFO8" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe></iframe>
                        
                            </div>
                                            <!-- INSERT UPDATED VIDEO HERE ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^--> 
                        
  
                    </article>
                </div>
                <div class="right-half">
                    <article>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        
                        <h5 style="color:black";>Find Us At</h5>
                        <br> 
                        <i class="fa wp-icon fa-facebook-f fa-lg"></i>
                        <i class="fa wp-icon fa-linkedin fa-lg"></i>
                        <i class="fa wp-icon fa-twitter fa-lg"></i>
                        <i class="fa wp-icon fa-instagram fa-lg"></i>
                        <i class="fa wp-icon fa-google-plus fa-lg"></i>
                        <i class="fa wp-icon fa-youtube fa-lg"></i>
                        <i class="fa wp-icon fa-pinterest fa-lg"></i>
                        
                    </article>
                </div>
            </section>
        </div>
    </div>


    
<!-- JavaScript --> 
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.6/jquery.fullpage.min.css'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.6/jquery.fullpage.min.js'></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.0/TweenMax.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.2/ScrollMagic.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.2/plugins/animation.gsap.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.2/plugins/debug.addIndicators.min.js'></script>
<script  src="js/scroll.js"></script>  
    
<!-- MDB --> 
<script src="js/MDB/js/mdb.js"></script>
    
<script>
var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Agility", "Outdoor", "Playtime", "Sleep", "Training"],
        datasets: [{
            
            data: [ 1.5 , 2,  6, 12, 1.5],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
    
    
    
//pie
var ctxP = document.getElementById("pieChart").getContext('2d');
var myPieChart = new Chart(ctxP, {
    type: 'pie',
    data: {
        labels: ["Vet", "Training", "Medication", "Toys", "Grooming"],
        datasets: [
            {
                data: [300, 50, 100, 40, 120],
                backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C", "#949FB1", "#4D5360"],
                hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870", "#A8B3C5", "#616774"]
            }
        ]
    },
    options: {
        responsive: true
    }
});
    
</script>
  

</body>

</html>
