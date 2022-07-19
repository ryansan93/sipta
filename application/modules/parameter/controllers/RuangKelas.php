<?php defined('BASEPATH') OR exit('No direct script access allowed');

class RuangKelas extends Public_Controller {

    private $pathView = 'parameter/ruang_kelas/';
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
                "assets/parameter/ruang_kelas/js/ruang-kelas.js",
            ));
            $this->add_external_css(array(
                "assets/parameter/ruang_kelas/css/ruang-kelas.css",
            ));

            $data = $this->includes;

            $m_rk = new \Model\Storage\RuangKelas_model();
            $d_rk = $m_rk->orderBy('nama', 'asc')->get()->toArray();

            $content['akses'] = $this->hakAkses;
            $content['data'] = $d_rk;
            $content['title_panel'] = 'Master Ruang Kelas';

            // Load Indexx
            $data['title_menu'] = 'Master Ruang Kelas';
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
            $m_rk = new \Model\Storage\RuangKelas_model();
            $d_rk = $m_rk->where('kode', $params['kode'])->first();

            if ( !$d_rk ) {
                $m_rk->kode = $params['kode'];
                $m_rk->nama = $params['nama'];
                $m_rk->save();

                $deskripsi_log = 'di-submit oleh ' . $this->userdata['detail_user']['nama_detuser'];
                Modules::run( 'base/event/save', $m_rk, $deskripsi_log );

                $this->result['status'] = 1;
                $this->result['message'] = 'Data berhasil di simpan.';
            } else {
                $this->result['message'] = 'Data kode ruang kelas sudah ada.<br>Harap cek kembali kode yang anda input.';
            }
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }

    public function modalEditForm()
    {
        $kode = $this->input->get('kode');

        $m_rk = new \Model\Storage\RuangKelas_model();
        $d_rk = $m_rk->where('kode', $kode)->first()->toArray();

        $content['data'] = $d_rk;

        $html = $this->load->view($this->pathView . 'editForm', $content, TRUE);

        echo $html;
    }

    public function edit()
    {
        $params = $this->input->post('params');

        try {
            $m_rk = new \Model\Storage\RuangKelas_model();
            $m_rk->where('kode', $params['kode'])->update(
                array(
                    'nama' => $params['nama']
                )
            );

            $d_rk = $m_rk->where('kode', $params['kode'])->first();

            $deskripsi_log = 'di-update oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run( 'base/event/update', $d_rk, $deskripsi_log );

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
            $m_rk = new \Model\Storage\RuangKelas_model();
            $d_rk = $m_rk->where('kode', $kode)->first();

            $m_rk->where('kode', $kode)->delete();

            $deskripsi_log = 'di-delete oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run( 'base/event/delete', $d_rk, $deskripsi_log );

            $this->result['status'] = 1;
            $this->result['message'] = 'Data berhasil di hapus.';
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }
}