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