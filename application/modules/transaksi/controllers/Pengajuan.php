<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pengajuan extends Public_Controller {

    private $pathView = 'transaksi/pengajuan/';
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
                "assets/transaksi/pengajuan/js/pengajuan.js",
            ));
            $this->add_external_css(array(
                "assets/transaksi/pengajuan/css/pengajuan.css",
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
            $content['title_panel'] = 'Pengajuan TA';

            // Load Indexx
            $data['title_menu'] = 'Pengajuan TA';
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

    public function getJenisPengajuan()
    {
        $m_jp = new \Model\Storage\JenisPengajuan_model();
        $d_jp = $m_jp->where('urut', '<>', 1)->orderBy('nama', 'asc')->get();

        $data = null;
        if ( $d_jp->count() > 0 ) {
            $data = $d_jp->toArray();
        }

        return $data;
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

    public function getJenisPelaksanaan()
    {
        $m_jp = new \Model\Storage\JenisPelaksanaan_model();
        $d_jp = $m_jp->orderBy('nama', 'asc')->get();

        $data = null;
        if ( $d_jp->count() > 0 ) {
            $data = $d_jp->toArray();
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

    public function getDataRancanganProposal()
    {
        $data = null;
        $m_rp = new \Model\Storage\RancanganProposal_model();
        $d_rp = $m_rp->where('nim', $this->userid)->where('g_status', getStatus('approve'))->get();

        if ( $d_rp->count() > 0 ) {
            $d_rp = $d_rp->toArray();
            foreach ($d_rp as $key => $value) {
                $data[ $value['kode'] ] = array(
                    'kode_pengajuan' => $value['kode'],
                    'jenis_pengajuan' => 'RANCANGAN PROPOSAL',
                    'judul_penelitian' => $value['judul_penelitian']
                );
            }
        }

        return $data;
    }

    public function getDataSempro()
    {
        $m_jenis_pengajuan = new \Model\Storage\JenisPengajuan_model();
        $d_jenis_pengajuan = $m_jenis_pengajuan->where('nama', 'like', '%seminar proposal%')->first();

        $data = null;
        if ( $d_jenis_pengajuan ) {
            $m_pengajuan = new \Model\Storage\Pengajuan_model();
            $d_pengajuan = $m_pengajuan->where('nim', $this->userid)->where('g_status', getStatus('approve'))->where('jenis_pengajuan_kode', $d_jenis_pengajuan->kode)->with(['jenis_pengajuan'])->get();

            if ( $d_pengajuan->count() > 0 ) {
                $d_pengajuan = $d_pengajuan->toArray();
                foreach ($d_pengajuan as $key => $value) {
                    $data[ $value['kode'] ] = array(
                        'kode_pengajuan' => $value['kode'],
                        'jenis_pengajuan' => $value['jenis_pengajuan']['nama'],
                        'judul_penelitian' => $value['judul_penelitian']
                    );
                }
            }
        }

        return $data;
    }

    public function getDataSemhas()
    {
        $m_jenis_pengajuan = new \Model\Storage\JenisPengajuan_model();
        $d_jenis_pengajuan = $m_jenis_pengajuan->where('nama', 'like', '%seminar hasil%')->first();

        $data = null;
        if ( $d_jenis_pengajuan ) {
            $m_pengajuan = new \Model\Storage\Pengajuan_model();
            $d_pengajuan = $m_pengajuan->where('nim', $this->userid)->where('g_status', getStatus('approve'))->where('jenis_pengajuan_kode', $d_jenis_pengajuan->kode)->with(['jenis_pengajuan'])->get();

            if ( $d_pengajuan->count() > 0 ) {
                $d_pengajuan = $d_pengajuan->toArray();
                foreach ($d_pengajuan as $key => $value) {
                    $data[ $value['kode'] ] = array(
                        'kode_pengajuan' => $value['kode'],
                        'jenis_pengajuan' => $value['jenis_pengajuan']['nama'],
                        'judul_penelitian' => $value['judul_penelitian']
                    );
                }
            }
        }

        return $data;
    }

    public function kelengkapanPengajuan()
    {
        $jenis_pengajuan_kode = $this->input->get('jenis_pengajuan_kode');

        $m_jp = new \Model\Storage\JenisPengajuan_model();
        $d_jp = $m_jp->where('kode', $jenis_pengajuan_kode)->first();

        if ( $d_jp->form_pengajuan == 'kompre' ) {
            $content['data_semhas'] = $this->getDataSemhas();
            $html = $this->load->view($this->pathView . 'formKompre', $content, TRUE);
        } else {
            if ( stristr($d_jp->nama, 'seminar proposal') !== false ) {
                $content['data_rancangan_proposal'] = $this->getDataRancanganProposal();
            } else {
                $content['jml_sempro'] = $this->cekPengajuanSemhas();
                $content['data_sempro'] = $this->getDataSempro();
            }
            $html = $this->load->view($this->pathView . 'formSemhas', $content, TRUE);
        }

        echo $html;
    }

    public function cekPengajuanSemhas()
    {
        $m_jp = new \Model\Storage\JenisPengajuan_model();
        $d_jp = $m_jp->where('nama', 'like', '%SEMINAR PROPOSAL%')->first();

        $jml_sempro = 0;
        if ( !empty($d_jp) ) {
            $jenis_pengajuan_kode = $d_jp->kode;

            $m_ks = new \Model\Storage\KartuSeminar_model();
            $d_ks = $m_ks->where('nim', $this->userid)->with(['pengajuan'])->get();

            if ( $d_ks->count() > 0 ) {
                $d_ks = $d_ks->toArray();

                foreach ($d_ks as $k_ks => $v_ks) {
                    if ( $v_ks['pengajuan']['jenis_pengajuan_kode'] == $jenis_pengajuan_kode ) {
                        $jml_sempro++;
                    }
                }
            }
        }

        return $jml_sempro;
    }

    public function formDataPengajuan()
    {
        $params = $this->input->get('params');

        $jenis_pengajuan_kode = $params['jenis_pengajuan_kode'];
        $pengajuan_kode = $params['pengajuan_kode'];

        $m_jp = new \Model\Storage\JenisPengajuan_model();
        $d_jp = $m_jp->where('kode', $jenis_pengajuan_kode)->first();

        $m_jsu = new \Model\Storage\JamSeminarUjian_model();
        $d_jsu = $m_jsu->where('jenis_pengajuan_kode', $jenis_pengajuan_kode)->orderBy('awal', 'asc')->get();

        $data_jsu = null;
        if ( $d_jsu->count() > 0 ) {
            $data_jsu = $d_jsu->toArray();
        }

        $m_kp = new \Model\Storage\KelengkapanPengajuan_model();
        $d_kp = $m_kp->where('jenis_pengajuan_kode', $jenis_pengajuan_kode)->orderBy('kode', 'asc')->get();

        $data_kp = null;
        if ( $d_kp->count() > 0 ) {
            $data_kp = $d_kp->toArray();
        }

        $content['jenis_pelaksanaan'] = $this->getJenisPelaksanaan();
        $content['data_kelengkapan'] = $data_kp;
        $content['jam_seminar_ujian'] = $data_jsu;

        if ( $d_jp->form_pengajuan == 'kompre' ) {
            $content['data_semhas'] = $this->getDataSemhas();
            $html = $this->load->view($this->pathView . 'formDataKompre', $content, TRUE);
        } else {
            if ( stristr($d_jp->nama, 'seminar proposal') !== false ) {
                $m_rp = new \Model\Storage\RancanganProposal_model();
                $d_rp = $m_rp->where('kode', $pengajuan_kode)->with(['mahasiswa', 'prodi', 'rancangan_proposal_dosen'])->first()->toArray();

                $list_pembimbing = null;
                foreach ($d_rp['rancangan_proposal_dosen'] as $k_rpd => $v_rpd) {
                    if ( $v_rpd['tipe_dosen'] == 'pembimbing' ) {
                        $list_pembimbing[] = array(
                            'nip' => $v_rpd['nip'],
                            'nama' => $v_rpd['nama'],
                            'no_telp' => $v_rpd['no_telp']
                        );
                    }
                }

                $data = array(
                    'kode' => $d_rp['kode'],
                    'prodi_kode' => $d_rp['prodi_kode'],
                    'nim' => $d_rp['nim'],
                    'no_telp' => $d_rp['no_telp'],
                    'judul_penelitian' => $d_rp['judul_penelitian'],
                    'tahun_akademik' => $d_rp['tahun_akademik'],
                    'g_status' => $d_rp['g_status'],
                    'mahasiswa' => $d_rp['mahasiswa'],
                    'prodi' => $d_rp['prodi'],
                    'list_pembimbing' => $list_pembimbing
                );
            } else {
                $m_pengajuan = new \Model\Storage\Pengajuan_model();
                $d_pengajuan = $m_pengajuan->where('kode', $pengajuan_kode)->with(['mahasiswa', 'prodi', 'pengajuan_dosen'])->first()->toArray();

                $list_pembimbing = null;
                foreach ($d_pengajuan['pengajuan_dosen'] as $k_pd => $v_pd) {
                    $list_pembimbing[] = array(
                        'nip' => $v_pd['nip'],
                        'nama' => $v_pd['nama'],
                        'no_telp' => $v_pd['no_telp']
                    );
                }

                $data = array(
                    'kode' => $d_pengajuan['kode'],
                    'prodi_kode' => $d_pengajuan['prodi_kode'],
                    'nim' => $d_pengajuan['nim'],
                    'no_telp' => $d_pengajuan['no_telp'],
                    'judul_penelitian' => $d_pengajuan['judul_penelitian'],
                    'tahun_akademik' => $d_pengajuan['tahun_akademik'],
                    'g_status' => $d_pengajuan['g_status'],
                    'mahasiswa' => $d_pengajuan['mahasiswa'],
                    'prodi' => $d_pengajuan['prodi'],
                    'list_pembimbing' => $list_pembimbing
                );
            }

            $content['data'] = $data;

            $html = $this->load->view($this->pathView . 'formDataSemhas', $content, TRUE);
        }

        echo $html;
    }

    public function getRuangKelas()
    {
        $m_rk = new \Model\Storage\RuangKelas_model();
        $d_rk = $m_rk->orderBy('nama', 'asc')->get();

        $data = null;
        if ( $d_rk->count() > 0 ) {
            $data = $d_rk->toArray();
        }

        return $data;
    }

    public function riwayatForm($start_date = null, $end_date = null)
    {
        $content['akses'] = $this->hakAkses;
        $content['start_date'] = $start_date;
        $content['end_date'] = $end_date;
        $content['jenis_pengajuan'] = $this->getJenisPengajuan();

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

        $m_pengajuan = new \Model\Storage\Pengajuan_model();
        if ( $d_mahasiswa ) {
            $d_pengajuan = $m_pengajuan->whereBetween('tgl_pengajuan', [$start_date, $end_date])->where('nim', $this->userid)->with(['jenis_pengajuan', 'mahasiswa'])->orderBy('tgl_pengajuan', 'desc')->get();
        } else {
            $d_pengajuan = $m_pengajuan->whereBetween('tgl_pengajuan', [$start_date, $end_date])->with(['jenis_pengajuan', 'mahasiswa'])->orderBy('tgl_pengajuan', 'desc')->get();
        }

        $data = null;
        if ( $d_pengajuan->count() > 0 ) {
            $data = $d_pengajuan->toArray();
        }

        $content['data'] = $data;

        $html = $this->load->view($this->pathView . 'list', $content, TRUE);

        echo $html;
    }

    public function addForm()
    {
        $content['akses'] = $this->hakAkses;
        $content['jenis_pengajuan'] = $this->getJenisPengajuan();

        $html = $this->load->view($this->pathView . 'addForm', $content, TRUE);

        return $html;
    }

    public function viewForm($kode)
    {
        $m_pengajuan = new \Model\Storage\Pengajuan_model();
        $d_pengajuan = $m_pengajuan->where('kode', $kode)->with(['jenis_pengajuan', 'mahasiswa', 'jenis_pelaksanaan', 'prodi', 'pengajuan_dosen', 'pengajuan_kelengkapan', 'ruang_kelas'])->first()->toArray();

        $jenis_pengajuan_form = $d_pengajuan['jenis_pengajuan']['form_pengajuan'];

        $content['akses'] = $this->hakAkses;
        $content['ruang_kelas'] = $this->getRuangKelas();
        $content['data'] = $d_pengajuan;

        $html = $this->load->view($this->pathView . 'form'.ucfirst($jenis_pengajuan_form).'View', $content, TRUE);

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
        $mappingFiles = $this->mappingFiles( $files );

        try {
            $m_pengajuan = new \Model\Storage\Pengajuan_model();
            $kode = $m_pengajuan->getNextIdRibuan();

            $m_pengajuan->kode = $kode;
            $m_pengajuan->kode_pengajuan = isset($params['kode_pengajuan']) ? $params['kode_pengajuan'] : null;
            $m_pengajuan->jenis_pengajuan_kode = $params['jenis_pengajuan'];
            $m_pengajuan->tgl_pengajuan = date('Y-m-d');
            $m_pengajuan->prodi_kode = $params['prodi_kode'];
            $m_pengajuan->nim = $params['nim'];
            $m_pengajuan->no_telp = $params['no_telp'];
            $m_pengajuan->jenis_pelaksanaan_kode = $params['jenis_pelaksanaan_kode'];
            $m_pengajuan->judul_penelitian = $params['judul_penelitian'];
            $m_pengajuan->jadwal = $params['jadwal'];
            $m_pengajuan->jam_pelaksanaan = $params['jam_pelaksanaan'];
            $m_pengajuan->jam_selesai = $params['jam_selesai'];
            $m_pengajuan->g_status = 1;
            $m_pengajuan->batal = 0;
            $m_pengajuan->tahun_akademik = $params['tahun_akademik'];
            $m_pengajuan->save();

            foreach ($params['list_kelengkapan_pengajuan'] as $k_lkp => $v_lkp) {
                $path_name = null;
                if ( !empty($mappingFiles[ $v_lkp['kode'] ]) ) {
                    $moved = uploadFile($mappingFiles[ $v_lkp['kode'] ]);
                    if ( $moved ) {
                        $path_name = $moved['path'];
                    }
                }

                $m_pk = new \Model\Storage\PengajuanKelengkapan_model();
                $m_pk->pengajuan_kode = $kode;
                $m_pk->kelengkapan_pengajuan_kode = $v_lkp['kode'];
                $m_pk->lampiran = $path_name;
                $m_pk->save();
            }

            foreach ($params['list_penguji'] as $k_lp => $v_lp) {
                if ( isset($v_lp['penguji']) ) {
                    $m_pd = new \Model\Storage\PengajuanDosen_model();
                    $m_pd->pengajuan_kode = $kode;
                    $m_pd->jenis_dosen = isset($v_lp['jenis_penguji']) ? $v_lp['jenis_penguji'] : 'dalam';
                    $m_pd->nip = isset($v_lp['nip']) ? $v_lp['nip'] : null;
                    $m_pd->nama = $v_lp['penguji'];
                    $m_pd->no_telp = isset($v_lp['no_telp']) ? $v_lp['no_telp'] : null;
                    $m_pd->save();
                }
            }

            $deskripsi_log = 'di-submit oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run( 'base/event/save', $m_pengajuan, $deskripsi_log );

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
            $m_pengajuan = new \Model\Storage\Pengajuan_model();
            if ( $params['jenis'] != getStatus(4) ) {
                $m_pengajuan->where('kode', $params['kode'])->update(
                    array(
                        'g_status' => getStatus($params['jenis']),
                        // 'jam_selesai' => $params['jam_selesai'],
                        'ruang_kelas' => $params['ruang_kelas'],
                        'akun_zoom' => $params['akun_zoom'],
                        'id_meeting' => $params['id_meeting'],
                        'password_meeting' => $params['password_meeting']
                    )
                );

                $_d_pengajuan = $m_pengajuan->where('kode', $params['kode'])->first();
                $today = date('Y-m-d');

                $m_js = new \Model\Storage\JadwalSeminar_model();
                $d_js_tgl = $m_js->select('tgl_berlaku')->where('tgl_berlaku', '<=', $today)->orderBy('tgl_berlaku', 'desc')->first();

                if ( $d_js_tgl ) {
                    $d_js = $m_js->where('tgl_berlaku', $d_js_tgl->tgl_berlaku)->orderBy('kode', 'desc')->first();

                    if ( $d_js ) {
                        $m_jsd = new \Model\Storage\JadwalSeminarDet_model();
                        $d_jsd = $m_jsd->where('asal', $_d_pengajuan->jenis_pengajuan_kode)->first();

                        if ( $d_jsd ) {
                            $lama_hari = $d_jsd->lama_hari;

                            $tgl_tujuan = next_date($today, $lama_hari);

                            $m_njs = new \Model\Storage\NotifikasiJadwalSeminar_model();
                            $now = $m_njs->getDate();

                            $m_njs->tgl_trans = $now['waktu'];
                            $m_njs->tgl_tujuan = $tgl_tujuan;
                            $m_njs->nim = $_d_pengajuan->nim;
                            $m_njs->pengajuan_kode = $_d_pengajuan->kode;
                            $m_njs->jenis_pengajuan_kode_asal = $_d_pengajuan->jenis_pengajuan_kode;
                            $m_njs->jenis_pengajuan_kode_tujuan = $d_jsd->tujuan;
                            $m_njs->save();
                        }
                    }
                }
            } else {
                $m_pengajuan->where('kode', $params['kode'])->update(
                    array(
                        'g_status' => getStatus($params['jenis'])
                    )
                );
            }

            $d_pengajuan = $m_pengajuan->where('kode', $params['kode'])->first();

            $deskripsi_log = 'di-'.$params['jenis'].' oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run( 'base/event/update', $d_pengajuan, $deskripsi_log );

            $this->result['status'] = 1;
            $this->result['content'] = array('kode' => $params['kode']);
            $this->result['message'] = 'Data berhasil di '.$params['jenis'].'.';
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }

    public function cekRuangan()
    {
        $params = $this->input->post('params');
        try {
            $m_pengajuan = new \Model\Storage\Pengajuan_model();
            $d_pengajuan = $m_pengajuan->where('kode', $params['kode'])->first();

            $jadwal = $d_pengajuan->jadwal;
            $jam_pelaksanaan = substr($d_pengajuan->jam_pelaksanaan, 0, 8);
            $jam_selesai = substr($d_pengajuan->jam_selesai, 0, 8);

            // cetak_r($jadwal.' | '.$jam_pelaksanaan.' | '.$jam_selesai, 1);

            $d_pengajuan_cek = $m_pengajuan->where('jadwal', $jadwal)->where('ruang_kelas', $params['ruang_kelas'])->where('jam_pelaksanaan', $jam_pelaksanaan)->with(['mahasiswa'])->first();

            if ( $d_pengajuan_cek ) {
                $this->result['status'] = 1;
                $this->result['message'] = 'Ruangan yang anda pilih sudah terpakai oleh mahasiswa <b>'.strtoupper($d_pengajuan_cek->mahasiswa->nama).'</b>';
            } else {
                $this->result['status'] = 0;
            }
        } catch (Exception $e) {
            $this->result['status'] = 2;
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }

    public function notifikasi($g_status)
    {
        $m_pengajuan = new \Model\Storage\Pengajuan_model();
        $d_pengajuan = $m_pengajuan->where('g_status', $g_status)->get();

        $data = null;
        if ( $d_pengajuan->count() > 0 ) {
            $sql = "
                select min(tgl_pengajuan) as start_date, max(tgl_pengajuan) as end_date from pengajuan
                where
                    g_status = ".$g_status."
            ";
            $_d_pengajuan = $m_pengajuan->hydrateRaw($sql)->toArray();

            $start_date = $_d_pengajuan[0]['start_date'];
            $end_date = $_d_pengajuan[0]['end_date'];

            $params = array(
                'start_date' => $start_date,
                'end_date' => $end_date
            );

            $data[] = array(
                'title' => 'Notifikasi Pengajuan',
                'deskripsi' => 'Approve Pengajuan',
                'jumlah' => $d_pengajuan->count(),
                'action' => "window.open('transaksi/Pengajuan/index/".base64_encode((json_encode($params)))."')"
            );
        }

        return $data;
    }
}