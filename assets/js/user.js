$(document).ready(function() {
	$('#inDepartment').on('change',function(){
		var inDepartment = $('#inDepartment').val().trim();
		get("inDivision",inDepartment,"");
	})

	$('#modalAdd #btnSave').on('click',function(){
		save('user','');
	})

	$('#modalAdd #inId').on('keyup',function(){
		check("inId","");
	})

	$('#modalAdd').on('hidden.bs.modal', function () {
		clear('user','');
		viewData();
	})

	$("#inRepeatpassword").on("keyup",function(){
		var inPassword = $("#inPassword").val();
		var inRepeatpassword = $("#inRepeatpassword").val();

		if (inPassword == inRepeatpassword) {
			$("#inPassword").removeClass("is-invalid");
			$("#inRepeatpassword").removeClass("is-invalid");
		}
	})

    viewData();
});

$(function () {
    $('#inDepartment').select2({
		dropdownParent: $('#modalAdd'),
		theme: 'bootstrap4'
	})
})

function viewData() {
	var rowTable = $('#tableSearch tr').length;
	var inWhere = "";
	var inSearchcolumn = "";
	var inSearchparameter = "";
	var inSearchinput = "";

	if (rowTable == 1) {
		inSearchcolumn = $('.inSearchcolumn').val();
		inSearchparameter = $('.inSearchparameter').val();
		inSearchinput = $('.inSearchinput').val();

		if (inSearchcolumn.trim() != "" && inSearchinput.trim() != "") {
			if (inSearchparameter == "=") {
				inWhere = " AND " + inSearchcolumn + " " + inSearchparameter + " " +"'" + inSearchinput + "'"; 
			} else if (inSearchparameter == "like") {
				inWhere = " AND " + inSearchcolumn + " " + inSearchparameter + " " +"'%" + inSearchinput.replace(" ","%") + "%'";
			}
		}
	}
	else if (rowTable > 1) {
		var inWhere = "";
		var inSearchcolumn = "";
		var inSearchparameter = "";
		var inSearchinput = "";
		var xSearchcolumn = [];
		var xSearchparameter = [];
		var xSearchinput = [];

		$('.inSearchcolumn').each(function(){ 
			xSearchcolumn.push($(this).val());
		});
		
		$('.inSearchparameter').each(function(){ 
			xSearchparameter.push($(this).val());
		});

		$('.inSearchinput').each(function(){ 
			xSearchinput.push($(this).val());
		});

		for (var i = 0; i < xSearchcolumn.length; i++) {
			inSearchcolumn = xSearchcolumn[i];
			inSearchparameter = xSearchparameter[i];
			inSearchinput = xSearchinput[i];

			if (inSearchcolumn.trim() != "" && inSearchinput.trim() != "") {
				if (inSearchparameter == "=") {
					inWhere += " AND " + inSearchcolumn + " " + inSearchparameter + " " +"'" + inSearchinput + "'"; 
				} else if (inSearchparameter == "like") {
					inWhere += " AND " + inSearchcolumn + " " + inSearchparameter + " " +"'%" + inSearchinput.replace(" ","%") + "%'";
				}
			}
		}
	}

	// console.log("test" + inWhere);
	// return;

	$.ajax({
		type: "POST",
		url: base_url+"user_management/viewData",
		data: {
				inWhere: inWhere
			},
		cache: false,
		success: function (data) {
			$('#tableArea').html(data);
			$(function () {
				$("#dataTable").DataTable();
			})
		}
	});
}

