const resultdiv=document.getElementById("results");
const routebtn=document.getElementById("routebtn");
const stopbtn=document.getElementById("stopbtn");

var routes, stops, stations, stopOfRoutes, estimatedArrivalTimes;

routebtn.disabled = true;
stopbtn.disabled = true;

routebtn.addEventListener("click", searchRoute);
stopbtn.addEventListener("click", searchStop);



loadData();
setInterval(loadData, 60000);


function loadData() {
    fetch('Route.json')
        .then(response => response.json())
        .then(data => {
            routes = data;
            // Enable the search buttons now that the data is loaded
            routebtn.disabled = false;
            stopbtn.disabled = false;
        })
        .catch(error => console.error('Error:', error));

    fetch('Stop.json')
        .then(response => response.json())
        .then(data => {
            stops = data;
            // Enable the search buttons now that the data is loaded
            routebtn.disabled = false;
            stopbtn.disabled = false;
        })
        .catch(error => console.error('Error:', error));

    fetch('Stations.json')
        .then(response => response.json())
        .then(data => {
            stations = data;
            // Enable the search buttons now that the data is loaded
            routebtn.disabled = false;
            stopbtn.disabled = false;
        })
        .catch(error => console.error('Error:', error));

    fetch('Stop_Of_Route.json')
        .then(response => response.json())
        .then(data => {
            stopOfRoutes = data;
            // Enable the search buttons now that the data is loaded
            routebtn.disabled = false;
            stopbtn.disabled = false;
        })
        .catch(error => console.error('Error:', error));
    fetch('Estimate_Arrival_Time.json')
        .then(response => response.json())
        .then(data => {
            estimatedArrivalTimes = data;
            // Enable the search buttons now that the data is loaded
            routebtn.disabled = false;
            stopbtn.disabled = false;
        })
        .catch(error => console.error('Error:', error));
}



function searchRoute() {
    var routeInput = document.getElementById('routeInput').value;
    var route = routes.find(r => r.RouteID === routeInput);
    if (route) {
        var stopsOfRoute = stopOfRoutes.filter(s => s.RouteID === route.RouteID);
        var stopDetails = stopsOfRoute.map(s => stops.find(stop => stop.StopID === s.StopID));
        resultdiv.innerHTML=``;// Display the route and stop details in the 'results' div
    }
}

function searchStop() {
    console.log("stop");
    var stopInput = document.getElementById('stopInput').value;
    var stop = stops.find(s => s.StopID === stopInput);
    if (stop) {
        var routesOfStop = stopOfRoutes.filter(s => s.StopID === stop.StopID);
        var routeDetails = routesOfStop.map(r => routes.find(route => route.RouteID === r.RouteID));
        resultdiv.innerHTML=``;// Display the stop and route details in the 'results' div
    }
}

function getEstimatedArrivalTime(routeID, stopID) {
    var estimatedArrivalTime = estimatedArrivalTimes.find(e => e.RouteID === routeID && e.StopID === stopID);
    return estimatedArrivalTime ? estimatedArrivalTime.EstimateTime : 'N/A';
}


