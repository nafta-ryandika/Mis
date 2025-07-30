$(document).ready(function() {
    $('#dataTable').DataTable();

    $('#modalAdd').on('hidden.bs.modal', function () {
        $("#inTitle").val('');
        $("#inMenu_id").val('');
        $("#inUrl").val('');
        $("#inIcon").val('');
        $("#inStatus").val('');
    })
});

function getData(id) {
    var inTitle = "";
    var inMenu_id = "";
    var inUrl = "";
    var inIcon = "";
    var inStatus = "";

    $.ajax({
        type: "POST",
        url: base_url+"menu/getData",
        data: {id : id},
        cache: false,
        dataType: "json",
        async: false,
        success: function (data) {
            var i;
			for (i=0; i<data.submenu.length; i++) {
				inTitle = data.submenu[i].title;
				inMenu_id = data.submenu[i].menu_id;
                inUrl = data.submenu[i].url;
				inIcon = data.submenu[i].icon;
				inStatus = data.submenu[i].status;
			}

            $(".modal-dialog .modal-content .modal-body #inTitle").val(inTitle);
            $(".modal-dialog .modal-content .modal-body #inMenu_id").val(inMenu_id);
            $(".modal-dialog .modal-content .modal-body #inUrl").val(inUrl);
            $(".modal-dialog .modal-content .modal-body #inIcon").val(inIcon);
            $(".modal-dialog .modal-content .modal-body #inStatus").val(inStatus);
        }
    }).done(function (){
        $('form').attr('action',  base_url + 'menu/update?'+'update=submenu&id=' + id);
        $('#modalAdd').modal('show');
    });
}