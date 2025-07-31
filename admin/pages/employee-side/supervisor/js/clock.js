function updateClock() {
  const now = new Date();
  const options = { hour: 'numeric', minute: 'numeric', hour12: true };
  const formattedTime = now.toLocaleTimeString('en-US', options);
  document.getElementById('clock').textContent = formattedTime;
}

// Update the clock immediately and then every second
updateClock();
setInterval(updateClock, 1000);
