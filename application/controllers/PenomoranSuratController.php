<?php
defined('BASEPATH') or exit('No direct script access allowed');

include 'BaseController.php';

class PenomoranSuratController extends BaseController {
    protected $success  = true;
    protected $message  = '';
    protected $entity   = 'penomoranSurat';
    protected $entityId = 'penomoran_surat_id';

    public function __construct() {
        parent::__construct();
        $this->load->library('upload');     
    }
    
    protected function configFileUploads($path) {
        //cek directory
        if (!is_dir($path)) {
            mkdir($path, 0775, true);
        }
        //config image
        $config['upload_path']   = $path;
        $config['allowed_types'] = 'jpeg|gif|jpg|png|pdf';
        $config['max_size']      = '10000';
        $config['overwrite']     = false;

        return $config;
    }

    public function uploadDokumen_post() {
        $files = $_FILES;
        $jenisSurat = preg_replace('/\s+/', '_', strtolower($this->input->post('jenis_surat')));
        $nomorSurat = $this->input->post('nomor_surat_lengkap');
        $nomorSurat = str_replace(" ", "_", str_replace(".", "-", str_replace("/", "-", $nomorSurat))); //remove / on filename
        $penomoranSuratId = $this->input->post('penomoran_surat_id');
        
        $filename = new SplFileInfo($files['file_scan_surat']['name']);
        $extensionFile = $filename->getExtension();
        
        $files['file_scan_surat']['name'] = $nomorSurat.'.'.$extensionFile;
        $path = 'dokumen/'.$jenisSurat.'/surat/';

        $uploadedFiles = $this->do_upload($files, $path);
        foreach ($uploadedFiles as $keyFile => $valueFile) {
            if(!$valueFile['success']) {
                $this->session->set_flashdata(KEY_STATUS, false);
                $this->session->set_flashdata(KEY_MESSAGE, "File <b>".$keyFile."</b> - ".$valueFile['message']);
                redirect($this->entity);
            }
            $dataPost[$keyFile] = $valueFile['photo'];
        }
        $dataPost['status_file_scan'] = 'closed';

        $this->message = "Data successfully entered.";
        $data          = new stdClass();
        $entityId      = $this->entityId;

        $data->$entityId = $this->getModel()->update($dataPost,$penomoranSuratId);

        if (!$data->$entityId) {
            $this->success = false;
            $this->message = 'Data failed to be entered';
            $data          = '';
        }

        $response = $this->createResponse($this->success, $this->message, $this->entity, $data);

        if ($response->success) {
            redirect($this->entity);
        } else {
            redirect($this->entity . '/add');
        }
    }

    public function testUpload() {
        $files = ['asd'];
        $tes   = 'asd';
        $this->do_upload($files, $tes);
    }

    protected function getModel() {
        return $this->penomoranSurat;
    }

    protected function getEntityId() {
        return $this->entityId;
	}

	public function index()
    {
        $authStatus = $this->session->flashdata(KEY_STATUS);
        $authMessage = $this->session->flashdata(KEY_MESSAGE);
        
        $allowAddSurat = !$this->getModel()->hasOpenedSurat();
        
        $data = $this->getModel()->all();
        $data = [
            'alertStatus' => $authStatus,
            'alertMessage' => $authMessage,
            'allowAddSurat' => $allowAddSurat,
            $this->entity.'s' => $data
        ];
        return view ($this->entity.'.index',$data);
    }

	public function add_get() {
		$allowAddSurat = !$this->getModel()->hasOpenedSurat(); 
		//if ada satu aja surat yang open, akan dilarang untuk add surat
		if(!$allowAddSurat) {
			return view ('notfound', [
				'message' => 'Tidak diizinkan untuk akses halaman ini, Masih ada surat yang FILE nya belum terupload',
                'redirectUrl' => base_url($this->entity)
            ]);
		}

		$jadwalId=0;
		$totalPeserta="";
		if(isset($_GET['id'])){
			$jadwalId=$_GET['id'];
			$jadwalRapatById= $this->jadwalRapat->find($jadwalId);
			$createby=$jadwalRapatById->created_by;
			$userById= $this->user->find($createby);
			$groupByUser=$userById->group_id;
			if($groupByUser==1 || $groupByUser==2 || $groupByUser==3){
				$kodeSatuan=substr($userById->kode_satuan,0,3);
			}
			else if($userById==4){ // POLRES
				$kodeSatuan=substr($userById->kode_satuan,5);
			}
			else{
				$kodeSatuan=substr($userById->kode_satuan,7);
			}
			$countPeserta= $this->lampiranPeserta->countByKodeSatuan($kodeSatuan,$jadwalId);
			$totalPeserta=$countPeserta->total;
			$jenisSurats= $this->jenisSurat->all();
		}
		else{
			$jenisSurats= $this->jenisSurat->all();
		}
		$data = [
			'jadwalID'=>$jadwalId,
			'countPeserta'=>$totalPeserta,
			'jenisSurats' => $jenisSurats
		];
		return view ('penomoranSurat.add', $data);	
	}
	
