<?php
namespace Model\Storage;
use \Model\Storage\Conf as Conf;

class Prodi_model extends Conf{
  protected $table = 'prodi';
  protected $primaryKey = 'kode';
  protected $kodeTable = 'PRD';
}
