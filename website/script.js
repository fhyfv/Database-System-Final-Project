const resultdiv=document.getElementById("results");
const routebtn=document.getElementById("routebtn");
const stopbtn=document.getElementById("stopbtn");
const regbtn=document.getElementById("register");
const logbtn=document.getElementById("login");
const favbtn=document.getElementById("fav");

var routes, stops, stations, stopOfRoutes, estimatedArrivalTimes;

routebtn.disabled = true;
stopbtn.disabled = true;

routebtn.addEventListener("click", searchRoute);
stopbtn.addEventListener("click", searchStop);
regbtn.addEventListener("click", regi);
logbtn.addEventListener("click", logi);
favbtn.addEventListener("click", showFav);


//loadData();
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

    fetch('Station.json')
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
    resultdiv.innerHTML=``;
    let id=indexroute(routeInput);
    console.log(routeInput)
    console.log(id);
    if(id!=null){
        for(let j=0;j<stopOfRoutes[id].Stops.length;j++){
            console.log(stopOfRoutes[id].Stops[j].StopName.Zh_tw);
            resultdiv.innerHTML=resultdiv.innerHTML+`${stopOfRoutes[id].Stops[j].StopName.Zh_tw}<br/>`;
        }
        resultdiv.innerHTML=resultdiv.innerHTML+`---------------------------------------------------<br/>`;
        console.log("----------------");
        if(stopOfRoutes[id+1].Direction==1){
            for(let j=0;j<stopOfRoutes[id+1].Stops.length;j++){
                console.log(stopOfRoutes[id+1].Stops[j].StopName.Zh_tw);
                resultdiv.innerHTML=resultdiv.innerHTML+`${stopOfRoutes[id+1].Stops[j].StopName.Zh_tw}<br/>`;
            }
        }
    }
}
function searchStop() {
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


function regi(){
    console.log(0);
    let id=prompt("使用者ID");
    while(id){                             //id 已被使用
        id=prompt("使用者ID重複");
    }
    if(id){                             //成功取id
        let passwd=prompt("密碼");
        //註冊
    }
}
function logi(){
    console.log(1);
    let id=prompt("使用者ID");
    if(id){                             //id 存在使用者
        let passwd=prompt("密碼");
        if(passwd){                     //password正確
            //登入
        }
    }
}

function showFav(){

}


function indexroute(rid){           //用sql這裡可以刪掉
    for (let i=0;i<stopOfRoutes.length;i++){
        if(rid==stopOfRoutes[i].RouteID){
            return i;
        }
    }
    return null;
}
