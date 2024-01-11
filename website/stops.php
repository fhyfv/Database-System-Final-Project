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
            echo "Route Name: " . $routeUID . "<br>";
            echo "<div class='add-favorite-button'>" .
                    "<form class='add-favorite' action='favorite.php' method='post'>" .
                    "<input type = 'text' name= 'routeUid'>" .
                    "<button type='submit' name='addFavorite'>Add Favorite</button>" .
                "</div>";
            echo "StopUID\tStopName\tDirection\t<br>"; 
            foreach ($results as $row) {
                echo $row["StopUID"] . "\t" .$row["StopName"] . "\t" . $row["Direction"] . "<br>";
            }
        }
    }
?>

<?php
    include_once("footer.php");
?>