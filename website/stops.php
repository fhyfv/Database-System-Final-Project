<?php
    include_once("header.php");
?>
<?php
    if (isset($_POST["viewStops"])){
        $routeUID = $_POST["routeUID"];

        require_once 'includes/dbh.inc.php';
        require_once 'includes/functions.inc.php';

        $results = getStops($conn, $routeUID);
        if (empty($results)){
            echo "<p>No stops found for this route.</p>";
        }
        else{
            echo "Stops for route: " . $routeUID . "<br>";
            echo "StopUID\tStopName\tDirection<br>";
            foreach ($results as $row) {
                echo $row["StopUID"] . "\t" .$row["StopName"] . "\t" . $row["Direction"] . "<br>";
            }
        }
    }
?>