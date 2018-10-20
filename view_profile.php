<?php
    
    include_once("php_includes/check_login_status.php");

    include 'crud.php';
    $object = new Crud();



    $u = "";
    $userlevel = "";
    $joindate = "";
    $lastsession = "";

    if(isset($_GET["u"])){
        $u = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);
    } else {
        header("location:index.php");
        exit();	
    }

    $sql = "SELECT * FROM users WHERE username='$u' AND activated='1' LIMIT 1";
    $user_query = mysqli_query($db_conx, $sql);

    $numrows = mysqli_num_rows($user_query);
    if($numrows < 1){
        echo "That user does not exist or is not yet activated, press back";
        exit();	
    }

    $isOwner = "no";

    if($u == $log_username && $user_ok == true){
        $isOwner = "yes";
    }

    if ($isOwner == "no") {
            header('location:login.php'); 
    }

    while ($row = mysqli_fetch_array($user_query, MYSQLI_ASSOC)) {
        
        $profile_id = $row["id"];
        $userlevel = $row["userlevel"];
        $signup = $row["signup"];
        $lastlogin = $row["lastlogin"];
        $joindate = strftime("%b %d, %Y", strtotime($signup));
        $lastsession = strftime("%b %d, %Y", strtotime($lastlogin));
    }

    if ($userlevel == 'b') {
        header("location: orgs/dashboard.php?u=".$_SESSION["username"]);
    }

     $query = "SELECT * FROM users_pets WHERE uid='$id' ORDER BY id DESC";  
     $result = mysqli_query($db_conx, $query);  


?>
<html>
    <head>
    <title><?php echo $u; ?>'s Dashboard</title>
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
        <img src="imgs/dogs.png" max-width="$100%" max-height="%100" />
    </div>
    
    <br> 
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a id="gruppo-sm" class="navbar-brand" href="../index.php">REPAWSITORY</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Records</a></li>
                    <li class=""><a href="../editaccount.php?u=<?php echo $u; ?>">Edit Account</a></li>
                    <li class=""><a href="../rescueme.php">Adoptions</a></li>
                    <li class=""><a href="../logout.php">Log out</a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <p class="navbar-text">Signed in as <?php echo $u; ?></p>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>



    <h1 id="gruppo" align="center"><?php echo $u . "'s Pets"; ?></h1>
    
    <div class="container box" style="margins:20px;">
        <div class="col-md-8">
            <button type="button" name="add" id="add" class="btn btn-info" data-toggle="collapse" data-target="#user_collapse">Add your Pet!</button>
        </div>

        
        <br />
        <br />
        <br />
        <br />
        
        <div id="user_collapse" class="collapse">
    
            <!--=== FORM START ===--> 
            <form method="post" id="user_form">
                
                <h3 style="margin-left:15px;"> Basic Information: </h3>
                
                <div class="radio radio-info radio-inline" style="margin-left:15px;">
                    <input type="radio" id="Dog" value="1" onclick="setSelect('dogdd')"  name="type" checked="">
                    <label for="Dog"> Dog </label>
                </div>
                    <div class="radio radio-danger radio-inline">
                    <input type="radio" id="Cat" value="2" onclick="setSelect('catdd')" name="type">
                    <label for="Cat"> Cat</label>
                </div>

                <br> 
                <br> 
                
                <!-- ======= ROW 1 ======== - >
                
                <!-- NAME --> 
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="text" name="name" id="name" placeholder="Name" class="form-control" required/>
                    </div>

                   <?php
                
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
                    <!-- BREED --> 
                    <div class="form-group col-md-3">
                        <select  class="custom-select my-1 mr-sm-2 form-control" name="breed" id="breed" style=""  > </select>
                    </div>
                
                    <!-- AGE --> 
                    <div class="form-group col-md-3">
                        <select name="age" id="age" class="form-control" required>  
                            <option value="">Age</option>  
                            <option value="Young">Young</option>  
                            <option value="Teen">Teen</option>
                            <option value="Adult">Adult</option>
                            <option value="Senior">Senior</option>
                        </select>
                </div>
            </div><!-- End form-row 1-->
                
            <div class="form-row">
                <div class="form-group col-md-3">
                        <select name="gender" id="gender" class="form-control" required>  
                            <option value="">Gender</option>  
                            <option value="Male">Male</option>  
                            <option value="Female">Female</option>  
                        </select>  
                    </div>
                
                <div class="form-group col-md-3">
                        <select name="color" id="color" class="form-control" required>  
                            <option value="">Color</option>  
                            <option value="White">White</option>  
                            <option value="Black">Black</option>
                            <option value="Gray">Gray</option>
                            <option value="Brown">Brown</option>
                            <option value="Yellow">Yellow / Orange</option>
                        </select>  
                    </div>
                
                <div class="form-group col-md-3">
                        <select name="hair" id="hair" class="form-control" required>  
                            <option value="">Hair</option>  
                            <option value="Short">Short</option>  
                            <option value="Medium">Medium</option>  
                            <option value="Long">Long</option>  
                        </select>  
                    </div>

                    <div class="form-group col-md-3">
                        <select name="size" id="size" class="form-control" required>  
                            <option value="">Size</option>  
                            <option value="XSmall">Extra Small</option>  
                            <option value="Small">Small</option>
                            <option value="Medium">Medium</option>
                            <option value="Large">Large</option>
                            <option value="XLarge">Extra Large</option>
                        </select> 
                    </div>
                </div> <!-- End form-row -->
                
                <h3 style="margin-left:15px;"> Vet Information: </h3>
                
               <div class="form-row">
                   <div class="form-group col-md-3">
                        <input type="text" class="form-control" placeholder="vetname" id="vetname" name="vetname" required>
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" class="form-control" placeholder="City" id="city" name="city" required>
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" class="form-control" placeholder="State" maxlength="2" name="state" id="state" required>
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" class="form-control" placeholder="Zipcode" id="zip" name="zip" maxlength="5" required>
                    </div>
                </div> <!-- End form-row --> 
                
                <br />
                <br />
                
                <label>Have a Pic?</label>
                <input type="file" name="user_image" id="user_image" />
                <input type="hidden" name="hidden_user_image" id="hidden_user_image" />
                <span id="uploaded_image"></span>
                <br />

                <div align="center">
                    <input type="hidden" name="action" id="action" />
                    <input type="hidden" name="user_id" id="user_id" />
                    <input type="submit" name="button_action" id="button_action" class="btn btn-danger" value="Create Profile" />
                </div>
            </form>
        </div>
        <br><br>
    
    <!-- DISPLAY TABLE --> 
    <div id="user_table" class="table-responsive"> </div>
  </div>
