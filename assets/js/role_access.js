$(document).ready(function() {
    
});

$('.form-check-input').on('click', function() {
    const menu_id = $(this).data('menu');
    const role_id = $(this).data('role');

    $.ajax({
        url: base_url+"administrator/changeAccess",
        type: 'POST',
        data: {
            menu_id: menu_id,
            role_id: role_id
        },
        success: function() {
            document.location.href = base_url + "administrator/roleAccess/" + role_id;
        }
    })
});