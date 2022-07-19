<?php defined('BASEPATH') OR exit('No direct script access allowed');

class KelengkapanPengajuan extends Public_Controller {

    private $pathView = 'parameter/kelengkapan_pengajuan/';
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
                "assets/parameter/kelengkapan_pengajuan/js/kelengkapan-pengajuan.js",
            ));
            $this->add_external_css(array(
                "assets/parameter/kelengkapan_pengajuan/css/kelengkapan-pengajuan.css",
            ));

            $data = $this->includes;

            $m_kp = new \Model\Storage\KelengkapanPengajuan_model();
            $d_kp = $m_kp->orderBy('nama', 'asc')->with(['jenis_pengajuan'])->get()->toArray();

            $content['akses'] = $this->hakAkses;
            $content['data'] = $d_kp;
            $content['title_panel'] = 'Master Kelengkapan Pengajuan';

            // Load Indexx
            $data['title_menu'] = 'Master Kelengkapan Pengajuan';
            $data['view'] = $this->load->view($this->pathView . 'index', $content, TRUE);
            $this->load->view($this->template, $data);
        } else {
            showErrorAkses();
        }
    }

    public function modalAddForm()
    {
        $m_jp = new \Model\Storage\JenisPengajuan_model();
        $d_jp = $m_jp->get();

        if ( $d_jp->count() > 0 ) {
            $d_jp = $d_jp->toArray();
        }

        $content['jenis_pengajuan'] = $d_jp;

        $html = $this->load->view($this->pathView . 'addForm', $content, TRUE);

        echo $html;
    }

    public function save()
    {
        $params = $this->input->post('params');

        try {
            $m_kp = new \Model\Storage\KelengkapanPengajuan_model();

            $kode = $m_kp->getNextId();

            $m_kp->kode = $kode;
            $m_kp->jenis_pengajuan_kode = $params['kode_jenis_pengajuan'];
            $m_kp->nama = $params['nama'];
            $m_kp->save();

            $deskripsi_log = 'di-submit oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run( 'base/event/save', $m_kp, $deskripsi_log );

            $this->result['status'] = 1;
            $this->result['message'] = 'Data berhasil di simpan.';
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }

    public function modalEditForm()
    {
        $kode = $this->input->get('kode');

        $m_kp = new \Model\Storage\KelengkapanPengajuan_model();
        $d_kp = $m_kp->where('kode', $kode)->first()->toArray();

        $m_jp = new \Model\Storage\JenisPengajuan_model();
        $d_jp = $m_jp->get();

        if ( $d_jp->count() > 0 ) {
            $d_jp = $d_jp->toArray();
        }

        $content['jenis_pengajuan'] = $d_jp;
        $content['data'] = $d_kp;

        $html = $this->load->view($this->pathView . 'editForm', $content, TRUE);

        echo $html;
    }

    public function edit()
    {
        $params = $this->input->post('params');

        try {
            $m_kp = new \Model\Storage\KelengkapanPengajuan_model();
            $m_kp->where('kode', $params['kode'])->update(
                array(
                    'jenis_pengajuan_kode' => $params['kode_jenis_pengajuan'],
                    'nama' => $params['nama']
                )
            );

            $d_kp = $m_kp->where('kode', $params['kode'])->first();

            $deskripsi_log = 'di-update oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run( 'base/event/update', $d_kp, $deskripsi_log );

            $this->result['status'] = 1;
            $this->result['message'] = 'Data berhasil di edit.';
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }

    public function delete()
    {
        $kode = $this->input->post('kode');

        try {
            $m_kp = new \Model\Storage\KelengkapanPengajuan_model();
            $d_kp = $m_kp->where('kode', $kode)->first();

            $m_kp->where('kode', $kode)->delete();

            $deskripsi_log = 'di-delete oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run( 'base/event/delete', $d_kp, $deskripsi_log );

            $this->result['status'] = 1;
            $this->result['message'] = 'Data berhasil di hapus.';
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }
}