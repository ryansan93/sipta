<?php
namespace Model\Storage;
use \Model\Storage\Conf as Conf;

class JamSeminarUjian_model extends Conf{
  protected $table = 'jam_seminar_ujian';
  protected $primaryKey = 'id';

  public function jenis_pengajuan()
	{
		return $this->hasOne('\Model\Storage\JenisPengajuan_model', 'kode', 'jenis_pengajuan_kode');
	}
}
