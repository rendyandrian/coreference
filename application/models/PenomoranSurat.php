<?php
require_once 'BaseModel.php';
class PenomoranSurat extends BaseModel {

    public function __construct() {
        $this->table    = parent::$tablePenomoranSurat;
        $this->idColumn = $this->table . '_id';
        parent::__construct($this->table);
    }

    public function all($statusNomorSurat='publish') {
        $this->db->select('penomoran_surat_id');
        $this->db->select('jenis_surat_name');
        $this->db->select('tgl_surat');
        $this->db->select('nomor_surat_prefix');
        $this->db->select('nomor_surat');
        $this->db->select('nomor_surat_suffix');
        $this->db->select('concat(nomor_surat_prefix,nomor_surat,nomor_surat_suffix) as nomor_surat_lengkap');
        $this->db->select('file_scan_surat');
        $this->db->select('status_file_scan');
        $this->db->from($this->table);
        $this->db->join(parent::$tableJenisSurat, 'jenis_surat_id');
        if($this->isMabes()!=1) {
            $this->db->join(parent::$tableUser, 'user_id');
            $this->db->where(parent::$tableUser.'.kode_satuan', $this->userLoggedInKodeSatuan());
        }
        $this->db->where('status_nomor_surat', $statusNomorSurat);
        $this->db->where($this->table.'.status_aktif', 1);
        $this->db->order_by($this->idColumn, 'desc');
        $data = $this->db->get();
        return $data->result();
    }


    public function insertPeserta($data){
        $this->db->insert('lampiran_peserta', $data);
        return $this->db->insert_id();	
    }
    
    public function insertTembusan($data){
        $this->db->insert('tembusan', $data);
        return $this->db->insert_id();	
    }
    
    public function insertPenomoranSurat($data){
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();	
    }

    public function getLastRecord($jenisSurat){
        $this->db->from('log_tgl_surat_terupdate');
        $this->db->where('jenis_surat_id', $jenisSurat);
        $this->db->order_by('tgl_surat_terupdate_id', 'desc');
        $data = $this->db->get();
        return $data->first_row();	
    }

    public function insertLogTgl($dataLogPenomoran){
        $this->db->insert('log_tgl_surat_terupdate', $dataLogPenomoran);
        return $this->db->insert_id();	

    }

    public function getLastRecordPenomoranSurat($tgl_surat,$jenisSurat){
        $this->db->from('log_tgl_surat_terupdate');
        $this->db->where('tgl', $tgl_surat);
        $this->db->where('jenis_surat_id', $jenisSurat);
        $this->db->order_by('jenis_surat_id', 'desc');
        $data = $this->db->get();
        // print_r($this->db->last_query());
        return $data->first_row();	
    }
    
    public function getAddLastRecordPenomoranSurat($tgl_surat,$jenisSurat){
        $this->db->from($this->table);
        $this->db->where('jenis_surat_id', $jenisSurat);
        $this->db->order_by('nomor_surat', 'desc');
        $data = $this->db->get();
        // print_r($this->db->last_query());die();
        return $data->first_row();	
    }

    public function getCekLastRecordPenomoranSuratByJenisSurat($jenisSurat){
        $this->db->from($this->table);
        $this->db->where('jenis_surat_id', $jenisSurat);
        $this->db->order_by($this->table.'_id', 'desc');
        $data = $this->db->get();
        return $data->first_row();	
    }


    public function getUpdatePenomoranSurat($tgl_surat,$jenisSurat){
        $this->db->from($this->table);
        $this->db->where('tgl_surat', $tgl_surat);
        $this->db->where('status_nomor_surat','draft');
        $this->db->where('jenis_surat_id',$jenisSurat);
        $this->db->order_by($this->table.'_id', 'asc');
        $data = $this->db->get();
        // print_r($this->db->last_query());
        return $data->first_row();	
    }

    
    public function getCountKoutaSurat($tgl_surat,$idJenis){
        $this->db->select('count(penomoran_surat_id) as total');
        $this->db->from($this->table);
        $this->db->where('tgl_surat', $tgl_surat);
        $this->db->where('jenis_surat_id', $idJenis);
        $this->db->where('status_nomor_surat','draft');
        $this->db->order_by($this->table.'_id', 'asc');
        $data = $this->db->get();
        return $data->first_row();	
    }

    public function getCountLogSurat($tgl_surat,$idJenis){
        $this->db->select('count(tgl) as log');
        $this->db->from('log_tgl_surat_terupdate');
        $this->db->where('tgl', $tgl_surat);
        $this->db->where('jenis_surat_id', $idJenis);
        $data = $this->db->get();
        return $data->first_row();	
    }
    
    public function find($id){
        $this->db->from($this->table);
        $this->db->where($this->table.'_id', $id);
        $data = $this->db->get();
        return $data->first_row();	
    }
    

    public function getNomorSuratForSprint() {
        $this->db->from($this->table);
        if($this->isMabes()!=1) {
            $this->db->join(parent::$tableUser, 'user_id');
            $this->db->where(parent::$tableUser.'.kode_satuan', $this->userLoggedInKodeSatuan());
        }
        $this->db->where($this->table.'.jenis_surat_id', 7);
        $this->db->where('penomoran_surat_id not in (select penomoran_surat_id from sprint s where status_aktif = true)');
        $this->db->order_by($this->idColumn, 'desc');
        $data = $this->db->get();
        return $data->result();
    }

    public function hasOpenedSurat() {
        $this->db->from($this->table);
        $this->db->where('status_nomor_surat','publish');
        $this->db->where('status_file_scan','open');
        $this->db->where('status_aktif', 1);
        if($this->isMabes()!=1) {
            $this->db->join(parent::$tableUser, 'user_id');
            $this->db->where(parent::$tableUser.'.kode_satuan', $this->userLoggedInKodeSatuan());
        }
        $data = $this->db->get();
        return $data->num_rows() > 0 ? true : false;  
    }
}

?>