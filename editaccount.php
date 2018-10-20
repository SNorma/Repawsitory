<?php

    include_once("php_includes/check_login_status.php");

    // Make sure the _GET username is set, and sanitize it
    if(isset($_GET["u"])){
        $u = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);
    } else {
        header("location:../index.php");
        exit();	
    }

    // Select the member from the users table
    $sql = "SELECT * FROM users WHERE username='$u' AND activated='1' LIMIT 1";
    $user_query = mysqli_query($db_conx, $sql);

    $res = mysqli_fetch_array($user_query);
    $id = $res['id'];
    $e = $res['email'];
        
    // Now make sure that user exists in the table
    $numrows = mysqli_num_rows($user_query);
    if($numrows < 1){
        echo "That user does not exist or is not yet activated, press back";
        exit();	
    }
    // Check to see if the viewer is the account owner
    $isOwner = "no";

    if($u == $log_username && $user_ok == true){
        $isOwner = "yes";
    }

    if ($isOwner == "no") {
            header('location:../login.php'); 
    }
    
     $query = "SELECT * FROM pet_adopt WHERE uid='$id' ORDER BY id DESC";  
     $result = mysqli_query($db_conx, $query);  
?> 
<html>
    <head>
    
    <title><?php echo $u; ?>'s Account</title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        
    <!-- Google Font --> 
    <link href="https://fonts.googleapis.com/css?family=Crushed|Gruppo" rel="stylesheet">
    
        
    <script>

        $( '#topheader .navbar-nav a' ).on( 'click', function () {
            $( '#topheader .navbar-nav' ).find( 'li.active' ).removeClass( 'active' );
            $( this ).parent( 'li' ).addClass( 'active' );
        });

    </script>
        
        
    <style>
    
        body {
            margin:0;
            padding:0;
            background-color:#f1f1f1;
           }
       
        .box {   
            width:1270px;
            padding:20px;
            background-color:#fff;
            border:1px solid #ccc;
            border-radius:5px;
            margin-top:10px;
        }
        
        .top-container img {
            width: 100%;
            height: 35vh;
            margin-left: auto;
	        margin-right: auto;
	        display: block;
            
        }
        
        #topheader .navbar-nav li > a {
            text-transform: capitalize;
            color: #333;
            transition: background-color .2s, color .2s;

            &:hover,
            &:focus {
                background-color: #333;
                color: #fff;
            }
        }

        #topheader .navbar-nav li.active > a {
            background-color: #333;
            color: #fff;
        }
        
        #gruppo {
            font-family: 'Gruppo'; font-size: 60px; 
            }
        
        #gruppo-sm {
            font-family: 'Gruppo'; font-size: 20px; 
        }
        
        #pitty {
            -webkit-filter: brightness(120%);   
        }
        
        ul.nav a:hover { color: black !important; }
        .nav > li > a:hover{
            background-color:#FCC;
        }

    </style>
