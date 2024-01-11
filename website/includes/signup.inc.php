<?php

    if (isset($_POST["submit"])){

        $userName = $_POST["username"];
        $pwd = $_POST["pwd"];

        require_once 'dbh.inc.php';
        require_once 'functions.inc.php';

        if (emptyInputSignup($userName, $pwd) !== false){
            header("location: ../signup.php?error=emptyinput");
            exit();
        }

        if (uidExists($conn, $userName) !== false){
            header("location: ../signup.php?error=usernametaken");
            exit();
        }

        createUser($conn, $userName, $pwd);
    }
    else{
        header("location: ../signup.php");
        exit();
    }
?>

