document.querySelector('#kt_sign_in_form').addEventListener('submit', (e) => {
    e.preventDefault();

    // Use e.target to get the form element
    const formData = new FormData(e.target);

    fetch('authentication/login.php', {
        method:'post',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            window.location.href = './admin/index.php'
        }
    })
})