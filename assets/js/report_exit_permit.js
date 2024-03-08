$(document).ready(function() {
    viewData();

	$('.inSearchcolumn').on('change',function(){
		var rowIndex = $(this).index();
		var searchColumn = $(this).val();

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
	})
});

function viewData() {
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
		
	}

	// console.log(inWhere);
	// return;

	$.ajax({
		type: "POST",
		url: base_url+"report/viewData",
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