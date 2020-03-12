$(".button-upload-dokumen" ).click(function() {
	var statusId = $(this).attr('id');
	var idNomorSurat = $('#penomoran-surat-'+statusId).val();
	var nomorSurat = $('#nomor-surat-'+statusId).val();
	var jenisSurat = $('#jenis-surat-'+statusId).val();
	
	$('#penomoran_surat_id').val(idNomorSurat);
	$('#jenis_surat').val(jenisSurat);
	$('#nomor_surat_lengkap').val(nomorSurat);
	// var statusApprove = $('#status-approve-'+laporanId).val();
	// $.ajax({
	// 	url: baseUrl+'laporan/'+laporanId+'/status/'+statusApprove,
	// 	success: function(response) {
	// 		if(response.status_approve == 1){
	// 			$('#status-approve-'+laporanId).val('0');
	// 			$("#"+statusId+"").html('Approve');
	// 			$("#"+statusId+"").removeClass('btn-danger');
	// 			$("#"+statusId+"").addClass('btn-success');
	// 			$(".status-laporan").remove();
	// 		}else{
	// 			$('#status-approve-'+laporanId).val('1');
	// 			$("#"+statusId+"").html('Reject');
	// 			$("#"+statusId+"").removeClass('btn-success');
	// 			$("#"+statusId+"").addClass('btn-danger');
	// 		}
	// 	}
	// });
});