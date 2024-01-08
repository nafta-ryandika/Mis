$(document).ready(function() {
    $('#dataTable').DataTable();
});

function getData(id,menu) {
    $("#inMenu").val(menu);
    $('form').attr('action',  'menu/update?'+'update=menu&id=' + id);
}