function ayat(){
	const baseUrl = $('#base-url').val();
	id=$('#ayat').val();
	$.ajax({
		url: baseUrl+'anotasi/'+id,
		method: "GET",
		success: function(data) {
			$.each(data, function(key, arab) {
				var ayat=arab.Data;
				console.log(ayat);
				// var ruangRapatName=ruangRapat.ruang_rapat_name;
				// let current_ruang_rapat_id = $('#current_ruang_rapat_id').val();
				// var selected= '';
				// if(ruangRapatId==current_ruang_rapat_id){
				// 	selected='selected';
				// }
				// formRuangRapat+= "<option value='"+ruangRapatId+"' "+selected+">"+ruangRapatName+"</option>";
			});
		}
	});
}

$( "#button" ).hide();
function getPersonelByNRPForAddUser() {
	const baseUrl = $('#base-url').val();
	const nrp=$( "input#nrp" ).val();

	if(nrp==''){
		$( "input#nrp" ).focus();
	}else{
		document.getElementById("loading").innerHTML="<i class=\"fas fa-spinner fa-spin\"></i> Loading";
		$.ajax({
			url: baseUrl+'personel/'+nrp,
			method: "GET",
			success: function(data) {
				//loading
				document.getElementById("loading").innerHTML="<i class=\"fas fa-check fa-sm text-white-50\"></i> Cek Data NRP</i>";
				console.log(data);
				if(!data.success){
                    $('.toast').toast('show');
                }
                else{
                	const personel = data.personel;
                	const jabatanTerakhir = personel.riwayat_jabatan[personel.riwayat_jabatan.length-1];
                	const satuan = jabatanTerakhir.satuan_jabatan_keterangan;
                	const kodeSatuan = jabatanTerakhir.kode_satuan;
                	console.log(jabatanTerakhir);
                    $( "input#name" ).val(personel.nama_lengkap);
                    $( "input#satuan" ).val(satuan);
                    $( "input#kode_satuan" ).val(kodeSatuan);

                }
			}
		});
	}
}

function getPersonelByNRP() {
	var count=$('.removediv').length;
	count=count+1
	const baseUrl = $('#base-url').val();
	const nrp=$( "input#nrp" ).val();	
	if(nrp==''){
		$( "input#nrp" ).focus();
	}else{
		document.getElementById("loading").innerHTML="<i class=\"fas fa-spinner fa-spin\"></i> Loading";
		$.ajax({
			url: baseUrl+'personel/'+nrp,
			method: "GET",
			success: function(data) {
				//loading
				console.log(data);
				document.getElementById("loading").innerHTML="<i class=\"fas fa-check fa-sm text-white-50\"></i> Cek Data NRP</i>";
				if(!data.success){
					$( "input#name" ).val("");
					$( "input#nrp" ).val("");
					$( "input#satuan" ).val("");
					$( "input#kode_satuan" ).val("");
					$('#toastCekNrp').toast('show');
					$( "#button" ).hide();
				}
				else{			
					var field_wrapper = $('.field_wrapper'); //Input field wrapper

					var fieldHTML = ''; //New input field html 
					fieldHTML +="<tr class='removediv'>";
					fieldHTML +="<td>Peserta </td>";
					fieldHTML +="<td>";
					fieldHTML +="	<div class='form-inline'>";
					fieldHTML +="		<input type='text' class='nama"+count+" form-control' name='nama[]' id='peserta' placeholder='Masukkan NRP Anda' min='0' readonly style='width:500px;'>";
					fieldHTML +="		<input type='text' class='nrp"+count+" form-control' name='peserta[]' id='pesertaHidden' placeholder='Masukkan NRP Anda' min='0' hidden>";
					fieldHTML +="		<input type='text' class='panitia"+count+" form-control ml-10' name='panitia[]' id='panitia' placeholder='Masukkan Panitia' style='' >";
					fieldHTML +="		<a href='javascript:void(0);' class='remove_peserta d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm ml-10' style=''>";
					fieldHTML +="			<i class='fas fa-times fa-sm text-white-50'></i> </i>";
					fieldHTML +="		</a>	";
					fieldHTML +="	</div>";
					fieldHTML +="</td>";
					fieldHTML +="</tr>";
					$(field_wrapper).append(fieldHTML); //Add field html

					// alert(nrpID);
					$( "#button" ).show();
					const pangkat = data.personel.pangkat_terakhir.singkatan;
					const jabatan_struktur = data.personel.jabatan_terakhir.riwayat_jabatan_keterangan;
					const personel = data.personel;
					const kodeSatuan = data.personel.jabatan_terakhir.kode_satuan;
					const jabatanTerakhir = personel.riwayat_jabatan[personel.riwayat_jabatan.length-1];
					console.log(jabatanTerakhir);
					$( "input#nrp" ).val("");
					$( "input.nrp"+count).val(nrp+'/'+pangkat+'/'+personel.nama_lengkap+'/'+kodeSatuan+'/'+jabatan_struktur);
					$( "input.nama"+count).val(pangkat+' '+personel.nama_lengkap);
				}
			}
		});
	}
}

