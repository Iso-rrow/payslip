    function updateDate() {
        const now = new Date();
        const dateElement = document.getElementById('currentDate');

        // Options for formatting the date
        const options = {
            weekday: 'long', // e.g., "Wednesday"
            year: 'numeric', // e.g., "2025"
            month: 'long',   // e.g., "July"
            day: 'numeric'   // e.g., "30"
        };

        // Format the date string
        const formattedDate = now.toLocaleDateString(undefined, options);

        // Update the HTML element
        dateElement.innerHTML = `${formattedDate}`;
    }

    // Call updateDate immediately to display the date on page load
    updateDate();

    // Update the date every second (optional, for real-time display)
    // For date only, updating once a day might be sufficient, but for demonstration,
    // setInterval is used to show real-time capabilities if time were also included.
    // For date only, you might consider updating less frequently if needed.
    // setInterval(updateDate, 1000 * 60 * 60 * 24); // Update once a day