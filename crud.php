<?php
    
    class Crud {
     
 		 private $host = "repawsitory.c9sl07vbzyiv.us-west-2.rds.amazonaws.com:3306";
     private $username = 'logistic';
     private $password = 'solutions';
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
        <th width="10%">Repaw ID:</th> 
        <th width="40%">Image</th>
        <th width="20%">Name</th>
        <th width="15%">View Profile</th>
        <th width="15%">Delete</th>
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
         <td><button type="button" name="update" id="'.$row->id.'" class="btn btn-info btn-xs update">View Profile</button></td>
         <td><button type="button" name="delete" id="'.$row->id.'" class="btn btn-primary btn-xs delete">Delete</button></td>
        </tr>
        ';
       }
      }
      else
      {
       $output .= '
        <tr>
         <td colspan="16" align="center">No pet info found.. Please create a new pet!</td>
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
