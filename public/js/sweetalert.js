document.addEventListener('DOMContentLoaded', function () {
    const successMessage = document.querySelector('.alert-success');
    if (successMessage) {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: successMessage.innerText,
        });
    }

    const errorMessage = document.querySelector('.alert-error');
    if (errorMessage) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: errorMessage.innerText,
        });
    }
});
