<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen extends Public_Controller {

    private $pathView = 'parameter/dosen/';
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
                "assets/parameter/dosen/js/dosen.js",
            ));
            $this->add_external_css(array(
                "assets/parameter/dosen/css/dosen.css",
            ));

            $data = $this->includes;

            $m_dosen = new \Model\Storage\Dosen_model();
            $d_dosen = $m_dosen->orderBy('nama', 'asc')->get()->toArray();

            $content['akses'] = $this->hakAkses;
            $content['data'] = $d_dosen;
            $content['title_panel'] = 'Master Dosen';

            // Load Indexx
            $data['title_menu'] = 'Master Dosen';
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
            $m_dosen = new \Model\Storage\Dosen_model();
            $d_dosen = $m_dosen->where('nip', $params['nip'])->first();

            if ( !$d_dosen ) {
                $m_dosen->nip = $params['nip'];
                $m_dosen->nidn = $params['nidn'];
                $m_dosen->nama = $params['nama'];
                $m_dosen->no_telp = $params['no_telp'];
                $m_dosen->email = $params['email'];
                $m_dosen->save();

                $m_usr = new \Model\Storage\User_model();
                $now = $m_usr->getDate();

                // ENCRYPT PASSWORD
                $id_user = $params['nidn'];

                $this->load->helper('phppass');
                $hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
                $password = $id_user;
                $hash_password = $hasher->HashPassword($password);

                // INSERT TO TABLE ms_user
                $m_usr->id_user = $id_user;
                $m_usr->username_user = $id_user;
                $m_usr->status_user = 1;
                $m_usr->pass_user = $hash_password;
                $m_usr->save();

                $m_dusr = new \Model\Storage\DetUser_model();

                // GET ID FOR SAVE TO detail_user
                $id_detuser = $m_dusr->getNextId();

                // INSERT TO TABLE detail_user
                $m_dusr->id_detuser = $id_detuser;
                $m_dusr->id_user = $id_user;
                $m_dusr->aktif_detuser = $now['tanggal'];
                $m_dusr->jk_detuser = '-';
                $m_dusr->email_detuser = $params['email'];
                $m_dusr->nama_detuser = $params['nama'];
                $m_dusr->username_detuser = $id_user;
                $m_dusr->pass_detuser = $hash_password;
                $m_dusr->telp_detuser = $params['no_telp'];
                $m_dusr->id_group = 'GRP2212001';
                $m_dusr->edit_detuser = $now['waktu'];
                $m_dusr->useredit_detuser = $this->userid;
                $m_dusr->save();

                $deskripsi_log = 'di-submit oleh ' . $this->userdata['detail_user']['nama_detuser'];
                Modules::run( 'base/event/save', $m_dosen, $deskripsi_log );

                $this->result['status'] = 1;
                $this->result['message'] = 'Data berhasil di simpan.';
            } else {
                $this->result['message'] = 'Data NIP prodi sudah ada.<br>Harap cek kembali NIP yang anda input.';
            }
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }

    public function modalEditForm()
    {
        $nip = $this->input->get('nip');

        $m_dosen = new \Model\Storage\Dosen_model();
        $d_dosen = $m_dosen->where('nip', $nip)->first()->toArray();

        $content['data'] = $d_dosen;

        $html = $this->load->view($this->pathView . 'editForm', $content, TRUE);

        echo $html;
    }

    public function edit()
    {
        $params = $this->input->post('params');

        try {
            $m_dosen = new \Model\Storage\Dosen_model();
            $m_dosen->where('nip', $params['nip'])->update(
                array(
                    'nidn' => $params['nidn'],
                    'nama' => $params['nama'],
                    'no_telp' => $params['no_telp'],
                    'email' => $params['email']
                )
            );

            $d_dosen = $m_dosen->where('nip', $params['nip'])->first();

            $deskripsi_log = 'di-update oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run( 'base/event/update', $d_dosen, $deskripsi_log );

            $this->result['status'] = 1;
            $this->result['message'] = 'Data berhasil di edit.';
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }

    public function delete()
    {
        $nip = $this->input->post('nip');

        try {
            $m_dosen = new \Model\Storage\Dosen_model();
            $d_dosen = $m_dosen->where('nip', $nip)->first();

            $m_dosen->where('nip', $nip)->delete();

            $deskripsi_log = 'di-delete oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run( 'base/event/delete', $d_dosen, $deskripsi_log );

            $this->result['status'] = 1;
            $this->result['message'] = 'Data berhasil di hapus.';
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }

    public function insert_user_dosen()
    {
        $m_dosen = new \Model\Storage\Dosen_model();
        $d_dosen = $m_dosen->get();

        if ( $d_dosen->count() > 0 ) {
            $d_dosen = $d_dosen->toArray();

            $m_dosen = new \Model\Storage\Dosen_model();
            $nidn = $m_dosen->select('nidn')->get()->toArray();

            $m_usr = new \Model\Storage\User_model();
            $d_usr = $m_usr->whereIn('id_user', $nidn)->delete();

            $m_dusr = new \Model\Storage\DetUser_model();
            $d_dusr = $m_dusr->where('id_user', $nidn)->delete();

            foreach ($d_dosen as $key => $value) {
                $m_usr = new \Model\Storage\User_model();
                $now = $m_usr->getDate();

                // ENCRYPT PASSWORD
                $id_user = $value['nidn'];

                $this->load->helper('phppass');
                $hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
                $password = $id_user;
                $hash_password = $hasher->HashPassword($password);

                // INSERT TO TABLE ms_user
                $m_usr->id_user = $id_user;
                $m_usr->username_user = $id_user;
                $m_usr->status_user = 1;
                $m_usr->pass_user = $hash_password;
                $m_usr->save();

                $m_dusr = new \Model\Storage\DetUser_model();

                // GET ID FOR SAVE TO detail_user
                $id_detuser = $m_dusr->getNextId();

                // INSERT TO TABLE detail_user
                $m_dusr->id_detuser = $id_detuser;
                $m_dusr->id_user = $id_user;
                $m_dusr->aktif_detuser = $now['tanggal'];
                $m_dusr->jk_detuser = '-';
                $m_dusr->email_detuser = $value['email'];
                $m_dusr->nama_detuser = $value['nama'];
                $m_dusr->username_detuser = $id_user;
                $m_dusr->pass_detuser = $hash_password;
                $m_dusr->telp_detuser = $value['no_telp'];
                $m_dusr->id_group = 'GRP2212001';
                $m_dusr->edit_detuser = $now['waktu'];
                $m_dusr->useredit_detuser = $this->userid;
                $m_dusr->save();
            }
        }
    }
}