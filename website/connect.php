<?php
    $host= "rongshashiala";
    $username = "rongshashiala";
    $password = "Ai2327226";
    $dbname = "final-project";

    // Create connection
    $conn = mysqli_connect($host, $username, $password, $dbname);

    // Check connection
    if ($conn){
        echo "</br>Connect Success</br>";
    }
    else{
        echo "</br>Connect Fail</br>" . mysqli_connect_error();
    }

    $sql = "SELECT id, route_info FROM route";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo $row["route_info"];
        }
    }
    else {
        echo "0 results";
    }

    mysqli_close($conn);
?>