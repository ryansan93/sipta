<?php
namespace Model\Storage;
use \Model\Storage\Conf as Conf;

class RancanganProposalKelengkapan_model extends Conf{
	protected $table = 'rancangan_proposal_kelengkapan';

	public function kelengkapan_pengajuan()
	{
		return $this->hasOne('\Model\Storage\KelengkapanPengajuan_model', 'kode', 'kelengkapan_pengajuan_kode');
	}
}
