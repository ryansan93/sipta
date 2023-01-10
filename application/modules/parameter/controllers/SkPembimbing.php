<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SkPembimbing extends Public_Controller {

    private $pathView = 'parameter/sk_pembimbing/';
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
                "assets/select2/js/select2.min.js",
                "assets/parameter/sk_pembimbing/js/sk-pembimbing.js",
            ));
            $this->add_external_css(array(
                "assets/select2/css/select2.min.css",
                "assets/parameter/sk_pembimbing/css/sk-pembimbing.css",
            ));

            $data = $this->includes;

            $m_skp = new \Model\Storage\SkPembimbing_model();
            $d_skp = $m_skp->with(['sk_pembimbing_dosen'])->orderBy('nama', 'asc')->get()->toArray();

            $content['akses'] = $this->hakAkses;
            $content['data'] = $d_skp;
            $content['title_panel'] = 'Master SK Pembimbing';

            $content['mahasiswa'] = $this->getMahasiswa();
            $content['dosen'] = $this->getDosen();

            // Load Indexx
            $data['title_menu'] = 'Master SK Pembimbing';
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

    public function getDosen()
    {
        $m_dosen = new \Model\Storage\Dosen_model();
        $d_dosen = $m_dosen->orderBy('nama', 'asc')->get();

        $data = null;
        if ( $d_dosen->count() > 0 ) {
            $data = $d_dosen->toArray();
        }

        return $data;
    }

    public function getLists()
    {
        $params = $this->input->get('params');

        $data = null;

        if ( $params['jenis_filter'] == 'mahasiswa' ) {
            $m_skp = new \Model\Storage\SkPembimbing_model();
            $d_skp = $m_skp->where('nim', $params['value_filter'])->with(['sk_pembimbing_dosen'])->get();

            if ( $d_skp->count() > 0 ) {
                $data = $d_skp->toArray();
            }
        } else {
            $m_skpd = new \Model\Storage\SkPembimbingDosen_model();
            $d_skpd = $m_skpd->select('id_header')->where('nip', $params['value_filter'])->get();

            if ( $d_skpd->count() > 0 ) {
                $d_skpd = $d_skpd->toArray();

                $m_skp = new \Model\Storage\SkPembimbing_model();
                $d_skp = $m_skp->whereIn('id', $d_skpd)->with(['sk_pembimbing_dosen'])->get();

                if ( $d_skp->count() > 0 ) {
                    $data = $d_skp->toArray();
                }
            }
        }

        $content['akses'] = $this->hakAkses;
        $content['data'] = $data;

        $html = $this->load->view($this->pathView . 'list', $content, TRUE);

        echo $html;
    }

    public function modalAddForm()
    {
        $content['mahasiswa'] = $this->getMahasiswa();
        $content['dosen'] = $this->getDosen();

        $html = $this->load->view($this->pathView . 'addForm', $content, TRUE);

        echo $html;
    }

    public function save()
    {
        $params = $this->input->post('params');

        try {
            $m_mahasiswa = new \Model\Storage\Mahasiswa_model();
            $d_mahasiswa = $m_mahasiswa->where('nim', $params['mahasiswa'])->first();

            $m_skp = new \Model\Storage\SkPembimbing_model();
            $m_skp->nim = $params['mahasiswa'];
            $m_skp->nama = $d_mahasiswa->nama;
            $m_skp->status = 1;
            $m_skp->save();

            $id_header = $m_skp->id;

            foreach ($params['list_pembimbing'] as $k_lp => $v_lp) {
                $m_dosen = new \Model\Storage\Dosen_model();
                $d_dosen = $m_dosen->where('nip', $v_lp['nip'])->first();

                $m_skpd = new \Model\Storage\SkPembimbingDosen_model();
                $m_skpd->id_header = $id_header;
                $m_skpd->nip = $v_lp['nip'];
                $m_skpd->nama = $d_dosen->nama;
                $m_skpd->no = $v_lp['no'];
                $m_skpd->save();
            }

            $deskripsi_log = 'di-submit oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run( 'base/event/save', $m_skp, $deskripsi_log );

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

        $m_skp = new \Model\Storage\SkPembimbing_model();
        $d_skp = $m_skp->where('id', $id)->with(['sk_pembimbing_dosen'])->first();

        $data = null;

        if ( $d_skp->count() > 0 ) {
            $data = $d_skp->toArray();
        }

        $content['data'] = $data;
        $content['mahasiswa'] = $this->getMahasiswa();
        $content['dosen'] = $this->getDosen();

        $html = $this->load->view($this->pathView . 'editForm', $content, TRUE);

        echo $html;
    }

    public function edit()
    {
        $params = $this->input->post('params');

        try {
            $m_mahasiswa = new \Model\Storage\Mahasiswa_model();
            $d_mahasiswa = $m_mahasiswa->where('nim', $params['mahasiswa'])->first();

            $m_skp = new \Model\Storage\SkPembimbing_model();
            $m_skp->where('id', $params['id'])->update(
                array(
                    'nim' => $params['mahasiswa'],
                    'nama' => $d_mahasiswa->nama
                )
            );

            $id_header = $params['id'];

            $m_skpd = new \Model\Storage\SkPembimbingDosen_model();
            $m_skpd->where('id_header', $id_header)->delete();

            foreach ($params['list_pembimbing'] as $k_lp => $v_lp) {
                $m_dosen = new \Model\Storage\Dosen_model();
                $d_dosen = $m_dosen->where('nip', $v_lp['nip'])->first();

                $m_skpd = new \Model\Storage\SkPembimbingDosen_model();
                $m_skpd->id_header = $id_header;
                $m_skpd->nip = $v_lp['nip'];
                $m_skpd->nama = $d_dosen->nama;
                $m_skpd->no = $v_lp['no'];
                $m_skpd->save();
            }

            $deskripsi_log = 'di-update oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run( 'base/event/update', $m_skp, $deskripsi_log );

            $this->result['status'] = 1;
            $this->result['message'] = 'Data berhasil di ubah.';
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }

    public function delete()
    {
        $id = $this->input->post('params');

        try {
            $m_skp = new \Model\Storage\SkPembimbing_model();
            $d_skp = $m_skp->where('id', $id)->first();

            $m_skpd = new \Model\Storage\SkPembimbingDosen_model();
            $m_skpd->where('id_header', $id)->delete();
            $m_skp->where('id', $id)->delete();

            $deskripsi_log = 'di-delete oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run( 'base/event/delete', $d_skp, $deskripsi_log );

            $this->result['status'] = 1;
            $this->result['message'] = 'Data berhasil di hapus.';
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }
}