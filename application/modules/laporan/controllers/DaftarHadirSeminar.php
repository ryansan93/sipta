<?php defined('BASEPATH') OR exit('No direct script access allowed');

class DaftarHadirSeminar extends Public_Controller {

    private $pathView = 'laporan/daftar_hadir_seminar/';
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
                "assets/laporan/daftar_hadir_seminar/js/daftar-hadir-seminar.js",
            ));
            $this->add_external_css(array(
                'assets/select2/css/select2.min.css',
                "assets/laporan/daftar_hadir_seminar/css/daftar-hadir-seminar.css",
            ));

            $data = $this->includes;

            $content['akses'] = $this->hakAkses;
            $content['title_panel'] = 'Daftar Hadir Seminar';

            $content['mahasiswa'] = $this->getMahasiswa();

            // Load Indexx
            $data['title_menu'] = 'Daftar Hadir Seminar';
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

        $m_pengajuan = new \Model\Storage\Pengajuan_model();
        $d_pengajuan = $m_pengajuan->where('nim', $mahasiswa)->where('g_status', getStatus('approve'))->with(['mahasiswa', 'jenis_pengajuan', 'jenis_pelaksanaan', 'ruang_kelas'])->get();

        $data = null;

        if ( $d_pengajuan->count() > 0 ) {
            $d_pengajuan = $d_pengajuan->toArray();

            foreach ($d_pengajuan as $k_pengajuan => $v_pengajuan) {
                $m_ks = new \Model\Storage\KartuSeminar_model();
                $d_ks = $m_ks->where('pengajuan_kode', $v_pengajuan['kode'])->with(['mahasiswa'])->get();

                $key = str_replace('-', '', $v_pengajuan['jadwal']).' | '.$v_pengajuan['kode'];

                $data[ $key ] = array(
                    'kode' => $v_pengajuan['kode'],
                    'mahasiswa' => $v_pengajuan['mahasiswa']['nama'],
                    'judul_penelitian' => $v_pengajuan['judul_penelitian'],
                    'jenis_pelaksanaan' => $v_pengajuan['jenis_pelaksanaan']['nama'],
                    'tanggal' => $v_pengajuan['jadwal'],
                    'jam_mulai' => $v_pengajuan['jam_pelaksanaan'],
                    'jam_selesai' => $v_pengajuan['jam_selesai'],
                    'ruang_kelas' => $v_pengajuan['ruang_kelas']['nama'],
                    'akun_zoom' => $v_pengajuan['akun_zoom'],
                    'id_meeting' => $v_pengajuan['id_meeting'],
                    'password_meeting' => $v_pengajuan['password_meeting'],
                    'list_mahasiswa' => null
                );

                if ( $d_ks->count() > 0 ) {
                    $d_ks = $d_ks->toArray();

                    foreach ($d_ks as $k_ks => $v_ks) {

                        $key_mahasiswa = $v_ks['nim'];
                        $data[ $key ]['list_mahasiswa'][ $key_mahasiswa ] = array(
                            'nim' => $v_ks['mahasiswa']['nim'], 
                            'nama' => $v_ks['mahasiswa']['nama'], 
                            'prodi' => $v_ks['mahasiswa']['prodi']['nama'], 
                        );
                    }

                    ksort($data);
                }
            }
        }

        $content['data'] = $data;

        $html = $this->load->view($this->pathView . 'list', $content, TRUE);

        echo $html;
    }
}