<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include 'BaseController.php';

class JadwalRapatController extends BaseController {
    protected $success  = true;
    protected $message  = '';
    protected $entity   = 'jadwalRapat';
    protected $entityId = 'jadwal_rapat_id';

    public function index()
    {
        $authStatus = $this->session->flashdata(KEY_STATUS);
        $authMessage = $this->session->flashdata(KEY_MESSAGE);
        $filter = $this->input->get();

        $userData = $this->session->{KEY_USER};
        $userLoginId = $userData['personel']->user_id;

        $data =$this->getModel()->filterJadwalRapat($filter);

        $ruangRapat = $this->ruangRapat->all();

        $data = [
            'dataFilter' => $filter,
            'alertStatus' => $authStatus,
            'alertMessage' => $authMessage,
            'ruangRapat' => $ruangRapat,
            'userLoginId' => $userLoginId,
            $this->entity.'s' => $data
        ];
        return view ($this->entity.'.index',$data);
    }

    public function add_post() {
        $this->message = "Data successfully entered.";

        $sessionUser = $this->session->{KEY_USER}['personel'];
        $userId      = $sessionUser->user_id;

        $data     = new stdClass();
        $entityId = $this->entityId;

        $dataPost               = $this->input->post();
        $dataPost['created_by'] = $userId;
        $additionalData         = $dataPost['additional'];
        unset($dataPost['additional']);
        unset($dataPost['current_id_ruang_rapat']);

        if (!isset($additionalData['pejabat'])) {
            $additionalData['pejabat'] = [];
        }
        if (!isset($additionalData['peserta'])) {
            $additionalData['peserta'] = [];
        }

        //room checking
        $conflictDate = $this->scheduleChecking('add', $dataPost);

        if ($conflictDate) {
            //set jadwal rapat conflict message
            $this->setJadwalRapatConflictMessage($conflictDate);

            $response = $this->createResponse($this->success, $this->message, $this->entity, $data);

            $authStatus  = $this->session->flashdata(KEY_STATUS);
            $authMessage = $this->session->flashdata(KEY_MESSAGE);

            $additionalData['alertStatus']  = $authStatus;
            $additionalData['alertMessage'] = $authMessage;

            return view($this->entity . '/add', $additionalData);
        }

        //form validation
        $config = $this->configFormAddJadwalRapat($dataPost);
        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == false) {
            return view($this->entity . '/add', $additionalData);
        }

        $jadwalRapatId = $this->getModel()->insert($dataPost);

        if ($jadwalRapatId) {
            $result = $this->additionalDataProcess($additionalData, $jadwalRapatId);
            if (!$result) {
                $this->getModel()->delete($jadwalRapatId);
                $this->success = false;
                $this->message = 'Data failed to be entered';
                $data          = '';
            }
        }

        $response = $this->createResponse($this->success, $this->message, $this->entity, $data);

