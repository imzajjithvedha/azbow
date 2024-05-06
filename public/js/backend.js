$(document).ready(function() {
    $('.filter-single-dropdown').select2();
});


// Prevent too many clicks
    window.submitForm = function() {
        var form = $(".table-container .create-modal form");

        if(form[0].checkValidity()) {
            $('.table-container .modal form .form-btn').prop('disabled', true);
            form.submit();
        }
        else {
            form[0].reportValidity();
        }
    }

    window.updateForm = function() {
        var form = $(".table-container .edit-modal form");

        if(form[0].checkValidity()) {
            $('.table-container .modal form .form-btn').prop('disabled', true);
            form.submit();
        }
        else {
            form[0].reportValidity();
        }
    }
// Prevent too many clicks


// ck editor
    let editors = [];

    document.querySelectorAll('.editor').forEach(element => {
        ClassicEditor
            .create(element)
            .then(new_editor => {
                editors.push(new_editor);
            })
            .catch(error => {
                console.error(error);
            });
    });
// ck editor