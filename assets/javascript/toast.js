import toast from 'toastr';

const successFlashMessage = document.querySelector('#successFlashMessage');
const errorFlashMessage = document.querySelector('#errorFlashMessage');

toast.options = {
    "positionClass": "toast-bottom-right",
    "timeOut": "15000",
    "progressBar": true,
    "closeButton": true,
}

if (successFlashMessage) {
    toast.success(successFlashMessage.textContent)
}
if (errorFlashMessage) {
    toast.error(errorFlashMessage.textContent)
}