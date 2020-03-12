@extends('layouts/master')

@section('content')
	<div class="container-fluid">
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Inbox</h1>
		</div>
    @if(isset($alertStatus))
    <div class="card mb-3 @if($alertStatus) border-bottom-success @else border-bottom-danger @endif alert-box">
      <div class="card-body">
        {{$alertMessage}}
      </div>
    </div>
    @endif
    <div class="row">
      @php
       $array=0;
       $count=count($nomor);
       @endphp
       {{-- {{$count}} --}}
      @foreach ($nomor as $nomors)
      @if ($array<$count-2)
        <!-- Earnings (Monthly) Card Example -->
        <!-- master border dan button -->
        @if ($nomor[$array]->jenis_surat_id=='5')
          @php
            $border="border-left-primary";
            $buttonDetail="btn-primary";
          @endphp  
        @elseif ($nomor[$array]->jenis_surat_id=='6')
          @php
            $border="border-left-warning";
            $buttonDetail="btn-warning";
          @endphp  
        @elseif ($nomor[$array]->jenis_surat_id=='3')
          @php
            $border="border-left-danger";
            $buttonDetail="btn-danger";
          @endphp  
        @elseif ($nomor[$array]->jenis_surat_id=='4')
          @php
            $border="border-left-secondary";
            $buttonDetail="btn-secondary";
          @endphp  
        @else
          @php
            $border="border-left-success";
            $buttonDetail="btn-success";
          @endphp  
        @endif
        {{-- cek apakah memiliki jadwal rapat id --}}
        @if (isset($nomor[$array]->jadwal_rapat_id))
          @php
              $jadwalRapatId=$nomor[$array]->jadwal_rapat_id;   
          @endphp
        @else 
          @php
              $jadwalRapatId=0;   
          @endphp
        @endif
        
        {{-- cek apakah memiliki Sprint ID --}}
        @if (isset($nomor[$array]->sprint_id))
          @php
              $sprintId=$nomor[$array]->sprint_id;   
          @endphp
        @else 
          @php
              $sprintId=0;   
          @endphp
        @endif


        <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100 cardInbox {{$border}}">
          <div class="row " >
              <div class="col-md-8 ">
                <p style="padding:10px 20px; margin:0px; font-weight:bold;" >
                  {{$nomor[$array]->jenis_surat}}
                </p>
              </div>
              <div class="col-md-4">
                @if ($jadwalRapatId!=0)
                {{-- <a href="{{ base_url("")}}jadwalRapat/{{$jadwalRapatId}}"> --}}
                @elseif($sprintId!=0)
                {{-- <a href="{{ base_url("")}}sprint/{{$sprintId}}"> --}}
                @else
                {{-- <a href="{{ base_url("")}}penomoranSurat/{{$nomor[$array]->penomoran_surat_id}}/detail"> --}}
                @endif
                  {{-- <button class="d-none d-sm-inline-block btn btn-sm {{$buttonDetail}} shadow-sm" style="float:right; margin:20px;"><i class="fas fa-edit fa-sm text-white-50"></i> Detail</button> --}}
                </a>
              </div>
          </div>
          <div class="shadow " style="padding:30px;">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Nomor Surat</div>
            @php
							$nomorSurat=$nomor[$array]->nomor_surat;
							$invID = str_pad($nomorSurat, 3, '0', STR_PAD_LEFT);	
						@endphp
            <div class="h6 mb-0 font-weight-bold text-gray-800">{{$nomor[$array]->nomor_surat_prefix}}/{{$invID}}/{{$nomor[$array]->nomor_surat_suffix}}</div>
            </div>
            <div class="col-auto" id="icons">
            <i class="fas fa-envelope faa-horizontal animated fa-2x text-yellow-300"></i>
            </div>
          </div>
          </div>
          <div class="text-xs font-weight-bold text-danger text-uppercase mb-1 "style="padding:20px;">Tanggal Surat :
            {{$lastDateValueAddOne=date('d-m-y', strtotime($nomor[$array]->tgl_surat))}}
          </div>
          <div class="content" style="background:transparent; padding:20px; padding-top:0px;">
            @if($nomor[$array]->pejabat!=NULL)
              <p>
                <b>Pejabat</b>
              </p>
              @if ($nomor[$array]->peserta==NULL)
                <div id="anggota" style="height:150px; overflow-x:hidden;">
              @else 
                <div id="anggota" style="height:50px; overflow-x:hidden;">
              @endif
                <table class="table">
                  @php
                  $keyno=0;   
                  @endphp
                  @foreach ($nomor[$array]->pejabat as $item)
                    <tr>
                      <td><img class="img-profile rounded-circle" style="width:40px;" src="https://source.unsplash.com/QAB-WJcbgJk/60x60"></td>
                      <td style="font-size:12px; padding-left:10px;">{{$nomor[$array]->pejabat[$keyno]->pangkat.' '.$nomor[$array]->pejabat[$keyno]->name}}</td>
                    </tr>
                    @php
                    $keyno++;   
                    @endphp
                  @endforeach
                </table>  
              </div>
            @endif
            @if ($nomor[$array]->peserta!=NULL)
            <p>
              <b>Peserta</b>
            </p>
            <div id="anggota" style="height:150px; overflow-x:hidden;">
              <table class="table">
                @php
                 $keyno=0;   
                @endphp
                @foreach ($nomor[$array]->peserta as $item)
                  <tr>
                    <td><img class="img-profile rounded-circle" style="width:40px;" src="https://source.unsplash.com/QAB-WJcbgJk/60x60"></td>
                    <td style="font-size:12px; padding-left:10px;">{{$nomor[$array]->peserta[$keyno]->pangkat.' '.$nomor[$array]->peserta[$keyno]->name}}</td>
                  </tr>
                  @php
                   $keyno++;   
                  @endphp
                @endforeach
              </table>
            </div>
            @endif
          </div>
        </div>
        </div>
      @endif
      @php
        $array++;  
      @endphp
      @endforeach
      <!-- Earnings (Monthly) Card Example -->
    </div>
  </div>
@endsection