CREATE TABLE IF NOT EXISTS Routes  (
    RouteUID VARCHAR(20) PRIMARY KEY,
    RouteName VARCHAR(255),
    DepartureStopName VARCHAR(255),
    DestinationStopName VARCHAR(255),
    RouteMapImageUrl VARCHAR(255)
);

LOAD DATA LOCAL INFILE 'Data/Route.json' 
    INTO TABLE Routes 
    LINES TERMINATED BY '\n'
    (@json)
    SET
        RouteUID = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.RouteUID')),
        RouteName = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.RouteName')),
        DepartureStopName = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.DepartureStopName')),
        DestinationStopName = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.DestinationStopName')),
        RouteMapImageUrl = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.RouteMapImageUrl'));


CREATE TABLE IF NOT EXISTS Stops (
    StopUID VARCHAR(20) PRIMARY KEY,
    StopName VARCHAR(255),
    StopPositionLon DOUBLE,
    StopPositionLat DOUBLE,
    StopAddress VARCHAR(255),
    StationGroupID VARCHAR(20)
);

LOAD DATA LOCAL INFILE 'Data/Stop.json' 
    INTO TABLE Stops
    LINES TERMINATED BY '\n'
    (@json)
    SET
        StopUID = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.StopUID')),
        StopName = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.StopName')),
        StopPositionLon = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.StopPositionLon')),
        StopPositionLat = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.StopPositionLat')),
        StopAddress = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.StopAddress')),
        StationGroupID = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.StationGroupID'));

CREATE TABLE IF NOT EXISTS Stations (
    StationUID VARCHAR(20) PRIMARY KEY,
    StationName VARCHAR(255),
    StationGroupID VARCHAR(20),
    StationPositionLon DOUBLE,
    StationPositionLat DOUBLE
);

LOAD DATA LOCAL INFILE 'Data/Station.json' 
    INTO TABLE Stations
    LINES TERMINATED BY '\n'
    (@json)
    SET
        StationUID = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.StationUID')),
        StationName = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.StationName')),
        StationGroupID = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.StationGroupID')),
        StationPositionLon = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.StationPositionLon')),
        StationPositionLat = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.StationPositionLat'));

CREATE TABLE IF NOT EXISTS Stop_Of_Routes (
    RouteUID VARCHAR(20),
    SubRouteUID VARCHAR(255),
    Direction INT,
    StopUID VARCHAR(20),
    StopSequence INT,
    PRIMARY KEY (RouteUID, SubRouteUID, Direction, StopUID)
);
LOAD DATA LOCAL INFILE 'Data/Stop_Of_Route.json' 
    INTO TABLE Stop_Of_Routes
    LINES TERMINATED BY '\n'
    (@json)
    SET
        RouteUID = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.RouteUID')),
        SubRouteUID = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.SubRouteUID')),
        Direction = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.Direction')),
	    StopUID = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.StopUID')),
        StopSequence = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.StopSequence'));

CREATE TABLE IF NOT EXISTS User (
    UserID int auto_increment PRIMARY KEY,
    UserName VARCHAR(255),
    UserPassword VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS User_Favorite (
    UserName VARCHAR(255),
    RouteUID VARCHAR(20),
    PRIMARY KEY (UserName, RouteUID)
);

DROP TABLE IF EXISTS EstimateTime;

CREATE TABLE IF NOT EXISTS EstimateTime (
    RouteUID VARCHAR(20),
    SubRouteUID VARCHAR(20),
    StopUID VARCHAR(20),
    Direction INT,
    StopStatus INT,
    IsLastBus BOOLEAN,
    PlateNumb VARCHAR(10),
    EstimateTime INT,
    PRIMARY KEY (RouteUID, SubRouteUID, StopUID, Direction)
);

LOAD DATA LOCAL INFILE 'Data/Estimate_Arrival_Time.json'
    INTO TABLE EstimateTime
    LINES TERMINATED BY '\n'
    (@json)
    SET
        RouteUID = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.RouteUID')),
        SubRouteUID = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.SubRouteUID')),
        StopUID = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.StopUID')),
        Direction = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.Direction')),
        StopStatus = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.StopStatus')),
        IsLastBus = if(JSON_UNQUOTE(JSON_EXTRACT(@json, '$.IsLastBus')) = 'true', 1, 0),
        PlateNumb = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.PlateNumb')),
        EstimateTime = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.EstimateTime'));

select r.RouteName 
from User_Favorite as u, Routes as r 
where u.UserName = "fhyfv" AND u.RouteUID = r.RouteUID;

DELETE FROM User_Favorite 
WHERE UserName = "fhyfv" AND 
RouteUID in (select routeUid from (select r.RouteUID as routeUid
        from User_Favorite as u, Routes as r 
        where u.RouteUID = r.RouteUID AND r.RouteName = "81") as a);
