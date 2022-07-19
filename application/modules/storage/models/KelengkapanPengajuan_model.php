<?php
namespace Model\Storage;
use \Model\Storage\Conf as Conf;

class KelengkapanPengajuan_model extends Conf{
	protected $table = 'kelengkapan_pengajuan';
	protected $primaryKey = 'kode';
	protected $kodeTable = 'KPG';

	public function jenis_pengajuan()
	{
		return $this->hasOne('\Model\Storage\JenisPengajuan_model', 'kode', 'jenis_pengajuan_kode');
	}
}
