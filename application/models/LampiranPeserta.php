<?php
	require_once 'BaseModel.php';
	class LampiranPeserta extends BaseModel {

		public function __construct(){
			$this->table = parent::$tableLampiranPeserta;
			parent::__construct($this->table);
		}

		public function findName($idPenomoran){
			$this->db->from($this->table);
			$this->db->where('penomoran_surat_id', $idPenomoran);
			$data = $this->db->get();
			return $data->result();		
		}
		public function deleteByPenomoran($idPenomoran){
			$this->db->where('penomoran_surat_id', $idPenomoran);
			$this->db->delete('lampiran_peserta'); 
			return $this->db->affected_rows();
		}

		public function countByKodeSatuan($kodeSatuan,$jadwalId) {
			$this->db->select('count(kode_satuan) as total');
			$this->db->from($this->table);
			$this->db->where('jadwal_rapat_id',$jadwalId);
			$this->db->like('kode_satuan', $kodeSatuan, 'after');     // Produces: WHERE `title` LIKE 'match%' ESCAPE '!'
			$result = $this->db->get();
			return $result->first_row();
		}

		public function updateStatusAktifByPenomoranId($data, $id) {
			$this->db->where('penomoran_surat_id', $id);
			$this->db->update($this->table, $data);
		   	return $this->db->affected_rows();
	   }

	}

?>