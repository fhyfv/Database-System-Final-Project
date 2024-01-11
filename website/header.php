<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>公車查詢</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>

    <nav>
        <div class = "wrapper">
            <a href = "index.php"></a>
            <ul>
                <li><a href = "index.php">Home</a></li>

                <?php
                    if (isset($_SESSION["userName"])){
                        echo "<li><a href = 'favorite.php'>My Favorite</a></li>";
                        echo "<li><a href = 'includes/logout.inc.php'>Log Out</a></li>";
                    }
                    else {
                        echo "<li><a href = 'signup.php'>Sign Up</a></li>";
                        echo "<li><a href = 'login.php'>Log In</a></li>";
                    }
                ?>
            </ul> 

    </nav>

    <div class = "wrapper">