$(document).ready(function() {
    viewData();

    $('#modalAdd').on('hidden.bs.modal', function () {
        $("#inMenu").val('');
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