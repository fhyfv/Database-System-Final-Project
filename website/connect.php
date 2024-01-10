<?php
    $host= "localhost";
    $username = "root";
    $password = "";

    // Create connection
    $conn = mysqli_connect($host, $username, $password);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    echo 'Connected successfully';

    mysqli_select_db($conn, $dbname) or 
    die("Connect database failed: " . mysqli_error($conn));

    mysqli_close($conn);
?>