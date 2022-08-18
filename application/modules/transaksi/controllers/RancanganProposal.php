<?php defined('BASEPATH') OR exit('No direct script access allowed');

class RancanganProposal extends Public_Controller {

    private $pathView = 'transaksi/rancangan_proposal/';
    private $url;
    private $hakAkses;

    function __construct()
    {
        parent::__construct();
        $this->url = $this->current_base_uri;
        $this->hakAkses = hakAkses($this->url);
    }

    /**************************************************************************************
     * PUBLIC FUNCTIONS
     **************************************************************************************/
    /**
     * Default
     */
    public function index($params=null)
    {
        if ( $this->hakAkses['a_view'] == 1 ) {
            $this->add_external_js(array(
                "assets/jquery/list.min.js",
                "assets/transaksi/rancangan_proposal/js/rancangan-proposal.js",
            ));
            $this->add_external_css(array(
                "assets/transaksi/rancangan_proposal/css/rancangan-proposal.css",
            ));

            $data = $this->includes;

            $start_date = null;
            $end_date = null;
            if ( !empty($params) ) {
                $_params = json_decode(base64_decode($params), true);

                $start_date = $_params['start_date'];
                $end_date = $_params['end_date'];
            }

            $content['akses'] = $this->hakAkses;
            $content['riwayatForm'] = $this->riwayatForm($start_date, $end_date);
            $content['addForm'] = $this->addForm();
            $content['title_panel'] = 'Rancangan Proposal';

            // Load Indexx
            $data['title_menu'] = 'Rancangan Proposal';
            $data['view'] = $this->load->view($this->pathView . 'index', $content, TRUE);
            $this->load->view($this->template, $data);
        } else {
            showErrorAkses();
        }
    }

    public function loadForm()
    {
        $id = $this->input->get('id');
        $resubmit = $this->input->get('resubmit');

        $html = null;
        if ( !empty($id) && empty($resubmit) ) {
            $html = $this->viewForm($id);
        } else {
            $html = $this->addForm();
        }

        echo $html;
    }

    public function getProdi()
    {
        $m_prodi = new \Model\Storage\Prodi_model();
        $d_prodi = $m_prodi->orderBy('nama', 'asc')->get();

        $data = null;
        if ( $d_prodi->count() > 0 ) {
            $data = $d_prodi->toArray();
        }

        return $data;
    }

    public function getMahasiswa()
    {
        $m_mahasiswa = new \Model\Storage\Mahasiswa_model();
        $d_mahasiswa = $m_mahasiswa->where('nim', $this->userid)->orderBy('nama', 'asc')->get();
        $data = null;
        if ( $d_mahasiswa->count() > 0 ) {
            $data = $d_mahasiswa->toArray();
        } else {
            $d_mahasiswa = $m_mahasiswa->orderBy('nama', 'asc')->get();
            if ( $d_mahasiswa->count() > 0 ) {
                $data = $d_mahasiswa->toArray();
            }
        }

        return $data;
    }

    public function getDosen()
    {
        $m_dosen = new \Model\Storage\Dosen_model();
        $d_dosen = $m_dosen->orderBy('nama', 'asc')->get();

        $data = null;
        if ( $d_dosen->count() > 0 ) {
            $data = $d_dosen->toArray();
        }

        return $data;
    }

    public function riwayatForm($start_date = null, $end_date = null)
    {
        $content['akses'] = $this->hakAkses;
        $content['start_date'] = $start_date;
        $content['end_date'] = $end_date;
        // $content['jenis_pengajuan'] = $this->getJenisPengajuan();

        $html = $this->load->view($this->pathView . 'riwayat', $content, TRUE);

        return $html;
    }

    public function getLists()
    {
        $params = $this->input->get('params');

        $start_date = $params['start_date'];
        $end_date = $params['end_date'];

        $m_mahasiswa = new \Model\Storage\Mahasiswa_model();
        $d_mahasiswa = $m_mahasiswa->where('nim', $this->userid)->orderBy('nama', 'asc')->first();

        $m_rp = new \Model\Storage\RancanganProposal_model();
        if ( $d_mahasiswa ) {
            $d_rp = $m_rp->whereBetween('waktu_konsul', [$start_date, $end_date])->where('nim', $this->userid)->with(['mahasiswa'])->orderBy('waktu_konsul', 'desc')->get();
        } else {
            $d_rp = $m_rp->whereBetween('waktu_konsul', [$start_date, $end_date])->with(['mahasiswa'])->orderBy('waktu_konsul', 'desc')->get();
        }

        $data = null;
        if ( $d_rp->count() > 0 ) {
            $data = $d_rp->toArray();
        }

        $content['data'] = $data;

        $html = $this->load->view($this->pathView . 'list', $content, TRUE);

        echo $html;
    }

