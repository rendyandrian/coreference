function ayat(){
	document.getElementById("showArab").innerHTML="<center style='padding:20px 0px;'><i class=\"fas fa-spinner fa-spin\"></i> Loading</center>";
	const baseUrl = $('#base-url').val();
	id=$('#ayat').val();
	$.ajax({
		url: baseUrl+'anotasi/'+id,
		method: "GET",
		success: function(data) {
			var showArab =" ";

			$.each(data, function(key, arab) {
				var ayat=arab.Data;
				var translation=arab.Translation;
				var tag=arab.tag;
				var Id=arab.Id;
				var SId=arab.SId;
				var VId=arab.VId;
				var WordId=arab.WordId;
				if(tag=='PRON'){
					showArab+="<button class='d-none d-sm-inline-block btn btn-sm btn-success shadow-sm' data-toggle=\"modal\" data-target=\"#anotasiModal\" onclick='tes(\""+ayat+"\",\""+translation+"\",\""+Id+"\",\""+SId+"\",\""+VId+"\",\""+WordId+"\")' title='"+translation+"' style='margin:3px;'>"+ayat+"</button>";
				}
				else{
					showArab+="<button class='d-none d-sm-inline-block btn btn-sm btn-disabled shadow-sm' title='"+translation+"' style='margin:3px;' onclick='alertNon()'>"+ayat+"</button>";
				}

			});
			document.getElementById('showArab').innerHTML=showArab;
		}
	});
}

function tes(ayat,terjemhan,Id,SId,VId,WordId){
	// tess=x.value;
	var textModal=" ";
	textModal+="<table class=\"table table-stripped\" id=\"dataTable\" width='100%' cellspacing='0'>";
	
	textModal+="<tr>";
	textModal+="<th>";
	textModal+="Urutan";
	textModal+="</th>";
	
	textModal+="<th>";
	textModal+="Kata";
	textModal+="</th>";

	
	textModal+="<th>";
	textModal+="Terjemahan";
	textModal+="</th>";
	
	textModal+="<th>";
	textModal+="Rujukan";
	textModal+="</th>";

	textModal+="</tr>";
	textModal+="<tr>";

	textModal+="<td>";
	textModal+=SId+":"+VId+":"+WordId;
	textModal+="</td>";
	
	textModal+="<td>";
	textModal+=ayat;
	textModal+="</td>";
	
	textModal+="<td>";
	textModal+=terjemhan;
	textModal+="</td>";
	
	textModal+="<td>";
	textModal+="<input type='text' value='' name='rujukan' class='form-control'>";
	textModal+="</td>";

	textModal+="</tr>";
	textModal+="</table>";
	document.getElementById('modalAyat').innerHTML=textModal;
}

function alertNon(){
	swal("Mohon Maaf!", "Kata Tersebut Bukan Tag Pronoun", "error");
}