$(document).ready(function(){
	// not save with enter
	$(window).keydown(function(event){
		if(event.keyCode == 13) {
			event.preventDefault();
			return false;
		}
	});
	// $(document).ready(function(){
// 	});
	var pathname = window.location.pathname;
	var res = pathname.substring(pathname.lastIndexOf('/') + 1);
	if(res=='detail'){
		$('#changeType input').prop("disabled", true);
		$('#changeType select').prop("disabled", true);
		$('#changeType button').prop("disabled", true);
		$("#tembusanbtn").removeClass('add_tembusan');
		$("#removebtn").removeClass('remove_button');
		$("#removePeserta").removeClass('remove_peserta');
		$("#btnSave").hide();
	}
	//Once remove button is clicked
	var maxField = 10; //Input fields increment limitation
	var addTembusan = $('.add_tembusan'); //Add button selector
	var wrapper = $('.field_tembusan'); //Input field wrapper
	var field_wrapper = $('.field_wrapper'); //Input field wrapper
	var fieldCounter = 1; //Initial field counter is 1
	
	//Once add button is clicked
	addTembusan.click(function(){
		
		const tembusan=$("input#tembusan").val();	
		if(tembusan==''){
			$( "input#tembusan" ).focus();
		}else{
			//Check maximum number of input fields
			if(fieldCounter < maxField){ 
				const cekValue = fieldCounter-1;
				tes=$("input.tembusan"+cekValue).val();
				if(tes==''){
					$("input.tembusan"+cekValue).focus();
				}else{
					// var fieldHTML = '<div><input type="text" name="field_name['+x+']" value=""/><a href="javascript:void(0);" class="remove_button"><img src="remove-icon.png"/></a></div>'; //New input field html 
					var fieldHTML = ''; //New input field html 
					fieldHTML +="<tr class='removediv'>";
					fieldHTML +="<td>Tembusan</td>";
					fieldHTML +="<td>";
					fieldHTML +="	<div class='form-inline'>";
					fieldHTML +="		<input type='text' id='tembusan' class='tembusan"+fieldCounter+" form-control' required name='tembusan[]' id='' placeholder='Masukkan Nama' min='0'>";
					fieldHTML +="		<a href='javascript:void(0);'  class='remove_button d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm ml-10'>";
					fieldHTML +="			<i class='fas fa-times fa-sm text-white-50'></i> </i>";
					fieldHTML +="		</a>	";
					fieldHTML +="	</div>";
					fieldHTML +="</td>";
					fieldHTML +="</tr>";
					$(wrapper).append(fieldHTML); //Add field html
					fieldCounter++; //Increment field counter
				}
			}
		}
	});
	$(wrapper).on('click', '.remove_button', function(e){
		e.preventDefault();
		$(this).parent().parent().parent().remove(); //Remove field html
		x--; //Decrement field counter
	});

	// delete peserta
	$(field_wrapper).on('click', '.remove_peserta', function(e){
		e.preventDefault();
		$(this).parent().parent().parent().remove(); //Remove field html
		x--; //Decrement field counter
	});

	// Validasi Tanggal Untuk Hari Ini
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	var yyyy = today.getFullYear();
	if(dd<10){
			dd='0'+dd
		} 
		if(mm<10){
			mm='0'+mm
		} 

	today = yyyy+'-'+mm+'-'+dd;
	document.getElementById("datefield").setAttribute("max", today);
});

$('#datefield').change(function() {
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	var yyyy = today.getFullYear();
	if(dd<10){
			dd='0'+dd
		} 
		if(mm<10){
			mm='0'+mm
		} 

	today = yyyy+'-'+mm+'-'+dd;

	const baseUrl = $('#base-url').val();
	var date = $(this).val();
	var jenisSuratId=$('#jenis_surat_id').val();
	// 2019-12-10
	if(today!=date){
		cekKouta(date,jenisSuratId); 
	}
});

function valueJenisSurat(){
	valueSuratId=$('#jenis_surat_id').val();
	date=$('#datefield').val();
	// load to ajax in function cekKouta
	cekKouta(date,valueSuratId); 
	$(".field_wrapper").show();
	if(valueSuratId==7){
		$(".field_wrapper").hide();
		$('.field_wrapper input').val("");
		$('.remove_peserta').parent().parent().parent().remove(); //Remove field html
	}
}

function cekKouta(date,jenisSuratId){
	$.ajax({
		url: baseUrl+'penomoranSurat/cekKouta/'+date+'/'+jenisSuratId,
		method: "GET",
		success: function(data) {
			// console.log(data.log);
			if(data.log==0){
				$("#btnSave").show();
			}
			else{
				if(data.total==0){
					$("#btnSave").hide();
				}
				else{
					$("#btnSave").show();
				}
				if(data.total>2 && data.log!=0){
					$("#changeColorKouta").addClass('text-success');
					$("#changeColorKouta").removeClass('text-danger');
				}
				else{
					$("#changeColorKouta").addClass('text-danger');
					$("#changeColorKouta").removeClass('text-success');
				}
				$('#toastDate').toast('show');
			}
			document.getElementById("countKouta").innerHTML=data.total;
		}
	});
}