</body>
</html>

<script type="text/javascript">
    
        /* CAT | DOG */ 
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

    
 
 /* DATA HANDLING */
 $(document).ready(function(){

  load_data();

  $('#action').val("Create Profile");

  $('#add').click(function(){
   $('#user_form')[0].reset();
   $('#uploaded_image').html('');
   $('#button_action').val("Create Profile");
  });
  function load_data(page)
  {
   var action = "Load";
   $.ajax({
    url:"action.php?u=<?php echo $id; ?>",
    method:"POST",
    data:{action:action, page:page},
    success:function(data)
    {
     $('#user_table').html(data);
    }
   });
  }

  $(document).on('click', '.pagination_link', function(){
   var page = $(this).attr("id");
   load_data(page);
  });

     // Value of session user's ID gets passed on action method POST
  $('#user_form').on('submit', function(event){
   event.preventDefault();
   var firstName = $('#name').val();
   var petCity = $('#city').val();
   var petState = $('#state').val();
   var vetName = $('#vetname').val();
   var petZip = $('#zip').val();
   var petGender = $('#gender').val();
   var getAge = $('#age').val();
   var getSize = $('#size').val();
   var petType = $('#type').val();
   var descrip = $('#description').val();
   var petColor = $('#color').val();
   var petHair = $('#hair').val();
   var petBreed = $('#breed').val();
      
   var extension = $('#user_image').val().split('.').pop().toLowerCase();
   if(extension != '')
   {
    if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
    {
     alert("Invalid Image File");
     $('#user_image').val('');
     return false;
    }
   }
   if(firstName != '')
   {
    $.ajax({
     url:"action.php?u=<?php echo $id; ?>",
     method:"POST",
     data:new FormData(this),
     contentType:false,
     processData:false,
     success:function(data)
     {
      alert(data);
      $('#user_form')[0].reset();
      load_data();      
      $('#action').val("Create Profile");
      $('#button_action').val("Create Profile");
      $('#uploaded_image').html('');
     }
    })
   }
   else
   {
    alert("Both Fields are Required");
   }
  });

  $(document).on('click', '.update', function(){
   var user_id = $(this).attr("id");
   var action = "Fetch Single Data";
   $.ajax({
    url:"action.php",
    method:"POST",
    data:{user_id:user_id, action:action},
    dataType:"json",
    success:function(data)
    {
     $('.collapse').collapse("show");
        
     $('#name').val(data.name);
     $('#city').val(data.city);
     $('#vetname').val(data.vetname);
     $('#state').val(data.state);
     $('#zip').val(data.zip);
     $('#age').val(data.age);
     $('#size').val(data.size);
     $('#gender').val(data.gender);
     $('#type').val(data.type);
     $('#description').val(data.description);
     $('#color').val(data.color);
     $('#hair').val(data.hair);
     $('#breed').val(data.breed);
        
     $('#uploaded_image').html(data.image);
     $('#hidden_user_image').val(data.user_image);
     $('#button_action').val("Edit");
     $('#action').val("Edit");
     $('#user_id').val(user_id);
    }
   });
  });
  
  $(document).on('click', '.delete', function(){
   var user_id = $(this).attr("id");
   var action = "Delete";
   if(confirm("Are you sure you want to delete this?"))
   {
    $.ajax({
     url:"action.php",
     method:"POST",
     data:{user_id:user_id, action:action},
     success:function(data)
     {
      alert(data);
      load_data();
     }
    });
   }
   else
   {
    return false;
   }
  });
  
  $('#search').keyup(function(){
   var query = $('#search').val();
   var action = "Search";
   if(query != '')
   {
    $.ajax({
     url:"action.php",
     method:"POST",
     data:{query:query, action:action},
     success:function(data)
     {
      $('#user_table').html(data);
     }
    });
   }
   else
   {
    load_data();
   }
  });
  
 });
</script>

