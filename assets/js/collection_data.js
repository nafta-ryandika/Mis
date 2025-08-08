$(document).ready(function() {
	$('#inId').on('keypress',function(e) {
		if(e.which == 13) {
			check("inId","");
		}
	});

	$('#modalAdd').on('hidden.bs.modal', function () {
		clear('vote','');
		$("#inId").focus();
		$("#inId").val("");
	})

    // viewData();
});

$(function () {
    $('#inParameter').select2({
		theme: 'bootstrap4'
	})
})

function lock(){
	var inParameter = $("#inParameter").val().trim();

	if (inParameter == "") {
		Swal.fire({
			title: "Input Parameter Empty !",
			icon: "error",
			timer: 1000
		}).then(function () { 
			$("#inParameter").focus();
		});
	} else {
		if ($("#btnLock").text() == "Lock") {
			$("#inParameter").prop("disabled",true);
			$("#btnLock").removeClass('btn-success').addClass('btn-danger');
			$("#btnLock").html("<i class='fas fa-fw fa-solid fa-lock m-1'></i>Unlock");
			$("#inId").focus();	
		} else {
			$("#inParameter").prop("disabled",false);
			$("#btnLock").removeClass('btn-danger').addClass('btn-success');
			$("#btnLock").html("<i class='fas fa-fw fa-solid fa-lock-open m-1'></i>Lock");
		}
	}
}

function check(param,obj) {
	if (param == "inId") {
		var inParameter = $("#inParameter").val();
		var inId = $("#inId").val();
		var num = inId.length;

		if (inParameter == "" || btnLock == "Lock") {
			Swal.fire({
				title: "Please Check Parameter !",
				icon: "error",
				timer: 1000
			}).then(function () { 
				
			});
		} else if (num >= 4) {
			$.ajax({
				type: "POST",
				url: base_url+"fair_trade/check",
				data: {
						param: param,
						obj: inParameter+"|"+inId
				},
				cache: false,
				dataType: "JSON",
				success: function (data) {
					console.log(data.err+"lalala")
					if (data.res == "Success") {
						Swal.fire({
							title: "Thank You!",
							icon: "success",
							timer: 1000
						}).then(function () { 
							$("#inId").val("");
							$("#inId").focus();
						});
					} else if (data.res == "Error") {
						Swal.fire({
							title: data.err,
							icon: "error",
							timer: 1000
						}).then(function () { 
							$("#inId").val("");
							$("#inId").focus();
						});
					}
					else {
						Swal.fire({
							icon: "error",
							timer: 1000
						}).then(function () { 
							$("#inId").val("");
							$("#inId").focus();
						});
					}
				}
			})
		} else {
			return;
		}
	}
}

function viewData() { 
	var inParameter = $("#inParameter").val();
	var btnLock = $("#btnLock").text().trim();

	if (inParameter == "" || btnLock == "Lock") {
		Swal.fire({
			title: "Please Check Setting !",
			icon: "error",
			timer: 1000
		})
	}
	else {
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

		$.ajax({
			type: "POST",
			url: base_url+"fair_trade/viewData",
			data: {
					param: inParameter,
					obj: "",
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
												<option value="dt1.id">ID</option>\n\
												<option value="dt2.Nama_Kry">Name</option>\n\
												<option value="dt2.Ucode_Dept">Department</option>\n\
												<option value="dt2.Ucode_Sec">Section</option>\n\
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
	}
}

function remove(param,obj) {
	if (param == "parameter") {
		$(obj).closest('tr').remove();
	}
}

function get(param,obj,callBack) {
	if (obj == 0) {
		$.ajax({
			type: "POST",
			url: base_url+"fair_trade/get",
			data: {
				param: param,
				obj: obj
			},
			cache: false,
			dataType: "JSON",
			success: function (data) {
				if (param == "dt2.Ucode_Dept") {
					var html = '<select class="form-control inSearchinput" style="width: 100%;">\n\
									<option value="">Select</option>';
					var i;
	
					for (i=0; i<data.res.length; i++) {
						html += '<option value="' + data.res[i].UCode_Dept + '">' + data.res[i].Nama_Dept + '</option>';
					}

					html += "</select>";

					callBack(html);
				}
			}
		});
	} else if (obj == 1) {
		$.ajax({
			type: "POST",
			url: base_url+"fair_trade/get",
			data: {
				param: param,
				obj: obj
			},
			cache: false,
			dataType: "JSON",
			success: function (data) {
				if (param == "dt2.Ucode_Sec") {
					var html = '<select class="form-control inSearchinput" style="width: 100%;">\n\
									<option value="">Select</option>';
					var i;
	
					for (i=0; i<data.res.length; i++) {
						html += '<option value="' + data.res[i].UCode_Sec + '">' + data.res[i].Nama_Sec + '</option>';
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

			if (searchColumn == "dt2.Ucode_Dept") {
				get(searchColumn,"0",function(data){
					$('#tableSearch tr:eq('+rowIndex+') .col-5').html(data);
				})
			} else if (searchColumn == "dt2.Ucode_Sec") {
				get(searchColumn,"1",function(data){
					$('#tableSearch tr:eq('+rowIndex+') .col-5').html(data);
				})
			} else {
				$('#tableSearch tr:eq('+rowIndex+') .inSearchinput').prop('type','text');
			}
		}
	}
}