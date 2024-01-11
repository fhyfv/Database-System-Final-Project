<?php

    if (isset($_POST["submit"])){

        $userName = $_POST["username"];
        $pwd = $_POST["pwd"];

        require_once 'dbh.inc.php';
        require_once 'functions.inc.php';

        if (emptyInputLogin($userName, $pwd) === true){
            header("location: ../login.php?error=emptyinput");
            exit();
        }

        loginUser($conn, $userName, $pwd);
    }
    else{
        header("location: ../login.php");
        exit();
    }
?>