function get(param,obj,callBack) {
	if (param == "edit") {
		$.ajax({
			type: "POST",
			url: base_url+"user_management/get",
			data: {
				param: param,
				obj: obj
			},
			cache: false,
			dataType: "JSON",
			success: function (data) {
				var user_data = data.res;

				$('#modalAdd').modal('show').after(function (data) {
					$('#inMode').val('edit');
					get("inDepartment",user_data.department_id,"");
					get("inDivision",user_data.department_id,user_data.division_id);
					get("inRole",user_data.role_id,"");
					$("#inIdx").val(user_data.id);
					$("#inId").val(user_data.user_id);
					$("#inName").val(user_data.name);	
					$("#inEmail").val(user_data.email);	

					$("#inPassword").closest("div").parent("div").hide();
					$("#inRepeatpassword").closest("div").parent("div").hide();
					$("#inStatus").val(user_data.status);
				})
			}
		})
	} else if (param == "searchColumn") {
			var rowIndex = $(obj).closest('tr').index();
			var searchColumn = $(obj).val();

			$('#tableSearch tr:eq('+rowIndex+') .col-5').html('<input type="text" class="form-control inSearchinput">');

			if (searchColumn == "dt1.department_id") {
				get("searchColumn"+searchColumn,"",function(data){
					$('#tableSearch tr:eq('+rowIndex+') .col-5').html(data);
				})
			} else if (searchColumn == "dt1.role_id") {
				get("searchColumn"+searchColumn,"",function(data){
					$('#tableSearch tr:eq('+rowIndex+') .col-5').html(data);
				})
			} else if (searchColumn == "status") {
				get("searchColumn"+searchColumn,"",function(data){
					$('#tableSearch tr:eq('+rowIndex+') .col-5').html(data);
				})
			} else {
				$('#tableSearch tr:eq('+rowIndex+') .inSearchinput').prop('type','text');
			}
	} else if (param == "inDepartment") {
		$.ajax({
			type: "POST",
			url: base_url+"user_management/get",
			data: {
				param: param,
				obj: obj
			},
			cache: false,
			dataType: "JSON",
			success: function (data) {
					var html = '<option value="">Select</option>';
					var i;
	
					for (i=0; i<data.res.length; i++) {
						if (obj.trim() != "" && obj == data.res[i].id) {
							html += '<option value="' + data.res[i].id + '" selected>' + data.res[i].department + '</option>';	
						}
						else {
							html += '<option value="' + data.res[i].id + '">' + data.res[i].department + '</option>';
						}
					}
	
					$('#inDepartment').html(html);
			}
		});
	} else if (param == "inDivision") {
		$.ajax({
			type: "POST",
			url: base_url+"user_management/get",
			data: {
				param: param,
				obj: obj
			},
			cache: false,
			dataType: "JSON",
			beforeSend: function(data) {
				$('#inDivision').select2({
					dropdownParent: $('#modalAdd'),
					theme: 'bootstrap4'
				})
			},
			success: function (data) {
					var html = '<option value="">Select</option>';
					var i;
	
					for (i=0; i<data.res.length; i++) {
						if (callBack.trim() != "" && callBack == data.res[i].id) {
							html += '<option value="' + data.res[i].id + '" selected>' + data.res[i].division + '</option>';	
						}
						else {
							html += '<option value="' + data.res[i].id + '">' + data.res[i].division + '</option>';
						}
					}
	
					$('#inDivision').html(html);
			}
		});
	} else if (param == "inRole") {
		$.ajax({
			type: "POST",
			url: base_url+"user_management/get",
			data: {
				param: param,
				obj: obj
			},
			cache: false,
			dataType: "JSON",
			beforeSend: function(data) {
				$('#inDivision').select2({
					dropdownParent: $('#modalAdd'),
					theme: 'bootstrap4'
				})
			},
			success: function (data) {
					var html = '<option value="">Select</option>';
					var i;
	
					for (i=0; i<data.res.length; i++) {
						if (obj.trim() != "" && obj == data.res[i].id) {
							html += '<option value="' + data.res[i].id + '" selected>' + data.res[i].role + '</option>';	
						}
						else {
							html += '<option value="' + data.res[i].id + '">' + data.res[i].role + '</option>';
						}
					}
	
					$('#inRole').html(html);
			}
		});
	} else if (param == "detail") {
		$.ajax({
			type: "POST",
			url: base_url+"user_management/get",
			data: {
				param: param,
				obj: obj
			},
			cache: false,
			dataType: "JSON",
			success: function (data) {
				var user_data = data.res;

				$('#modalDetail').modal('show').after(function (data) {
					$("#modalDetail .modal-dialog .modal-content .modal-body #inId").text(user_data.user_id);
					$("#modalDetail .modal-dialog .modal-content .modal-body #inName").text(user_data.name);
					$("#modalDetail .modal-dialog .modal-content .modal-body #inDepartment").text(user_data.department);
					$("#modalDetail .modal-dialog .modal-content .modal-body #inDivision").text(user_data.division);
					$("#modalDetail .modal-dialog .modal-content .modal-body #inRole").text(user_data.role);
					$("#modalDetail .modal-dialog .modal-content .modal-body #inEmail").text(user_data.email);
					$("#modalDetail .modal-dialog .modal-content .modal-body #inImage").attr("src",base_url+"assets/img/profile/"+user_data.image);
					$("#modalDetail .modal-dialog .modal-content .modal-body #inStatus").text(user_data.status);
					$("#modalDetail .modal-dialog .modal-content .modal-body #inCreated_by").text(user_data.created_by);
					$("#modalDetail .modal-dialog .modal-content .modal-body #inCreated_at").text(user_data.created_at);
					
					// get("inDepartment",user_data.department_id,"");
					// get("inDivision",user_data.department_id,user_data.division_id);
					// get("inRole",user_data.role_id,"");
					// $("#inIdx").val(user_data.id);
					// $("#inId").val(user_data.user_id);
					// $("#inName").val(user_data.name);	

					// $("#inPassword").closest("div").parent("div").hide();
					// $("#inRepeatpassword").closest("div").parent("div").hide();
					// $("#inStatus").val(user_data.status);
				})
			}
		})
	} else if (param == "searchColumnstatus") {
		var html = '<select class="form-control inSearchinput" style="width: 100%;">\n\
						<option value="">Select</option>\n\
						<option value="0">Not Active</option>\n\
						<option value="1">Active</option>\n\
					</select>';
		
		callBack(html);
	} else if (param == "searchColumndt1.department_id") {
		$.ajax({
			type: "POST",
			url: base_url+"user_management/get",
			data: {
				param: "inDepartment",
				obj: obj
			},
			cache: false,
			dataType: "JSON",
			success: function (data) {
					var html = '<select class="form-control inSearchinput" style="width: 100%;">\n\
									<option value="">Select</option>';
					var i;
	
					for (i=0; i<data.res.length; i++) {
						html += '<option value="' + data.res[i].id + '">' + data.res[i].department + '</option>';
					}

					html += '</select>';

					callBack(html);
			}
		});
	} else if (param == "searchColumndt1role_id") {
		$.ajax({
			type: "POST",
			url: base_url+"user_management/get",
			data: {
				param: "inRole",
				obj: obj
			},
			cache: false,
			dataType: "JSON",
			beforeSend: function(data) {
				$('#inDivision').select2({
					dropdownParent: $('#modalAdd'),
					theme: 'bootstrap4'
				})
			},
			success: function (data) {
					var html = '<select class="form-control inSearchinput" style="width: 100%;">\n\
									<option value="">Select</option>';
					var i;

					for (i=0; i<data.res.length; i++) {
						html += '<option value="' + data.res[i].id + '">' + data.res[i].role + '</option>';
					}

					html += '</select>';

					callBack(html);
			}
		});
	} 
}

