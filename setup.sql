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
