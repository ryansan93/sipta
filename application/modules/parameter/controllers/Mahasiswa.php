<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends Public_Controller {

    private $pathView = 'parameter/mahasiswa/';
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
                "assets/parameter/mahasiswa/js/mahasiswa.js",
            ));
            $this->add_external_css(array(
                "assets/parameter/mahasiswa/css/mahasiswa.css",
            ));

            $data = $this->includes;

            $m_mahasiswa = new \Model\Storage\Mahasiswa_model();
            $d_mahasiswa = $m_mahasiswa->with(['prodi'])->orderBy('nama', 'asc')->get()->toArray();

            $content['akses'] = $this->hakAkses;
            $content['data'] = $d_mahasiswa;
            $content['title_panel'] = 'Master Mahasiswa';

            // Load Indexx
            $data['title_menu'] = 'Master Mahasiswa';
            $data['view'] = $this->load->view($this->pathView . 'index', $content, TRUE);
            $this->load->view($this->template, $data);
        } else {
            showErrorAkses();
        }
    }

    public function getDataProdi()
    {
        $m_prodi = new \Model\Storage\Prodi_model();
        $d_prodi = $m_prodi->orderBy('nama', 'asc')->get();

        $data = null;
        if ( $d_prodi->count() > 0 ) {
            $data = $d_prodi->toArray();
        }

        return $data;
    }

    public function modalAddForm()
    {
        $content['prodi'] = $this->getDataProdi();

        $html = $this->load->view($this->pathView . 'addForm', $content, TRUE);

        echo $html;
    }

    public function save()
    {
        $params = $this->input->post('params');

        try {
            $m_mahasiswa = new \Model\Storage\Mahasiswa_model();
            $d_mahasiswa = $m_mahasiswa->where('nim', $params['nim'])->first();

            if ( !$d_mahasiswa ) {
                $m_mahasiswa->nim = $params['nim'];
                $m_mahasiswa->nama = $params['nama'];
                $m_mahasiswa->no_telp = $params['no_telp'];
                $m_mahasiswa->email = $params['email'];
                $m_mahasiswa->prodi_kode = $params['prodi_kode'];
                $m_mahasiswa->save();

                $deskripsi_log = 'di-submit oleh ' . $this->userdata['detail_user']['nama_detuser'];
                Modules::run( 'base/event/save', $m_mahasiswa, $deskripsi_log );

                $this->result['status'] = 1;
                $this->result['message'] = 'Data berhasil di simpan.';
            } else {
                $this->result['message'] = 'Data NIM sudah ada.<br>Harap cek kembali NIM yang anda input.';
            }
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }

    public function modalEditForm()
    {
        $nim = $this->input->get('nim');

        $m_mahasiswa = new \Model\Storage\Mahasiswa_model();
        $d_mahasiswa = $m_mahasiswa->where('nim', $nim)->first()->toArray();

        $content['data'] = $d_mahasiswa;
        $content['prodi'] = $this->getDataProdi();

        $html = $this->load->view($this->pathView . 'editForm', $content, TRUE);

        echo $html;
    }

    public function edit()
    {
        $params = $this->input->post('params');

        try {
            $m_mahasiswa = new \Model\Storage\Mahasiswa_model();
            $d_mahasiswa = $m_mahasiswa->where('nim', $params['nim'])->first();

            $m_mahasiswa->where('nim', $params['nim'])->update(
                array(
                    'nama' => $params['nama'],
                    'no_telp' => $params['no_telp'],
                    'email' => $params['email'],
                    'prodi_kode' => $params['prodi_kode']
                )
            );

            $d_mahasiswa = $m_mahasiswa->where('nim', $params['nim'])->first();

            $deskripsi_log = 'di-update oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run( 'base/event/update', $d_mahasiswa, $deskripsi_log );

            $this->result['status'] = 1;
            $this->result['message'] = 'Data berhasil di edit.';
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }

    public function delete()
    {
        $nim = $this->input->post('nim');

        try {
            $m_mahasiswa = new \Model\Storage\Mahasiswa_model();
            $d_mahasiswa = $m_mahasiswa->where('nim', $nim)->first();

            $m_mahasiswa->where('nim', $nim)->delete();

            $deskripsi_log = 'di-delete oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run( 'base/event/delete', $d_mahasiswa, $deskripsi_log );

            $this->result['status'] = 1;
            $this->result['message'] = 'Data berhasil di hapus.';
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }
}