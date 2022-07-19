<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Prodi extends Public_Controller {

    private $pathView = 'parameter/prodi/';
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
                "assets/parameter/prodi/js/prodi.js",
            ));
            $this->add_external_css(array(
                "assets/parameter/prodi/css/prodi.css",
            ));

            $data = $this->includes;

            $m_prodi = new \Model\Storage\Prodi_model();
            $d_prodi = $m_prodi->orderBy('nama', 'asc')->get()->toArray();

            $content['akses'] = $this->hakAkses;
            $content['data'] = $d_prodi;
            $content['title_panel'] = 'Master Prodi';

            // Load Indexx
            $data['title_menu'] = 'Master Prodi';
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

    public function save()
    {
        $params = $this->input->post('params');

        try {
            $m_prodi = new \Model\Storage\Prodi_model();
            $d_prodi = $m_prodi->where('kode', $params['kode'])->first();

            if ( !$d_prodi ) {
                $m_prodi->kode = $params['kode'];
                $m_prodi->nama = $params['nama'];
                $m_prodi->save();

                $deskripsi_log = 'di-submit oleh ' . $this->userdata['detail_user']['nama_detuser'];
                Modules::run( 'base/event/save', $m_prodi, $deskripsi_log );

                $this->result['status'] = 1;
                $this->result['message'] = 'Data berhasil di simpan.';
            } else {
                $this->result['message'] = 'Data kode prodi sudah ada.<br>Harap cek kembali kode yang anda input.';
            }
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }

    public function modalEditForm()
    {
        $kode = $this->input->get('kode');

        $m_prodi = new \Model\Storage\Prodi_model();
        $d_prodi = $m_prodi->where('kode', $kode)->first()->toArray();

        $content['data'] = $d_prodi;

        $html = $this->load->view($this->pathView . 'editForm', $content, TRUE);

        echo $html;
    }

    public function edit()
    {
        $params = $this->input->post('params');

        try {
            $m_prodi = new \Model\Storage\Prodi_model();
            $m_prodi->where('kode', $params['kode'])->update(
                array(
                    'nama' => $params['nama']
                )
            );

            $d_prodi = $m_prodi->where('kode', $params['kode'])->first();

            $deskripsi_log = 'di-update oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run( 'base/event/update', $d_prodi, $deskripsi_log );

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
            $m_prodi = new \Model\Storage\Prodi_model();
            $d_prodi = $m_prodi->where('kode', $kode)->first();

            $m_prodi->where('kode', $kode)->delete();

            $deskripsi_log = 'di-delete oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run( 'base/event/delete', $d_prodi, $deskripsi_log );

            $this->result['status'] = 1;
            $this->result['message'] = 'Data berhasil di hapus.';
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }
}