	public function add_post() {
		$this->message = "Data successfully entered.";
		$data = new stdClass();
		$userData = $this->session->{KEY_USER};
        $userId = $userData['personel']->user_id;
        $kodeSatuan = $userData['satuan']->kode_satuan;
        
        $entityId = $this->entityId;
		$dataPost = $this->input->post();

		$dataPost['user_id']=$userId;
		$jenisSuratId=$dataPost['jenis_surat_id'];
		$dataPost['status_file_scan']='open';
		$dataPost['status_nomor_surat']='draft';
		$dataPost['kode_satuan_konseptor']=$kodeSatuan;
		$tglSurat=$dataPost['tgl_surat'];
		$peserta=$dataPost;
		//get record last
		$lastPenomoran = $this->getModel()->getLastRecord($jenisSuratId);
		$lastDate=$lastPenomoran->tgl;
		$nomorTerakhir=$lastPenomoran->nomor_terakhir;
		
		//check selisih and count tanggal
		$date1=date_create($lastDate);
		$date2=date_create($dataPost['tgl_surat']);
		$diff=date_diff($date1,$date2);
		$rangeDate=$diff->format("%a");

		// UNSET DATA
		$tembusan=$dataPost['tembusan'];
		unset($dataPost['tembusan']);
		unset($dataPost['peserta']);
		unset($dataPost['panitia']);
		unset($dataPost['nama']);
		unset($dataPost['jadwalRapat']);
		$cekRange="";
		if($lastDate<$dataPost['tgl_surat']){
			$cekRange="valid";
		}
		if($rangeDate>1 && $cekRange=='valid'){ // cek apakah ada selisih diantara tanggal terakhir dengan tanggal input
			//get nomor surat terakhir
			// $lastDateValueAddOne=date('Y-m-d', strtotime($lastDate. ' + 1 days'));
			// $getLastRecordNomorSurat = $this->getModel()->getLastRecordPenomoranSurat($lastDate,$jenisSurat);
			$findSlotByJenisSurat=$this->jenisSurat->find($jenisSuratId);
			$slotSurat=$findSlotByJenisSurat->slot;
			// proses loop tiap jenis surat dengan mengecek last record di log
			// foreach ($getAllJenisSurat as $key => $value) {
				// $jenisSuratLoop=$value->jenis_surat_id;
				$lastPenomoran = $this->getModel()->getLastRecordPenomoranSurat($lastDate,$jenisSuratId);
				$ceklastPenomoranInPenomoranSurat = $this->getModel()->getCekLastRecordPenomoranSuratByJenisSurat($jenisSuratId);
				$nomorTerakhir=$lastPenomoran->nomor_terakhir;
				$nomorSuratTerakhir=$ceklastPenomoranInPenomoranSurat->nomor_surat;
				if($nomorSuratTerakhir>$nomorTerakhir){
					$nomorTerakhir=$nomorSuratTerakhir;
				}
				// print_r($nomorTerakhir);
				// if($nomorTerakhir<$getLastRecordNomorSurat->nomor_surat){
				// 	$nomorTerakhir=$getLastRecordNomorSurat->nomor_surat;
				// }
				for ($i=1; $i < $rangeDate; $i++) {
					$newDateLog=date('Y-m-d', strtotime($lastDate. ' + '.$i.' days'));
					//count berfungsi untuk menambahkan slot 5 surat di setiap selisih tanggal
					$count=$nomorTerakhir+$slotSurat;
					$dataLogPenomoran = [
						'tgl' 				=> $newDateLog,
						'nomor_terakhir' 	=> $count,
						'jenis_surat_id' 	=> $jenisSuratId,
					];
					// save slot in table penomoran
					for ($noterakhir=$nomorTerakhir+1; $noterakhir<=$count ; $noterakhir++) { 
						$insertPenomoranSurat = [
							'user_id' 				=> $userId,
							'nomor_surat' 			=> $noterakhir,
							'jenis_surat_id' 		=> $jenisSuratId,
							'tgl_surat' 			=> $dataLogPenomoran['tgl'],
							'status_file_scan' 		=> 'open',
							'status_nomor_surat' 	=> 'draft',
							'kode_satuan_konseptor' => $kodeSatuan
						];
						// menambahkan data di penomoran surat dengan status draft
						$this->getModel()->insertPenomoranSurat($insertPenomoranSurat);
						$last=$noterakhir;
					}
				// 	//menambahkan log ke tanggal
				$insertLogTglSurat = $this->getModel()->insertLogTgl($dataLogPenomoran);
				$nomorTerakhir=$nomorTerakhir+$slotSurat;
				}
			// }
			
			$lastPenomoranAdd = $this->getModel()->getLastRecordPenomoranSurat($lastDate,$jenisSuratId);
			//algoritma for add tanggal setelah loop draft
			$last=$nomorTerakhir;
			// print_r($nomorTerakhir);
			$dataPost['nomor_surat']=$last+1;
			$dataPost['status_nomor_surat']='publish';
			// print_r($dataPost);
			
			//menambahkan data setelah penomoran terakhir dengan status surat publish
			$data->$entityId = $this->getModel()->insert($dataPost);
		}else{
			// //cek update berdasarkan jenis surat dan status nomor surat
			$dataPost['status_nomor_surat']='publish';

			$updatePenomoranSurat = $this->getModel()->getUpdatePenomoranSurat($tglSurat,$jenisSuratId);
			
		
			// //cek slot di penomoran surat
			if($updatePenomoranSurat!=NULL){
				$id=$updatePenomoranSurat->penomoran_surat_id;
				unset($dataPost['nomor_surat']);
				// print_r($id);
				$data->$entityId = $this->getModel()->update($dataPost, $id);
				$data->$entityId=$id;
			}
			else{
				$dataPost['status_nomor_surat']='publish';
				$ceklastPenomoranInPenomoranSurat = $this->getModel()->getAddLastRecordPenomoranSurat($tglSurat,$jenisSuratId);
				// 	//cek penomoran surat terakhir ketika tanggal sudah ada di penomoran
				$lastPenomoran = $this->getModel()->getLastRecordPenomoranSurat($lastDate,$jenisSuratId);
				$nomorPenomoranSurat=0;
				if($ceklastPenomoranInPenomoranSurat!=NULL){
					$nomorPenomoranSurat=$ceklastPenomoranInPenomoranSurat->nomor_surat;
				}
				//cek apakah nomor surat terakhir di log dan di penomoran
				if($lastPenomoran->nomor_terakhir<$nomorPenomoranSurat){
					$nomorTerakhir=$nomorPenomoranSurat;
				}
				else{
					$nomorTerakhir=$lastPenomoran->nomor_terakhir;
				}
				$dataPost['nomor_surat']=$nomorTerakhir+1;
			// 	//simpan jika tanggal nya ada di penomoran
				$data->$entityId = $this->getModel()->insert($dataPost);
			}
		}
		$dataPostPeserta['peserta']=$this->input->post('peserta');
		$dataPostPeserta['panitia']=$this->input->post('panitia');
		$dataPostTembusan['tembusan']=$this->input->post('tembusan');
		$dataPostJadwalRapat['jadwalRapat']=$this->input->post('jadwalRapat');
		// Lampiran Peserta
		if($dataPostPeserta['peserta']!=NULL){
			foreach ($dataPostPeserta['peserta'] as $key => $value) {
				$peserta = explode("/", $value);
				$dataPeserta['penomoran_surat_id']=$data->$entityId;
				$dataPeserta['nrp']=$peserta[0];
				$dataPeserta['pangkat']=$peserta[1];
				$dataPeserta['name']=$peserta[2];
				$dataPeserta['kode_satuan']=$peserta[3];
				$dataPeserta['jabatan_struktur']=$peserta[4];
				$dataPeserta['jabatan_kepanitiaan']=$dataPostPeserta['panitia'][$key];
				$dataPeserta['created_by']=$userId;
				$insertPeserta= $this->getModel()->insertPeserta($dataPeserta);
			}
		}

		// Lampiran tembusan
		if($dataPostTembusan['tembusan']!=NULL){
			foreach ($dataPostTembusan['tembusan'] as $key1 => $value) {
				$dataTembusan['penomoran_surat_id']=$data->$entityId;
				$dataTembusan['tembusan_name']=$value;
				$insertTembusan= $this->getModel()->insertTembusan($dataTembusan);
			}
		}

		// Update Jadwal Rapat 
		$idJadwalSurat=$dataPostJadwalRapat['jadwalRapat'];
		if($dataPostJadwalRapat['jadwalRapat']!=NULL){
			$updateNomorSuratJadwalRapat = [
				'penomoran_surat_id' 	=> $data->$entityId
			];
			$updateJadwal = $this->jadwalRapat->update($updateNomorSuratJadwalRapat, $idJadwalSurat);
		}
        if(!$data->$entityId){
            $this->success = false;
            $this->message = 'Data failed to be entered';
            $data = '';
        }

        $response = $this->createResponse($this->success,$this->message,$this->entity,$data);
        if($response->success){
            redirect($this->entity);
        }
        else{
            redirect($this->entity.'/add');
        }
	}
	public function cek_kouta($date,$idJenis){
		header('Content-Type: application/json');
		$cekLog = $this->getModel()->getCountLogSurat($date,$idJenis);
		$data = $this->getModel()->getCountKoutaSurat($date,$idJenis);
		$data->log=$cekLog->log;
        echo json_encode($data);
	}
	public function edit_get($id){
		$authStatus 	= $this->session->flashdata(KEY_STATUS);
        $authMessage 	= $this->session->flashdata(KEY_MESSAGE);
		//cek value from tabel penomoran surat
        $data 				= $this->getModel()->find($id);
        $tembusans 			= $this->tembusan->findByPenomoranId($id);
        $lampiranPesertas 	= $this->lampiranPeserta->findName($id);
		$jenisSurats= $this->jenisSurat->all();
        $data = [
            'alertStatus' => $authStatus,
			'alertMessage' => $authMessage,
			'jenisSurats' => $jenisSurats,
			'tembusans' => $tembusans,
			'lampiranPesertas' => $lampiranPesertas,
            $this->entity => $data
		];
		// echo "<pre>";
		// print_r($lampiranPesertas);
		// echo "</pre>";
        return view ($this->entity.'.edit', $data); 		
	}
	public function edit_post($id){
		$this->message = "Data successfully updated.";
		$userData = $this->session->{KEY_USER};
		$userId = $userData['personel']->user_id;
		
		$kodeSatuan = $userData['satuan']->kode_satuan;
		
		$dataPost['user_id']=$userId;
		$dataPost['kode_satuan_konseptor']=$kodeSatuan;

        $data = new stdClass();
        $entityId = $this->entityId;

		$dataPost = $this->input->post();
		
		unset($dataPost['tembusan']);
		unset($dataPost['peserta']);
		unset($dataPost['panitia']);
		unset($dataPost['nama']);

        // $data->$entityId = $this->getModel()->update($dataPost,$id);

		$dataPostPeserta['peserta']=$this->input->post('peserta');
		$dataPostPeserta['panitia']=$this->input->post('panitia');
		$dataPostTembusan['tembusan']=$this->input->post('tembusan');
		// Lampiran Peserta
		if($dataPostPeserta['peserta']!=NULL){
			$deleteLampiranPeserta= $this->lampiranPeserta->deleteByPenomoran($id);
			foreach ($dataPostPeserta['peserta'] as $key => $value) {
				$peserta = explode("/", $value);
				$dataPeserta['penomoran_surat_id']=$id;
				$dataPeserta['nrp']=$peserta[0];
				$dataPeserta['pangkat']=$peserta[1];
				$dataPeserta['name']=$peserta[2];
				$dataPeserta['kode_satuan']=$peserta[3];
				$dataPeserta['jabatan_struktur']=$peserta[4];
				$dataPeserta['jabatan_kepanitiaan']=$dataPostPeserta['panitia'][$key];
				$dataPeserta['created_by']=$userId;
				$insertPeserta= $this->getModel()->insertPeserta($dataPeserta);
			}
		}
		// Lampiran tembusan
		if($dataPostTembusan['tembusan']!=NULL){
			$deleteTembusan= $this->tembusan->deleteByPenomoran($id);
			foreach ($dataPostTembusan['tembusan'] as $key1 => $value) {
				$dataTembusan['penomoran_surat_id']=$id;
				$dataTembusan['tembusan_name']=$value;
				$insertTembusan= $this->getModel()->insertTembusan($dataTembusan);
			}
		}
        if($data->$entityId < 0){
            $this->success = false;
            $this->message = 'Data failed to be update';
            $data = '';
        }else{
            $data = (object) $dataPost;
        }

        $response = $this->createResponse($this->success,$this->message,$this->entity,$data);
        if($response->success){
            redirect($this->entity);
        }
        else{
            redirect($this->entity.'/'.$id.'/edit');
		}
	}

	public function reset($id) {
        $this->message = "File nomor surat berhasil di reset.";
        $data = new stdClass();
        $entityId = $this->entityId;

	// 	$hasOpenedSurat = $this->getModel()->hasOpenedSurat();
	// 	if($hasOpenedSurat) {
	// 		$this->success = false;
	//		$this->message = 'Hanya boleh ada satu nomor surat yang belum di upload';
	// 	} else {
	// 	}
        $dataReset = [
        	'status_file_scan' => 'open'
        ];
        $data->$entityId = $this->getModel()->update($dataReset, $id);

        if($data->$entityId < 0){
            $this->success = false;
            $this->message = 'Data failed reset';
            $data = '';
        }else{
            $data = (object) $dataPost;
        }

        $response = $this->createResponse($this->success,$this->message,$this->entity,$data);
		redirect($this->entity);
    }
}
