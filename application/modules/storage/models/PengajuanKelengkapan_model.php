<?php
namespace Model\Storage;
use \Model\Storage\Conf as Conf;

class PengajuanKelengkapan_model extends Conf{
	protected $table = 'pengajuan_kelengkapan';

	public function kelengkapan_pengajuan()
	{
		return $this->hasOne('\Model\Storage\KelengkapanPengajuan_model', 'kode', 'kelengkapan_pengajuan_kode');
	}
}
