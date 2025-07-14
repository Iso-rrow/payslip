document.querySelector('#kt_sign_in_form').addEventListener('submit', (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);

    fetch('authentication/login.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        console.log('RESPONSE:', data); 

        if (data.success) {
            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                alert("No redirect URL provided by server.");
            }
        } else {
            alert(data.message || "Login failed.");
        }
    })
    .catch(err => {
        console.error("Fetch error:", err);
    });
});
