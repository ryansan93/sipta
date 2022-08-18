<?php
namespace Model\Storage;
use \Model\Storage\Conf as Conf;

class Blangko_model extends Conf{
	protected $table = 'blangko';
	protected $primaryKey = 'kode';
	protected $kodeTable = 'BLG';

	public function pengajuan()
	{
		return $this->hasOne('\Model\Storage\Pengajuan_model', 'kode', 'pengajuan_kode')->with(['jenis_pengajuan', 'mahasiswa']);
	}

	public function blangko_kelengkapan()
	{
		return $this->hasMany('\Model\Storage\BlangkoKelengkapan_model', 'blangko_kode', 'kode')->with(['kelengkapan_blangko']);
	}
}