function report(param,obj){
	var rowTable = $('#tableSearch tr').length;
	var inWhere = "";

	if (rowTable == 1) {
		var inSearchcolumn = $('.inSearchcolumn').val();
		var inSearchparameter = $('.inSearchparameter').val();
		var inSearchinput = $('.inSearchinput').val();

		if (inSearchcolumn.trim() != "" && inSearchinput.trim() != "") {
			if (inSearchparameter == "=") {
				inWhere = "AND " + inSearchcolumn + " " + inSearchparameter + " " +"'" + inSearchinput + "'"; 
			} else if (inSearchparameter == "like") {
				inWhere = "AND " + inSearchcolumn + " " + inSearchparameter + " " +"'%" + inSearchinput.replace(" ","%") + "%'";
			}
		}
	}
	else if (rowTable > 1) {
		var inWhere = "";
		var inSearchcolumn = "";
		var inSearchparameter = "";
		var inSearchinput = "";
		var xSearchcolumn = [];
		var xSearchparameter = [];
		var xSearchinput = [];

		$('.inSearchcolumn').each(function(){ 
			xSearchcolumn.push($(this).val());
		});
		
		$('.inSearchparameter').each(function(){ 
			xSearchparameter.push($(this).val());
		});

		$('.inSearchinput').each(function(){ 
			xSearchinput.push($(this).val());
		});

		for (var i = 0; i < xSearchcolumn.length; i++) {
			inSearchcolumn = xSearchcolumn[i];
			inSearchparameter = xSearchparameter[i];
			inSearchinput = xSearchinput[i];

			if (inSearchcolumn.trim() != "" && inSearchinput.trim() != "") {
				if (inSearchparameter == "=") {
					inWhere += " AND " + inSearchcolumn + " " + inSearchparameter + " " +"'" + inSearchinput + "'"; 
				} else if (inSearchparameter == "like") {
					inWhere += " AND " + inSearchcolumn + " " + inSearchparameter + " " +"'%" + inSearchinput.replace(" ","%") + "%'";
				}
			}
		}
	}

	if (param == "pdf") {
		if (obj == "user") {
			window.open(base_url+'report/user_management?param='+param+'&obj='+obj+'&where='+encodeURIComponent(inWhere), '_blank');
		}
	}
	else if (param == "excel") {
		if (obj == "user") {
			window.open(base_url+'report/report?param='+param+'&obj='+obj+'&where='+encodeURIComponent(inWhere), '_blank');
		}
	}
}

