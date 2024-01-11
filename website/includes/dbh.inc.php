<?php

    $host= "localhost";
    $username = "root";
    $password = "";
    $dbname = "Project";

    $conn = mysqli_connect($host, $username, $password, $dbname);

    if ($conn){
        echo "</br>Connect Success</br>";
    }
    else{
        echo "</br>Connect Fail</br>" . mysqli_connect_error();
    }

?>