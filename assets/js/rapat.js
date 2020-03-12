$( "#button" ).hide();
$( "#button-edit-nrp-pimpinan" ).hide();
const baseUrl = $('#base-url').val();

function checkNRP(nrp,callback) {
	const baseUrl = $('#base-url').val();
	$.ajax({
		url: baseUrl+'personel/'+nrp,
		method: "GET",
		dataType: "json",
		success : function(response) {
			callback(response);
		},
		error: function() {
			alert('Gagal Mengakses Jaringan.');
			document.getElementById("loading-pimpinan").innerHTML="<i class=\"fas fa-check fa-sm text-white-50\"></i> Cek Data NRP</i>";
		}
	});
	
}

$( "#button-edit-nrp-pimpinan" ).click(function() {
	$( "#button-edit-nrp-pimpinan" ).hide();
	$( "#button-cek-nrp-pimpinan" ).show();
	$('input#nrp').prop("disabled", false);
});


//add pejabat,peserta & pimpinan rapat
function fillDataPimpinanRapat(){
	document.getElementById("loading-pimpinan").innerHTML="<i class=\"fas fa-spinner fa-spin\"></i> Loading";
	const nrp = $('input#nrp').val();
	checkNRP(nrp,(response) => {
		document.getElementById("loading-pimpinan").innerHTML="<i class=\"fas fa-check fa-sm text-white-50\"></i> Cek Data NRP</i>";
		if(response.success){
			$( "#button-edit-nrp-pimpinan" ).show();
			$( "#button-cek-nrp-pimpinan" ).hide();
	
			var namaLengkap = response.personel.nama_lengkap;
			var pangkat = response.personel.pangkat_terakhir.singkatan;
			var jabatan = response.personel.jabatan_terakhir.riwayat_jabatan_keterangan;
			$('input#nrp').prop("disabled", true);
			$('input#nrp-pimpinan').val(nrp);
			$('input#nama_pimpinan').val(pangkat+' '+namaLengkap);
			$('input#pangkat_pimpinan').val(pangkat);
			$('input#jabatan_struktur_pimpinan').val(jabatan);
		}else{
			$('#toast-nrp-pimpinan').toast('show');
		}
	});
}

function addPejabat(jadwalRapatId){
	const nrp = $('input#nrp-pejabat').val();
	const baseUrl = $('#base-url').val();

	document.getElementById("loading-pejabat").innerHTML="<i class=\"fas fa-spinner fa-spin\"></i> Loading";

	checkNRP(nrp,(data) => {
		document.getElementById("loading-pejabat").innerHTML="<i class=\"fas fa-check fa-sm text-white-50\"></i> Cek Data NRP</i>";
		if(data.success){
			// alert(nrpID);
			$( "#button" ).show();
			const pangkat = data.personel.pangkat_terakhir.singkatan;
			const jabatan_struktur = data.personel.jabatan_terakhir.riwayat_jabatan_keterangan;
			const personel = data.personel;
			const kodeSatuan = data.personel.jabatan_terakhir.kode_satuan;
			// const jabatanTerakhir = personel.riwayat_jabatan[personel.riwayat_jabatan.length-1];

			if(jadwalRapatId){
				// console.log(personel);
				$.ajax({
				url: baseUrl+'pejabat',
				method: "POST",
				data:{
					jadwal_rapat_id: jadwalRapatId,
					nrp: nrp,
					name: personel.nama_lengkap,
					kode_satuan: kodeSatuan,
					pangkat: pangkat,
					jabatan_struktur: jabatan_struktur,
				},
				success : function(response) {
					console.log(response);
				}
				});
			}

			var count=$('.removediv').length;

			count=count+1;
			var wrapper = $('.field_wrapper_pejabat'); //Input field wrapper

			var fieldHTML = ''; //New input field html 
			fieldHTML +="<tr>";
			fieldHTML +="<td>";
			fieldHTML +="	<div class='form-inline'>";
			fieldHTML +="		<input type='text' class='nama"+count+" form-control removediv' id='' placeholder='Masukkan NRP Anda' min='0' readonly style='width:500px;margin-left:-10px;'>";
			fieldHTML +="		<input type='text' class='nrp"+count+" form-control' name='additional[pejabat][]' id='' placeholder='Masukkan NRP Anda' min='0' hidden>";
			fieldHTML +="		<a href='javascript:void(0);'  class='remove_button d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm' style='margin-left:10px;'>";
			fieldHTML +="			<i class='fas fa-times fa-sm text-white-50'></i> </i>";
			fieldHTML +="		</a>	";
			fieldHTML +="		<div class='toast' data-autohide='true' data-delay='4000' data-animation=\"true\" style='position:relative; padding:0px; margin:0px;'>";
			fieldHTML +="			<div class=\"toast-body\" style='padding:7px 10px; margin:0px;'>";
			fieldHTML +="				<strong class='mr-auto text-danger'><i class='fas fa-times' ></i> Gagal</strong> Data <b>NRP</b> tidak ditemukan";
			fieldHTML +="			</div>";
			fieldHTML +="		</div>";
			fieldHTML +="	</div>";
			fieldHTML +="</td>";
			fieldHTML +="</tr>";
			$(wrapper).append(fieldHTML); //Add field html

			$( "input#nrp-pejabat" ).val("");
			$( "input.nrp"+count).val(nrp+'/'+pangkat+'/'+personel.nama_lengkap+'/'+kodeSatuan+'/'+jabatan_struktur);
			$( "input.nama"+count).val(pangkat+' '+personel.nama_lengkap);	
		}else{
			$('#toast-nrp-pejabat').toast('show');
		}			
	});
}

