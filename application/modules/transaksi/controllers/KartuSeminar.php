<?php defined('BASEPATH') OR exit('No direct script access allowed');

class KartuSeminar extends Public_Controller {

    private $pathView = 'transaksi/kartu_seminar/';
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
                "assets/transaksi/kartu_seminar/js/kartu-seminar.js",
            ));
            $this->add_external_css(array(
                "assets/transaksi/kartu_seminar/css/kartu-seminar.css",
            ));

            $data = $this->includes;

            $content['akses'] = $this->hakAkses;
            $content['title_panel'] = 'Kartu Seminar';
            $content['jenis_pengajuan'] = $this->getJenisPengajuan();

            // Load Indexx
            $data['title_menu'] = 'Kartu Seminar';
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

    public function getDataSeminarAktif()
    {
        $jenis_pengajuan_kode = $this->input->get('jenis_pengajuan_kode');

        $m_conf = new \Model\Storage\Conf();
        $now = $m_conf->getDate();

        $tanggal = date('Y-m-d');
        $jam = substr($now['waktu'], 11, 5);
        $tanggal = '2022-11-30';
        $jam = '11:00';

        $m_pengajuan = new \Model\Storage\Pengajuan_model();
        $d_pengajuan = $m_pengajuan->where('jenis_pengajuan_kode', $jenis_pengajuan_kode)->where('jadwal', '>=', $tanggal)->where('g_status', getStatus('approve'))->with(['mahasiswa', 'ruang_kelas', 'jenis_pelaksanaan'])->get();

        $data = null;
        if ( $d_pengajuan->count() > 0 ) {
            $d_pengajuan = $d_pengajuan->toArray();

            foreach ($d_pengajuan as $k_pengajuan => $v_pengajuan) {
                $key = str_replace('-', '', $v_pengajuan['jadwal']).' | '.$v_pengajuan['kode'];

                $m_ks = new \Model\Storage\KartuSeminar_model();
                $d_ks = $m_ks->where('nim', $this->userid)->where('pengajuan_kode', $v_pengajuan['kode'])->first();

                $aktif = 0;
                $hadir = 0;

                $jam_pelaksanaan = substr($v_pengajuan['jam_pelaksanaan'], 0, 5);
                $jam_selesai = substr($v_pengajuan['jam_selesai'], 0, 5);
                if ( $jam_pelaksanaan <= $jam && $jam_selesai >= $jam ) {
                    $aktif = 1;
                }

                if ( $d_ks ) {
                    $hadir = 1;
                }

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
                    'aktif' => $aktif,
                    'hadir' => $hadir
                );
            }

            ksort( $data );
        }

        $content['akses'] = $this->hakAkses;
        $content['data'] = $data;

        $html = $this->load->view($this->pathView . 'list', $content, TRUE);

        echo $html;
    }

    public function checkIn()
    {
        $pengajuan_kode = $this->input->post('pengajuan_kode');

        try {
            $m_ks = new \Model\Storage\KartuSeminar_model();
            $kode = $m_ks->getNextIdRibuan();

            $m_ks->kode = $kode;
            $m_ks->nim = $this->userid;
            $m_ks->pengajuan_kode = $pengajuan_kode;
            $m_ks->save();

            $deskripsi_log = 'di-submit oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run( 'base/event/save', $m_ks, $deskripsi_log );

            $this->result['status'] = 1;
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }

    public function checkOut()
    {
        $pengajuan_kode = $this->input->post('pengajuan_kode');

        try {
            $m_ks = new \Model\Storage\KartuSeminar_model();
            $d_ks = $m_ks->where('pengajuan_kode', $pengajuan_kode)->where('nim', $this->userid)->first();

            $m_ks->where('pengajuan_kode', $pengajuan_kode)->where('nim', $this->userid)->delete();

            $deskripsi_log = 'di-submit oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run( 'base/event/save', $d_ks, $deskripsi_log );
            
            $this->result['status'] = 1;
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }
}