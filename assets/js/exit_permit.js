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

	$("#modalUpdate .modal-dialog .modal-content .modal-footer #btnSave").on('click',function(){
		save('update','exitPermit');
	});
	
	$("#modalUpdate .modal-dialog .modal-content .modal-footer #btnNew").on('click',function(){
		save('new','exitPermit');
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
	var necessity_id = "";

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
						$("#modalAdd .modal-dialog .modal-content .modal-body #inId").val(obj);
						$("#modalAdd .modal-dialog .modal-content .modal-body #inName").val(data.name);
						$("#modalAdd .modal-dialog .modal-content .modal-body #inDepartment").val(data.department);
						$("#modalAdd .modal-dialog .modal-content .modal-body #inDivision").val(data.division);
						$("#modalAdd .modal-dialog .modal-content .modal-body #inPosition").val(data.position);
						modal = data.res;
				}
				else if (data.res == 2) {
					$("#modalUpdate .modal-dialog .modal-content .modal-body #inTransaction_id").val(data.transaction_id);
					$("#modalUpdate .modal-dialog .modal-content .modal-body #inId").text(obj);
					$("#modalUpdate .modal-dialog .modal-content .modal-body #inName").text(data.name);
					$("#modalUpdate .modal-dialog .modal-content .modal-body #inDepartment").text(data.department);
					$("#modalUpdate .modal-dialog .modal-content .modal-body #inDivision").text(data.division);
					$("#modalUpdate .modal-dialog .modal-content .modal-body #inPosition").text(data.position);
					$("#modalUpdate .modal-dialog .modal-content .modal-body #inDate_in").text(data.date_in);
					$("#modalUpdate .modal-dialog .modal-content .modal-body #inTime_in").text(data.time_in);
					$("#modalUpdate .modal-dialog .modal-content .modal-body #inNecessity").text(data.necessity_id);
					$("#modalUpdate .modal-dialog .modal-content .modal-body #inRemark").text(data.remark);
					modal = data.res;
				}
			}
		}
	}).done(function(){
		if (modal == 1) {
			$('#modalAdd').modal('show');
			get("inNecessity","");
		} else if (modal == 2) {
			$('#modalUpdate').modal('show');
		}

		$("#inId").val("");
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
				if (data.res == "success") {
					Swal.fire({
						title: "Data Saved!",
						icon: "success",
						timer: 1000
					}).then(function () {
						$('#modalAdd').modal('toggle');
						viewData();
						$("#inId").focus();
					});
				}
				// console.log(data.res);
			}
		})
	} else if (param == 'update') {
		var inId = $("#modalUpdate .modal-dialog .modal-content .modal-body #inTransaction_id").val();

		$.ajax({
			type: "POST",
			url: base_url+"hrd/save",
			data: {
				param: param,
				obj: obj,
				inId: inId
			},
			cache: false,
			dataType: "JSON",
			success: function (data) {
				if (data.res == "success") {
					Swal.fire({
						title: "Data Saved!",
						icon: "success",
						timer: 1000
					}).then(function () {
						$('#modalUpdate').modal('toggle');
						viewData();
						$("#inId").focus();
					});
				}
				else {
					Swal.fire({
						title: "Data Error!",
						text: data.res,
						icon: "error"
					}).then(function () {
						$('#modalUpdate').modal('toggle');
						viewData();
						$("#inId").focus();
					});
				}
				// console.log(data.res);
			}
		})
	} else if (param == 'new') {
		var inId = $("#modalUpdate .modal-dialog .modal-content .modal-body #inTransaction_id").val();

		$.ajax({
			type: "POST",
			url: base_url+"hrd/save",
			data: {
				param: param,
				obj: obj,
				inId: inId
			},
			cache: false,
			dataType: "JSON",
			success: function (data) {
				if (data.res == "success") {
					Swal.fire({
						title: "Data Saved!",
						icon: "success",
						timer: 1000
					}).then(function () {
						$('#modalUpdate').modal('toggle');
						viewData();
						$("#inId").focus();
					});
				}
				else {
					Swal.fire({
						title: "Data Error!",
						text: data.res,
						icon: "error"
					})
				}
				// console.log(data.res);
			}
		})
	}
}