<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include 'BaseController.php';

class PesertaController extends BaseController {
    protected $success  = true;
    protected $message  = '';
    protected $entity   = 'lampiran_peserta';
    protected $entityId = 'lampiran_peserta_id';

    public function add_post() {
        header("Content-type:application/json");
        $dataPost = $this->input->post();
        $data     = $this->getModel()->insert($dataPost);
        if (!$data) {
            $this->success = false;
        }
        $respone['success']    = $this->success;
        $respone['message']    = $this->message;
        $respone['lampiran_peserta_id'] = $data;
        echo json_encode($respone);
    }

    public function delete($id) {
        $this->message = "Data successfully deleted.";
        $data          = $this->getModel()->delete($id);

        if (!$data) {
            $this->success = false;
            $this->message = "Data failed to delete.";
        }

        $respone['success'] = $this->success;
        $respone['message'] = $this->message;
        echo json_encode($respone);
    }

    protected function getModel() {
        return $this->peserta;
    }

    protected function getEntityId() {
        return $this->entityId;
    }
}
?>
