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
    RouteName VARCHAR(255),
    Direction INT,
    PRIMARY KEY (RouteUID, Direction)
);

LOAD DATA LOCAL INFILE 'Data/Stop_Of_Route.json' 
    INTO TABLE Stop_Of_Routes
    LINES TERMINATED BY '\n'
    (@json)
    SET
        RouteUID = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.RouteUID')),
        RouteName = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.RouteName')),
        Direction = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.Direction'));
