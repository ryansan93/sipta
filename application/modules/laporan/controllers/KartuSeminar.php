<?php defined('BASEPATH') OR exit('No direct script access allowed');

class KartuSeminar extends Public_Controller {

    private $pathView = 'laporan/kartu_seminar/';
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
                "assets/select2/js/select2.min.js",
                "assets/jquery/list.min.js",
                "assets/laporan/kartu_seminar/js/kartu-seminar.js",
            ));
            $this->add_external_css(array(
                'assets/select2/css/select2.min.css',
                "assets/laporan/kartu_seminar/css/kartu-seminar.css",
            ));

            $data = $this->includes;

            $content['akses'] = $this->hakAkses;
            $content['title_panel'] = 'Laporan Kartu Seminar';

            $content['mahasiswa'] = $this->getMahasiswa();

            // Load Indexx
            $data['title_menu'] = 'Laporan Kartu Seminar';
            $data['view'] = $this->load->view($this->pathView . 'index', $content, TRUE);
            $this->load->view($this->template, $data);
        } else {
            showErrorAkses();
        }
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

    public function getLists()
    {
        $mahasiswa = $this->input->get('mahasiswa');

        $m_conf = new \Model\Storage\Conf();
        $now = $m_conf->getDate();

        $m_ks = new \Model\Storage\KartuSeminar_model();
        $d_ks = $m_ks->where('nim', $mahasiswa)->with(['mahasiswa', 'pengajuan'])->get();

        $data = null;
        if ( $d_ks->count() > 0 ) {
            $d_ks = $d_ks->toArray();

            foreach ($d_ks as $k_ks => $v_ks) {
                $key = str_replace('-', '', $v_ks['pengajuan']['jadwal']).' | '.$v_ks['pengajuan']['kode'];

                $data[ $key ] = array(
                    'kode' => $v_ks['pengajuan']['kode'],
                    'judul_penelitian' => $v_ks['pengajuan']['judul_penelitian'],
                    'jenis_pelaksanaan' => $v_ks['pengajuan']['jenis_pelaksanaan']['nama'],
                    'tanggal' => $v_ks['pengajuan']['jadwal'],
                    'jam_mulai' => $v_ks['pengajuan']['jam_pelaksanaan'],
                    'jam_selesai' => $v_ks['pengajuan']['jam_selesai'],
                    'ruang_kelas' => $v_ks['pengajuan']['ruang_kelas']['nama'],
                    'akun_zoom' => $v_ks['pengajuan']['akun_zoom'],
                    'id_meeting' => $v_ks['pengajuan']['id_meeting'],
                    'password_meeting' => $v_ks['pengajuan']['password_meeting'],
                    'mahasiswa' => $v_ks['pengajuan']['mahasiswa']['nama']
                );
            }

            ksort($data);
        }

        $content['data'] = $data;

        $html = $this->load->view($this->pathView . 'list', $content, TRUE);

        echo $html;
    }
}