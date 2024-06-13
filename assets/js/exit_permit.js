$(document).ready(function() {
    viewData();

    $('#modalAdd').on('hidden.bs.modal', function () {
        $("#inNecessity").val('');
        $("#inRemark").val('');
        $("#inTransaction_id").val('');
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
				$("#dataTable").DataTable({
					columnDefs:[{targets:[7,8,9,10], class:"nowrap-column"}]
				});
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
	var objx = "";

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
					$("#modalUpdate .modal-dialog .modal-content .modal-body #inDate_out").text(data.date_out);
					$("#modalUpdate .modal-dialog .modal-content .modal-body #inTime_out").text(data.time_out);
					$("#modalUpdate .modal-dialog .modal-content .modal-body #inNecessity").text(data.necessity);
					$("#modalUpdate .modal-dialog .modal-content .modal-body #inRemark").text(data.remark);
					modal = data.res;
				}
			}
			else {
				objx = obj.split("|");

				if (objx[0] == "exitPermit") {
					if (objx[1] == "detail") {
						if (data.res == 3) {
							$("#modalDetail .modal-dialog .modal-content .modal-body #inId").text(data.employee_id);
							$("#modalDetail .modal-dialog .modal-content .modal-body #inName").text(data.name);
							$("#modalDetail .modal-dialog .modal-content .modal-body #inDepartment").text(data.department);
							$("#modalDetail .modal-dialog .modal-content .modal-body #inDivision").text(data.division);
							$("#modalDetail .modal-dialog .modal-content .modal-body #inPosition").text(data.position);
							$("#modalDetail .modal-dialog .modal-content .modal-body #inDate_in").text(data.date_in);
							$("#modalDetail .modal-dialog .modal-content .modal-body #inTime_in").text(data.time_in);
							$("#modalDetail .modal-dialog .modal-content .modal-body #inDate_out").text(data.date_out);
							$("#modalDetail .modal-dialog .modal-content .modal-body #inTime_out").text(data.time_out);
							$("#modalDetail .modal-dialog .modal-content .modal-body #inNecessity").text(data.necessity);
							$("#modalDetail .modal-dialog .modal-content .modal-body #inRemark").text(data.remark);
							$("#modalDetail .modal-dialog .modal-content .modal-body #inCreated_by").text(data.created_by);
							$("#modalDetail .modal-dialog .modal-content .modal-body #inCreated_at").text(data.created_at);
							$("#modalDetail .modal-dialog .modal-content .modal-body #inLog_by").text(data.log_by);
							$("#modalDetail .modal-dialog .modal-content .modal-body #inLog_at").text(data.log_at);

							modal = data.res;
						}
					}
					else if (objx[1] == "edit") {
						if (data.res == 4) {
							$("#modalAdd .modal-dialog .modal-content .modal-body #inTransaction_id").val(data.transaction_id);
							$("#modalAdd .modal-dialog .modal-content .modal-body #inId").val(data.employee_id);
							$("#modalAdd .modal-dialog .modal-content .modal-body #inName").val(data.name);
							$("#modalAdd .modal-dialog .modal-content .modal-body #inDepartment").val(data.department);
							$("#modalAdd .modal-dialog .modal-content .modal-body #inDivision").val(data.division);
							$("#modalAdd .modal-dialog .modal-content .modal-body #inPosition").val(data.position);
							$("#modalAdd .modal-dialog .modal-content .modal-body #inDate_out").val(data.date_out);
							$("#modalAdd .modal-dialog .modal-content .modal-body #inTime_out").val(data.time_out);
							$("#modalAdd .modal-dialog .modal-content .modal-body #inNecessity").val(data.necessity_id);
							$("#modalAdd .modal-dialog .modal-content .modal-body #inRemark").val(data.remark);
							modal = data.res;
							necessity_id = data.necessity_id;
						}
					}
				}
			}
		}
	}).done(function(){
		if (modal == 1) {
			$('#modalAdd').modal('show');
			get("inNecessity","");
		} else if (modal == 2) {
			$('#modalUpdate').modal('show');
		} else if (modal == 3) {
			$('#modalDetail').modal('show');
		} else if (modal == 4) {
			$('#modalAdd').modal('show');
			get("inNecessity",necessity_id);
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
					if (obj.trim() != "" && obj == data.res[i].id) {
						html += '<option value="' + data.res[i].id + '" selected>' + data.res[i].necessity + '</option>';	
					}
					else {
						html += '<option value="' + data.res[i].id + '">' + data.res[i].necessity + '</option>';
					}
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
		var inTransaction_id = $(".modal-dialog .modal-content .modal-body #inTransaction_id").val();

		$.ajax({
			type: "POST",
			url: base_url+"hrd/save",
			data: {
				param: param,
				obj: obj,
				inId: inId,
				inNecessity: inNecessity,
				inRemark: inRemark,
				inTransaction_id: inTransaction_id
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
		var employeeId = $("#modalUpdate .modal-dialog .modal-content .modal-body #inId").text();

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
						$('#modalUpdate').modal('toggle');
						check('employeeId',employeeId);
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

function remove(param,obj){
	Swal.fire({
		title: "Delete Data ?",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33"
	}).then((res) => {
		if (res.isConfirmed) {
			$.ajax({
				type: "POST",
				url: base_url+"hrd/remove",
				data: {
					param: param,
					obj: obj
				},
				cache: false,
				dataType: "JSON",
				success: function (data) {
					if (data.res == "success") {
						Swal.fire({
							title: "Data Deleted !",
							icon: "success"
						}).then(function () {
							viewData();
							$("#inId").focus();
						});;
					}
					else {
						Swal.fire({
							title: "Data Error!",
							text: data.res,
							icon: "error"
						})
					}
				}
			})
		}
	  });
}