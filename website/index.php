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
    
        // Use a prepared statement to execute a SELECT query
        $sql = "SELECT RouteUID, RouteName FROM Routes WHERE RouteName LIKE ?";
        $stmt = $conn->prepare($sql);
    
        // Bind the search statement to the placeholder
        $searchParam = "%" . $searchStatement . "%";
        $stmt->bind_param("s", $searchParam);
        $stmt->execute();
    
        // Store the results
        $result = $stmt->get_result();
    
        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }
    
        // Close the statement
        $stmt->close();
    }
    $conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>公車查詢</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script>
</head>
<body>
    <h1>公車查詢</h1>
    <div id="login">登入</div>
    <div id="register">註冊</div>
    <div id="fav">我的最愛</div>

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
        <input type="text" name = "search" id="search" value= "<?php echo htmlspecialchars($searchStatement); ?>">
        <input type="submit" name="submit" value="Search">
    </form>
    
   
</body>
</html>

