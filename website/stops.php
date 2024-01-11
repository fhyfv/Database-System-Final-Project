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
            echo "SubRouteUID\tStopUID\tStopName\tDirection\tEstimateTime\tPlateNumb<br>";
            foreach ($results as $row) {
                echo $row['SubRouteUID'] . "\t" .$row["StopUID"] . "\t" .$row["StopName"] . "\t" . $row["Direction"] . "\t" . $row["EstimateTime"] . "\t" . $row["PlateNumb"] . "<br>" ;
            }
        }
    }
?>