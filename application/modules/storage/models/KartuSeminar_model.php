<?php
namespace Model\Storage;
use \Model\Storage\Conf as Conf;

class KartuSeminar_model extends Conf{
	protected $table = 'kartu_seminar';
	protected $primaryKey = 'kode';
	protected $kodeTable = 'KSM';

	public function pengajuan()
	{
		return $this->hasOne('\Model\Storage\Pengajuan_model', 'kode', 'pengajuan_kode')->with(['mahasiswa', 'ruang_kelas', 'jenis_pelaksanaan']);
	}
}
