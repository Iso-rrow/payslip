<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION['employee_id'])) {
    header('Location: login.html');
    exit;
} 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Time In</title>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['employee_id']; ?></h2>
    <button id="timeInButton" disabled>Time In</button>
    <button id="timeOutButton" disabled>Time Out</button>
    
    
<!--////////////////////scripts/////////////////////
    ///////////////////////////////////////////////-->
     
    <script>
    const companyLat = 14.234263;
    const companyLon = 121.052018;

navigator.geolocation.getCurrentPosition(function(position) {
    const userLat = position.coords.latitude;
    const userLon = position.coords.longitude;

    const distance = getDistance(userLat, userLon, companyLat, companyLon);
    if (distance <= 0.6){
        document.getElementById("timeInButton").disabled = false;
        document.getElementById("timeOutButton").disabled = false;
    } else {
        alert(`You are ${distance.toFixed(2)} km away from the company.`);
    }

    document.getElementById("timeInButton").addEventListener("click", function() {
        fetch('/h_r_3/admin/function_php/timein_action.php', {


            method: 'POST',
            headers: {'Content-Type': 'application/json'},
             credentials: 'include',
            body: JSON.stringify({
                lat: userLat,
                lon: userLon,
                action: 'in'
            })
        }).then(res => res.text()).then(alert);
    });

    document.getElementById("timeOutButton").addEventListener("click", function() {
        fetch('/h_r_3/admin/function_php/timein_action.php', {


            method: 'POST',
            headers: {'Content-Type': 'application/json'},
             credentials: 'include',
            body: JSON.stringify({
                lat: userLat,
                lon: userLon,
                action: 'out'
            })
        }).then(res => res.text()).then(alert);
    });
});

function getDistance(lat1, lon1, lat2, lon2) {
    var R = 6371;
    var dLat = (lat2 - lat1) * Math.PI / 180;
    var dLon = (lon2 - lon1) * Math.PI / 180;
    var a = Math.sin(dLat / 2) ** 2 + Math.cos(lat1 * Math.PI / 180) *
            Math.cos(lat2 * Math.PI / 180) * Math.sin(dLon / 2) ** 2;
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c;
}
    </script>
</body>
</html>
    