<?php
    
include('php_includes/db_conx.php');
    include('php_includes/db_conx.php'); 
    include 'crud.php';
    $object = new Crud();

    $user_id = $_GET['u'];

    // All functionality POSTS to ACTION!
    if(isset($_POST["action"])) {
     
        // LOADING: LOAD ONLY DATA FROM user_id... 
        if($_POST["action"] == "Load") {
            
            // Set records per page
            $record_per_page = 5;
            $page = '';
            
            // For Pagination...
            if(isset($_POST["page"])) {
                $page = $_POST["page"];
            }
            else {
                $page = 1;
            }
      
            $start_from = ($page - 1) * $record_per_page;

            
            // DATA SELECT: 
            echo $object->get_data_in_table("SELECT * FROM users_pets WHERE uid='$user_id' ORDER BY id DESC LIMIT $start_from, $record_per_page");
            echo '<br /><div align="center">';
            echo $object->make_pagination_link("SELECT * FROM users_pets WHERE uid='$user_id' ORDER by id", $record_per_page);
            echo '</div><br />';
            echo '</div><br />';

         }

        // INSERT: Insert data where id of SESSION['user'] = uid in users_pets table
        if($_POST["action"] == "Create Profile") {

            $name = mysqli_real_escape_string($object->connect, $_POST["name"]);
            $color = mysqli_real_escape_string($object->connect, $_POST["color"]);
            $gender = mysqli_real_escape_string($object->connect, $_POST["gender"]);
            $type = mysqli_real_escape_string($object->connect, $_POST["type"]);
            $age = mysqli_real_escape_string($object->connect, $_POST["age"]);
            $size = mysqli_real_escape_string($object->connect, $_POST["size"]);
            $zip = mysqli_real_escape_string($object->connect, $_POST["zip"]);
            $city = mysqli_real_escape_string($object->connect, $_POST["city"]);
            $vetname = mysqli_real_escape_string($object->connect, $_POST["vetname"]);
            $state = mysqli_real_escape_string($object->connect, $_POST["state"]);
            $hair = mysqli_real_escape_string($object->connect, $_POST["hair"]);
            $description = mysqli_real_escape_string($object->connect, $_POST["description"]);
            $breed = mysqli_real_escape_string($object->connect, $_POST["breed"]); 

            $image = $object->upload_file($_FILES["user_image"]);

            if (!file_exists("upload/$uid")) {
                mkdir("upload/$uid", 0777,true);
            }

            $destFile = "uploads/". $uid . "/";
            move_uploaded_file( $_FILES['image']['tmp_name'], $destFile );
            
            $query = " INSERT INTO users_pets (vetname, description, breed, hair, uid, name, color, gender, type, age, size,city,state,zip, image) VALUES ('".$vetname."','".$description."','".$breed."','".$hair."','".$user_id."','".$name."', '".$color."', '".$gender."','".$type."','".$age."','".$size."','".$city."','".$state."','".$zip."','".$image."')";

            $object->execute_query($query);

            echo "Data Inserted";
         }


        // EDITING:     
        if($_POST["action"] == "Fetch Single Data") {
            
            $output = '';
            $query = "SELECT * FROM users_pets WHERE id = '".$_POST["user_id"]."'";
            $result = $object->execute_query($query);
            
            while($row = mysqli_fetch_array($result)) {
                
                $output["name"] = $row['name'];
                $output["description"] = $row['description'];
                $output["breed"] = $row['breed'];
                $output["hair"] = $row['hair'];
                $output["city"] = $row['city'];
                $output["vetname"] = $row['vetname'];
                $output["state"] = $row['state'];
                $output["zip"] = $row['zip'];
                $output["type"] = $row['type'];
                $output["age"] = $row['age'];
                $output["size"] = $row['size'];
                $output["color"] = $row['color'];
                $output["gender"] = $row['gender'];
                $output["image"] = '<img src="upload/'.$row['image'].'" class="img-thumbnail" width="50" height="35" />';
                $output["user_image"] = $row['image'];
            }
        
            echo json_encode($output);
        }

     if($_POST["action"] == "Edit")
     {
      $image = '';
      if($_FILES["user_image"]["name"] != '')
      {
       $image = $object->upload_file($_FILES["user_image"]);
      }
      else
      {
       $image = $_POST["hidden_user_image"];
      }
      $name = mysqli_real_escape_string($object->connect, $_POST["name"]);
      $type = mysqli_real_escape_string($object->connect, $_POST["type"]);
      $city = mysqli_real_escape_string($object->connect, $_POST["city"]);
      $state = mysqli_real_escape_string($object->connect, $_POST["state"]);
      $zip = mysqli_real_escape_string($object->connect, $_POST["zip"]);
      $age = mysqli_real_escape_string($object->connect, $_POST["age"]);
      $size = mysqli_real_escape_string($object->connect, $_POST["size"]);
      $color = mysqli_real_escape_string($object->connect, $_POST["color"]);
      $gender = mysqli_real_escape_string($object->connect, $_POST["gender"]);
      $description = mysqli_real_escape_string($object->connect, $_POST["description"]);
      $breed = mysqli_real_escape_string($object->connect, $_POST["breed"]);
      $hair = mysqli_real_escape_string($object->connect, $_POST["hair"]);
      
        $query = "UPDATE users_pets SET description = '".$description."',breed = '".$breed."',hair = '".$hair."',city = '".$city."',state = '".$state."',zip = '".$zip."', age = '".$age."',size = '".$size."',gender = '".$gender."', type = '".$type."',name = '".$name."', color = '".$color."', image = '".$image."' WHERE id = '".$_POST["user_id"]."'";
      $object->execute_query($query);
      echo 'Data Updated';

     }

     if($_POST["action"] == "Delete")
     {
      $query = "DELETE FROM users_pets WHERE id = '".$_POST["user_id"]."'";
      $object->execute_query($query);
      echo "Data Deleted";
     }

     if($_POST["action"] == "Search")
     {
      $search = mysqli_real_escape_string($object->connect, $_POST["query"]);
      $query = "
      SELECT * FROM users_pets 
      WHERE description LIKE '%".$search."%' 
      ORDER BY id DESC
      ";
      //echo $query;
      echo $object->get_data_in_table($query);  
     }
    }
?>