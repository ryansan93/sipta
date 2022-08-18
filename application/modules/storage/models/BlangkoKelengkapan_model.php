<?php
namespace Model\Storage;
use \Model\Storage\Conf as Conf;

class BlangkoKelengkapan_model extends Conf{
	protected $table = 'blangko_kelengkapan';

	public function kelengkapan_blangko()
	{
		return $this->hasOne('\Model\Storage\KelengkapanBlangko_model', 'kode', 'kelengkapan_blangko_kode');
	}
}
