$(document).ready(function() { 
	$('#btnPreview').on('click',function(){
		var inFile = $('#inFile1')[0].files[0];
    	var inAuditaction = $('#inAuditaction').val();

		if (!inAuditaction) {
			Swal.fire({
				title: "Input Parameter Empty !",
				icon: "error",
				timer: 1000
			})
			return;
		} else if (!inFile) {
			Swal.fire({
				title: "Input File Empty !",
				icon: "error",
				timer: 1000
			})
			return;
		} else {
			$('#uploadForm').submit(function(e){
				e.preventDefault();

				var formData = new FormData(this);
				formData.append('file', inFile);
				formData.append('inAuditaction', inAuditaction);

				$.ajax({
					url: base_url+'audit/previewData',
					type: 'POST',
					data: formData,
					contentType: false,
					processData: false,
					success: function (data) {
							$('.viewArea').show(function(){
								$('#tableArea').html(data);
								$(function () {
									$("#dataTable").DataTable();
								})
							})
					},
					error: function (xhr, status, error) {
						Swal.fire({
							title: data.err,
							icon: "error",
							timer: 1000
						})
					}
				});
			})
		}
	})

	$('#btnUpload').on('click',function(){
		var inFile = $('#inFile1')[0].files[0];
    	var inAuditaction = $('#inAuditaction').val();

		if (!inAuditaction) {
			Swal.fire({
				title: "Input Parameter Empty !",
				icon: "error",
				timer: 1000
			})
			return;
		} else if (!inFile) {
			Swal.fire({
				title: "Input File Empty !",
				icon: "error",
				timer: 1000
			})
			return;
		} else {
			$('#uploadForm').submit(function(e){
				e.preventDefault();

				var formData = new FormData(this);
				formData.append('file', inFile);
				formData.append('inAuditaction', inAuditaction);

				$.ajax({
					url: base_url+'audit/uploadData',
					type: 'POST',
					data: formData,
					contentType: false,
					processData: false,
					success: function (data) {
						Swal.fire({
							title: "Thank You!",
							icon: "success",
							timer: 1000
						});
					},
					error: function (xhr, status, error) {
						Swal.fire({
							title: data.err,
							icon: "error",
							timer: 1000
						})
					}
				});
			})
		}
	})

	$('#btnSync').on('click',function(){
		var inAuditaction = $('#inAuditaction').val();

		$.ajax({
			type: "POST",
			url: base_url+'audit/sync',
			data: {inAuditaction : inAuditaction},
			dataType: "JSON",
			success: function (data) {
				if (data.res == "success") {
					Swal.fire({
						title: "Sync Completed",
						icon: "success",
						timer: 1000
					});
				} else {
					Swal.fire({
						title: data.err,
						icon: "error",
						timer: 1000
					})
				}
			}
		});
	})

	$('#btnTemplate').on('click',function(){
		var inAuditaction = $('#inAuditaction').val();

		if (inAuditaction == "2") {
			// window.open(base_url+'audit/template?param='+inAuditaction, '_blank');
			window.open(base_url+'report/report?param='+inAuditaction+'&obj='+inAuditaction+'&where='+encodeURIComponent(inAuditaction), '_blank');
		}
	})
});

$(function () {
    $('#inAuditaction').select2({
		theme: 'bootstrap4'
	})
})


function set(param,obj){
	if (param.id == 'inAuditaction') {
		var inAuditaction = $('#'+param.id).val();

		if (inAuditaction == 1 || inAuditaction == 2) {
			$('.formArea').hide();
			$('#form1').show();
		} else if (inAuditaction == 3) {
			$('.formArea').hide();
			$('#form2').show();
		}

		$('.viewArea').hide();
	}

	var inAuditaction = $("#inAuditaction").val().trim();

	if (inAuditaction == "") {
		Swal.fire({
			title: "Input Action Empty !",
			icon: "error",
			timer: 1000
		}).then(function () { 
			$("#inAuditaction").focus();
		});
	} else {
		var html = "";
		if (inAuditaction == 1) {
// 			html = "<form id='uploadForm' enctype='multipart/form-data' class='form-inline text-center margin-top'>\n\
// 						<div class='input-group mb-3'>\n\
//   <div class='input-group-prepend'>\n\
//     <span class='input-group-text' id='inputGroupFileAddon01'>Upload</span>\n\
//   </div>\n\
//   <div class='custom-file'>\n\
//     <input type='file' class='custom-file-input' id='inputGroupFile01' aria-describedby='inputGroupFileAddon01'>\n\
//     <label class='custom-file-label' for='inputGroupFile01'>Choose file</label>\n\
//   </div>\n\
// </div>\n\
// 						<button type='submit' class='btn btn-primary m-2'>Preview</button>\n\
// 					</form>";

// 				// 	<div class='form-group row'>\n\
// 				// 	<div class='col-4'>\n\
// 				// 	<input type='file' class='form-control' name='file' id='file' accept='.xls,.xlsx' required>\n\
// 				// 	</div>\n\
// 				// </div>\n\

			
		}

		// $('#inputArea').html(html);
	}
}

