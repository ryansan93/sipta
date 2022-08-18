<?php
namespace Model\Storage;
use \Model\Storage\Conf as Conf;

class NotifikasiJadwalSeminar_model extends Conf{
	protected $table = 'notifikasi_jadwal_seminar';
	protected $primaryKey = 'id';

	public function mahasiswa()
	{
		return $this->hasOne('\Model\Storage\Mahasiswa_model', 'nim', 'nim');
	}

	public function pengajuan()
	{
		return $this->hasOne('\Model\Storage\Pengajuan_model', 'kode', 'pengajuan_kode');
	}

	public function jenis_pengajuan_asal()
	{
		return $this->hasOne('\Model\Storage\JenisPengajuan_model', 'kode', 'jenis_pengajuan_kode_asal');
	}

	public function jenis_pengajuan_tujuan()
	{
		return $this->hasOne('\Model\Storage\JenisPengajuan_model', 'kode', 'jenis_pengajuan_kode_tujuan');
	}
}