    public function addForm()
    {        
        $m_jp = new \Model\Storage\JenisPengajuan_model();
        $d_jp = $m_jp->where('nama', 'like', '%rancangan proposal%')->first();

        $data_kp = null;
        if ( $d_jp ) {
            $m_kp = new \Model\Storage\KelengkapanPengajuan_model();
            $d_kp = $m_kp->where('jenis_pengajuan_kode', $d_jp->kode)->orderBy('kode', 'asc')->get();

            if ( $d_kp->count() > 0 ) {
                $data_kp = $d_kp->toArray();
            }
        }

        $content['prodi'] = $this->getProdi();
        $content['mahasiswa'] = $this->getMahasiswa();
        $content['data_kelengkapan'] = $data_kp;
        $content['dosen'] = $this->getDosen();
        $content['akses'] = $this->hakAkses;

        $html = $this->load->view($this->pathView . 'addForm', $content, TRUE);

        return $html;
    }

    public function viewForm($kode)
    {
        $m_rp = new \Model\Storage\RancanganProposal_model();
        $d_rp = $m_rp->where('kode', $kode)->with(['mahasiswa', 'prodi', 'rancangan_proposal_dosen', 'rancangan_proposal_kelengkapan'])->first()->toArray();

        $list_pembimbing = null;
        $list_penguji = null;
        if ( !empty($d_rp['rancangan_proposal_dosen']) ) {
            foreach ($d_rp['rancangan_proposal_dosen'] as $k_rpd => $v_rpd) {
                if ( $v_rpd['tipe_dosen'] == 'penguji' ) {
                    $list_penguji[] = array(
                        'jenis_dosen' => $v_rpd['jenis_dosen'],
                        'dosen_kode' => $v_rpd['dosen_kode'],
                        'nip' => $v_rpd['nip'],
                        'nama' => $v_rpd['nama'],
                        'no_telp' => $v_rpd['no_telp']
                    );
                } else {
                    $list_pembimbing[] = array(
                        'jenis_dosen' => $v_rpd['jenis_dosen'],
                        'dosen_kode' => $v_rpd['dosen_kode'],
                        'nip' => $v_rpd['nip'],
                        'nama' => $v_rpd['nama'],
                        'no_telp' => $v_rpd['no_telp']
                    );
                }
            }
        }

        $data = array(
            'kode' => $d_rp['kode'],
            'prodi_kode' => $d_rp['prodi_kode'],
            'nim' => $d_rp['nim'],
            'no_telp' => $d_rp['no_telp'],
            'judul_penelitian' => $d_rp['judul_penelitian'],
            'tahun_akademik' => $d_rp['tahun_akademik'],
            'waktu_konsul' => $d_rp['waktu_konsul'],
            'g_status' => $d_rp['g_status'],
            'mahasiswa' => $d_rp['mahasiswa'],
            'prodi' => $d_rp['prodi'],
            'list_pembimbing' => $list_pembimbing,
            'list_penguji' => $list_penguji,
            'rancangan_proposal_kelengkapan' => $d_rp['rancangan_proposal_kelengkapan']
        );

        $content['dosen'] = $this->getDosen();
        $content['akses'] = $this->hakAkses;
        $content['data'] = $data;

        $html = $this->load->view($this->pathView . 'viewForm', $content, TRUE);

        return $html;
    }

    public function editForm($kode)
    {
        $m_pengajuan = new \Model\Storage\Pengajuan_model();
        $d_pengajuan = $m_pengajuan->where('kode', $kode)->with(['jenis_pengajuan', 'mahasiswa', 'jenis_pelaksanaan', 'prodi', 'pengajuan_dosen', 'pengajuan_kelengkapan'])->first()->toArray();

        $jenis_pengajuan_form = $d_pengajuan['jenis_pengajuan']['form_pengajuan'];

        $content['akses'] = $this->hakAkses;
        $content['data'] = $d_pengajuan;

        $html = $this->load->view($this->pathView . 'form'.ucfirst($jenis_pengajuan_form).'Edit', $content, TRUE);

        return $html;
    }

