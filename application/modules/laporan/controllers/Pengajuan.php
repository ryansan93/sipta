<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pengajuan extends Public_Controller {

    private $pathView = 'laporan/pengajuan/';
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
                "assets/select2/js/select2.min.js",
                "assets/jquery/list.min.js",
                "assets/laporan/pengajuan/js/pengajuan.js",
            ));
            $this->add_external_css(array(
                'assets/select2/css/select2.min.css',
                "assets/laporan/pengajuan/css/pengajuan.css",
            ));

            $data = $this->includes;

            $content['akses'] = $this->hakAkses;
            $content['title_panel'] = 'Laporan Pengajuan TA';

            $content['report_by_tanggal'] = $this->load->view($this->pathView . 'report_by_tanggal', null, TRUE);
            $content['report_by_dosen'] = $this->load->view($this->pathView . 'report_by_dosen', null, TRUE);
            $content['report_by_prodi'] = $this->load->view($this->pathView . 'report_by_prodi', null, TRUE);
            $content['dosen'] = $this->getDosen();

            // Load Indexx
            $data['title_menu'] = 'Laporan Pengajuan TA';
            $data['view'] = $this->load->view($this->pathView . 'index', $content, TRUE);
            $this->load->view($this->template, $data);
        } else {
            showErrorAkses();
        }
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
        $params = $this->input->post('params');

        try {
            $start_date = $params['start_date'];
            $end_date = $params['end_date'];
            $_dosen = $params['dosen'];

            $nip_dosen = array();
            if ( !empty( $_dosen ) ) {
                foreach ($_dosen as $k_dosen => $v_dosen) {
                    if ( stristr($v_dosen, 'all') !== FALSE ) {
                        $d_dosen = $this->getDosen();

                        foreach ($d_dosen as $key => $val) {
                            $nip_dosen[] = $val['nip'];
                        }

                        break;
                    } else {
                        $nip_dosen[] = $v_dosen;
                    }
                }
            }

            $sql = "
                select 
                    p.kode as kode, 
                    p.tgl_pengajuan as tgl_pengajuan, 
                    p.jadwal as tgl_seminar, 
                    p.jam_pelaksanaan as jam_pelaksanaan, 
                    m.nama as nama,
                    p.nim as nim,
                    prd.nama as prodi,
                    p.prodi_kode as prodi_kode,
                    jplk.nama as jenis_pelaksanaan,
                    jp.nama as jenis_pengajuan,
                    p.jenis_pengajuan_kode as jenis_pengajuan_kode,
                    rk.nama as ruang_kelas,
                    p.akun_zoom as akun_zoom,
                    ns.no_surat as no_surat, 
                    ns.path as path,
                    p.kode_pengajuan as kode_pengajuan
                from pengajuan p
                left join
                    mahasiswa m
                    on
                        p.nim = m.nim
                left join
                    prodi prd
                    on
                        p.prodi_kode = prd.kode
                left join
                    no_surat ns
                    on
                        p.kode = ns.pengajuan_kode
                left join
                    jenis_pengajuan jp
                    on
                        p.jenis_pengajuan_kode = jp.kode
                left join
                    jenis_pelaksanaan jplk
                    on
                        p.jenis_pelaksanaan_kode = jplk.kode
                left join
                    ruang_kelas rk
                    on
                        p.ruang_kelas = rk.kode
                where
                    p.tgl_pengajuan between '".$start_date."' and '".$end_date."'
            ";
            $m_pengajuan = new \Model\Storage\Pengajuan_model();
            $d_pengajuan = $m_pengajuan->hydrateRaw($sql);

            $data = null;
            if ( $d_pengajuan->count() > 0 ) {
                $d_pengajuan = $d_pengajuan->toArray();

                foreach ($d_pengajuan as $key => $value) {
                    if ( !empty($value['kode_pengajuan']) ) {
                        $m_pd = new \Model\Storage\PengajuanDosen_model();
                        $_d_pd = $m_pd->where('pengajuan_kode', $value['kode_pengajuan'])->whereIn('nip', $nip_dosen)->get();
                        if ( $_d_pd->count() > 0 ) {
                            $data[ $value['kode'] ] = $value;

                            $d_pd = $m_pd->where('pengajuan_kode', $value['kode_pengajuan'])->get()->toArray();

                            $no = 1;
                            foreach ($d_pd as $k_pd => $v_pd) {
                                $data[ $value['kode'] ]['dosbing'.$no] = $v_pd['nama'];
                                $data[ $value['kode'] ]['nip_dosbing'.$no] = $v_pd['nip'];

                                $no++;
                            }
                        }
                    } else {
                        $m_pd = new \Model\Storage\PengajuanDosen_model();
                        $_d_pd = $m_pd->where('pengajuan_kode', $value['kode'])->whereIn('nip', $nip_dosen)->get();
                        if ( $_d_pd->count() > 0 ) {
                            $data[ $value['kode'] ] = $value;

                            $d_pd = $m_pd->where('pengajuan_kode', $value['kode'])->get()->toArray();

                            $no = 1;
                            foreach ($d_pd as $k_pd => $v_pd) {
                                $data[ $value['kode'] ]['dosbing'.$no] = $v_pd['nama'];
                                $data[ $value['kode'] ]['nip_dosbing'.$no] = $v_pd['nip'];

                                $no++;
                            }
                        }
                    }
                }
            }

            $mapping_by_tanggal = !empty($data) ? $this->mapping_by_tanggal( $data ) : null;
            $mapping_by_dosen = !empty($data) ? $this->mapping_by_dosen( $data, $nip_dosen ) : null;
            $mapping_by_prodi = !empty($data) ? $this->mapping_by_prodi( $data ) : null;

            $content_report_by_tanggal['data'] = $mapping_by_tanggal;
            $html_report_by_tanggal = $this->load->view($this->pathView . 'list_report_by_tanggal', $content_report_by_tanggal, TRUE);

            $content_report_by_dosen['data'] = $mapping_by_dosen;
            $html_report_by_dosen = $this->load->view($this->pathView . 'list_report_by_dosen', $content_report_by_dosen, TRUE);

            $content_report_by_prodi['data'] = $mapping_by_dosen;
            $html_report_by_prodi = $this->load->view($this->pathView . 'list_report_by_prodi', $content_report_by_prodi, TRUE);

            $list_html = array(
                'list_report_by_tanggal' => $html_report_by_tanggal,
                'list_report_by_dosen' => $html_report_by_dosen
            );

            $this->result['status'] = 1;
            $this->result['content'] = $list_html;
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }

    public function mapping_by_tanggal($_data)
    {
        $data = null;
        foreach ($_data as $key => $value) {
            $data[ $value['tgl_pengajuan'] ]['tanggal'] = $value['tgl_pengajuan'];
            $data[ $value['tgl_pengajuan'] ]['detail'][ $value['kode'] ] = $value;
        }

        return $data;
    }

    public function mapping_by_dosen($_data, $nip_dosen)
    {
        $data = null;
        foreach ($_data as $key => $value) {
            foreach ($value as $k_val => $v_val) {
                if ( stristr($k_val, 'nip_dosbing') !== false ) {
                    if ( in_array($v_val, $nip_dosen) !== false ) {
                        $data[ $v_val ]['nip'] = $v_val;
                        $data[ $v_val ]['nama'] = $value[ substr($k_val, 4, strlen($k_val)) ];
                        $data[ $v_val ]['detail'][ $value['kode'] ] = $value;
                    }
                }
            }
        }

        return $data;
    }

    public function mapping_by_prodi($_data)
    {
        $data = null;
        foreach ($_data as $key => $value) {
            if ( !empty($value['no_surat']) ) {
                $data[ $value['prodi_kode'] ]['kode'] = $value['prodi_kode'];
                $data[ $value['prodi_kode'] ]['nama'] = $value['prodi'];
                if ( !isset($data[ $value['prodi_kode'] ]['detail'][ $value['jenis_pengajuan_kode'] ]) ) {
                    $data[ $value['prodi_kode'] ]['detail'][ $value['jenis_pengajuan_kode'] ]['nama'] = $value['jenis_pengajuan'];
                    $data[ $value['prodi_kode'] ]['detail'][ $value['jenis_pengajuan_kode'] ]['jumlah'] = 1;
                } else {
                    $data[ $value['prodi_kode'] ]['detail'][ $value['jenis_pengajuan_kode'] ]['jumlah'] += 1;
                }
            }
        }

        return $data;
    }
}