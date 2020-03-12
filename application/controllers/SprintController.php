<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include 'BaseController.php';

class SprintController extends BaseController {
    protected $success  = true;
    protected $message  = '';
    protected $entity   = 'sprint';
    protected $entityId = 'sprint_id';

    public function index() {
        $status      = $this->input->get('status');
        $authStatus  = $this->session->flashdata(KEY_STATUS);
        $authMessage = $this->session->flashdata(KEY_MESSAGE);

        //get page opened
        $page = $this->input->get('status');

        $data = $this->getModel()->getDataSprint($status);

        $data = [
            'alertStatus'       => $authStatus,
            'alertMessage'      => $authMessage,
            'page'              => $page,
            $this->entity . 's' => $data,
        ];
        return view($this->entity . '.index', $data);
    }

    public function add_post() {
        $this->message = "Data successfully entered.";
        $data          = new stdClass();
        $entityId      = $this->entityId;

        $dataPost                                                     = $this->input->post();
        $additionalData                                               = $dataPost['additional'];
        $penomoranSuratId                                             = $dataPost['penomoran_surat_id'];
        $dataPost['tanggal_start'] == '' ? $dataPost['tanggal_start'] = null : "";
        $dataPost['tanggal_end'] == '' ? $dataPost['tanggal_end']     = null : "";
        $pageAccessed                                                 = $dataPost['page_accessed'];
        unset($dataPost['additional']);
        unset($dataPost['page_accessed']);

        //insert data sprint before check double sprint
        $sprintId = $this->getModel()->insert($dataPost);

        //form validation
        $config = $this->configFormAddSprint($dataPost);
        $this->form_validation->set_rules($config);

        if ($sprintId) {
            $result = $this->additionalDataProcess($additionalData, $penomoranSuratId);
            if (!$result) {
                $this->getModel()->delete($sprintId);
                $this->success = false;
                $this->message = 'Data failed to be entered';
                $data          = '';
            }
        }

        //check double sprint
        $doubleSprintCheck = $this->doubleSprintChecking($dataPost['tanggal_start'], $dataPost['tanggal_end'], $pageAccessed);

        if ($doubleSprintCheck['status'] == true) {
            $this->getModel()->delete($sprintId);
            $this->success = false;
            $number        = 1;
            foreach ($doubleSprintCheck['data_peserta'] as $keyDataPeserta => $dataPeserta) {
                if (count($dataPeserta) > 1) {
                    foreach ($dataPeserta as $element) {
                        $sprintName[] = $element['sprint_name'];
                    }
                    $pesertaBentrok .= '<br>' . $number . '.' . $keyDataPeserta . ' (' . implode(',', $sprintName) . ')';
                    $number++;
                }
            }
            $this->message = "Terdapat beberapa peserta rapat yang bentrok : " . $pesertaBentrok;
            $data          = [];

            $response = $this->createResponse($this->success, $this->message, $this->entity, $data);
            redirect($this->entity . '/add');
        }

        $response = $this->createResponse($this->success, $this->message, $this->entity, $data);

        if ($response->success) {
            redirect($this->entity);
        } else {
            return view($this->entity . '/add');
        }
    }

    public function edit_get($sprintId) {
        $authStatus  = $this->session->flashdata(KEY_STATUS);
        $authMessage = $this->session->flashdata(KEY_MESSAGE);

        //get page opened
        $page = $this->input->get('status');

        $data = $this->getModel()->find($sprintId);

        $dataPeserta = $this->peserta->getPesertaBySprintId($sprintId);

        $data = [
            'alertStatus'  => $authStatus,
            'alertMessage' => $authMessage,
            $this->entity  => $data,
            'peserta'      => $dataPeserta,
            'page'         => $page,
        ];

        return view($this->entity . '.edit', $data);
    }

