<?php
	require_once 'BaseModel.php';
	class JenisSurat extends BaseModel {

		public function __construct(){
			$this->table = parent::$tableJenisSurat;
			parent::__construct($this->table);
		}

		public function getJenisSuratByJenisSuratId($jenisSuratId) {
			$this->db->select('*');
			$this->db->from($this->table);
			$this->db->where('jenis_surat_id',$jenisSuratId);
			$result = $this->db->get();
			return $result->first_row();
		}

		public function findUndangan($jenisSuratId) {
			$this->db->select('*');
			$this->db->from($this->table);
			$this->db->where('jenis_surat_id',$jenisSuratId);
			$result = $this->db->get();
			return $result->result();
		}

		
	}

?>