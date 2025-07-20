<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


if (!isset($_SESSION['employee_id'])) {
    header('Location: ../authentication/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Time In</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div style="text-align: center; position: absolute; top: 20%; left: 55%; transform: translate(-50%, -50%);">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?></h2>
    <a href="admin?pages=employeedashboard" class="btn btn-success" id="timeInButton" disabled><i
                class="bi bi-person-workspace fs-1 me-1"></i>
            Time in</a>
    <a href="#" class="btn btn-danger" id="timeOutButton" disabled>
        <i class="bi bi-person-walking fs-1 me-1"></i> Time Out
    </a>
</div>

<script>
const companyLat = 14.234263;
const companyLon = 121.052018;

// Calculate distance between two coordinates using Haversine formula
function getDistance(lat1, lon1, lat2, lon2) {
    const R = 6371;
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = Math.sin(dLat / 2) ** 2 +
        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
        Math.sin(dLon / 2) ** 2;
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c;
}

// Enable buttons based on distance
navigator.geolocation.getCurrentPosition(function(position) {
    const userLat = position.coords.latitude;
    const userLon = position.coords.longitude;
    const distance = getDistance(userLat, userLon, companyLat, companyLon);

    if (distance <= 0.6) {
        document.getElementById("timeInButton").disabled = false;
        document.getElementById("timeOutButton").disabled = false;
    } else {
        alert(`You are ${distance.toFixed(2)} km away from the company.`);
    }

    // Attach event listeners after checking distance
    document.getElementById("timeInButton").addEventListener("click", function () {
        handleTimeAction("in", userLat, userLon);
    });

    document.getElementById("timeOutButton").addEventListener("click", function () {
        handleTimeAction("out", userLat, userLon);
    });

}, function (error) {
    alert("Unable to access location.");
    console.error(error);
});

// Send time-in/time-out data to backend
function handleTimeAction(action, lat, lon) {
    fetch('/payslip/admin/function_php/timein_action.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'include',
        body: JSON.stringify({ lat: lat, lon: lon, action: action })
    })
    .then(res => res.text())
    .then(response => {
        alert(response);
        location.reload();
    })
    .catch(err => {
        console.error(err);
        alert("Failed to record time.");
    });
}
</script>
</body>
</html>
