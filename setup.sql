create table route(
    id int auto_increment,
    route_info json,
    primary key(id)
);

create table stop(
    id int auto_increment,
    stop_info json,
    primary key(id)
);

create table station(
    id int auto_increment,
    station_info json,
    primary key(id)
);

create table stop_of_route(
    id int auto_increment,
    stop_of_route_info json,
    primary key(id)
);

util.importJson("Data/route.json", {schema: "project", table: "route", tableColumn: "route_info"})
util.importJson("Data/stop.json", {schema: "project", table: "stop", tableColumn: "stop_info"})
util.importJson("Data/station.json", {schema: "project", table: "station", tableColumn: "station_info"})
util.importJson("Data/stop_of_route.json", {schema: "project", table: "stop_of_route", tableColumn: "stop_of_route_info"})