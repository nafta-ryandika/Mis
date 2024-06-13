$(document).ready(function() {
	$('#inVote').on('change',function(){
		var inVote = $('#inVote').val().trim();
		get("inLocation",inVote,"");
	})

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
    $('#inVote').select2({
		theme: 'bootstrap4'
	})
})

function lock(){
	var inVote = $("#inVote").val().trim();
	var inLocation = $("#inLocation").val().trim();

	if (inVote == "") {
		Swal.fire({
			title: "Input Vote Empty !",
			icon: "error",
			timer: 1000
		}).then(function () { 
			$("#inVote").focus();
		});
	} else if (inLocation == "") {
		Swal.fire({
			title: "Input Location Empty !",
			icon: "error",
			timer: 1000
		}).then(function () { 
			$("#inLocation").focus();
		});
	} else {
		if ($("#btnLock").text() == "Lock") {
			$("#inVote").prop("disabled",true);
			$("#inLocation").prop("disabled",true);
			$("#btnLock").removeClass('btn-success').addClass('btn-danger');
			$("#btnLock").html("<i class='fas fa-fw fa-solid fa-lock m-1'></i>Unlock");
			$("#inId").focus();	
		} else {
			$("#inVote").prop("disabled",false);
			$("#inLocation").prop("disabled",false);
			$("#btnLock").removeClass('btn-danger').addClass('btn-success');
			$("#btnLock").html("<i class='fas fa-fw fa-solid fa-lock-open m-1'></i>Lock");
		}

		get("candidate",inVote,"");
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
				$(function () {
					$("#dataTable").DataTable();
				})
			}
		});
	}
}

function get(param,obj,callBack) {
	if (param == "inLocation") {
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
				$('#inLocation').select2({
					theme: 'bootstrap4'
				})
			},
			success: function (data) {
					var html = '<option value="">Select</option>';
					var i;
	
					for (i=0; i<data.res.length; i++) {
						if (callBack.trim() != "" && callBack == data.res[i].id) {
							html += '<option value="' + data.res[i].id + '" selected>' + data.res[i].name + '</option>';	
						}
						else {
							html += '<option value="' + data.res[i].id + '">' + data.res[i].name + '</option>';
						}
					}
	
					$('#inLocation').html(html);
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