<?php
namespace Model\Storage;
use \Model\Storage\Conf as Conf;

class JadwalSeminarDet_model extends Conf{
	protected $table = 'jadwal_seminar_det';

	public function jenis_pengajuan_asal()
	{
		return $this->hasOne('\Model\Storage\JenisPengajuan_model', 'kode', 'asal');
	}

	public function jenis_pengajuan_tujuan()
	{
		return $this->hasOne('\Model\Storage\JenisPengajuan_model', 'kode', 'tujuan');
	}
}
