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
        if ($row = $result->fetch_assoc() > 0){
            while ($row = $result->fetch_assoc()) {
                $results[] = $row;
            }
            return $result;
        }
        else{
            $row = $result->fetch_assoc();
            return $row;
        }
        
        mysqli_stmt_close($stmt);
    }

    function searchStop($conn, $stopName){

        // $sql = "SELECT DISTINCT Routes.RouteUID, RouteName, Direction, Stop_Of_Routes.StopUID
        //         FROM Stop_Of_Routes JOIN Routes ON Stop_Of_Routes.RouteUID=Routes.RouteUID
        //         WHERE Stop_Of_Routes.StopUID LIKE ?";
        $sql = "SELECT DISTINCT Routes.RouteUID, RouteName, Direction, Stop_Of_Routes.StopUID, Stops.StopName
                FROM Stop_Of_Routes JOIN Routes ON Stop_Of_Routes.RouteUID=Routes.RouteUID
                JOIN Stops ON Stop_Of_Routes.StopUID=Stops.StopUID
                WHERE Stop_Of_Routes.StopUID LIKE ?";
        
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

    function getStops($conn, $routeUID) {
        $sql = "SELECT sr.SubRouteUID, sr.Direction, s.StopUID, s.StopName, e.EstimateTime, e.PlateNumb 
                FROM Stop_Of_Routes sr
                JOIN EstimateTime e ON (sr.StopUID=e.StopUID and sr.RouteUID=e.RouteUID and sr.Direction=e.Direction and sr.SubRouteUID=e.SubRouteUID)
                JOIN Stops s ON s.StopUID=sr.StopUID
                WHERE sr.RouteUID LIKE ? 
                ORDER BY sr.SubRouteUID, sr.StopSequence";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
    
        mysqli_stmt_bind_param($stmt, "s", $routeUID);
        mysqli_stmt_execute($stmt);
    
        $resultData = mysqli_stmt_get_result($stmt);
        $results = mysqli_fetch_all($resultData, MYSQLI_ASSOC);
    
        mysqli_stmt_close($stmt);
    
        return $results;
    }

    function showFavorite($conn, $userName){
        
        $sql = "select u.RouteUID, r.RouteName 
        from User_Favorite as u, Routes as r 
        where u.UserName = ? AND u.RouteUID = r.RouteUID;";

        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../website/favorite.php?error=stmtfailed");
            exit();
        } 
        mysqli_stmt_bind_param($stmt, "s", $userName);
        mysqli_stmt_execute($stmt);
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc() > 0){
            while ($row = $result->fetch_assoc()) {
                $results[] = $row;
            }
            return $result;
        }
        else{
            $row = $result->fetch_assoc();
            return $row;
        }
        mysqli_stmt_close($stmt);
        header("location: ../website/favorite.php?error=none");
        exit();
    }

    function addFavorite($conn, $routeUID){
        $userName = $_SESSION["userName"];
        $sql = "INSERT INTO User_Favorite (UserName, RouteUID) VALUES (?, ?)";

        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../website/favorite.php?error=stmtfailed");
            exit();
        } 
        mysqli_stmt_bind_param($stmt, "ss", $userName, $routeUID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("location: ../website/favorite.php?error=none");
        exit();
    }

    function deleteFavorite($conn, $routeName){

        $userName = $_SESSION["userName"];
        $sql = "DELETE FROM User_Favorite 
        WHERE UserName = ? AND 
        RouteUID in (select routeUid from (select r.RouteUID as routeUid
                from User_Favorite as u, Routes as r 
                where u.RouteUID = r.RouteUID AND r.RouteName = ?) as a);";

        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../website/favorite.php?error=stmtfailed");
            exit();
        } 
        mysqli_stmt_bind_param($stmt, "ss", $userName, $routeName);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("location: ../website/favorite.php?error=none");
        exit();
    }
?>