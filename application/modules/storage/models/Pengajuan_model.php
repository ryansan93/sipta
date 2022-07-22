<?php
namespace Model\Storage;
use \Model\Storage\Conf as Conf;

class Pengajuan_model extends Conf{
	protected $table = 'pengajuan';
	protected $primaryKey = 'kode';
	protected $kodeTable = 'PGJ';

	public function jenis_pengajuan()
	{
		return $this->hasOne('\Model\Storage\JenisPengajuan_model', 'kode', 'jenis_pengajuan_kode');
	}

	public function mahasiswa()
	{
		return $this->hasOne('\Model\Storage\Mahasiswa_model', 'nim', 'nim');
	}

	public function jenis_pelaksanaan()
	{
		return $this->hasOne('\Model\Storage\JenisPelaksanaan_model', 'kode', 'jenis_pelaksanaan_kode');
	}

	public function prodi()
	{
		return $this->hasOne('\Model\Storage\Prodi_model', 'kode', 'prodi_kode');
	}

	public function pengajuan_dosen()
	{
		return $this->hasMany('\Model\Storage\PengajuanDosen_model', 'pengajuan_kode', 'kode');
	}

	public function pengajuan_kelengkapan()
	{
		return $this->hasMany('\Model\Storage\PengajuanKelengkapan_model', 'pengajuan_kode', 'kode')->with(['kelengkapan_pengajuan']);
	}
}
