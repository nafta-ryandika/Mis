$(document).ready(function() {
    viewData();

    $('#modalAdd').on('hidden.bs.modal', function () {
        $("#inMenu").val('');
    })

	$('#modalAdd').on('shown.bs.modal', function() {
		$(".modal-dialog .modal-content .modal-body #inNecessity").focus();
	});

	$('#inId').on('keypress',function(e){
		if (e.which == 13) {
			check('employeeId',$(this).val().trim());
		}
	});

	$("#btnSave").on('click',function(){
		save('add','exitPermit');
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
		}
	});
}

function check(param,obj){
	var modal = "";
	$.ajax({
		type: "POST",
		url: base_url+"hrd/check",
		data: {
				param: param,
				obj: obj
			},
		cache: false,
		dataType: "JSON",
		async: false,
		success: function (data) {
			if (param == "employeeId")  {
				if (data.res == 0) {
					Swal.fire(
						data.err
					) 
				} else if (data.res == 1) {
						$(".modal-dialog .modal-content .modal-body #inId").val(obj);
						$(".modal-dialog .modal-content .modal-body #inName").val(data.name);
						$(".modal-dialog .modal-content .modal-body #inDepartment").val(data.department);
						$(".modal-dialog .modal-content .modal-body #inDivision").val(data.division);
						$(".modal-dialog .modal-content .modal-body #inPosition").val(data.position);
						modal = data.res;
				}
			}
		}
	}).done(function(){
		if (modal == 1) {
			$('#modalAdd').modal('show');
			get("inNecessity","");
			// $(".modal-dialog .modal-content .modal-body #inNecessity").focus();
		}

		$("#inId").val("");
	});
}

function get(param,obj) { 
	console.log('test');
	$.ajax({
		type: "POST",
		url: base_url+"hrd/get",
		data: {
			param: param,
			obj: obj
		},
		cache: false,
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

function save(param, obj) {
	if (param == 'add') {
		var inId = $(".modal-dialog .modal-content .modal-body #inId").val();
		var inNecessity = $(".modal-dialog .modal-content .modal-body #inNecessity").val();
		var inRemark = $(".modal-dialog .modal-content .modal-body #inRemark").val();

		$.ajax({
			type: "POST",
			url: base_url+"hrd/save",
			data: {
				param: param,
				obj: obj,
				inId: inId,
				inNecessity: inNecessity,
				inRemark: inRemark
			},
			cache: false,
			dataType: "JSON",
			success: function (data) {
				console.log(data.res);
			}
		})
	}
}