        if ($response->success) {
            redirect($this->entity);
        } else {
            return view($this->entity . '/add', $additionalData);
        }
    }

    public function edit_get($id) {
        $data        = $this->getModel()->find($id);

        $userData = $this->session->{KEY_USER};
        $userId = $userData['personel']->user_id;
        
        //if ada satu aja surat yang open, akan dilarang untuk add surat
        if($userId!=$data->created_by) {
            return view ('notfound', [
                'message' => 'Tidak diizinkan untuk mengakses halamn ini',
                'redirectUrl' => base_url($this->entity)
            ]);
        }

        $authStatus  = $this->session->flashdata(KEY_STATUS);
        $authMessage = $this->session->flashdata(KEY_MESSAGE);


        $dataPejabat = $this->pejabat->getPejabatByJadwalRapat($id);
        $dataPeserta = $this->peserta->getPesertaByJadwalRapat($id);

        $implodedDataPejabat = [];
        foreach ($dataPejabat as $keyDataPejabat => $valueDataPejabat) {
            unset($valueDataPejabat['jadwal_rapat_id']);
            unset($valueDataPejabat['created_at']);
            $implodedDataPejabat[] = implode('/', $valueDataPejabat);
        }

        $implodedDataPeserta = [];
        foreach ($dataPeserta as $keyDataPeserta => $valueDataPeserta) {
            unset($valueDataPeserta['penomoran_surat_id']);
            unset($valueDataPeserta['jadwal_rapat_id']);
            unset($valueDataPeserta['created_at']);
            unset($valueDataPeserta['created_by']);
            $implodedDataPeserta[] = implode('/', $valueDataPeserta);
        }

        $data = [
            'alertStatus'  => $authStatus,
            'alertMessage' => $authMessage,
            $this->entity  => $data,
            'pejabat'      => $implodedDataPejabat,
            'peserta'      => $implodedDataPeserta,
        ];

        return view($this->entity . '.edit', $data);
    }

    public function edit_post($id) {
        $this->message = "Data successfully updated.";
        $data          = new stdClass();
        $entityId      = $this->entityId;

        $dataPost       = $this->input->post();
        $additionalData = $dataPost['additional'];
        unset($dataPost['additional']);
        unset($dataPost['current_id_ruang_rapat']);

        if (!isset($additionalData['pejabat'])) {
            $additionalData['pejabat'] = [];
        }
        if (!isset($additionalData['peserta'])) {
            $additionalData['peserta'] = [];
        }
        
        $dataPost['jadwal_rapat_id'] = $id;
        $conflictDate                = $this->scheduleChecking('edit', $dataPost);
        unset($dataPost['jadwal_rapat_id']);

        if ($conflictDate) {
            //set jadwal rapat conflict message
            $this->setJadwalRapatConflictMessage($conflictDate);

            $response = $this->createResponse($this->success, $this->message, $this->entity, $data);

            $authStatus  = $this->session->flashdata(KEY_STATUS);
            $authMessage = $this->session->flashdata(KEY_MESSAGE);

            $additionalData['alertStatus']  = $authStatus;
            $additionalData['alertMessage'] = $authMessage;

            redirect($this->entity . '/' . $id . '/edit', $additionalData);
        }

        //form validation
        $config = $this->configFormAddJadwalRapat($dataPost);
        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == false) {
            return view($this->entity . '/add', $additionalData);
        }

        $data->$entityId = $this->getModel()->update($dataPost, $id);

        if ($data->$entityId < 0) {
            $this->success = false;
            $this->message = 'Data failed to be update';
            $data          = '';
        } else {
            $data = (object) $dataPost;
        }

        $response = $this->createResponse($this->success, $this->message, $this->entity, $data);
        if ($response->success) {
            redirect($this->entity);
        } else {
            redirect($this->entity . '/' . $id . '/edit');
        }
    }

    public function show($id) {
        $authStatus  = $this->session->flashdata(KEY_STATUS);
        $authMessage = $this->session->flashdata(KEY_MESSAGE);

        $data        = $this->getModel()->find($id);
        $dataPejabat = $this->pejabat->getPejabatByJadwalRapat($id);
        $dataPeserta = $this->peserta->getPesertaByJadwalRapat($id);

        $implodedDataPejabat = [];
        foreach ($dataPejabat as $keyDataPejabat => $valueDataPejabat) {
            unset($valueDataPejabat['jadwal_rapat_id']);
            unset($valueDataPejabat['created_at']);
            $implodedDataPejabat[] = implode('/', $valueDataPejabat);
        }

        $implodedDataPeserta = [];
        foreach ($dataPeserta as $keyDataPeserta => $valueDataPeserta) {
            unset($valueDataPeserta['penomoran_surat_id']);
            unset($valueDataPeserta['jadwal_rapat_id']);
            unset($valueDataPeserta['created_at']);
            unset($valueDataPeserta['created_by']);
            $implodedDataPeserta[] = implode('/', $valueDataPeserta);
        }

        $data = [
            'alertStatus'  => $authStatus,
            'alertMessage' => $authMessage,
            $this->entity  => $data,
            'pejabat'      => $implodedDataPejabat,
            'peserta'      => $implodedDataPeserta,
        ];
        return view($this->entity . '.show', $data);
    }

    //insert pejabat and peserta by jadwal rapat
    public function additionalDataProcess($additionalData, $jadwalRapatId) {
        $personelDatas = [];
        foreach ($additionalData as $additionalKey => $additionalValue) {
            foreach ($additionalValue as $personelKey => $personelData) {
                $arrayDataPersonel = explode('/', $personelData);
                $nrp               = $arrayDataPersonel[0];
                $name              = $arrayDataPersonel[2];
                $pangkat           = $arrayDataPersonel[1];
                $kodeSatuan        = $arrayDataPersonel[3];
                $jabatanStruktur   = $arrayDataPersonel[4];

                $personelDatas[$additionalKey][$personelKey]['jadwal_rapat_id']  = $jadwalRapatId;
                $personelDatas[$additionalKey][$personelKey]['nrp']              = $nrp;
                $personelDatas[$additionalKey][$personelKey]['name']             = $name;
                $personelDatas[$additionalKey][$personelKey]['pangkat']          = $pangkat;
                $personelDatas[$additionalKey][$personelKey]['kode_satuan']      = $kodeSatuan;
                $personelDatas[$additionalKey][$personelKey]['jabatan_struktur'] = $jabatanStruktur;
            }
        }

        foreach ($personelDatas as $personelDataKey => $personelData) {
            $result = $this->{$personelDataKey}->insertBatch($personelData);
            if ($result < 1) {
                $this->success = false;
            }
        }

        return $this->success;
    }

    public function scheduleChecking($type, $dataPost) {
        $jadwalRapatId              = isset($dataPost['jadwal_rapat_id']) ? $dataPost['jadwal_rapat_id'] : "";
        $dateStart                  = $dataPost['tanggal_start'];
        $dateEnd                    = $dataPost['tanggal_end'];
        $leaderTimeStart            = $dataPost['waktu_memimpin_start'];
        $leaderTimeEnd              = $dataPost['waktu_memimpin_end'];
        $roomId                     = $dataPost['ruang_rapat_id'];
        $nrpPimpinan = $dataPost['nrp_pimpinan'];
        $resultScheduleRoomChecking = $this->getModel()->checkRoomIsAvailable($type, $dateStart, $dateEnd, $roomId, $jadwalRapatId);

        if ($resultScheduleRoomChecking) {
            $data['schedule_room'] = $resultScheduleRoomChecking;
            return $data;
        }

        $resultScheduleLeaderChecking = $this->getModel()->checkMeetingLeaderSchedule($type, $leaderTimeStart, $leaderTimeEnd, $jadwalRapatId, $nrpPimpinan);

        if ($resultScheduleLeaderChecking) {
            $data['schedule_leader'] = $resultScheduleLeaderChecking;
            return $data;
        }
    }

    public function configFormAddJadwalRapat($dataPost) {
        unset($dataPost['created_by']);
        $fields = array_keys($dataPost);

        $errorMsgValidation = [
            'required' => '%s tidak boleh di kosongkan.',
        ];

        $config = [];
        foreach ($fields as $key => $value) {
            $explodeKey             = explode('#', $value);
            $config[$key]['field']  = $value;
            $config[$key]['label']  = $value;
            $config[$key]['rules']  = 'required';
            $config[$key]['errors'] = $errorMsgValidation;
        }

        return $config;
    }

    private function setJadwalRapatConflictMessage($conflictDate){
        $this->success = false;
        if (isset($conflictDate['schedule_room'])) {
            $this->message = '<b>' . $conflictDate['schedule_room']->ruang_rapat_name . '</b> telah dipakai sampai tanggal <b>' . $conflictDate['schedule_room']->tanggal_end . '</b> dan ruangan ini sudah dipakai oleh <b>' . $conflictDate['schedule_room']->nama_pimpinan . '</b>. Nomor surat : ' . $conflictDate['schedule_room']->nomor_surat_prefix . $conflictDate['schedule_room']->nomor_surat . $conflictDate['schedule_room']->nomor_surat_suffix.'silahkan hubungi admin mabes.';
        } else {
            $this->message = '<b>' . $conflictDate['schedule_leader']->nama_pimpinan . '</b> telah memimpin rapat pada tanggal <b>' . $conflictDate['schedule_leader']->waktu_memimpin_start . '</b> s/d <b>' . $conflictDate['schedule_leader']->waktu_memimpin_end . '</b> di ruang <b>' . $conflictDate['schedule_leader']->ruang_rapat_name . '</b>';

        }
    }

    protected function getModel() {
        return $this->jadwalRapat;
    }

    protected function getEntityId() {
        return $this->entityId;
    }
}
?>
