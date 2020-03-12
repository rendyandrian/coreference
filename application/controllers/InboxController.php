<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include 'BaseController.php';

class InboxController extends BaseController {
	protected $success = true;
	protected $message = '';
	protected $entity  = 'inbox';
	protected $entityId  = 'inbox_id';


	protected function getModel() {
		return $this->inbox;
	}

	protected function getEntityId() {
		return $this->entityId;
	}
	public function index()
    {
		$userData = $this->session->{KEY_USER};
		$userId = $userData['personel']->user_id;
		$kodeSatuan = $userData['satuan']->kode_satuan;
		
        $authStatus = $this->session->flashdata(KEY_STATUS);
        $authMessage = $this->session->flashdata(KEY_MESSAGE);

		// Sprint 
		$nomorSuratSprintByKodeSatuan = $this->getModel()->allSprintByKodeSatuan($kodeSatuan);
		// Jadwal Rapat
		$nomorSuratJadwalRapatByKodeSatuan = $this->getModel()->allJadwalRapatByKodeSatuan($kodeSatuan);	
		// Penomoran Surat
		$nomorSuratByKodeSatuan = $this->getModel()->allPenomoranSuratByKodeSatuan($kodeSatuan);
		$mergeAllSurat=array_merge_recursive($nomorSuratByKodeSatuan,$nomorSuratJadwalRapatByKodeSatuan,$nomorSuratSprintByKodeSatuan);
		foreach ($mergeAllSurat as $key => $value) {
			$nomorsurat=$mergeAllSurat[$key]->penomoran_surat_id;
			//cek jadwal rapat
			$cekJadwalRapat=$this->getModel()->valueJadwalRapatByNomorSurat($nomorsurat);
			if(isset($cekJadwalRapat[0]->jadwalRapat)){
				$jadwalRapatId=$cekJadwalRapat[0]->jadwalRapat;
			}
			else{
				$jadwalRapatId=0;
			}
			$value->peserta=$this->getModel()->allPesertaByNomorSurat($nomorsurat,$jadwalRapatId,$kodeSatuan);
			// ini tempat validasi agar peserta dari jadwal rapat ada

			//
			$value->pejabat=$this->getModel()->allPejabatByNomorSurat($nomorsurat,$kodeSatuan);
			$mergeAllSurat['peserta']=$value->peserta;
			$mergeAllSurat['pejabat']=$value->pejabat;
		}
        $data = [
			'alertStatus' => $authStatus,
            'alertMessage' => $authMessage,
			'nomor' =>$mergeAllSurat
		];
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
        return view ($this->entity.'.index',$data);
    }
	
}
?>
