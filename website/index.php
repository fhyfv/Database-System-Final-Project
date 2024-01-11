<?php
    include_once("header.php");
?>
  
<?php
    if (isset($_SESSION["userName"])){
        echo "<p> Hello there " . $_SESSION["userName"] . "</p>";
    }
?>

    <h1>公車查詢</h1>
    <section class = "route-search">
        <h2> Route Search </h2>
        <div class = "route-search-search">
            <form action="index.php" method="post" >
                <input type="text" name="routename" placeholder= "Enter Route Name">
                <button type = "submit" name = "routeSearchSubmit">Search Route</button> 
            </form>
        </div>
    </section>

    <?php
        if (isset($_POST["routeSearchSubmit"])){
            $routeName = $_POST["routename"];

            require_once 'includes/dbh.inc.php';
            require_once 'includes/functions.inc.php';

            if (emptyInputSearch($routeName) === true){
                header("location: ../index.php?error=emptyinput");
                exit();
            }
            
            $results = searchRoute($conn, $routeName);
            if (empty($results)){
                echo "<p>No results found.</p>";
            }
            else{
                echo "Result" . "<br>";
                echo "RouteUID" . "\t" . "RouteName" . "<br>";
                foreach ($results as $row){
                    echo "<div class='route-row'>";
                    echo "<div class='route-info-button'>";
                    echo "<span class='route-info'>".$row["RouteUID"]."\t".$row["RouteName"]."</span>";
                    echo "<form class='view-stops-form' action='stops.php' method='post'>";
                    echo "<input type='hidden' name='routeUID' value='".$row["RouteUID"]."'>";
                    echo "<button type='submit' name='viewStops'>View Stops</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";

                }
            }
        }
    ?>

    <section class = "stop-search">
        <h2> Stop Search </h2>
        <div class = "stop-search-search">
            <form action="index.php" method="post" >
                <input type="text" name="stopname" placeholder= "Enter Stop Name">
                <button type = "submit" name = "stopSearchSubmit">Search Stop</button> 
            </form>
        </div>
    </section>

    <?php
        if (isset($_POST["stopSearchSubmit"])){

            $stopName = $_POST["stopname"];
            require_once 'includes/dbh.inc.php';
            require_once 'includes/functions.inc.php';

            if (emptyInputSearch($stopName) === true){
                header("location: ../index.php?error=emptyinput");
                exit();
            }
            
            $results = searchStop($conn, $stopName);
            if (empty($results)){
                echo "<p>No results found.</p>";
            }
            else{
                echo "Result" . "<br>";
                echo "RouteName\tDirection\tStopUID<br>";
                foreach ($results as $row) {
                    echo "<div class='route-row'>";
                    echo "<div class='route-info-button'>";
                    echo "<span class='route-info'>".$row["RouteName"] . "\t" .  $row["Direction"] . "\t" .  $row["StopUID"]."</span>";
                    echo "<form class='view-stops-form' action='stops.php' method='post'>";
                    echo "<input type='hidden' name='routeUID' value='".$row["RouteUID"]."'>";
                    echo "<button type='submit' name='viewStops'>View Stops Of Route</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                }
            }
        }
    ?>
   
<?php
    include_once("footer.php");
?>