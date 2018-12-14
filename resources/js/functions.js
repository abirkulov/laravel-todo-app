export function clearErrorsOnInput() {
    $(this).removeClass('is-invalid invalid-file');
    $(this).siblings('.invalid-feedback').remove();
}

export function inputErrorsListener() {
    $('.form-control.is-invalid').on('change', clearErrorsOnInput);
    $('.form-control.is-invalid').on('keydown', clearErrorsOnInput);
    $('.invalid-file').on('change', clearErrorsOnInput);
}

export function getDeleteModal(deleteRoute) {
    $('#confirm').off('click');
    $('#confirm').on('click', function () {
        window.location.href = deleteRoute;
    });
}

export function deleteFlashMessage() {
    setTimeout(function() {
        $(".alert").remove();
    }, 5000)
}