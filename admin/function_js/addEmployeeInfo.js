
document.querySelector('#addEmployeeForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerText = 'Saving...';

    fetch('/payslip/admin/function_php/addEmployeeInfo.php', {
        method: 'POST',
        body: formData,
    })
    .then(async response => {
        const text = await response.text();
        let data;

        try {
            data = JSON.parse(text);
        } catch (err) {
            console.error('Server returned non-JSON:', text);
            alert('Server returned invalid response.');
            return;
        }

        if (data.success) {
            let msg = data.message || "Employee added successfully!";
            if (data.mail_error) {
                msg += "\n\nBut the email could not be sent.";
            }
            alert(msg);

            form.reset();

            let modal = bootstrap.Modal.getInstance(document.getElementById('addEmployeeModal'));
            if (modal) modal.hide();

            if (window.dt) {
                window.dt.draw();
            }

        } else {
            let msg = '';
            if (data.errors && Array.isArray(data.errors)) {
                msg = data.errors.join('\n');
            } else if (data.message) {
                msg = data.message;
            } else {
                msg = 'Something went wrong!';
            }
            alert(msg);
        }
    })
    .catch(err => {
        console.error('Fetch/network error:', err);
        alert('Something went wrong! (network or server error)');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerText = 'Save Employee';
    });
});



$(document).ready(function() {
    $('#departmentSelect').on('change', function() {
        const deptId = $(this).val();
        $('#roleSelect').html('<option>Loading...</option>');

        $.ajax({
            url: '/payslip/admin/function_php/fetch_roles.php',
            method: 'POST',
            data: { department_id: deptId },
            success: function(response) {
                $('#roleSelect').html(response);
            },
            error: function() {
                $('#roleSelect').html('<option value="">Error loading roles</option>');
            }
        });
    });
});