function check(param,obj) {
	if (param == "inId") {
		var inVote = $("#inVote").val().trim();
		var inLocation = $("#inLocation").val().trim();
		var btnLock = $("#btnLock").text().trim();

		if (inVote == "" || inLocation == "" || btnLock == "Lock") {
			Swal.fire({
				title: "Please Check Setting !",
				icon: "error",
				timer: 1000
			}).then(function () { 
				
			});
		} else {
			var inId = $("#inId").val();
			var num = inId.length;

			if (num >= 4) {
				$.ajax({
					type: "POST",
					url: base_url+"vote/check",
					data: {
							param: param,
							obj: inId+"|"+inVote+"|"+inLocation
					},
					cache: false,
					dataType: "JSON",
					success: function (data) {
						if (data.res == 0) {
							Swal.fire({
								title: data.err,
								icon: "error",
								timer: 1000
							}).then(function () { 
								$("#inId").val("");
							});
						} else {
							$('#modalAdd').modal('show').after(function () {
								$("#modalAdd #txtId").text(data.id);
								$("#modalAdd #txtName").text(data.name);
								$("#modalAdd #txtDepartment").text(data.department_id);
								$("#modalAdd #txtDivision").text(data.division_id);
								$("#modalAdd #txtPosition").text(data.position_id);
							})
						}
					}
				})
			} else {
				return;
			}
		}
	}
}

function viewData() { 
	var inVote = $("#inVote").val().trim();
	var inLocation = $("#inLocation").val().trim();
	var btnLock = $("#btnLock").text().trim();

	if (inVote == "" || inLocation == "" || btnLock == "Lock") {
		Swal.fire({
			title: "Please Check Setting !",
			icon: "error",
			timer: 1000
		}).then(function () { 
			
		});
	}
	else {
		$.ajax({
			type: "POST",
			url: base_url+"vote/viewData",
			data: {
					param: inVote,
					obj: ""
				},
			cache: false,
			success: function (data) {
				$('#tableArea').html(data);
			},
			complete: function (data) {
				$(function () {
					$("#dataTable").DataTable();
				})
			}
		});
	}
}

function get(param,obj,callBack) {
	if (param == "inFromtransaction") {
		$.ajax({
			type: "POST",
			url: base_url+"audit/get",
			data: {
				param: param,
				obj: obj
			},
			cache: false,
			dataType: "JSON",
			beforeSend: function(data) {
				$('#inFromtransaction').select2({
					theme: 'bootstrap4'
				})
			},
			success: function (data) {
					var html = '<option value="">Select</option>';
					var i;
	
					for (i=0; i<data.res.length; i++) {
						if (callBack.trim() != "" && callBack == data.res[i].id) {
							html += '<option value="' + data.res[i].id + '" selected>' + data.res[i].transaction + '</option>';	
						}
						else {
							html += '<option value="' + data.res[i].id + '">' + data.res[i].ntransaction + '</option>';
						}
					}
	
					$('#inFromtransaction').html(html);
			}
		});
	}
	else if (param == "candidate") {
		$.ajax({
			type: "POST",
			url: base_url+"vote/get",
			data: {
				param: param,
				obj: obj
			},
			cache: false,
			dataType: "JSON",
			beforeSend: function(data) {
			},
			success: function (data) {
					var html = '';
					var i;
	
					for (i=0; i<data.res.length; i++) {
							html += '<div class="card-deck m-0 text-center col-sm-3">\n\
										<div class="card mb-4 shadow-sm">\n\
											<div class="card-header">\n\
												<h4 class="my-0 font-weight-normal">' + data.res[i].no + '</h4>\n\
											</div>\n\
											<div class="card-body">\n\
												<img src="'+ base_url + data.res[i].image +'" class="img-thumbnail" alt="...">\n\
												<h4  class="card-title pricing-card-title">' + data.res[i].remark + '</h4>\n\
												<button type="button" class="btn btn-lg btn-block btn-outline-success" onclick="save(\'vote\',\''+data.res[i].id+'\')">Vote</button>\n\
											</div>\n\
										</div>\n\
									</div>';
					}
	
					$('#viewCandidate').html(html);
			}
		});
	}
}

function save(param,obj){
	if (param == 'vote') {
		var  employee_id = $('#txtId').text();
		var  vote_id = $("#inVote").val(); 
		var  location_id = $("#inLocation").val(); 
		var  vote_candidate_id = obj;
		
		$.ajax({
			type: "POST",
			url: base_url+"vote/save",
			data: {
				param: param,
				obj: employee_id + "|" + vote_id + "|" + vote_candidate_id + "|" + location_id
			},
			cache: false,
			dataType: "JSON",
			success: function (data) {
				if (data.res == 'success') {
					Swal.fire({
						title: "Thank You!",
						icon: "success",
						timer: 1000
					}).then(function () { 
						$('#modalAdd').modal('toggle', function () {
							setTimeout(function(){
								$('#inId').focus();
							},100);
							clear('vote','');
						})
					});
				} else if (date.err == '') {
					console.log(data.err);
				} 
			},
			complete: function(data){
				// $("#inId").val("");
				// $("#inId").focus();
			}
		});
	}
}

function clear(param,obj) {
	if (param == "vote") {
		$("#modalAdd #txtId").text("");
		$("#modalAdd #txtName").text("");
		$("#modalAdd #txtDepartment").text("");
		$("#modalAdd #txtDivision").text("");
		$("#modalAdd #txtPosition").text("");
	}
}