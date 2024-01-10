const fs = require('fs');
let route = JSON.parse(fs.readFileSync('Route_raw.json'));
let stop = JSON.parse(fs.readFileSync('Stop_raw.json'));
let station = JSON.parse(fs.readFileSync('Station_raw.json'));
let stop_of_route = JSON.parse(fs.readFileSync('Stop_Of_Route_raw.json'));

var filtered_route = route.map(function(hit){
    return { 
    RouteUID : hit.RouteUID,
    RouteName : hit.RouteName.Zh_tw,
    DepartureStopName : hit.DepartureStopNameZh,
    DestinationStopName : hit.DestinationStopNameZh, 
    RouteMapImageUrl : hit.RouteMapImageUrl }
})

var filtered_stop = stop.map(function(hit){
  return { 
    StopUID : hit.StopUID,
    StopName : hit.StopName.Zh_tw,
    StopPositionLon : hit.StopPosition.PositionLon,
    StopPositionLat : hit.StopPosition.PositionLat,
    StopAddress : hit.StopAddress,
    StationGroupID : hit.StationGroupID }
})

var filtered_station = station.map(function(hit){
  return { 
    StationUID : hit.StationUID,
    StationName : hit.StationName.Zh_tw,
    StationGroupID : hit.StationGroupID,
    StationPositionLon : hit.StationPosition.PositionLon,
    StationPositionLat : hit.StationPosition.PositionLat
     }
})

var filtered_stop_of_route = stop_of_route.map(function(hit){
  return { 
    RouteUID : hit.RouteUID,
    RouteName : hit.RouteName.Zh_tw,
    Direction : hit.Direction }
})

fs.writeFileSync('process_route.json', JSON.stringify(filtered_route, null, 4));
fs.writeFileSync('process_stop.json', JSON.stringify(filtered_stop, null, 4));
fs.writeFileSync('process_station.json', JSON.stringify(filtered_station, null, 4));
fs.writeFileSync('process_stop_of_route.json', JSON.stringify(filtered_stop_of_route, null, 4));