    public function edit_post($sprintId) {
        $this->message = "Data sprint berhasil di update.";
        $data          = new stdClass();
        $entityId      = $this->entityId;

        $dataPost = $this->input->post();

        //variabelize data post
        $dateStart       = $dataPost['tanggal_start'];
        $dateEnd         = $dataPost['tanggal_end'];
        $pageAccessed    = $dataPost['page_accessed'];
        $tanggalStartOld = $dataPost['tanggal_start_old'];
        $tanggalEndtOld  = $dataPost['tanggal_end_old'];

        unset($dataPost['tanggal_end_old']);
        unset($dataPost['additional']);
        unset($dataPost['double_sprint']);
        unset($dataPost['tanggal_start_old']);
        unset($dataPost['tanggal_end_old']);
        unset($dataPost['page_accessed']);

        $dataPost['tanggal_start'] == '' ? $dataPost['tanggal_start'] = null : "";
        $dataPost['tanggal_end'] == '' ? $dataPost['tanggal_end']     = null : "";

        $data->$entityId = $this->getModel()->update($dataPost, $sprintId);

        $doubleSprintCheck             = $this->doubleSprintChecking($dateStart, $dateEnd, $pageAccessed);
        $dataPost['page_accessed']     = $pageAccessed;
        $dataPost['tanggal_start_old'] = $tanggalStartOld;
        $dataPost['tanggal_end_old']   = $tanggalEndtOld;
        $resultDoubleSprint            = $this->getActionForEditSprint($doubleSprintCheck, $dataPost, $sprintId);
        
        if ($doubleSprintCheck['status'] == true && $resultDoubleSprint['status_action'] == false) {
            $this->success = false;
            $number        = 1;
            foreach ($doubleSprintCheck['data_peserta'] as $keyDataPeserta => $dataPeserta) {
                if (count($dataPeserta) > 1) {
                    foreach ($dataPeserta as $element) {
                        $sprintName[] = $element['sprint_name'];
                    }
                    $pesertaBentrok .= '<br>' . $number . '.' . $keyDataPeserta . ' (' . implode(',', $sprintName) . ')';
                    $number++;
                }
            }
            $this->message = "Terdapat beberapa peserta rapat yang bentrok : " . $pesertaBentrok;
            $data          = [];

            $response = $this->createResponse($this->success, $this->message, $this->entity, $data);
            redirect($this->entity . '/' . $sprintId . '/edit?status=' . $resultDoubleSprint['page_accessed']);
        }

        if ($data->$entityId < 0) {
            $this->success = false;
            $this->message = 'Data failed to be update';
            $data          = '';
        } else {
            $data = (object) $dataPost;
        }

        $response = $this->createResponse($this->success, $this->message, $this->entity, $data);
        if ($response->success) {
            redirect($this->entity.'?status=list_sprint');
        } else {
            redirect($this->entity . '/' . $sprintId . '/edit?status='.$pageAccessed);
        }
    }

    public function show($id) {
        $authStatus  = $this->session->flashdata(KEY_STATUS);
        $authMessage = $this->session->flashdata(KEY_MESSAGE);

        $data             = $this->getModel()->find($id);
        $penomoranSuratId = $data->penomoran_surat_id;

        $dataPeserta = $this->peserta->getAllPesertaByPenomoranSuratId($penomoranSuratId);

        $data = [
            'alertStatus'  => $authStatus,
            'alertMessage' => $authMessage,
            $this->entity  => $data,
            'peserta'      => $dataPeserta,
        ];

        return view($this->entity . '.show', $data);
    }