    public function mappingFiles($files)
    {
        $mappingFiles = [];
        foreach ($files['tmp_name'] as $key => $file) {
            $sha1 = sha1_file($file);
            $index = $key;
            $mappingFiles[$index] = [
                'name' => $files['name'][$key],
                'tmp_name' => $file,
                'type' => $files['type'][$key],
                'size' => $files['size'][$key],
                'error' => $files['error'][$key]
            ];
        }
        
        return $mappingFiles;
    }

    public function save()
    {
        $params = json_decode($this->input->post('data'), true);
        $files = isset($_FILES['lampiran']) ? $_FILES['lampiran'] : null;
        $mappingFiles = !empty($files) ? $this->mappingFiles( $files ) : null;

        try {
            $m_rp = new \Model\Storage\RancanganProposal_model();
            $kode = $m_rp->getNextIdRibuan();

            $m_rp->kode = $kode;
            $m_rp->prodi_kode = $params['prodi_kode'];
            $m_rp->nim = $params['nim'];
            $m_rp->no_telp = $params['no_telp'];
            $m_rp->judul_penelitian = $params['judul_penelitian'];
            $m_rp->tahun_akademik = $params['tahun_akademik'];
            $m_rp->waktu_konsul = $params['jadwal'];
            $m_rp->g_status = 1;
            $m_rp->save();

            if ( !empty($params['list_kelengkapan_pengajuan']) ) {
                foreach ($params['list_kelengkapan_pengajuan'] as $k_lkp => $v_lkp) {
                    $path_name = null;
                    if ( !empty($mappingFiles[ $v_lkp['kode'] ]) ) {
                        $moved = uploadFile($mappingFiles[ $v_lkp['kode'] ]);
                        if ( $moved ) {
                            $path_name = $moved['path'];
                        }
                    }

                    $m_rpk = new \Model\Storage\RancanganProposalKelengkapan_model();
                    $m_rpk->pengajuan_kode = $kode;
                    $m_rpk->kelengkapan_pengajuan_kode = $v_lkp['kode'];
                    $m_rpk->lampiran = $path_name;
                    $m_rpk->save();
                }
            }

            if ( !empty($params['list_pembimbing']) ) {
                foreach ($params['list_pembimbing'] as $k_lp => $v_lp) {
                    if ( isset($v_lp['pembimbing']) ) {
                        $m_rpd = new \Model\Storage\RancanganProposalDosen_model();
                        $m_rpd->pengajuan_kode = $kode;
                        $m_rpd->nip = isset($v_lp['nip']) ? $v_lp['nip'] : null;
                        $m_rpd->nama = $v_lp['pembimbing'];
                        $m_rpd->no_telp = isset($v_lp['no_telp']) ? $v_lp['no_telp'] : null;
                        $m_rpd->tipe_dosen = 'pembimbing';
                        $m_rpd->save();
                    }
                }
            }

            if ( !empty($params['list_penguji']) ) {
                foreach ($params['list_penguji'] as $k_lp => $v_lp) {
                    if ( isset($v_lp['penguji']) ) {
                        $m_rpd = new \Model\Storage\RancanganProposalDosen_model();
                        $m_rpd->pengajuan_kode = $kode;
                        $m_rpd->jenis_dosen = isset($v_lp['jenis_penguji']) ? $v_lp['jenis_penguji'] : 'dalam';
                        $m_rpd->nip = isset($v_lp['nip']) ? $v_lp['nip'] : null;
                        $m_rpd->nama = $v_lp['penguji'];
                        $m_rpd->tipe_dosen = 'penguji';
                        $m_rpd->save();
                    }
                }
            }

            $deskripsi_log = 'di-submit oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run( 'base/event/save', $m_rp, $deskripsi_log );

            $this->result['status'] = 1;
            $this->result['message'] = 'Data berhasil di simpan.';
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }

    public function delete()
    {
        $kode = $this->input->post('params');

        try {
            $m_pengajuan = new \Model\Storage\Pengajuan_model();
            $d_pengajuan = $m_pengajuan->where('kode', $kode)->first();

            $m_pk = new \Model\Storage\PengajuanKelengkapan_model();
            $m_pd = new \Model\Storage\PengajuanDosen_model();

            $m_pk->where('pengajuan_kode', $kode)->delete();
            $m_pd->where('pengajuan_kode', $kode)->delete();
            $m_pengajuan->where('kode', $kode)->delete();

            $deskripsi_log = 'di-delete oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run( 'base/event/delete', $d_pengajuan, $deskripsi_log );

            $this->result['status'] = 1;
            $this->result['message'] = 'Data berhasil di hapus.';
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }

    public function approve_reject() {
        $params = $this->input->post('params');

        try {
            $m_rp = new \Model\Storage\RancanganProposal_model();
            if ( $params['jenis'] != getStatus(4) ) {
                $m_rp->where('kode', $params['kode'])->update(
                    array(
                        'g_status' => getStatus($params['jenis'])
                    )
                );

                if ( !empty($params['list_pembimbing']) ) {
                    $m_rpd = new \Model\Storage\RancanganProposalDosen_model();
                    $m_rpd->where('rancangan_proposal_kode', $params['kode'])->where('tipe_dosen', 'pembimbing')->delete();

                    foreach ($params['list_pembimbing'] as $k_lp => $v_lp) {
                        if ( isset($v_lp['pembimbing']) ) {
                            $m_rpd = new \Model\Storage\RancanganProposalDosen_model();
                            $m_rpd->rancangan_proposal_kode = $params['kode'];
                            $m_rpd->nip = isset($v_lp['nip']) ? $v_lp['nip'] : null;
                            $m_rpd->nama = $v_lp['pembimbing'];
                            $m_rpd->no_telp = isset($v_lp['no_telp']) ? $v_lp['no_telp'] : null;
                            $m_rpd->tipe_dosen = 'pembimbing';
                            $m_rpd->save();
                        }
                    }
                }

                if ( !empty($params['list_penguji']) ) {
                    $m_rpd = new \Model\Storage\RancanganProposalDosen_model();
                    $m_rpd->where('rancangan_proposal_kode', $params['kode'])->where('tipe_dosen', 'penguji')->delete();

                    foreach ($params['list_penguji'] as $k_lp => $v_lp) {
                        if ( isset($v_lp['penguji']) ) {
                            $m_rpd = new \Model\Storage\RancanganProposalDosen_model();
                            $m_rpd->rancangan_proposal_kode = $params['kode'];
                            $m_rpd->jenis_dosen = isset($v_lp['jenis_penguji']) ? $v_lp['jenis_penguji'] : 'dalam';
                            $m_rpd->nip = isset($v_lp['nip']) ? $v_lp['nip'] : null;
                            $m_rpd->nama = $v_lp['penguji'];
                            $m_rpd->tipe_dosen = 'penguji';
                            $m_rpd->save();
                        }
                    }
                }
            } else {
                $m_rp->where('kode', $params['kode'])->update(
                    array(
                        'g_status' => getStatus($params['jenis'])
                    )
                );
            }

            $d_rp = $m_rp->where('kode', $params['kode'])->first();

            $deskripsi_log = 'di-'.$params['jenis'].' oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run( 'base/event/update', $d_rp, $deskripsi_log );

            $this->result['status'] = 1;
            $this->result['content'] = array('kode' => $params['kode']);
            $this->result['message'] = 'Data berhasil di '.$params['jenis'].'.';
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }

    public function notifikasi($g_status)
    {
        $m_rp = new \Model\Storage\RancanganProposal_model();
        $d_rp = $m_rp->where('g_status', $g_status)->get();

        $data = null;
        if ( $d_rp->count() > 0 ) {
            $sql = "
                select min(waktu_konsul) as start_date, max(waktu_konsul) as end_date from rancangan_proposal
                where
                    g_status = ".$g_status."
            ";
            $_d_rp = $m_rp->hydrateRaw($sql)->toArray();

            $start_date = $_d_rp[0]['start_date'];
            $end_date = $_d_rp[0]['end_date'];

            $params = array(
                'start_date' => $start_date,
                'end_date' => $end_date
            );

            $data[] = array(
                'title' => 'Notifikasi Rancangan Proposal',
                'deskripsi' => 'Approve Rancangan Proposal',
                'jumlah' => $d_rp->count(),
                'action' => "window.open('transaksi/RancanganProposal/index/".base64_encode((json_encode($params)))."')"
            );
        }

        return $data;
    }
}