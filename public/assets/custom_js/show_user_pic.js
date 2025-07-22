
$(document).ready(function () {
    $('#user_pic').change(function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#imagePreview').attr('src', e.target.result);
                $('#imageLink').attr('href', e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });
});
