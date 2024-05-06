$(document).ready(function() {
	$('#inDepartment').on('change',function(){
		var inDepartment = $('#inDepartment').val().trim();
		get("inDivision",inDepartment,"");
	})


	$('#inDepartment').on('click',function(){
		$('#formAdd').validate().resetForm();
	})

	$('#modalAdd #btnSave').on('click',function(){
		save('user','');
	})

    viewData();
});

$(function () {
	$.validator.setDefaults({         
		focusInvalid: false
	});

	function scrollToError(error, validator) {
		var elem = $(validator.errorList[0].element);
		if (elem.length) {
			if (elem.is(':visible'))
				return elem.offset().top - 16;
			elem = elem.prev($(".select2-container"));
			if (elem.length) {
				return elem.offset().top - 16;
			}
		}
		return 0; // scroll to top if all else fails
	}

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
				$("#dataTable").DataTable({
					columnDefs:[{targets:[7,8,9,10], class:"nowrap-column"}]
				});
			})
		}
	});
}

function get(param,obj,callBack) {
	if (obj == 0) {
		if (param == "dt1.status") {
			var html = '<select class="form-control inSearchinput" style="width: 100%;">\n\
							<option value="">Select</option>\n\
							<option value="0">Pending</option>\n\
							<option value="1">Complete</option>\n\
							<option value="2">Uncomplete</option>\n\
						</select>';
			
			callBack(html);
		}
	} else if (obj == 1) {
		$.ajax({
			type: "POST",
			url: base_url+"report/get",
			data: {
				report: 'exitPermit',
				param: param,
				obj: obj
			},
			cache: false,
			dataType: "JSON",
			success: function (data) {
				if (param == "dt1.necessity_id") {
					var html = '<select class="form-control inSearchinput" style="width: 100%;">\n\
									<option value="">Select</option>';
					var i;
	
					for (i=0; i<data.res.length; i++) {
						html += '<option value="' + data.res[i].id + '">' + data.res[i].necessity + '</option>';
					}

					html += "</select>";

					callBack(html);
				}
			}
		});	
	} else {
		if (param == "searchColumn") {
			var rowIndex = $(obj).closest('tr').index();
			var searchColumn = $(obj).val();

			$('#tableSearch tr:eq('+rowIndex+') .col-5').html('<input type="text" class="form-control inSearchinput">');

			if (searchColumn == "dt1.date_in" || searchColumn == "dt1.date_out") {
				$('#tableSearch tr:eq('+rowIndex+') .inSearchinput').prop('type','date');
			} else if (searchColumn == "TIME_FORMAT(dt1.time_in, '%H:%i')" || searchColumn == "TIME_FORMAT(dt1.time_out, '%H:%i')") {
				$('#tableSearch tr:eq('+rowIndex+') .inSearchinput').prop('type','time');
			} else if (searchColumn == "dt1.necessity_id") {
				get(searchColumn,"1",function(data){
					$('#tableSearch tr:eq('+rowIndex+') .col-5').html(data);
				})
			} else if (searchColumn == "dt1.status") {
				get(searchColumn,"0",function(data){
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
							if (obj.trim() != "" && obj == data.res[i].id) {
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
		}
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
		if (obj == "exitPermit") {
			window.open(base_url+'report/report?param='+param+'&obj='+obj+'&where='+encodeURIComponent(inWhere), '_blank');
		}
	}
	else if (param == "excel") {
		if (obj == "exitPermit") {
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
												<option value="dt1.employee_id">Employee ID</option>\n\
												<option value="dt2.name">Name</option>\n\
												<option value="dt4.department">Department</option>\n\
												<option value="dt5.division">Division</option>\n\
												<option value="dt1.date_in">Date IN</option>\n\
												<option value="TIME_FORMAT(dt1.time_in, \'%H:%i\')">Time IN</option>\n\
												<option value="dt1.date_out">Date OUT</option>\n\
												<option value="TIME_FORMAT(dt1.time_out, \'%H:%i\')">Time OUT</option>\n\
												<option value="dt1.necessity_id">Necessity</option>\n\
												<option value="dt1.status">Status</option>\n\
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
		$('#inMode').val('add')
	}
}

function save(param,obj){
	if (param == 'user') {
		var forms = $('#formAdd');
	    
		var validation = Array.prototype.filter.call(forms, function(form) {
			if (form.checkValidity() === false) {
			event.preventDefault();
			event.stopPropagation();
			} else {
				var  inMode = $('#inMode').val();
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

				$.ajax({
					type: "POST",
					url: base_url+"user_management/save",
					data: {
						param: param,
						obj: obj,
						inMode: inMode,
						inId: inId,
						inName: inName,
						inDepartment: inDepartment,
						inDivision: inDivision,
						inRole: inRole,
						inEmail: inEmail,
						inImage: inImage,
						inPassword: inPassword,
						inRepeatpassword: inRepeatpassword,
						inStatus: inStatus 
					},
					cache: false,
					dataType: "JSON",
					beforeSend: function(data) {
						
					},
					success: function (data) {
						console.log('test');	
					}
				});
			}

			form.classList.add('was-validated');
		});
	}
}

function remove(param,obj) {
	if (param == "parameter") {
		$(obj).closest('tr').remove();
	}
}