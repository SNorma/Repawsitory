<?php
    include_once("php_includes/check_login_status.php");
?>

<div id="pageTop">
  <div id="pageTopWrap">
    <div id="pageTopLogo">
    </div>
    <div id="pageTopRest">
      <div id="menu1">
        <div>
            <?php 
                if($user_ok == true){
                    echo '<a href="index.php"> Home </a> | <a href="users.php?u=' . $_SESSION["username"] . '"> Profile </a> | <a href="logout.php"> Logout | <a href="../editaccount.php?u=' . $_SESSION["username"] . '"> Edit Account </a></a>';
                }
                else {
                    echo '<a href="index.php"> Home </a> | <a href="login.php">Login </a> |  <a href="signup.php">Sign Up</a>';
                }
            ?>  
        </div>
      </div>
        <div>
        </div>
      </div>
    </div>
  </div>
</div>