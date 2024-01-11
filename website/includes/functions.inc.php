<?php

    function emptyInputSignup($userName, $pwd){
        $result = false;
        if (empty($userName) || empty($pwd)){
            $result = true;
        }

        return $result;
    }
    
    function uidExists($conn, $userName) {

        $sql = "select * from user where UserName = ?;";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../signup.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $userName);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($resultData)){
            return $row;
        }
        else{
            $result = false;
            return $result;
        }

        mysqli_stmt_close($stmt);
    }

    function createUser($conn, $userName, $pwd){

        $sql = "insert into User (UserName, UserPassword) values (?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../signup.php?error=stmtfailed");
            exit();
        } 

        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ss", $userName, $hashedPwd);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("location: ../signup.php?error=none");
        exit();
    }

    function emptyInputLogin($userName, $pwd){
        $result = false;
        if (empty($userName) || empty($pwd)){
            $result = true;
        }
        
        return $result;
    }

    function loginUser($conn, $userName, $pwd){

        $userNameExists = uidExists($conn, $userName);

        if ($userNameExists === false){
            header("location: ../login.php?error=wronglogin");
            exit();
        }

        $pwdHashed = $userNameExists["UserPassword"];
        $checkPwd = password_verify($pwd, $pwdHashed);

        if ($checkPwd == false){
            header("location: ../login.php?error=wronglogin");
            exit();
        }
        else {
            session_start();
            $_SESSION["userId"] = $userNameExists["UserName"];;
            $_SESSION["userName"] = $userNameExists["UserName"];;
            header("location: ../index.php");
            exit();
        }
    }

    function emptyInputSearch($searchName){
        $result = false;
        if (empty($searchName)){
            $result = false;
        }
    
        return $result;
    }

    function searchRoute($conn, $routeName){

        $sql = "SELECT RouteUID, RouteName FROM Routes WHERE RouteName LIKE ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../index.php?error=stmtfailed");
            exit();
        } 

        $searchParam = "%" . $routeName . "%";
        mysqli_stmt_bind_param($stmt, "s", $searchParam);
        mysqli_stmt_execute($stmt);

        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }

        mysqli_stmt_close($stmt);

        return $result;
    }

    function searchStop($conn, $stopName){

        $sql = "SELECT * FROM Stop_Of_Routes WHERE StopUID LIKE ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../index.php?error=stmtfailed");
            exit();
        } 

        $searchParam = "%" . $stopName . "%";
        mysqli_stmt_bind_param($stmt, "s", $searchParam);
        mysqli_stmt_execute($stmt);

        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }

        mysqli_stmt_close($stmt);

        return $result;
    }
?>