function add(param,obj){
	if (param == "parameter") {
		var html = '<tr>\n\
						<td>\n\
							<div class="row col-12">\n\
								<div class="col-8 m-2">\n\
									<div class="form-group row">\n\
										<div class="col-3">\n\
											<select class="form-control inSearchcolumn" style="width: 100%;" onchange="get(\'searchColumn\',this,\'\')">\n\
												<option value="">Parameter</option>\n\
												<option value="user_id">ID</option>\n\
												<option value="name">Name</option>\n\
												<option value="dt1.department_id">Department</option>\n\
												<option value="dt3.division">Division</option>\n\
												<option value="dt1.role_id">Role</option>\n\
												<option value="email">Email</option>\n\
												<option value="status">Status</option>\n\
											</select>\n\
										</div>\n\
										<div class="col-2">\n\
											<select class="form-control inSearchparameter" style="width: 100%;">\n\
												<option value="=">Equal</option>\n\
												<option value="like">Like</option>\n\
											</select>\n\
										</div>\n\
										<div class="col-5">\n\
											<input type="text" class="form-control inSearchinput">\n\
										</div>\n\
										<div class="col-2">\n\
											<a class="btn btn-danger" id="btnRemove" title="Remove" onclick="remove(\'parameter\',this)"><i class="fas fa-fw fa-solid fa-square-xmark m-1"></i></a>\n\
										</div>\n\
									</div>\n\
								</div>\n\
							</div>\n\
						</td>\n\
					<tr/>';

		$('#tableSearch tr:last').after(html);
	} else if (param == "add") {
		$('#modalAdd').modal('show');
		get("inDepartment","inDepartment","");
		get("inRole","inRole","");
		$('#inMode').val('add');
	}
}

function save(param,obj){
	if (param == 'user') {
		var forms = $('#formAdd');
		var  inMode = $('#inMode').val();
		var  inIdx = $('#inIdx').val();
		var  inId = $('#inId').val();
		var  inName = $('#inName').val();
		var  inDepartment = $('#inDepartment').val();
		var  inDivision = $('#inDivision').val();
		var  inRole = $('#inRole').val();
		var  inEmail = $('#inEmail').val();
		var  inImage = $('#inImage').val();
		var  inPassword = $('#inPassword').val();
		var  inRepeatpassword = $('#inRepeatpassword').val();
		var  inStatus = $('#inStatus').val();

		if (inMode == "edit") {
			$("#modalAdd #inPassword").prop("required",false);
			$("#modalAdd #inRepeatpassword").prop("required",false);
		} else {
			$("#modalAdd #inPassword").prop("required",true);
			$("#modalAdd #inRepeatpassword").prop("required",true);
		}
	    
		var validation = Array.prototype.filter.call(forms, function(form) {
			if (form.checkValidity() === false) {
			event.preventDefault();
			event.stopPropagation();
			} else {
				if ($(".is-invalid").length > 0) {
					Swal.fire({
						title: "Error !",
						icon: "error",
						timer: 1000
					})
					return;
				} else if (inPassword != inRepeatpassword) {
					$("#formAdd").removeClass("was-validated");
					$("#inPassword").addClass("is-invalid");
					$("#inRepeatpassword").addClass("is-invalid");
					return;
				} else {
					$.ajax({
						type: "POST",
						url: base_url+"user_management/save",
						data: {
							param: param,
							obj: obj,
							inMode: inMode,
							inIdx: inIdx,
							inId: inId,
							inName: inName,
							inDepartment: inDepartment,
							inDivision: inDivision,
							inRole: inRole,
							inEmail: inEmail,
							inImage: inImage,
							inPassword: inPassword,
							inStatus: inStatus 
						},
						cache: false,
						dataType: "JSON",
						success: function (data) {
							if (data.res == 'success') {
								Swal.fire({
									title: "Data Saved!",
									icon: "success",
									timer: 1000
								}).then(function () { 
									if (inMode == "add") {
										clear('user','');
										$("#inId").focus();	
									} else if (inMode == "edit") {
										clear('user','add');
										$('#modalAdd').modal('toggle');
										viewData();
									}
								});
							} else if (date.err == '') {
								console.log(data.err);
							} 
						}
					});
				}
			}

			form.classList.add('was-validated');
		});
	}
}

