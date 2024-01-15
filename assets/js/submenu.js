$(document).ready(function() {
    $('#dataTable').DataTable();
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
        }
    }).done(function (){
        $.ajax({
            type: "POST",
            url: base_url+"menu/submenu",
            data:   "mode=edit&inTitle="+inTitle+
                    "&inMenu_id="+inMenu_id+
                    "&inUrl="+inUrl+
                    "&inIcon="+inIcon+
                    "&inStatus="+inStatus,
            // dataType: "dataType",
            cache: false,
            success: function (data) {
                $('#modalAdd').modal('show',function (){
                    // $('#inTitle').val('lalalala');
                });
            }
        });
    });
}