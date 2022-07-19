<?php
namespace Model\Storage;
use \Model\Storage\Conf as Conf;

class JenisPelaksanaan_model extends Conf{
  protected $table = 'jenis_pelaksanaan';
  protected $primaryKey = 'kode';
  protected $kodeTable = 'JNP';
}
