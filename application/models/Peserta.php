<?php
	require_once 'BaseModel.php';
	class Peserta extends BaseModel {

		public function __construct(){
			$this->table = parent::$tablePeserta;
			parent::__construct($this->table);
		} 
		
		public function getPesertaByJadwalRapat($jadwalRapatId){
			$this->db->from($this->table);
			$this->db->where(parent::$tableJadwalRapat.'_id',$jadwalRapatId);
			$data = $this->db->get();

			return $data->result_array();
		}

		public function getPesertaBySprintId($sprintId){
			$this->db->from($this->table);
			$this->db->join(parent::$tableSprint,parent::$tablePenomoranSurat.'_id');
			$this->db->where(parent::$tableSprint.'_id',$sprintId);
			$this->db->where($this->table.'.status_aktif = true');
			$data = $this->db->get();
			return $data->result_array();
		}

		public function getAllPesertaByPenomoranSuratId($penomoranSuratId){
			$this->db->from($this->table);
			$this->db->join(parent::$tableSprint,parent::$tablePenomoranSurat.'_id');
			$this->db->where($this->table.'.status_aktif = true');
			$this->db->where(parent::$tableSprint.'.status_aktif = true');
			$this->db->where_in(parent::$tablePenomoranSurat.'_id',$penomoranSuratId);
			$data = $this->db->get();
			return $data->result_array();
		}

		public function getPesertaByPenomoranSuratId($penomoranSuratId){
			$this->db->select('distinct(nrp)');
			$this->db->select('penomoran_surat_id');
			$this->db->select('double_sprint');
			$this->db->select('sprint_id');
			$this->db->select('sprint_name');
			$this->db->select('tanggal_start');
			$this->db->select('tanggal_end');
			$this->db->select('name');
			$this->db->from($this->table);
			$this->db->join(parent::$tableSprint,parent::$tablePenomoranSurat.'_id');
			$this->db->where($this->table.'.status_aktif = true');
			$this->db->where(parent::$tableSprint.'.status_aktif = true');
			$this->db->where_in(parent::$tablePenomoranSurat.'_id',$penomoranSuratId);
			$data = $this->db->get();
			// echo $this->db->last_query();die();
			return $data->result_array();
		}
	}

?>