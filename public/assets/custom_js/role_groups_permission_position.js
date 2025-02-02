$('.permission').sortable({
    connectWith: '.permission', // Allow permissions to be moved between groups
    axis: 'x y',
    update: function (event, ui) {
        const parentGroup = $(this).closest('.permission_group_position').data('group-name');
        const sortedPermissions = $(this)
            .children()
            .map(function () {
                return $(this).find('input').val();
            })
            .get();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            data: { 'permissions': sortedPermissions, 'group': parentGroup },
            url: siteUrl + '/permissions-position',
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message, "Success message");
                } else {
                    toastr.error(response.message, "Danger message");
                }
            }
        });
    }
});

$('#permission-card').sortable({
    connectWith: '.permission_group_position', // Allow groups to interact
    axis: 'x y',
    update: function (event, ui) {
        const sortedData = $('#permission-card')
            .children()
            .map(function () {
                return $(this).data('group-name');
            })
            .get();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            data: { 'groups': sortedData },
            url: siteUrl + '/groups-position',
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message, "Success message");
                } else {
                    toastr.error(response.message, "Danger message");
                }
            }
        });
    }
});
