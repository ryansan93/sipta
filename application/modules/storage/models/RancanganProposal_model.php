<?php
namespace Model\Storage;
use \Model\Storage\Conf as Conf;

class RancanganProposal_model extends Conf{
	protected $table = 'rancangan_proposal';
	protected $primaryKey = 'kode';
	protected $kodeTable = 'RP';

	public function mahasiswa()
	{
		return $this->hasOne('\Model\Storage\Mahasiswa_model', 'nim', 'nim');
	}

	public function prodi()
	{
		return $this->hasOne('\Model\Storage\Prodi_model', 'kode', 'prodi_kode');
	}

	public function rancangan_proposal_dosen()
	{
		return $this->hasMany('\Model\Storage\RancanganProposalDosen_model', 'rancangan_proposal_kode', 'kode');
	}

	public function rancangan_proposal_kelengkapan()
	{
		return $this->hasMany('\Model\Storage\RancanganProposalKelengkapan_model', 'rancangan_proposal_kode', 'kode')->with(['kelengkapan_pengajuan']);
	}
}
