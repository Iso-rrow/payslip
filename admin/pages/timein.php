<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Redirect to login if not authenticated

// Redirect to login if not authenticated
if (!isset($_SESSION['employee_id'])) {
    header('Location: ../authentication/login.php');
    header('Location: ../authentication/login.php');
    exit;
}


?>
<!DOCTYPE html>
<html>


<head>
    <title>Time In</title>
</head>


<body>
    <div style="text-align: center; position: absolute; top: 20%; left: 55%; transform: translate(-50%, -50%);">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>
        <a href="admin?pages=employeedashboard" class="btn btn-success" id="timeInButton" disabled><i
                class="bi bi-person-workspace fs-1 me-1"></i>
            Time in</a>
        <a href="#" class="btn btn-danger " id="timeOutButton" disabled><i class="bi bi-person-walking fs-1 me-1"></i>
            Time out</a>
    </div>


    <!--////////////////////scripts/////////////////////
    <div style="text-align: center; position: absolute; top: 20%; left: 55%; transform: translate(-50%, -50%);">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>
        <a href="admin?pages=employeedashboard" class="btn btn-success" id="timeInButton" disabled><i
                class="bi bi-person-workspace fs-1 me-1"></i>
            Time in</a>
        <a href="#" class="btn btn-danger " id="timeOutButton" disabled><i class="bi bi-person-walking fs-1 me-1"></i>
            Time out</a>
    </div>


    <!--////////////////////scripts/////////////////////
    ///////////////////////////////////////////////-->


    <script>
    const companyLat = 14.234263;
    const companyLon = 121.052018;

    navigator.geolocation.getCurrentPosition(function(position) {
    const userLat = position.coords.latitude;
    const userLon = position.coords.longitude;

    function getDistance(lat1, lon1, lat2, lon2) {
        const R = 6371;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat / 2) ** 2 + Math.cos(lat1 * Math.PI / 180) *
            Math.cos(lat2 * Math.PI / 180) * Math.sin(dLon / 2) ** 2;
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }

    function handleTimeAction(action) {
        if (!navigator.geolocation) {
            alert("Geolocation is not supported by your browser.");
            return;
        }

        navigator.geolocation.getCurrentPosition(
            function(position) {
                const userLat = position.coords.latitude;
                const userLon = position.coords.longitude;

                const distance = getDistance(userLat, userLon, companyLat, companyLon);
                if (distance <= 0.6) {
                    document.getElementById("timeInButton").disabled = false;
                    document.getElementById("timeOutButton").disabled = false;
                } else {
                    alert(`You are ${distance.toFixed(2)} km away from the company.`);
                }
                const distance = getDistance(userLat, userLon, companyLat, companyLon);
                if (distance > 0.6) {
                    alert(`You are too far from the office (${distance.toFixed(2)} km).`);
                    return;
                }

                fetch('/payslip/admin/function_php/timein_action.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        credentials: 'include',
                        body: JSON.stringify({
                            lat: userLat,
                            lon: userLon,
                            action: action
                        })
                    })
                    .then(res => res.text())
                    .then(alert)
                    .catch(err => {
                        console.error(err);
                        alert("Failed to record time.");
                    });
            },
            function(error) {
                alert("Geolocation permission denied or unavailable.");
                console.error(error);
            }
        );
    }

    document.getElementById("timeInButton").addEventListener("click", () => handleTimeAction("in"));
    document.getElementById("timeOutButton").addEventListener("click", () => handleTimeAction("out"));
    const distance = getDistance(userLat, userLon, companyLat, companyLon);
    if (distance <= 0.6) {
        document.getElementById("timeInButton").disabled = false;
        document.getElementById("timeOutButton").disabled = false;
    } else {
        alert(`You are ${distance.toFixed(2)} km away from the company.`);
    }

    document.getElementById("timeInButton").addEventListener("click", function() {
        fetch('/payslip/admin/function_php/timein_action.php', {
            document.getElementById("timeInButton").addEventListener("click", function() {
                fetch('/payslip/admin/function_php/timein_action.php', {


                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    credentials: 'include',
                    body: JSON.stringify({
                        lat: userLat,
                        lon: userLon,
                        action: 'in'
                    })
                }).then(res => res.text()).then(alert);
            });
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            credentials: 'include',
            body: JSON.stringify({
                lat: userLat,
                lon: userLon,
                action: 'in'
            })
        }).then(res => res.text()).then(alert);
    });

    document.getElementById("timeOutButton").addEventListener("click", function() {
        fetch('/payslip/admin/function_php/timein_action.php', {
            document.getElementById("timeOutButton").addEventListener("click", function() {
                fetch('/payslip/admin/function_php/timein_action.php', {


                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    credentials: 'include',
                    body: JSON.stringify({
                        lat: userLat,
                        lon: userLon,
                        action: 'out'
                    })
                }).then(res => res.text()).then(alert);
            });
        });
        method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
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
            function getDistance(lat1, lon1, lat2, lon2) {
                var R = 6371;
                var dLat = (lat2 - lat1) * Math.PI / 180;
                var dLon = (lon2 - lon1) * Math.PI / 180;
                var a = Math.sin(dLat / 2) ** 2 + Math.cos(lat1 * Math.PI / 180) *
                    Math.cos(lat2 * Math.PI / 180) * Math.sin(dLon / 2) ** 2;
                var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                return R * c;
            }
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }
    </script>
</body>


</html>