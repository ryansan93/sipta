<?php defined('BASEPATH') OR exit('No direct script access allowed');

class JamSeminarUjian extends Public_Controller {

    private $pathView = 'parameter/jam_seminar_ujian/';
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
                "assets/parameter/jam_seminar_ujian/js/jam-seminar-ujian.js",
            ));
            $this->add_external_css(array(
                "assets/parameter/jam_seminar_ujian/css/jam-seminar-ujian.css",
            ));

            $data = $this->includes;

            $m_jsu = new \Model\Storage\JamSeminarUjian_model();
            $d_jsu = $m_jsu->with(['jenis_pengajuan'])->get()->toArray();

            $content['akses'] = $this->hakAkses;
            $content['data'] = $d_jsu;
            $content['title_panel'] = 'Master Jam Seminar / Ujian';

            // Load Indexx
            $data['title_menu'] = 'Master Jam Seminar / Ujian';
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

    public function modalAddForm()
    {
        $content['jenis_pengajuan'] = $this->getJenisPengajuan();
        $html = $this->load->view($this->pathView . 'addForm', $content, TRUE);

        echo $html;
    }

    public function save()
    {
        $params = $this->input->post('params');

        try {
            $m_jsu = new \Model\Storage\JamSeminarUjian_model();
            $m_jsu->jenis_pengajuan_kode = $params['jenis_pengajuan_kode'];
            $m_jsu->awal = $params['awal'];
            $m_jsu->akhir = $params['akhir'];
            $m_jsu->mstatus = 1;
            $m_jsu->save();

            $deskripsi_log = 'di-submit oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run( 'base/event/save', $m_jsu, $deskripsi_log );

            $this->result['status'] = 1;
            $this->result['message'] = 'Data berhasil di simpan.';
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }

    public function modalEditForm()
    {
        $id = $this->input->get('id');

        $m_jsu = new \Model\Storage\JamSeminarUjian_model();
        $d_jsu = $m_jsu->where('id', $id)->first()->toArray();

        $content['jenis_pengajuan'] = $this->getJenisPengajuan();
        $content['data'] = $d_jsu;

        $html = $this->load->view($this->pathView . 'editForm', $content, TRUE);

        echo $html;
    }

    public function edit()
    {
        $params = $this->input->post('params');

        try {
            $m_jsu = new \Model\Storage\JamSeminarUjian_model();
            $m_jsu->where('id', $params['id'])->update(
                array(
                    'jenis_pengajuan_kode' => $params['jenis_pengajuan_kode'],
                    'awal' => $params['awal'],
                    'akhir' => $params['akhir'],
                    'mstatus' => 1
                )
            );

            $d_jsu = $m_jsu->where('id', $params['id'])->first();

            $deskripsi_log = 'di-update oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run( 'base/event/update', $d_jsu, $deskripsi_log );

            $this->result['status'] = 1;
            $this->result['message'] = 'Data berhasil di edit.';
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }

    public function delete()
    {
        $id = $this->input->post('id');

        try {
            $m_jsu = new \Model\Storage\JamSeminarUjian_model();
            $m_jsu->where('id', $id)->update(
                array(
                    'mstatus' => 0
                )
            );

            $d_jsu = $m_jsu->where('id', $id)->first();

            $deskripsi_log = 'di-delete oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run( 'base/event/delete', $d_jsu, $deskripsi_log );

            $this->result['status'] = 1;
            $this->result['message'] = 'Data berhasil di hapus.';
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }
}