function addPeserta(jadwalRapatId,penomoranSuratId){
	const nrp = $('input#nrp-peserta').val();
	document.getElementById("loading-peserta").innerHTML="<i class=\"fas fa-spinner fa-spin\"></i> Loading";

	checkNRP(nrp,(data) => {
		document.getElementById("loading-peserta").innerHTML="<i class=\"fas fa-check fa-sm text-white-50\"></i> Cek Data NRP</i>";
		if(data.success){
			// alert(nrpID);
			$( "#button" ).show();
			const pangkat = data.personel.pangkat_terakhir.singkatan;
			const jabatan_struktur = data.personel.jabatan_terakhir.riwayat_jabatan_keterangan;
			const personel = data.personel;
			const kodeSatuan = data.personel.jabatan_terakhir.kode_satuan;
			
			if(jadwalRapatId){
				$.ajax({
				url: baseUrl+'peserta',
				method: "POST",
				data:{
					jadwal_rapat_id: jadwalRapatId,
					nrp: nrp,
					name: personel.nama_lengkap,
					kode_satuan: kodeSatuan,
					pangkat: pangkat,
					jabatan_struktur: jabatan_struktur,
				},
				success : function(response) {
					console.log(response);
				}
				});
			}
			
			if(penomoranSuratId){
				$.ajax({
				url: baseUrl+'peserta',
				method: "POST",
				data:{
					penomoran_surat_id: penomoranSuratId,
					nrp: nrp,
					name: personel.nama_lengkap,
					kode_satuan: kodeSatuan,
					pangkat: pangkat,
					jabatan_struktur: jabatan_struktur,
				},
				success : function(response) {
					console.log(response);
				}
				});
			}

			var count=$('.removediv').length;
			count=count+1;
			var wrapper = $('.field_wrapper_peserta'); //Input field wrapper

			var fieldHTML = ''; //New input field html 
			fieldHTML +="<tr>";
			fieldHTML +="<td>";
			fieldHTML +="	<div class='form-inline'>";
			fieldHTML +="		<input type='text' class='nama"+count+" form-control removediv' placeholder='Masukkan NRP Anda' min='0' readonly style='width:500px;margin-left:-10px;'>";
			fieldHTML +="		<input type='text' class='nrp"+count+" form-control' name='additional[peserta][]' placeholder='Masukkan NRP Anda' min='0' hidden>";
			fieldHTML +="		<a href='javascript:void(0);'  class='remove_button d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm' style='margin-left:10px;'>";
			fieldHTML +="			<i class='fas fa-times fa-sm text-white-50'></i> </i>";
			fieldHTML +="		</a>	";
			fieldHTML +="		<div class='toast' data-autohide='true' data-delay='4000' data-animation=\"true\" style='position:relative; padding:0px; margin:0px;'>";
			fieldHTML +="			<div class=\"toast-body\" style='padding:7px 10px; margin:0px;'>";
			fieldHTML +="				<strong class='mr-auto text-danger'><i class='fas fa-times' ></i> Gagal</strong> Data <b>NRP</b> tidak ditemukan";
			fieldHTML +="			</div>";
			fieldHTML +="		</div>";
			fieldHTML +="	</div>";
			fieldHTML +="</td>";
			fieldHTML +="</tr>";
			$(wrapper).append(fieldHTML); //Add field html


			$( "input#nrp-peserta" ).val("");
			$( "input.nrp"+count).val(nrp+'/'+pangkat+'/'+personel.nama_lengkap+'/'+kodeSatuan+'/'+jabatan_struktur);
			$( "input.nama"+count).val(pangkat+' '+personel.nama_lengkap);
		}else{
			$('#toast-nrp-peserta').toast('show');
		}				
	});
}

$(wrapper).on('click', '.remove_button', function(e){
	e.preventDefault();
	$(this).parent().parent().parent().remove(); //Remove field html
	// x--; //Decrement field counter
});

function deletePejabat(pejabatId){
	$.ajax({
		url: baseUrl+'pejabat/'+pejabatId+'/delete',
		method: "GET",
		dataType: "json",
		success : function(response) {
			console.log(response);
		}
	});
}

function deletePeserta(pesertaId){
	$.ajax({
		url: baseUrl+'peserta/'+pesertaId+'/delete',
		method: "GET",
		dataType: "json",
		success : function(response) {
			console.log(response);
		}
	});
}

//end of add pejabat,peserta & pimpinan rapat

if($('#ruang_rapat_select').length){
	const baseUrl = $('#base-url').val();
	$.ajax({
		url: baseUrl+'ruangRapatAll',
		method: "GET",
		success: function(data) {
			var formRuangRapat = " ";
			formRuangRapat+="<select class='selectpicker show-tick mediumForm' id='ruangRapatId' data-live-search='true' name='ruang_rapat_id' required>" ;
			formRuangRapat+= "<option value=''>Pilih Ruang Rapat</option>";
			$.each(data, function(key, ruangRapat) {
				var ruangRapatId=ruangRapat.ruang_rapat_id;
				var ruangRapatName=ruangRapat.ruang_rapat_name;
				let current_ruang_rapat_id = $('#current_ruang_rapat_id').val();
				var selected= '';
				if(ruangRapatId==current_ruang_rapat_id){
					selected='selected';
				}
				formRuangRapat+= "<option value='"+ruangRapatId+"' "+selected+">"+ruangRapatName+"</option>";
			});
			formRuangRapat+="</select>";
			document.getElementById('ruang_rapat_select').innerHTML=formRuangRapat;
			$('#ruangRapatId').selectpicker('refresh');
		}
	});

	$('#ruang_rapat_select').change(function() {
		var ruangRapatid = $('#ruangRapatId').val();
		$('#current_ruang_rapat_id').val(ruangRapatid);
	});
}