<?php
namespace Model\Storage;
use \Model\Storage\Conf as Conf;

class Mahasiswa_model extends Conf{
	protected $table = 'mahasiswa';
	protected $primaryKey = 'nim';

	public function prodi()
	{
		return $this->hasOne('\Model\Storage\Prodi_model', 'kode', 'prodi_kode');
	}
}