    public function deactivate($sprintId) {
        $this->message = 'Data successfully deleted';
        $authStatus    = $this->session->flashdata(KEY_STATUS);
        $authMessage   = $this->session->flashdata(KEY_MESSAGE);

        $dataPost = ['status_aktif' => 0];
        $data     = $this->getModel()->update($dataPost, $sprintId);
        if ($data >= 0) {
            $dataSprint       = $this->getModel()->getPenomoranSuratIdBySprint($sprintId);
            $penomoranSuratId = $dataSprint->penomoran_surat_id;
            $data             = $this->lampiranPeserta->updateStatusAktifByPenomoranId($dataPost, $penomoranSuratId);
        }

        $pageAccessed  = $this->input->get('status');
        $getDataSprint = $this->getModel()->find($sprintId);

        if ($pageAccessed == 'double_sprint') {
            $doubleSprintStatus = false;
            $dateStartOld       = $getDataSprint->tanggal_start;
            $dateEndOld         = $getDataSprint->tanggal_end;
            $doubleSprintOld    = $this->doubleSprintChecking($dateStartOld, $dateEndOld);

            $sprintIdAlowedToEnable = [];
            foreach ($doubleSprintOld['data_sprint'] as $keyDoubleSprintOld => $valueDoubleSprintOld) {
                //checking double sprint before status_doble sprint set false
                if ($valueDoubleSprintOld['sprint_id'] != $sprintId) {
                    $resultChecking = $this->doubleSprintChecking($valueDoubleSprintOld['tanggal_start'], $valueDoubleSprintOld['tanggal_end'], $pageAccessed);
                    if ($resultChecking['status'] == false) {
                        $sprintIdAlowedToEnable[] = $valueDoubleSprintOld['sprint_id'];
                    }
                }

            }

            if ($sprintIdAlowedToEnable) {
                $this->getModel()->setDoubleStatus($sprintIdAlowedToEnable, $doubleSprintStatus);
            }
        }

        if ($data < 0) {
            $this->success = false;
            $this->message = 'Data failed to be delete';
            $data          = '';
        } else {
            $data = (object) $dataPost;
        }

        $response = $this->createResponse($this->success, $this->message, $this->entity, $data);

        redirect($this->entity);
    }

