<?php

    $host= "localhost";
    $username = "user1";
    $password = "";
    $dbname = "Project";

    $conn = mysqli_connect($host, $username, $password, $dbname);

    if (!$conn){
        echo "</br>Connect Fail</br>" . mysqli_connect_error();
    }
?>