</head>
<body>

    <div class="top-container">
        <img src="../imgs/top_banner.jpg" max-width="$100%" max-height="%100" />
    </div>
    
    <br> 
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a id="gruppo-sm" class="navbar-brand" href="../index.php">REPAWSITORY</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class=""><a href="/orgs/dashboard.php?u=<?php echo $u; ?>">Records</a></li>
                    <li class="active"><a href="#">Edit Account</a></li>
                    <li class=""><a href="rescueme.php">Adoptions</a></li>
                    <li class=""><a href="logout.php">Log out</a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    
                    <p class="navbar-text">Signed in as <?php echo $u; ?></p>
                    
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    
    <br>
    <h1 id="gruppo" align="center"><?php echo $u . "'s Account Information"; ?></h1>
    

    <br>
    <br>
    
    <div class="container-fluid">
        
        <!-- ACCOUNT INFORMATION CARD --> 
        <div class="col-sm-6">
            <div class="thumbnail">
                <br>
                
                <div class="card-header" style="text-align:center;font-weight:bold;"> Account Information </div>
                <br>
                <br>
                <form method="POST">
                    <div class="card-body">
 
                        <?php
                            
                            if(isset($_POST['edit'])) {
                        
                                $fname = filter_var($_POST['fname'], FILTER_SANITIZE_STRING);
                                $lname = filter_var($_POST['lname'], FILTER_SANITIZE_STRING);
                                $address1 = filter_var($_POST['address1'], FILTER_SANITIZE_STRING);
                                $address2 = filter_var($_POST['address2'], FILTER_SANITIZE_STRING);
                                $city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
                                $state = filter_var($_POST['state'], FILTER_SANITIZE_STRING);
                                $zip = filter_var($_POST['zipcode'], FILTER_SANITIZE_NUMBER_INT); 
                                $phone = filter_var($_POST['phone'], FILTER_SANITIZE_NUMBER_INT);
                                $company = filter_var($_POST['company'], FILTER_SANITIZE_STRING);


                                $sql = "UPDATE usersmeta SET fname='$fname', lname='$lname', address1='$address1', address2='$address2', city='$city', state='$state', zipcode='$zip', phone='$phone', company='$company' WHERE uid=$id"; 

                                if (mysqli_query($db_conx, $sql)) {
                                        $mssg = "Records sucessfully updated!";
                                    } else {
                                        $mssg = "Error updating record: " . mysqli_error($db_conx);
                                    }       
                            }
            
                            $sql = "SELECT * FROM usersmeta WHERE uid='$id'"; 
                            $sql_query = mysqli_query($db_conx, $sql);

                            $r = mysqli_fetch_array($sql_query);
                            
                            /* Static */
                            $id = $r['id'];
                            $username = $r['username'];
                        
                        ?>
                        
                        <div class="form-group row">
                            <label for="fname" class="col-sm-2 col-form-label">First Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="fname" name="fname" placeholder="" value="<?php if(!empty($r['fname'])){ echo $r['fname']; } elseif(isset($fname)){ echo $fname; } ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lname" class="col-sm-2 col-form-label">Last Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="lname" name="lname" placeholder="" value="<?php if(!empty($r['lname'])){ echo $r['lname']; } elseif(isset($lname)){ echo $lname; } ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address1" class="col-sm-2 col-form-label">Address1</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="address1" name="address1" placeholder="" value="<?php if(!empty($r['address1'])){ echo $r['address1']; } elseif(isset($address1)){ echo $address1; } ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address2" class="col-sm-2 col-form-label">Address2</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="address2" name="address2" placeholder="" value="<?php if(!empty($r['address2'])){ echo $r['address2']; } elseif(isset($address2)){ echo $address2; } ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="city" class="col-sm-2 col-form-label">City</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="city" name="city" placeholder="" value="<?php if(!empty($r['city'])){ echo $r['city']; } elseif(isset($city)){ echo $city; } ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="state" class="col-sm-2 col-form-label">State</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="state" name="state" placeholder="" value="<?php if(!empty($r['state'])){ echo $r['state']; } elseif(isset($state)){ echo $state; } ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="zipcode" class="col-sm-2 col-form-label">Zipcode</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="" value="<?php if(!empty($r['zipcode'])){ echo $r['zipcode']; } elseif(isset($zipcode)){ echo $zipcode; } ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                            <div class="col-sm-10">
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="" value="<?php if(!empty($r['phone'])){ echo $r['phone']; } elseif(isset($phone)){ echo $phone; } ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="company" class="col-sm-2 col-form-label">Company</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="company" name="company" placeholder="" value="<?php if(!empty($r['company'])){ echo $r['company']; } elseif(isset($company)){ echo $company; } ?>">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <td><button type="submit" id="edit" name="edit" class="btn btn-info"> Update </button></td>
                        <?php echo '<div style="color:red;">' . $mssg . '</div>'; ?>
                    </div>
                </form>
            </div>
        </div>
        
        <script>
            $("input[type='tel']").each(function(){
				$(this).on("change keyup paste", function (e) {
			    		var output,
			      		$this = $(this),
			      		input = $this.val();

			    		if(e.keyCode != 8) {
			      			input = input.replace(/[^0-9]/g, ''); 	
			      			var area = input.substr(0, 3);
			      			var pre = input.substr(3, 3);
			      			var tel = input.substr(6, 4);
			      		
						if (area.length < 3) {
							output = "(" + area;
			      			} 
						else if (area.length == 3 && pre.length < 3) {
							output = "(" + area + ")" + " " + pre;
			     	 		} 
						else if (area.length == 3 && pre.length == 3) {
							output = "(" + area + ")" + " " + pre + "-" + tel;
			      			}
			      			
						$this.val(output);
			    		}
			  	});
			});
            
                $(function() {
                    // IMPORTANT: Fill in your client key
                    var clientKey = "rHbf3vK3QcHE6rTMlH1JQvefQViQBVrwxeaqFmG2kIDig5rypdVYlxRPuZnGwCeN";

                    var cache = {};
                    var container = $("#example1");
                    var errorDiv = container.find("div.text-error");

                    /** Handle successful response */
                    function handleResp(data)
                    {
                        // Check for error
                        if (data.error_msg)
                            errorDiv.text(data.error_msg);
                        else if ("city" in data)
                        {
                            // Set city and state
                            container.find("input[name='city']").val(data.city);
                            container.find("input[name='state']").val(data.state);
                        }
                    }

                    // Set up event handlers
                    container.find("input[name='zipcode']").on("keyup change", function() {
                        // Get zip code
                        var zipcode = $(this).val().substring(0, 5);
                        if (zipcode.length == 5 && /^[0-9]+$/.test(zipcode))
                        {
                            // Clear error
                            errorDiv.empty();

                            // Check cache
                            if (zipcode in cache)
                            {
                                handleResp(cache[zipcode]);
                            }
                            else
                            {
                                // Build url
                                var url = "https://www.zipcodeapi.com/rest/"+clientKey+"/info.json/" + zipcode + "/radians";

                                // Make AJAX request
                                $.ajax({
                                    "url": url,
                                    "dataType": "json"
                                }).done(function(data) {
                                    handleResp(data);

                                    // Store in cache
                                    cache[zipcode] = data;
                                }).fail(function(data) {
                                    if (data.responseText && (json = $.parseJSON(data.responseText)))
                                    {
                                        // Store in cache
                                        cache[zipcode] = json;

                                        // Check for error
                                        if (json.error_msg)
                                            errorDiv.text(json.error_msg);
                                    }
                                    else
                                        errorDiv.text('Request failed.');
                                });
                            }
                        }
                    }).trigger("change");
                });
        </script>
        
        
        
        <!-- CHANGE PASSWORD CARD ---------------------------------------------------------------------------------> 
        <div class="col-sm-6">
            <div class="thumbnail">
                <br>
                <div class="card-header" style="text-align:center;font-weight:bold;"> Change Password? </div>
                <br>
                <br>
                    <!-- Change password functionality --> 
                    <?php
                        $msg = '';

                        if(isset($_POST['change'])) {

                           $oldpw = $_POST['oldpass'];
                           $curpw = $res['password'];

                           $hash_pass = md5($oldpw);

                           $newpass = $_POST['newpass'];
                           $confpass = $_POST['confpass'];

                           if (md5($oldpw) == $curpw) {

                               if ($newpass == $confpass) {

                                   $updatepw = hash(md5,$newpass); 

                                   $sql = "UPDATE users SET password='$updatepw' WHERE username='$u'"; 

                                   if (mysqli_query($db_conx, $sql)) {
                                        $msg = "Password updated successfully! Please log back in.";
                                    } else {
                                        $msg = "Error updating record: " . mysqli_error($db_conx);
                                    }   
                                }
                               
                                else {
                                    
                                    $msg = "Passwords do not match...";
                                }
                            }
                            
                            else {
                                
                                $msg = "Wrong password.";
                            }
                        } 
                    ?>
                    <form method="POST">
                        <div class="card-body">
                            <div class="form-group row">

                                <label for="old" class="col-sm-3 col-form-label"> Current Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="oldpass" placeholder="">
                                </div>
                                <label for="newpass" class="col-sm-3 col-form-label"> New Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="newpass" placeholder="">
                                </div>
                                <label for="confpass" class="col-sm-3 col-form-label"> Confirm Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="confpass" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <span>
                                <button type="submit" name="change" class="btn btn-info"> Change </button>
                                <?php echo '<div style="color:red;">' . $msg . '</div>'; ?>
                            </span>
                        </div>
                    </form>
                </div> <!-- End .card --> 
            </div>
        </div> <!-- End .container-fluid --> 
    </body>
</html>