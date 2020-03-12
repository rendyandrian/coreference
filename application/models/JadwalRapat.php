<?php
require_once 'BaseModel.php';
class JadwalRapat extends BaseModel {

	public function __construct(){
		$this->table = parent::$tableJadwalRapat;
		parent::__construct($this->table);
		$this->idColumn = $this->table.'_id';
	}
	
	public function all() {
		$this->db->from($this->table);
		$this->db->join(parent::$tablePenomoranSurat,'penomoran_surat_id','left');
		$this->db->join(parent::$tableRuangRapat,'ruang_rapat_id');
		$this->db->where('status_aktif = 1');
		$this->db->order_by($this->idColumn, 'desc');
		// echo $this->db->last_query();
		$data = $this->db->get();
		return $data->result();
	}

    public function find($id) {
        $this->db->from($this->table);
        $this->db->join(parent::$tablePenomoranSurat, 'penomoran_surat_id', 'left');
        $this->db->join(parent::$tableRuangRapat, 'ruang_rapat_id');
        $this->db->where('status_aktif = 1');
        $this->db->where($this->idColumn, $id);
        $data = $this->db->get();
        return $data->first_row();
    }

    public function checkRoomIsAvailable($type, $dateStart, $dateEnd, $roomId, $jadwalRapatId) {
        if ($type == 'edit') {
            $jadwalRapatId = ' jadwal_rapat_id != ' . $jadwalRapatId . ' and ';
        }
        $query = "select * from `jadwal_rapat`
			join ruang_rapat using (ruang_rapat_id)
			left join penomoran_surat using (penomoran_surat_id)
			where (" . $jadwalRapatId . "jadwal_rapat.status_aktif = true and ruang_rapat_id=" . $roomId . " and
			('" . $dateStart . "' between tanggal_start and tanggal_end or '" . $dateEnd . "' between tanggal_start and tanggal_end)) or
			((" . $jadwalRapatId . "(tanggal_start between '" . $dateStart . "' and '" . $dateEnd . "')
			and ruang_rapat_id = " . $roomId . " and jadwal_rapat.status_aktif = true
			)
			or (" . $jadwalRapatId . "(tanggal_end between '" . $dateStart . "' and '" . $dateEnd . "')
			and ruang_rapat_id = " . $roomId . " and jadwal_rapat.status_aktif = true
			)) order by tanggal_end desc";
        $data = $this->db->query($query);
        return $data->first_row();
    }

    public function checkMeetingLeaderSchedule($type, $dateStart, $dateEnd, $jadwalRapatId, $nrpPimpinan) {
        if ($type == 'edit') {
            $jadwalRapatId = " jadwal_rapat_id != " . $jadwalRapatId . " and nrp_pimpinan='" . $nrp . "' and";
        }
        $query = "select * from `jadwal_rapat`
			join ruang_rapat using (ruang_rapat_id)
			left join penomoran_surat using (penomoran_surat_id)
			where (" . $jadwalRapatId . "('" . $dateStart . "' between waktu_memimpin_start and waktu_memimpin_end or '" . $dateEnd . "' between waktu_memimpin_start and waktu_memimpin_end) and jadwal_rapat.status_aktif = true) or
			((" . $jadwalRapatId . "(waktu_memimpin_start between '" . $dateStart . "' and '" . $dateEnd . "') and jadwal_rapat.status_aktif = true)
			or (" . $jadwalRapatId . "(waktu_memimpin_end between '" . $dateStart . "' and '" . $dateEnd . "') and jadwal_rapat.status_aktif = true)) order by waktu_memimpin_end desc";
        $data = $this->db->query($query);
        return $data->first_row();
    }
    public function filterJadwalRapat($filter) {
        isset($filter['tanggal_start']) ? $tanggalStart  = $filter['tanggal_start'] : $tanggalStart  = "";
        isset($filter['tanggal_end']) ? $tanggalEnd      = $filter['tanggal_end'] : $tanggalEnd      = "";
        isset($filter['nrp_pimpinan']) ? $nrpPimpinan    = $filter['nrp_pimpinan'] : $nrpPimpinan    = "";
        isset($filter['ruang_rapat_id']) ? $ruangRapatId = $filter['ruang_rapat_id'] : $ruangRapatId = "";

        $this->db->from($this->table);
        $this->db->join(parent::$tablePenomoranSurat, parent::$tablePenomoranSurat . '_id', 'left');
        $this->db->join(parent::$tableRuangRapat, parent::$tableRuangRapat . '_id');
        $this->db->where($this->table . '.status_aktif', true);
        if ($tanggalStart) {
            $this->db->where("tanggal_start >='" . $tanggalStart . "'");
        }

        if ($tanggalEnd) {
            $this->db->where("tanggal_end <='" . $tanggalEnd . "'");
        }

        if ($nrpPimpinan) {
            $this->db->where("nrp_pimpinan ='" . $nrpPimpinan . "'");
        }

        if ($ruangRapatId) {
            $this->db->where("ruang_rapat_id ='" . $ruangRapatId . "'");
        }

        $data = $this->db->get();

        return $data->result();
    }

}

?>