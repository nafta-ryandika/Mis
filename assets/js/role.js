$(document).ready(function() {
    $('#dataTable').DataTable();

    $('#modalAdd').on('hidden.bs.modal', function () {
        $("#inRole").val('');
    })
});

function getData(id,role) {
    $("#inRole").val(role);
    $('form').attr('action',  'role/update?'+'update=role&id=' + id);
}