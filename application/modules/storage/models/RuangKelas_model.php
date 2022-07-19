<?php
namespace Model\Storage;
use \Model\Storage\Conf as Conf;

class RuangKelas_model extends Conf{
  protected $table = 'ruang_kelas';
  protected $primaryKey = 'kode';
  protected $kodeTable = 'RGK';
}
