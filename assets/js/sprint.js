if($('#nomor_surat_sprint').length){
	const baseUrl = $('#base-url').val();
	$.ajax({
		url: baseUrl+'sprint/getNomorSurat',
		method: "GET",
		success: function(data) {
			var nomorSuratSelect = " ";
			// formRuangRapat+= "<option value=''>Pilih Ruang Rapat</option>";
			$.each(data, function(key, nomorSurat) {
				var nomorSuratId=nomorSurat.penomoran_surat_id;
				var nomorSurat=nomorSurat.nomor_surat_prefix+'/'+nomorSurat.nomor_surat+'/'+nomorSurat.nomor_surat_suffix;
				let currentNomorSurat = $('#current_nomor_surat_id').val();
				var selected= '';
				if(nomorSuratId==currentNomorSurat){
					selected='selected';
				}
				nomorSuratSelect+= "<option value='"+nomorSuratId+"' "+selected+">"+nomorSurat+"</option>";
			});
			$('#nomorSuratId').append(nomorSuratSelect);
			$('#nomorSuratId').selectpicker('refresh');
		}
	});

	$('#ruang_rapat_select').change(function() {
		var ruangRapatid = $('#ruangRapatId').val();
		$('#current_ruang_rapat_id').val(ruangRapatid);
	});
}