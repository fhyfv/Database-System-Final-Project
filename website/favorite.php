<?php
    include_once("header.php");
?>
<?php
    if (isset($_SESSION["userName"])){
        echo "<p> This is " . $_SESSION["userName"] . "'s favorite lists" . "</p>";
    }
?>
    <section class = "favorite-list">
        <?php

            require_once 'includes/dbh.inc.php';
            require_once 'includes/functions.inc.php';

            $results = showFavorite($conn, $_SESSION["userName"]);
            echo "<div class='delete-favorite-button'>" .
                    "<form class='delete-favorite' action='favorite.php' method='post'>" .
                    "<input type = 'text' name= 'routeName'>" .
                    "<button type='submit' name='deleteFavorite'>Delete Favorite</button>" .
                    "</div>";

            if (empty($results)){
                echo "<p>No favorite stop.</p>";
            }
            else{
                echo "RouteName<br>"; 
                foreach ($results as $row) {
                    echo $row["RouteUID"] . " " . $row["RouteName"] . "<br>";
                }
            }
            if (isset($_POST["addFavorite"])){

                $routeUID = $_POST["routeUid"];
            
                if (isset($_SESSION["userName"])){
                    addFavorite($conn, $routeUID);
                }
                else{

                }   
            }

            if (isset($_POST["deleteFavorite"])){
                $routeName = $_POST["routeName"];
                deleteFavorite($conn, $routeName);
            }

            if (isset($_GET["error"])){
                if ($_GET["error"] == "stmtfailed"){
                    echo "<p>Something wrong Try again!</p>";
                }
                else if ($_GET["error"] == "none"){
                    echo "<p>Add favorite successfully!</p>";
                }
            }
        ?>
    <section class = "signup-form">

<?php
    include_once("footer.php");
?>