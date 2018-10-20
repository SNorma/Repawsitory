<?php
    $db_conx = mysqli_connect("repawsitory.c9sl07vbzyiv.us-west-2.rds.amazonaws.com:3306", "logistic", "solutions", "test");

    // Push Live Use this => "repawsitory.c9sl07vbzyiv.us-west-2.rds.amazonaws.com:3306", "logistic", "solutions", "test"
    
    if (mysqli_connect_errno()) {
        echo mysqli_connect_error();
        exit();
    } 
?>
