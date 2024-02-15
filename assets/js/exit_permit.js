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

	$('#inNecessity').on('click', function(){
		get("inNecessity","");
	})
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
		success: function (data) {
			if (param == "employeeId")  {
				if (data.res == 0) {
					Swal.fire(
						data.err
					) 
				} else if (data.res == 0) {
					$('#modalAdd').modal('show'); 
				}
			}
		}
	});
}

function get(param,obj) { 
	$.ajax({
		type: "POST",
		url: base_url+"hrd/get",
		data: {
			param: param,
			obj: obj
		},
		dataType: "JSON",
		success: function (data) {
			if (param == "inNecessity") {
				var html = '<option value="">Select</option>';
				var i;

				for (i=0; i<data.res.length; i++) {
					html += '<option value="' + data.res[i].id + '">' + data.res[i].necessity + '</option>';
				}

				$('#inNecessity').html(html);
			}
		}
	});
}