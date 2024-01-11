<?php
    include_once("header.php");
?>
    <section class = "signup-form">
        <h2> Sign Up </h2>
        <div class = "signup-form-form">
            <form action="includes/signup.inc.php" method="post" >
                <input type="text" name="username"  placeholder= "User Name">
                <input type="text" name="pwd" placeholder= "User Password" autocomplete="off">
                <button type = "submit" name = "submit">Sign Up</button> 
            </form>
        </div>
        <?php
            if (isset($_GET["error"])){
                if ($_GET["error"] == "emptyinput"){
                    echo "<p>Fill in all fields!</p>";
                }
                else if ($_GET["error"] == "usernametaken"){
                    echo "<p>Username already taken!</p>";
                }
                else if ($_GET["error"] == "stmtfailed"){
                    echo "<p>Something wrong Try again!</p>";
                }
                else if ($_GET["error"] == "none"){
                    echo "<p>Sign up successfully!</p>";
                }
                    
            }
        ?>
    </section>

<?php
    include_once("footer.php");
?>
