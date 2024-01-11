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
    
    $searchStatement = '';
    $results = [];  
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the search statement from the form input
        $searchStatement = $_POST["search"];
        
        if ($searchStatement == ''){
            echo "Please enter a route name";
        }
        else{
            $sql = "SELECT RouteUID, RouteName FROM Routes WHERE RouteName LIKE ?";
            $stmt = $conn->prepare($sql);

            $searchParam = "%" . $searchStatement . "%";
            $stmt->bind_param("s", $searchParam);
            $stmt->execute();
        
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $results[] = $row;
            }
            $stmt->close();
        }
    }

    $stopSearch = '';
    $stopResults = [];  
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the search statement from the form input
        $stopSearch = $_POST["search"];
        
        if ($stopSearch == ''){
            echo "Please enter a route name";
        }
        else{
            $sql = "SELECT RouteUID, RouteName FROM Routes WHERE RouteName LIKE ?";
            $stmt = $conn->prepare($sql);

            $searchParam = "%" . $stopSearch . "%";
            $stmt->bind_param("s", $searchParam);
            $stmt->execute();
        
            $stopResult = $stmt->get_result();
            while ($row = $stopResult->fetch_assoc()) {
                $stopResults[] = $row;
            }
            $stmt->close();
        }
    }
    $conn->close();
?>

  
<?php
    include_once("header.php");
    if (isset($_SESSION["userName"])){
        echo "<p> Hello there " . $_SESSION["userName"] . "</p>";
    }
?>

        <h1>公車查詢</h1>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for = "search">路線查詢 : </label>
            <input type="text" name = "search" id="search" value= "<?php echo htmlspecialchars($searchStatement); ?>">
            <input type="submit" name="submit" value="Search">
        </form>
  
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && count($results) > 0) {
            echo "Result" . "<br>";
            foreach ($results as $row) {
                echo "RouteUID: " . $row["RouteUID"] . "\t" .
                "RouteName: " . $row["RouteName"] . "<br>";
            }
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && empty($results)) {
            echo "<p>No results found.</p>";
        }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for = "search">站牌查詢 : </label>
        <input type="text" name = "search" id="search" value= "<?php echo htmlspecialchars($stopSearch); ?>">
        <input type="submit" name="submit" value="Search">
    </form>
    
   
<?php
    include_once("footer.php");
?>