    //insert pejabat and peserta by jadwal rapat
    public function additionalDataProcess($additionalData, $penomoranSuratId) {
        $personelDatas = [];
        foreach ($additionalData as $additionalKey => $additionalValue) {
            foreach ($additionalValue as $personelKey => $personelData) {
                $arrayDataPersonel = explode('/', $personelData);
                $nrp               = $arrayDataPersonel[0];
                $name              = $arrayDataPersonel[2];
                $pangkat           = $arrayDataPersonel[1];
                $kodeSatuan        = $arrayDataPersonel[3];
                $jabatanStruktur   = $arrayDataPersonel[4];

                $personelDatas[$additionalKey][$personelKey]['penomoran_surat_id'] = $penomoranSuratId;
                $personelDatas[$additionalKey][$personelKey]['nrp']                = $nrp;
                $personelDatas[$additionalKey][$personelKey]['name']               = $name;
                $personelDatas[$additionalKey][$personelKey]['pangkat']            = $pangkat;
                $personelDatas[$additionalKey][$personelKey]['kode_satuan']        = $kodeSatuan;
                $personelDatas[$additionalKey][$personelKey]['jabatan_struktur']   = $jabatanStruktur;
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

    public function configFormAddSprint($dataPost) {
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

    public function doubleSprintChecking($dateStart, $dateEnd, $pageAccessed = "") {
        //check double sprint date
        $doubleSprintDate  = $this->getModel()->checkDoubleSprint($dateStart, $dateEnd);
        $penomoranSuratIds = array_column($doubleSprintDate, 'penomoran_surat_id');

        if ($pageAccessed == 'double_sprint' || $pageAccessed == 'list_sprint' || $pageAccessed == 'add_sprint' || $pageAccessed == 'belum_set_waktu') {
            $sprintCount = 1;
        } else {
            $sprintCount = 0;
        }

        $doubleSprint                     = false;
        $penomoranSuratIdPesertaByNrp     = [];
        $dataPenomoranPesertaDoubleSprint = [];
        if (count($doubleSprintDate) > $sprintCount) {
            $pesertaSprint = $this->peserta->getPesertaByPenomoranSuratId($penomoranSuratIds);
            foreach ($pesertaSprint as $element) {
                $name                                  = $element['name'];
                $penomoranSuratIdPesertaByNrp[$name][] = $element;

                unset($element['nrp']);
                unset($element['name']);
                $PenomoranPesertaDoubleSprint[$name][] = $element;
            }

            $penomoranSuratIdDoubeSprint = [];
            foreach ($PenomoranPesertaDoubleSprint as $keypenomoranSuratIdPeserta => $penomoranSuratIdPeserta) {
                if (count($penomoranSuratIdPeserta) > $sprintCount) {
                    $penomoranSuratIdDoubeSprint = array_merge($penomoranSuratIdDoubeSprint, $penomoranSuratIdPeserta);
                }
            }

            $dataPenomoranPesertaDoubleSprint = array_map("unserialize", array_unique(array_map("serialize", $penomoranSuratIdDoubeSprint)));

            $doubleSprint = $penomoranSuratIdDoubeSprint ? true : false;
        }

        $response['status']       = $doubleSprint;
        $response['data_peserta'] = $penomoranSuratIdPesertaByNrp;
        $response['data_sprint']  = $dataPenomoranPesertaDoubleSprint;

        return $response;
    }

    private function getActionForEditSprint($doubleSprint, $dataPost, $sprintId) {
        $statusAction = true;

        $pageAcessed      = $dataPost['page_accessed'];
        $penomoranSuratId = $dataPost['penomoran_surat_id'];

        if ($pageAcessed == 'belum_set_waktu') {
            if ($doubleSprint['data_peserta']) {
                $doubleSprintStatus = true;

                //arrange sprint_id into single array
                foreach ($doubleSprint['data_sprint'] as $keyDoubleSprintOld => $valueDoubleSprintOld) {
                    $sprintIdDoubleSprint[] = $valueDoubleSprintOld['sprint_id'];
                }

                if ($sprintIdDoubleSprint) {
                    $this->getModel()->setDoubleStatus($sprintIdDoubleSprint, $doubleSprintStatus);
                }
            }
        } elseif ($pageAcessed == 'double_sprint') {
            if ($doubleSprint['data_peserta']) {
                $doubleSprintStatus = false;
                $dateStartOld       = $dataPost['tanggal_start_old'];
                $dateEndOld         = $dataPost['tanggal_end_old'];

                $doubleSprintOld = $this->doubleSprintChecking($dateStartOld, $dateEndOld);

                foreach ($doubleSprintOld['data_sprint'] as $keyDoubleSprintOld => $valueDoubleSprintOld) {
                    //checking double sprint before status_doble sprint set false
                    if ($valueDoubleSprintOld['double_sprint'] == true) {
                        $resultChecking = $this->doubleSprintChecking($valueDoubleSprintOld['tanggal_start'], $valueDoubleSprintOld['tanggal_end'], $pageAcessed);

                        if (!$resultChecking['data_sprint']) {
                            $sprintIdAlowedToEnable[] = $valueDoubleSprintOld['sprint_id'];
                        }
                    }

                }
                $this->getModel()->setDoubleStatus($sprintIdAlowedToEnable, $doubleSprintStatus);
            } else {
                $doubleSprintStatus = false;
                $dateStartOld       = $dataPost['tanggal_start_old'];
                $dateEndOld         = $dataPost['tanggal_end_old'];

                $doubleSprintOld        = $this->doubleSprintChecking($dateStartOld, $dateEndOld, $pageAcessed);
                $sprintIdAlowedToEnable = [];
                foreach ($doubleSprintOld['data_sprint'] as $keyDoubleSprintOld => $valueDoubleSprintOld) {
                    //checking double sprint before status_doble sprint set false
                    $resultChecking = $this->doubleSprintChecking($valueDoubleSprintOld['tanggal_start'], $valueDoubleSprintOld['tanggal_end'], $pageAcessed);

                    if (!$resultChecking['data_sprint']) {
                        $sprintIdAlowedToEnable[] = $valueDoubleSprintOld['sprint_id'];
                    }

                }

                $this->getModel()->setDoubleStatus($sprintIdAlowedToEnable, $doubleSprintStatus);

            }
        } else {
            $statusAction = false;
        }
        $response['status_action'] = $statusAction;
        $response['page_accessed'] = $pageAcessed;
        return $response;
    }

    public function getNomorSuratSprint() {
        header("Content-type:application/json");
        $data = $this->penomoranSurat->getNomorSuratForSprint();
        echo json_encode($data);
    }

    protected function getModel() {
        return $this->sprint;
    }

    protected function getEntityId() {
        return $this->entityId;
    }
}
?>
