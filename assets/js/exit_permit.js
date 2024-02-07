$(document).ready(function() {
    viewData();

    $('#modalAdd').on('hidden.bs.modal', function () {
        $("#inMenu").val('');
    })

	$('#inId').on('keypress',function(e){
		if (e.which == 13) {
			check('employeeId',$(this).val().trim());
		}
	});
});

function viewData() {
	$.ajax({
		type: "POST",
		url: base_url+"hrd/viewData",
		cache: false,
		success: function (data) {
			$('#tableArea').html(data);
			$(function () {
				$("#dataTable").DataTable();
			})
		}
	});
}

function viewInput() {
	$.ajax({
		type: "POST",
		url: base_url+"hrd/viewInput",
		cache: false,
		success: function (data) {
			$('#contentArea').html(data);
			// $(function () {
			// 	// $("#dataTable").DataTable();
			// })
		}
	});
}


function check(param,obj){
	$.ajax({
		type: "POST",
		url: base_url+"hrd/check",
		data: {
				param: param,
				obj: obj
			},
		dataType: "JSON",
		success: function (response) {
			
		}
	});
}