function clear(param,obj) {
	// console.log("test");
	if (param == "user") {
		$('#inId').val("");
		$('#inName').val("");

		if (obj == "add") {
			$('#inMode').val('add');
		} else {
			$('#inMode').val("");
		}
		
		$('#inDepartment').val("");
		$('#inDivision').val("");
		$('#inRole').val("");
		$('#inEmail').val("");
		$('#inImage').val("");
		$('#inPassword').val("");
		$('#inRepeatpassword').val("");
		$('#inStatus').val("");

		$("#formAdd").removeClass("was-validated");
		$("input").removeClass("is-invalid");

		get("inDepartment","inDepartment","");
		get("inRole","inRole","");

		$("#inPassword").closest("div").parent("div").show();
		$("#inRepeatpassword").closest("div").parent("div").show();

		$("#modalAdd #inPassword").prop("required",true);
		$("#modalAdd #inRepeatpassword").prop("required",true);
	}
}

function remove(param,obj) {
	if (param == "parameter") {
		$(obj).closest('tr').remove();
	} else if (param == "data") {
		const swalWithBootstrapButtons = Swal.mixin({
			customClass: {
				confirmButton: "btn btn-lg btn-success m-3",
				cancelButton: "btn btn-lg btn-danger m-3"
			},
			buttonsStyling: false
		});

		swalWithBootstrapButtons.fire({
			title: "Are you sure?",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "Yes",
			cancelButtonText: "No",
			reverseButtons: true
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					type: "POST",
					url: base_url+"user_management/remove",
					data: {
						param: param,
						obj: obj
					},
					cache: false,
					dataType: "JSON",
					success: function (data) {
						if (data.res == 'success') {
							swalWithBootstrapButtons.fire({
								title: "Deleted!",
								icon: "success"
							}).then(function () { 
								viewData();
							});
						} else if (date.err == '') {
							console.log(data.err);
						} 
					}
				});
			} else if (
				result.dismiss === Swal.DismissReason.cancel
			) {
				swalWithBootstrapButtons.fire({
					title: "Cancelled",
					icon: "error"
				});
			}
		});
	}
	else if (param == "password") {
		const swalWithBootstrapButtons = Swal.mixin({
			customClass: {
				confirmButton: "btn btn-lg btn-success m-3",
				cancelButton: "btn btn-lg btn-danger m-3"
			},
			buttonsStyling: false
		});

		swalWithBootstrapButtons.fire({
			title: "Are you sure?",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "Yes",
			cancelButtonText: "No",
			reverseButtons: true
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					type: "POST",
					url: base_url+"user_management/remove",
					data: {
						param: param,
						obj: obj
					},
					cache: false,
					dataType: "JSON",
					success: function (data) {
						if (data.res == 'success') {
							swalWithBootstrapButtons.fire({
								title: "Reset!",
								text: "New Password : " + data.password,
								icon: "success"
							}).then(function () { 
								viewData();
							});
						} else if (date.err == '') {
							console.log(data.err);
						} 
					}
				});
			} else if (
				result.dismiss === Swal.DismissReason.cancel
			) {
				swalWithBootstrapButtons.fire({
					title: "Cancelled",
					icon: "error"
				});
			}
		});
	}
}

function check(param,obj) {
	if (param == "inId") {
		var inId = $("#"+param).val();
		var num = inId.length;
		
		if (num >= 4) {
			$.ajax({
				type: "POST",
				url: base_url+"user_management/check",
				data: {
						param: param,
						obj: inId
				},
				cache: false,
				dataType: "JSON",
				success: function (data) {
					if (data.res > 0) {
						$("#inId").addClass("is-invalid");
					}
					else {
						$("#inId").removeClass("is-invalid");
					}
				}
			})
		} else {
			return;
		}
	}
}