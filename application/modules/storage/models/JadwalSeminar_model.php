<?php
namespace Model\Storage;
use \Model\Storage\Conf as Conf;

class JadwalSeminar_model extends Conf{
	protected $table = 'jadwal_seminar';
	protected $primaryKey = 'kode';
	protected $kodeTable = 'JSM';

	public function detail()
	{
		return $this->hasMany('\Model\Storage\JadwalSeminarDet_model', 'jadwal_seminar_kode', 'kode')->with(['jenis_pengajuan_asal', 'jenis_pengajuan_tujuan']);
	}
}
