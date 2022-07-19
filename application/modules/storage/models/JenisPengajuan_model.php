<?php
namespace Model\Storage;
use \Model\Storage\Conf as Conf;

class JenisPengajuan_model extends Conf{
	protected $table = 'jenis_pengajuan';
	protected $primaryKey = 'kode';
	protected $kodeTable = 'JPG';
}
