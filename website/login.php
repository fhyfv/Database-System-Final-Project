<?php
    include_once("header.php");
?>

    <section class = "login-form">
        <h2> Log In </h2>
        <div class = "login-form-form">
            <form action="includes/login.inc.php" method="post" >
                <input type="text" name="username" placeholder= "User Name">
                <input type="text" name="pwd" placeholder= "User Password">
                <button type = "submit" name = "submit">Log In</button> 
            </form>
        </div>
        <?php
            if (isset($_GET["error"])){
                if ($_GET["error"] == "emptyinput"){
                    echo "<p>Fill in all fields!</p>";
                }
                else if ($_GET["error"] == "wronglogin"){
                    echo "<p>Incorrect Information!</p>";
                }   
            }
        ?>
    </section>

<?php
    include_once("footer.php");
?>