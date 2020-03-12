<?php
	require_once 'BaseModel.php';
	class Tembusan extends BaseModel {

		public function __construct(){
			$this->table = parent::$tableTembusan;
			parent::__construct($this->table);
		}
		public function findByPenomoranId($idPenomoran){
			$this->db->from($this->table);
			$this->db->where('penomoran_surat_id', $idPenomoran);
			$data = $this->db->get();
			return $data->result();		
		}
		
		public function deleteByPenomoran($idPenomoran){
			$this->db->where('penomoran_surat_id', $idPenomoran);
			$this->db->delete('tembusan'); 
			return $this->db->affected_rows();
		}

	}

?>