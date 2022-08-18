<?php defined('BASEPATH') OR exit('No direct script access allowed');

class PelaksanaanTA extends Public_Controller {

    private $pathView = 'transaksi/pelaksanaan_ta/';
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
                "assets/transaksi/pelaksanaan_ta/js/pelaksanaan-ta.js",
            ));
            $this->add_external_css(array(
                "assets/transaksi/pelaksanaan_ta/css/pelaksanaan-ta.css",
            ));

            $data = $this->includes;

            $start_date = null;
            $end_date = null;
            if ( !empty($params) ) {
                $_params = json_decode(base64_decode($params), true);

                $start_date = $_params['start_date'];
                $end_date = $_params['end_date'];
            }

            $content['akses'] = $this->hakAkses;
            $content['riwayatForm'] = $this->riwayatForm();
            $content['addForm'] = $this->addForm();
            $content['title_panel'] = 'Pelaksanaan TA';

            // Load Indexx
            $data['title_menu'] = 'Pelaksanaan TA';
            $data['view'] = $this->load->view($this->pathView . 'index', $content, TRUE);
            $this->load->view($this->template, $data);
        } else {
            showErrorAkses();
        }
    }

    public function getLists()
    {
        $params = $this->input->get('params');

        $jenis_pengajuan_kode = $params['jenis_pengajuan_kode'];

        $m_mahasiswa = new \Model\Storage\Mahasiswa_model();
        $d_mahasiswa = $m_mahasiswa->where('nim', $this->userid)->orderBy('nama', 'asc')->first();

        $_jenis_pengajuan_kode = null;
        if ( $jenis_pengajuan_kode !== 'all' ) {
            $m_jenis_pengajuan = new \Model\Storage\JenisPengajuan_model();
            $d_jenis_pengajuan = $m_jenis_pengajuan->select('kode')->get();

            if ( $d_jenis_pengajuan->count() > 0 ) {
                $_jenis_pengajuan_kode = $d_jenis_pengajuan->toArray();
            }
        } else {
            $_jenis_pengajuan_kode[] = $jenis_pengajuan_kode;
        }

        $m_blangko = new \Model\Storage\Blangko_model();
        $m_pengajuan = new \Model\Storage\Pengajuan_model();
        if ( $d_mahasiswa ) {
            $d_pengajuan = $m_pengajuan->select('kode')->whereIn('jenis_pengajuan_kode', $_jenis_pengajuan_kode)->where('nim', $this->userid)->orderBy('tgl_pengajuan', 'desc')->get();

            if ( $d_pengajuan ) {
                $d_pengajuan = $d_pengajuan->toArray();

                $d_blangko = $m_blangko->whereIn('pengajuan_kode', $d_pengajuan)->with(['pengajuan'])->orderBy('tgl_trans', 'desc')->get();
            }
        } else {
            $d_pengajuan = $m_pengajuan->whereIn('jenis_pengajuan_kode', $_jenis_pengajuan_kode)->orderBy('tgl_pengajuan', 'desc')->get();

            if ( $d_pengajuan ) {
                $d_pengajuan = $d_pengajuan->toArray();

                $d_blangko = $m_blangko->whereIn('pengajuan_kode', $d_pengajuan)->with(['pengajuan'])->orderBy('tgl_trans', 'desc')->get();
            }
        }

        $data = null;
        if ( $d_blangko->count() > 0 ) {
            $data = $d_blangko->toArray();
        }

        $content['data'] = $data;

        $html = $this->load->view($this->pathView . 'list', $content, TRUE);

        echo $html;
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

    public function getPengajuan()
    {
        $today = date('Y-m-d');

        $m_pengajuan = new \Model\Storage\Pengajuan_model();
        $d_pengajuan = $m_pengajuan->where('g_status', getStatus('approve'))->where('nim', $this->userid)->where('jadwal', '<=', $today)->with(['jenis_pengajuan'])->get();

        $data = null;
        if ( $d_pengajuan->count() > 0 ) {
            $d_pengajuan = $d_pengajuan->toArray();

            foreach ($d_pengajuan as $k_pengajuan => $v_pengajuan) {
                $m_blangko = new \Model\Storage\Blangko_model();
                $d_blangko = $m_blangko->where('pengajuan_kode', $v_pengajuan['kode'])->first();

                if ( !$d_blangko ) {
                    $data[] = array(
                        'kode' => $v_pengajuan['kode'],
                        'jenis_pengajuan_kode' => $v_pengajuan['jenis_pengajuan']['kode'],
                        'jenis_pengajuan' => $v_pengajuan['jenis_pengajuan']['nama'],
                        'judul' => $v_pengajuan['judul_penelitian']
                    );
                }
            }
        }

        return $data;
    }

    public function kelengkapanBlangko()
    {
        $jenis_pengajuan_kode = $this->input->get('jenis_pengajuan_kode');

        $m_kp = new \Model\Storage\KelengkapanBlangko_model();
        $d_kp = $m_kp->where('jenis_pengajuan_kode', $jenis_pengajuan_kode)->get();

        $data = null;
        if ( $d_kp->count() > 0 ) {
            $data = $d_kp->toArray();
        }

        $content['data'] = $data;
        $html = $this->load->view($this->pathView . 'formKelengkapan', $content, TRUE);

        echo $html;
    }

    public function getJenisPengajuan()
    {
        $m_jenis_pengajuan = new \Model\Storage\JenisPengajuan_model();
        $d_jenis_pengajuan = $m_jenis_pengajuan->where('urut', '<>', 1)->orderBy('nama', 'asc')->get();

        $data = null;
        if ( $d_jenis_pengajuan->count() > 0 ) {
            $data = $d_jenis_pengajuan->toArray();
        }

        return $data;
    }

    public function riwayatForm($start_date = null, $end_date = null)
    {
        $content['akses'] = $this->hakAkses;
        $content['jenis_pengajuan'] = $this->getJenisPengajuan();

        $html = $this->load->view($this->pathView . 'riwayat', $content, TRUE);

        return $html;
    }

    public function addForm()
    {
        $content['akses'] = $this->hakAkses;
        $content['pengajuan'] = $this->getPengajuan();

        $html = $this->load->view($this->pathView . 'addForm', $content, TRUE);

        return $html;
    }

    public function viewForm($kode)
    {
        $m_blangko = new \Model\Storage\Blangko_model();
        $d_blangko = $m_blangko->where('kode', $kode)->with(['pengajuan', 'blangko_kelengkapan'])->first()->toArray();

        $content['akses'] = $this->hakAkses;
        $content['data'] = $d_blangko;

        $html = $this->load->view($this->pathView . 'view_form', $content, TRUE);

        return $html;
    }

    public function editForm($kode)
    {
        $m_pengajuan = new \Model\Storage\Pengajuan_model();
        $d_pengajuan = $m_pengajuan->where('kode', $kode)->with(['jenis_pengajuan', 'mahasiswa', 'jenis_pelaksanaan', 'prodi', 'pengajuan_dosen', 'pengajuan_kelengkapan'])->first()->toArray();

        $jenis_pengajuan_form = $d_pengajuan['jenis_pengajuan']['form_pengajuan'];

        $content['akses'] = $this->hakAkses;
        $content['data'] = $d_pengajuan;

        $html = $this->load->view($this->pathView . 'form'.ucfirst($jenis_pengajuan_form).'Edit', $content, TRUE);

        return $html;
    }

    public function mappingFiles($files)
    {
        $mappingFiles = [];
        foreach ($files['tmp_name'] as $key => $file) {
            $sha1 = sha1_file($file);
            $index = $key;
            $mappingFiles[$index] = [
                'name' => $files['name'][$key],
                'tmp_name' => $file,
                'type' => $files['type'][$key],
                'size' => $files['size'][$key],
                'error' => $files['error'][$key]
            ];
        }
        
        return $mappingFiles;
    }

    public function save()
    {
        $params = json_decode($this->input->post('data'), true);
        $files = isset($_FILES['lampiran']) ? $_FILES['lampiran'] : null;
        $mappingFiles = $this->mappingFiles( $files );

        try {
            $m_blangko = new \Model\Storage\Blangko_model();
            $kode = $m_blangko->getNextId();

            $path_name_blangko = null;
            if ( !empty($mappingFiles['blangko']) ) {
                $moved = uploadFile($mappingFiles['blangko']);
                if ( $moved ) {
                    $path_name_blangko = $moved['path'];
                }

                $m_blangko->kode = $kode;
                $m_blangko->tgl_trans = date('Y-m-d');
                $m_blangko->pengajuan_kode = $params['pengajuan_kode'];
                $m_blangko->lampiran = $path_name_blangko;
                $m_blangko->save();

                foreach ($params['list_kelengkapan_blangko'] as $k_lkb => $v_lkb) {
                    $path_name = null;
                    if ( !empty($mappingFiles[ $v_lkb['kode'] ]) ) {
                        $moved = uploadFile($mappingFiles[ $v_lkb['kode'] ]);
                        if ( $moved ) {
                            $path_name = $moved['path'];
                        }
                    }

                    $m_pk = new \Model\Storage\BlangkoKelengkapan_model();
                    $m_pk->blangko_kode = $kode;
                    $m_pk->kelengkapan_blangko_kode = $v_lkb['kode'];
                    $m_pk->lampiran = $path_name;
                    $m_pk->save();
                }

                $deskripsi_log = 'di-submit oleh ' . $this->userdata['detail_user']['nama_detuser'];
                Modules::run( 'base/event/save', $m_blangko, $deskripsi_log );
            }

            $this->result['status'] = 1;
            $this->result['message'] = 'Data berhasil di simpan.';
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }

    public function delete()
    {
        $kode = $this->input->post('params');

        try {
            $m_blangko = new \Model\Storage\Blangko_model();
            $d_blangko = $m_blangko->where('kode', $kode)->first();

            $m_bk = new \Model\Storage\BlangkoKelengkapan_model();

            $m_bk->where('blangko_kode', $kode)->delete();
            $m_blangko->where('kode', $kode)->delete();

            $deskripsi_log = 'di-delete oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run( 'base/event/delete', $d_blangko, $deskripsi_log );

            $this->result['status'] = 1;
            $this->result['message'] = 'Data berhasil di hapus.';
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }
}