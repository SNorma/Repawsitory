<?php
    
    include ('../php_includes/check_login_status.php');
    include ('../php_includes/db_conx.php');

    class Crud {
     
     public $connect;
     private $host = "localhost";
     private $username = 'root';
     private $password = 'foobar';
     private $database = 'test';

     function __construct()
     {
      $this->database_connect();
     }

     public function database_connect()
     {
      $this->connect = mysqli_connect($this->host, $this->username, $this->password, $this->database);
     }

     public function execute_query($query)
     {
      return mysqli_query($this->connect, $query);
     }

     public function get_data_in_table($query)
     {
      $output = '';
      $result = $this->execute_query($query);
      $output .= '
      <table class="table table-bordered table-striped">
       <tr>
        <th width="3%">ID</th> 
        <th width="8%">Image</th>
        <th width="10%">Name</th>
        <th width="25%">Description</th>
        <th width="10%">Gender</th>
        <th width="10%">Breed</th>
        <th width="10%">Age</th>
        <th width="7%">Size</th>
        <th width="7%">Type</th>
        <th width="15%">City</th>
        <th width="4%">State</th>
        <th width="14%">Zip</th>
        <th width="14%">Color</th>
        <th width="14%">Hair</th>
        <th width="10%">Update</th>
        <th width="10%">Delete</th>
       </tr>
      ';
      if(mysqli_num_rows($result) > 0)
      {
       while($row = mysqli_fetch_object($result))
       {
        $output .= '
        <tr>
         <td>'.$row->id.'</td>
         <td><img src="upload/'.$row->image.'" class="img-thumbnail" width="50" height="35" /></td>
         <td>'.$row->name.'</td>
         <td>'.$row->description.'</td>
         <td>'.$row->gender.'</td>
         <td>'.$row->breed.'</td>
         <td>'.$row->age.'</td>
         <td>'.$row->size.'</td>
         <td>'.$row->type.'</td>
         <td>'.$row->city.'</td>
         <td>'.$row->state.'</td>
         <td>'.$row->zip.'</td>
         <td>'.$row->color.'</td>
         <td>'.$row->hair.'</td>
         <td><button type="button" name="update" id="'.$row->id.'" class="btn btn-info btn-xs update">Update</button></td>
         <td><button type="button" name="delete" id="'.$row->id.'" class="btn btn-primary btn-xs delete">Delete</button></td>
        </tr>
        ';
       }
      }
      else
      {
       $output .= '
        <tr>
         <td colspan="16" align="center">No Data Found</td>
        </tr>
       ';
      }
      $output .= '</table>';
      return $output;
     } 
     function upload_file($file)
     {
      if(isset($file))
      {
       $extension = explode('.', $file["name"]);
       $new_name = rand() . '.' . $extension[1];
       $destination = './upload/' . $new_name;
       move_uploaded_file($file['tmp_name'], $destination);
       return $new_name;
      }
     }

     function make_pagination_link($query, $record_per_page)
     {
      $output = '';
      $result = $this->execute_query($query);
      $total_records = mysqli_num_rows($result);
      $total_pages = ceil($total_records/$record_per_page);
      for($i=1; $i<=$total_pages; $i++)
      {
       $output .= '<span class="pagination_link" style="cursor:pointer; padding:6px; border:1px solid #ccc;" id="'.$i.'">'.$i.'</span>';
      }
      return $output;
     }
    }
?>
