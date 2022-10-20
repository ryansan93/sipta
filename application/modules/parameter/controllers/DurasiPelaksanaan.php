<?php defined('BASEPATH') OR exit('No direct script access allowed');

class DurasiPelaksanaan extends Public_Controller {

    private $pathView = 'parameter/durasi_pelaksanaan/';
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
                "assets/parameter/durasi_pelaksanaan/js/durasi-pelaksanaan.js",
            ));
            $this->add_external_css(array(
                "assets/parameter/durasi_pelaksanaan/css/durasi-pelaksanaan.css",
            ));

            $data = $this->includes;

            $m_dp = new \Model\Storage\DurasiPelaksanaan_model();
            $d_dp = $m_dp->get()->toArray();

            $content['akses'] = $this->hakAkses;
            $content['data'] = $d_dp;
            $content['title_panel'] = 'Durasi Pelaksanaan';

            // Load Indexx
            $data['title_menu'] = 'Durasi Pelaksanaan';
            $data['view'] = $this->load->view($this->pathView . 'index', $content, TRUE);
            $this->load->view($this->template, $data);
        } else {
            showErrorAkses();
        }
    }

    public function modalAddForm()
    {
        $html = $this->load->view($this->pathView . 'addForm', null, TRUE);

        echo $html;
    }

    public function modalEditForm()
    {
        $id = $this->input->get('id');

        $m_dp = new \Model\Storage\DurasiPelaksanaan_model();
        $d_dp = $m_dp->where('id', $id)->first()->toArray();

        $content['data'] = $d_dp;

        $html = $this->load->view($this->pathView . 'editForm', $content, TRUE);

        echo $html;
    }

    public function save()
    {
        $params = $this->input->post('params');

        try {
            $m_dp = new \Model\Storage\DurasiPelaksanaan_model();
            $m_dp->durasi = $params['durasi'];
            $m_dp->save();

            $deskripsi_log = 'di-submit oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run( 'base/event/save', $m_dp, $deskripsi_log );

            $this->result['status'] = 1;
            $this->result['message'] = 'Data berhasil di simpan.';
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }

    public function edit()
    {
        $params = $this->input->post('params');

        try {
            $m_dp = new \Model\Storage\DurasiPelaksanaan_model();
            $m_dp->where('id', $params['id'])->update(
                array(
                    'durasi' => $params['durasi']
                )
            );

            $d_dp = $m_dp->where('id', $params['id'])->first();

            $deskripsi_log = 'di-update oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run( 'base/event/update', $d_dp, $deskripsi_log );

            $this->result['status'] = 1;
            $this->result['message'] = 'Data berhasil di ubah.';
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }

    public function delete()
    {
        $id = $this->input->post('id');

        try {
            $m_dp = new \Model\Storage\DurasiPelaksanaan_model();
            $d_dp = $m_dp->where('id', $id)->first();

            $m_dp->where('id', $id)->delete();

            $deskripsi_log = 'di-hapus oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run( 'base/event/delete', $d_dp, $deskripsi_log );

            $this->result['status'] = 1;
            $this->result['message'] = 'Data berhasil di hapus.';
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }
}