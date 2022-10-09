<?php
namespace Model\Storage;
use \Model\Storage\Conf as Conf;

class SkPembimbingDosen_model extends Conf{
	protected $table = 'sk_pembimbing_dosen';

	public function dosen()
	{
		return $this->hasOne('\Model\Storage\Dosen_model', 'nip', 'nip');
	}
}
