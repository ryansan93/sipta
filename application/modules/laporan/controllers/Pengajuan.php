<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pengajuan extends Public_Controller {

    private $pathView = 'laporan/pengajuan/';
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
                "assets/laporan/pengajuan/js/pengajuan.js",
            ));
            $this->add_external_css(array(
                "assets/laporan/pengajuan/css/pengajuan.css",
            ));

            $data = $this->includes;

            $content['akses'] = $this->hakAkses;
            $content['title_panel'] = 'Laporan Pengajuan TA';

            // Load Indexx
            $data['title_menu'] = 'Laporan Pengajuan TA';
            $data['view'] = $this->load->view($this->pathView . 'index', $content, TRUE);
            $this->load->view($this->template, $data);
        } else {
            showErrorAkses();
        }
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
}