<?php defined('BASEPATH') OR exit('No direct script access allowed');

class JadwalSeminar extends Public_Controller {

    private $pathView = 'parameter/jadwal_seminar/';
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
                "assets/parameter/jadwal_seminar/js/jadwal-seminar.js",
            ));
            $this->add_external_css(array(
                "assets/parameter/jadwal_seminar/css/jadwal-seminar.css",
            ));

            $data = $this->includes;

            $content['akses'] = $this->hakAkses;
            $content['title_panel'] = 'Jadwal Seminar';

            $content['jenis_pengajuan'] = $this->getJenisPengajuan();

            $content['addForm'] = $this->addForm();
            $content['riwayatForm'] = $this->riwayatForm();

            // Load Indexx
            $data['title_menu'] = 'Jadwal Seminar';
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

    public function jadwal()
    {
        $jenis_pengajuan = $this->getJenisPengajuan();

        $data = null;
        if ( !empty($jenis_pengajuan) ) {
            $_jenis_pengajuan = null;
            foreach ($jenis_pengajuan as $k_jp => $v_jp) {
                $_jenis_pengajuan[ $v_jp['urut'] ] = $v_jp;
            }

            for ($i=1; $i <= count($_jenis_pengajuan); $i++) { 
                if ( isset($_jenis_pengajuan[$i+1]) ) {
                    $data[] = array(
                        'kode_asal' => $_jenis_pengajuan[$i]['kode'],
                        'asal' => $_jenis_pengajuan[$i]['nama'],
                        'kode_tujuan' => $_jenis_pengajuan[$i+1]['kode'],
                        'tujuan' => $_jenis_pengajuan[$i+1]['nama']
                    );
                }
            }
        }

        return $data;
    }

    public function getLists()
    {
        $params = $this->input->get('params');

        $start_date = $params['start_date'];
        $end_date = $params['end_date'];

        $m_js = new \Model\Storage\JadwalSeminar_model();
        $d_js = $m_js->whereBetween('tgl_berlaku', [$start_date, $end_date])->orderBy('tgl_berlaku', 'desc')->get();

        $data = null;
        if ( $d_js->count() > 0 ) {
            $data = $d_js->toArray();
        }

        $content['data'] = $data;
        $html = $this->load->view($this->pathView . 'list', $content, TRUE);

        echo $html;
    }

    public function riwayatForm()
    {
        $content['akses'] = $this->hakAkses;
        $html = $this->load->view($this->pathView . 'riwayatForm', $content, TRUE);

        return $html;
    }

    public function addForm()
    {
        $content['jadwal'] = $this->jadwal();

        $html = $this->load->view($this->pathView . 'addForm', $content, TRUE);

        return $html;
    }

    public function viewForm($kode)
    {
        $m_js = new \Model\Storage\JadwalSeminar_model();
        $d_js = $m_js->where('kode', $kode)->with(['detail'])->first()->toArray();

        $content['data'] = $d_js;

        $html = $this->load->view($this->pathView . 'viewForm', $content, TRUE);

        return $html;
    }

    public function save()
    {
        $params = $this->input->post('params');

        try {
            $m_js = new \Model\Storage\JadwalSeminar_model();
            $kode = $m_js->getNextId();

            $m_js->kode = $kode;
            $m_js->tgl_berlaku = $params['tgl_berlaku'];
            $m_js->save();

            foreach ($params['detail'] as $k => $val) {
                $m_jsd = new \Model\Storage\JadwalSeminarDet_model();

                $m_jsd->jadwal_seminar_kode = $kode;
                $m_jsd->asal = $val['kode_asal'];
                $m_jsd->tujuan = $val['kode_tujuan'];
                $m_jsd->lama_hari = $val['lama_hari'];
                $m_jsd->save();
            }

            $deskripsi_log = 'di-submit oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run( 'base/event/save', $m_js, $deskripsi_log );

            $this->result['status'] = 1;
            $this->result['message'] = 'Data berhasil di simpan.';
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }
}