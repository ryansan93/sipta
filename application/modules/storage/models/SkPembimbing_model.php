<?php
namespace Model\Storage;
use \Model\Storage\Conf as Conf;

class SkPembimbing_model extends Conf{
	protected $table = 'sk_pembimbing';
	protected $primaryKey = 'id';

	public function mahasiswa()
	{
		return $this->hasOne('\Model\Storage\Mahasiswa_model', 'nim', 'nim')->with(['prodi'])->orderBy('nama', 'asc');
	}

	public function sk_pembimbing_dosen()
	{
		return $this->hasMany('\Model\Storage\SkPembimbingDosen_model', 'id_header', 'id')->with(['dosen'])->orderBy('nama', 'asc');
	}
}
