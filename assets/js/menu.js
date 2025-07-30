$(document).ready(function() {
    $('#dataTable').DataTable();

    $('#modalAdd').on('hidden.bs.modal', function () {
        $("#inMenu").val('');
    })
});

function getData(id,menu) {
    $("#inMenu").val(menu);
    $('form').attr('action',  'menu/update?'+'update=menu&id=' + id);
}