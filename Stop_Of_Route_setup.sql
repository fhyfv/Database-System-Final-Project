CREATE TABLE IF NOT EXISTS Stop_Of_Routes (
    RouteUID VARCHAR(20),
    SubRouteUID VARCHAR(255),
    Direction INT,
    StopUID VARCHAR(20),
    PRIMARY KEY (RouteUID, SubRouteUID, Direction, StopUID)
);
LOAD DATA LOCAL INFILE 'Data/Stop_Of_Route_1.json' 
    INTO TABLE Stop_Of_Routes
    LINES TERMINATED BY '\n'
    (@json)
    SET
        RouteUID = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.RouteUID')),
        SubRouteUID = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.SubRouteUID')),
        Direction = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.Direction')),
	StopUID = JSON_UNQUOTE(JSON_EXTRACT(@json, '$.StopUID'));