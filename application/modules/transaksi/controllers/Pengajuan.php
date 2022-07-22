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
    public function index($segment=0)
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


            $content['akses'] = $this->hakAkses;
            $content['riwayatForm'] = $this->riwayatForm();
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
        $d_jp = $m_jp->orderBy('nama', 'asc')->get();

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
        $d_mahasiswa = $m_mahasiswa->orderBy('nama', 'asc')->get();

        $data = null;
        if ( $d_mahasiswa->count() > 0 ) {
            $data = $d_mahasiswa->toArray();
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

    public function kelengkapanPengajuan()
    {
        $jenis_pengajuan_kode = $this->input->get('jenis_pengajuan_kode');

        $m_jp = new \Model\Storage\JenisPengajuan_model();
        $d_jp = $m_jp->where('kode', $jenis_pengajuan_kode)->first();

        $m_kp = new \Model\Storage\KelengkapanPengajuan_model();
        $d_kp = $m_kp->where('jenis_pengajuan_kode', $jenis_pengajuan_kode)->orderBy('kode', 'asc')->get();

        if ( $d_kp->count() > 0 ) {
            $d_kp = $d_kp->toArray();
        }

        $content['prodi'] = $this->getProdi();
        $content['mahasiswa'] = $this->getMahasiswa();
        $content['jenis_pelaksanaan'] = $this->getJenisPelaksanaan();
        $content['data_kelengkapan'] = $d_kp;
        $content['dosen'] = $this->getDosen();

        if ( $d_jp->form_pengajuan == 'kompre' ) {
            $html = $this->load->view($this->pathView . 'formKompre', $content, TRUE);
        } else {
            $html = $this->load->view($this->pathView . 'formSemhas', $content, TRUE);
        }

        echo $html;
    }

    public function riwayatForm()
    {
        $content['jenis_pengajuan'] = $this->getJenisPengajuan();

        $html = $this->load->view($this->pathView . 'riwayat', $content, TRUE);

        return $html;
    }

    public function getLists()
    {
        $params = $this->input->get('params');

        $start_date = $params['start_date'];
        $end_date = $params['end_date'];

        $m_pengajuan = new \Model\Storage\Pengajuan_model();
        $d_pengajuan = $m_pengajuan->whereBetween('tgl_pengajuan', [$start_date, $end_date])->with(['jenis_pengajuan', 'mahasiswa'])->orderBy('tgl_pengajuan', 'desc')->get();

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
        $content['jenis_pengajuan'] = $this->getJenisPengajuan();

        $html = $this->load->view($this->pathView . 'addForm', $content, TRUE);

        return $html;
    }

    public function viewForm($kode)
    {
        $m_pengajuan = new \Model\Storage\Pengajuan_model();
        $d_pengajuan = $m_pengajuan->where('kode', $kode)->with(['jenis_pengajuan', 'mahasiswa', 'jenis_pelaksanaan', 'prodi', 'pengajuan_dosen', 'pengajuan_kelengkapan'])->first()->toArray();

        $jenis_pengajuan_form = $d_pengajuan['jenis_pengajuan']['form_pengajuan'];

        $content['akses'] = $this->hakAkses;
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
            $m_pengajuan->jenis_pengajuan_kode = $params['jenis_pengajuan'];
            $m_pengajuan->tgl_pengajuan = isset($params['tgl_pengajuan']) ? $params['tgl_pengajuan'] : date('Y-m-d');
            $m_pengajuan->prodi_kode = $params['prodi_kode'];
            $m_pengajuan->nim = $params['nim'];
            $m_pengajuan->no_telp = $params['no_telp'];
            $m_pengajuan->jenis_pelaksanaan_kode = $params['jenis_pelaksanaan_kode'];
            $m_pengajuan->judul_penelitian = $params['judul_penelitian'];
            $m_pengajuan->jadwal = $params['jadwal'];
            $m_pengajuan->jam_pelaksanaan = $params['jam_pelaksanaan'];
            $m_pengajuan->g_status = 1;
            $m_pengajuan->batal = 0;
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
                $m_pd = new \Model\Storage\PengajuanDosen_model();
                $m_pd->pengajuan_kode = $kode;
                $m_pd->jenis_dosen = isset($v_lp['jenis_penguji']) ? $v_lp['jenis_penguji'] : 'dalam';
                $m_pd->nip = isset($v_lp['nip']) ? $v_lp['nip'] : null;
                $m_pd->nama = $v_lp['penguji'];
                $m_pd->no_telp = isset($v_lp['no_telp']) ? $v_lp['no_telp'] : null;
                $m_pd->save();
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
}