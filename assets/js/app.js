function confirmDelete(entity,x){
       
	swal({
		title: "Are you sure?",
		text: "But you will still be able to retrieve this file.",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#2E59D9',
		cancelButtonColor: '#d33',
		confirmButtonText: "Yes, delete it!",
		cancelButtonText: "Cancel",
		closeOnConfirm: false,
		closeOnCancel: false
		},
		function(isConfirm){
		if (isConfirm) {
			window.location.href = entity+"/"+x+"/delete";
		} else {
			swal("Cancelled", "Data tidak terhapus", "error");
		}
		});
}

function confirmDeactivate(redirectUrl){
       
	swal({
		title: "Are you sure?",
		text: "But you will still be able to retrieve this file.",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#2E59D9',
		cancelButtonColor: '#d33',
		confirmButtonText: "Yes, delete it!",
		cancelButtonText: "Cancel",
		closeOnConfirm: false,
		closeOnCancel: false
		},
		function(isConfirm){
		if (isConfirm) {
			window.location.href = redirectUrl;
		} else {
			swal("Cancelled", "Data tidak terhapus", "error");
		}
	});
}

$( document ).ready(function() {
	// $('img').EZView();
});

$(".form_datetime").datetimepicker({
	format: "yyyy-mm-dd hh:ii",
	// linkField: "mirror_field",
	linkFormat: "yyyy-mm-dd hh:ii",
	showMeridian: true,
	autoclose: true,
	todayBtn: true
});
