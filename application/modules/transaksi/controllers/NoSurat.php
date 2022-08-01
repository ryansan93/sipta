<?php defined('BASEPATH') OR exit('No direct script access allowed');

class NoSurat extends Public_Controller {

    private $pathView = 'transaksi/no_surat/';
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
                "assets/transaksi/no_surat/js/no-surat.js",
            ));
            $this->add_external_css(array(
                "assets/transaksi/no_surat/css/no-surat.css",
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
            $content['title_panel'] = 'No. Surat';

            // Load Indexx
            $data['title_menu'] = 'No. Surat';
            $data['view'] = $this->load->view($this->pathView . 'index', $content, TRUE);
            $this->load->view($this->template, $data);
        } else {
            showErrorAkses();
        }
    }

    public function getLists()
    {
        $params = $this->input->get('params');

        $start_date = $params['start_date'];
        $end_date = $params['end_date'];

        $nim = null;
        if ( $this->hakAkses['a_approve'] == 1 ) {
            $nim = $this->userid;
        }

        $m_pengajuan = new \Model\Storage\Pengajuan_model();
        if ( !empty($nim) ) {
            $d_pengajuan = $m_pengajuan->whereBetween('tgl_pengajuan', [$start_date, $end_date])->where('nim', $nim)->with(['jenis_pengajuan', 'mahasiswa', 'no_surat'])->orderBy('tgl_pengajuan', 'desc')->get();
        } else {
            $d_pengajuan = $m_pengajuan->whereBetween('tgl_pengajuan', [$start_date, $end_date])->with(['jenis_pengajuan', 'mahasiswa', 'no_surat'])->orderBy('tgl_pengajuan', 'desc')->get();
        }

        $data = null;
        if ( $d_pengajuan->count() > 0 ) {
            $data = $d_pengajuan->toArray();
        }

        $content['akses'] = $this->hakAkses;
        $content['data'] = $data;

        $html = $this->load->view($this->pathView . 'list', $content, TRUE);

        echo $html;
    }

    public function getPengajuan()
    {
        $m_ns = new \Model\Storage\NoSurat_model();
        $d_ns = $m_ns->get();

        if ( $d_ns->count() > 0 ) {
            $sql = "
                select p.kode as kode, p.tgl_pengajuan as tgl_pengajuan, p.jadwal as jadwal, p.jam_pelaksanaan as jam_pelaksanaan, p.nim, p.jenis_pengajuan_kode, m.nama as nama_mahasiswa, jp.nama as nama_jenis_pengajuan from pengajuan p 
                right join
                    no_surat ns
                    on
                        p.kode <> ns.pengajuan_kode
                left join
                    jenis_pengajuan jp 
                    on
                        p.jenis_pengajuan_kode = jp.kode 
                left join
                    mahasiswa m 
                    on
                        p.nim = m.nim
                where
                    p.g_status = ".getStatus('approve')."
                group by p.kode, p.tgl_pengajuan, p.jadwal, p.jam_pelaksanaan, p.nim, p.jenis_pengajuan_kode, m.nama, jp.nama
            ";
        } else {
            $sql = "
                select p.kode as kode, p.tgl_pengajuan as tgl_pengajuan, p.jadwal as jadwal, p.jam_pelaksanaan as jam_pelaksanaan, p.nim, p.jenis_pengajuan_kode, m.nama as nama_mahasiswa, jp.nama as nama_jenis_pengajuan from pengajuan p 
                left join
                    jenis_pengajuan jp 
                    on
                        p.jenis_pengajuan_kode = jp.kode 
                left join
                    mahasiswa m 
                    on
                        p.nim = m.nim
                where
                    p.g_status = ".getStatus('approve')."
                group by p.kode, p.tgl_pengajuan, p.jadwal, p.jam_pelaksanaan, p.nim, p.jenis_pengajuan_kode, m.nama, jp.nama
            ";
        }

        $m_ns = new \Model\Storage\NoSurat_model();
        $d_ns = $m_ns->hydrateRaw( $sql );

        $data = null;
        if ( $d_ns->count() > 0 ) {
            $data = $d_ns->toArray();
        }

        return $data;
    }

    public function modalAddForm()
    {
        $content['pengajuan'] = $this->getPengajuan();

        $html = $this->load->view($this->pathView . 'addForm', $content, TRUE);

        echo $html;
    }

    public function save()
    {
        $params = $this->input->post('params');

        try {
            foreach ($params as $key => $value) {
                $m_ns = new \Model\Storage\NoSurat_model();
                $m_ns->pengajuan_kode = $value['kode_pengajuan'];
                $m_ns->no_surat = $value['no_surat'];
                $m_ns->g_status = getStatus('submit');
                $m_ns->save();

                $deskripsi_log = 'di-submit oleh ' . $this->userdata['detail_user']['nama_detuser'];
                Modules::run( 'base/event/save', $m_ns, $deskripsi_log );

                $m_pengajuan = new \Model\Storage\Pengajuan_model();
                $d_pengajuan = $m_pengajuan->where('kode', $value['kode_pengajuan'])->with(['jenis_pengajuan', 'mahasiswa', 'jenis_pelaksanaan', 'prodi', 'pengajuan_dosen', 'ruang_kelas', 'no_surat'])->first();

                if ( $d_pengajuan ) {
                    $d_pengajuan = $d_pengajuan->toArray();

                    if ( $d_pengajuan['jenis_pengajuan']['form_pengajuan'] == 'kompre' ) {
                        $this->export_pdf_kompre( $d_pengajuan );
                    } else {
                        $this->export_pdf_non_kompre( $d_pengajuan );
                    }
                }
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
        $params = $this->input->post('params');

        try {
            $m_ns = new \Model\Storage\NoSurat_model();
            $d_ns = $m_ns->where('pengajuan_kode', $params['kode'])->where('no_surat', $params['no_surat'])->first();

            $m_ns->where('pengajuan_kode', $params['kode'])->where('no_surat', $params['no_surat'])->delete();

            $deskripsi_log = 'di-delete oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run( 'base/event/delete', $d_ns, $deskripsi_log );

            $this->result['status'] = 1;
            $this->result['message'] = 'Data berhasil di hapus.';
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        display_json( $this->result );
    }

    public function export_pdf_non_kompre($data)
    {
        $style = array(
          'vpadding'      =>'auto',
          'hpadding'      =>'auto',
          'fgcolor'       => array(0, 0, 0),
          'bgcolor'       => false, //array(),
          'module_width'  => 1.2,
          'module_height' => 0.4,
        );

        $this->load->library('Pdf');
        $pdf = new Pdf('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
        $pdf -> setFontSubsetting(false);
        $pdf -> SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf -> SetPrintHeader(false);
        $pdf -> SetPrintFooter(false);
        $pdf -> SetAutoPageBreak(TRUE, 1);
        $pdf -> setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set margins
        // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf -> AddPage();

        // $width_page = 144;
        $pdf->Image('assets/images/templateSurat/logo-header.png', 5, 5, 0, 30, 'PNG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 0, false, false, false);

        $pdf->SetFont('times', '', 10);
        $html = '<table style="border-spacing:0; border-collapse: collapse;">
            <tbody>
                <tr>
                    <td style="width: 50px;">
                    </td>
                    <td style="width: 700px; vertical-align: top;">
                        <table style="border-spacing:0; border-collapse: collapse; color: #245fac;">
                            <tr>
                                <td style="width: 700px; text-align: center; font-size: 14pt;"><b>KEMENTRIAN PERTANIAN</b></td>
                            </tr>
                            <tr>
                                <td style="width: 700px; text-align: center; font-size: 11pt;">BADAN PENYULUHAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA PERTANIAN</td>
                            </tr>
                            <tr>
                                <td style="width: 700px; text-align: center; font-size: 13pt;"><b>POLITEKNIK PEMBANGUNAN PERTANIAN (POLBANGTAN) MALANG</b></td>
                            </tr>
                            <tr>
                                <td style="width: 700px; text-align: center; font-size: 7.5pt;">Jl. Dr. Cipto 144 A Bedali, Lawang - Malang 65200 Kotak Pos 144 Telp.0341- 427771, 427772, 427379, Fax. 427774</td>
                            </tr>
                            <tr>
                                <td style="width: 700px; text-align: center; font-size: 7.5pt;">website : www.polbangtanmalang.ac.id e-mail : official@polbangtanmalang.ac.id</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>';
        $pdf -> writeHTMLCell(0,0,0,5,$html,0,0,false,true,'L',true);

        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(36, 95, 172));
        $pdf->Line(0, 0, 0, 0, $style);

        $html = '<hr style="height: 1px; background-color: #245fac; color: #245fac; border-color: #245fac;">';
        $pdf -> writeHTMLCell(0,0,13,37,$html,0,0,false,true,'L',true);
        $html = '<hr style="height: 1.5px; background-color: #245fac; color: #245fac; border-color: #245fac;">';
        $pdf -> writeHTMLCell(0,0,13,38,$html,0,0,false,true,'L',true);

        $pdf->SetFont('times', '', 12);
        $html = '<table>
            <tbody>
                <tr>
                    <td style="width: 100px;">Nomor</td>
                    <td style="width: 5px;">:</td>
                    <td style="width: 330px;">'.$data['no_surat']['no_surat'].'</td>
                    <td style="width: 200px; text-align: right;">'.tglIndonesia(date('Y-m-d'), '-', ' ', true).'</td>
                </tr>
                <tr>
                    <td>Lampiran</td>
                    <td>:</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Hal</td>
                    <td>:</td>
                    <td>Undangan Seminar</td>
                </tr>
                <tr>
                    <td colspan="4">
                        <br>
                        <br>
                        <br>
                    </td>
                </tr>
            </tbody>
        </table>';
        $pdf -> writeHTMLCell(0,0,15,40,$html,0,0,false,true,'L',true);

        $pdf->Image('assets/images/templateSurat/TTD.png', 105, 185, 0, 38, 'PNG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 0, false, false, false);

        $html = '<table>
            <tbody>
                <tr>
                    <td colspan="3" style="width: 630px;">Kepada Yth Bapak/Ibu</td>
                </tr>';
        $no_dosen = 1;
        foreach ($data['pengajuan_dosen'] as $key => $value) {
            $html .= '<tr>
                    <td colspan="3"><span style="padding-left: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$no_dosen.'. '.ucwords(strtolower($value['nama'])).'</span></td>
                </tr>';

            $no_dosen++;
        }
        $html .= '<tr>
                    <td colspan="3">di - </td>
                </tr>
                <tr>
                    <td colspan="3"><span style="padding-left: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tempat</span></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <br>
                        <br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: justify;">Berdasarkan Kalender Akademik (Tentatif) Politeknik Pembangunan Pertanian Malang Tahun Akademik '.$data['tahun_akademik'].', akan dilaksanakan Seminar Hasil Tugas Akhir (TA). Selanjutnya untuk kelancaran kegiatan tersebut maka kami mohon kehadiran Bapak/Ibu.</td>
                </tr>
                <tr><td colspan="3">Adapun Mahasiswa dan waktu pelaksanaan kegiatan tersebut :</td></tr>
                <tr>
                    <td style="width: 200px;">Nama mahasiswa</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 500px;">'.$data['mahasiswa']['nama'].'</td>
                </tr>
                <tr>
                    <td style="width: 200px;">NIM</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 500px;">'.$data['mahasiswa']['nim'].'</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Program Studi</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 500px;">'.ucwords(strtolower($data['prodi']['nama'])).'</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Hari, Tanggal</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 500px;">'.tglKeHari($data['jadwal']).', '.tglIndonesia($data['jadwal'], '-', ' ', true).'</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Pukul</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 500px;">'.substr($data['jam_pelaksanaan'], 0, 5).'</td>
                </tr>';
        if ( $data['jenis_pelaksanaan']['ruang_kelas'] == 1 ) {
            $ruang_kelas = !empty($data['ruang_kelas']['nama']) ? $data['ruang_kelas']['nama'] : '-';
            $html .= '<tr>
                    <td style="width: 200px;">Tempat / Ruang</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 500px;">'.$ruang_kelas.'</td>
                </tr>';
        }
        if ( $data['jenis_pelaksanaan']['zoom'] == 1 ) {
            $html .= '<tr>
                        <td style="width: 200px;">ID Zoom Meeting</td>
                        <td style="width: 10px;">:</td>
                        <td style="width: 500px;">'.$data['id_meeting'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">Password</td>
                        <td style="width: 10px;">:</td>
                        <td style="width: 500px;">'.$data['password_meeting'].'</td>
                    </tr>';
        }
        $html .= '<tr>
                    <td colspan="3" style="text-align: justify;">Demikian atas perhatian dan kerjasama Bapak/ Ibu diucapkan terima kasih.</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <br>
                        <br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;"></td>
                    <td style="width: 10px;"></td>
                    <td style="width: 500px; text-align: center;">
                        Koordinator Bagian Administrasi Akademik,<br>Kemahasiswaan dan Alumni
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <br>
                        <br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;"></td>
                    <td style="width: 10px;"></td>
                    <td style="width: 500px; text-align: center;">
                        <b>Dr. Ugik Romadi, SST, M.Si</b><br>NIP. 19820713 200604 1 002
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="font-size: 10pt;">
                        <br>
                        Tembusan YTH :<br>
                        1. Direktur Polbangtan Malang sebagai laporan<br>
                        2. Wakil Direktur I Bidang Akademik dan Kerja Sama<br>
                        3. Ketua Jurusan '.ucwords(strtolower($data['prodi']['jurusan'])).' Ka. Prodi '.ucwords(strtolower($data['prodi']['nama'])).' Polbangtan Malang
                    </td>
                </tr>
            </tbody>
        </table>';
        $pdf -> writeHTMLCell(0,0,15,70,$html,0,0,false,true,'L',true);

        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(36, 95, 172));
        $pdf->Line(0, 0, 0, 0, $style);

        $html = '<hr style="height: 1px; background-color: #245fac; color: #245fac; border-color: #245fac;">';
        $pdf -> writeHTMLCell(0,0,13,270,$html,0,0,false,true,'L',true);

        $pdf->Image('assets/images/templateSurat/Footer.png', 13, 275, 0, 20, 'PNG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 0, false, false, false);

        $pdf -> AddPage();

        // $width_page = 144;
        $pdf->Image('assets/images/templateSurat/logo-header.png', 5, 5, 0, 30, 'PNG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 0, false, false, false);

        $pdf->SetFont('times', '', 10);
        $html = '<table style="border-spacing:0; border-collapse: collapse;">
            <tbody>
                <tr>
                    <td style="width: 50px;">
                    </td>
                    <td style="width: 700px; vertical-align: top;">
                        <table style="border-spacing:0; border-collapse: collapse; color: #245fac;">
                            <tr>
                                <td style="width: 700px; text-align: center; font-size: 14pt;"><b>KEMENTRIAN PERTANIAN</b></td>
                            </tr>
                            <tr>
                                <td style="width: 700px; text-align: center; font-size: 11pt;">BADAN PENYULUHAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA PERTANIAN</td>
                            </tr>
                            <tr>
                                <td style="width: 700px; text-align: center; font-size: 13pt;"><b>POLITEKNIK PEMBANGUNAN PERTANIAN (POLBANGTAN) MALANG</b></td>
                            </tr>
                            <tr>
                                <td style="width: 700px; text-align: center; font-size: 7.5pt;">Jl. Dr. Cipto 144 A Bedali, Lawang - Malang 65200 Kotak Pos 144 Telp.0341- 427771, 427772, 427379, Fax. 427774</td>
                            </tr>
                            <tr>
                                <td style="width: 700px; text-align: center; font-size: 7.5pt;">website : www.polbangtanmalang.ac.id e-mail : official@polbangtanmalang.ac.id</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>';
        $pdf -> writeHTMLCell(0,0,0,5,$html,0,0,false,true,'L',true);

        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(36, 95, 172));
        $pdf->Line(0, 0, 0, 0, $style);

        $html = '<hr style="height: 1px; background-color: #245fac; color: #245fac; border-color: #245fac;">';
        $pdf -> writeHTMLCell(0,0,13,37,$html,0,0,false,true,'L',true);
        $html = '<hr style="height: 1.5px; background-color: #245fac; color: #245fac; border-color: #245fac;">';
        $pdf -> writeHTMLCell(0,0,13,38,$html,0,0,false,true,'L',true);

        $pdf->SetFont('times', '', 12);
        $html = '<table>
            <tbody>
                <tr>
                    <td style="width: 100px;">Nomor</td>
                    <td style="width: 5px;">:</td>
                    <td style="width: 330px;">'.$data['no_surat']['no_surat'].'</td>
                    <td style="width: 200px; text-align: right;">'.tglIndonesia(date('Y-m-d'), '-', ' ', true).'</td>
                </tr>
                <tr>
                    <td>Lampiran</td>
                    <td>:</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Hal</td>
                    <td>:</td>
                    <td>Undangan Seminar</td>
                </tr>
                <tr>
                    <td colspan="4">
                        <br>
                        <br>
                        <br>
                    </td>
                </tr>
            </tbody>
        </table>';
        $pdf -> writeHTMLCell(0,0,15,40,$html,0,0,false,true,'L',true);

        $pdf->Image('assets/images/templateSurat/TTD.png', 105, 180, 0, 38, 'PNG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 0, false, false, false);
        $html = '<table>
            <tbody>
                <tr>
                    <td colspan="3" style="width: 630px;">Kepada Saudara.</td>
                </tr>
                <tr>
                    <td colspan="3" style="width: 630px;">Mahasiswa Polbangtan Malang</td>
                </tr>
                <tr>
                    <td colspan="3">di - </td>
                </tr>
                <tr>
                    <td colspan="3"><span style="padding-left: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tempat</span></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <br>
                        <br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: justify;">Berdasarkan Kalender Akademik (Tentatif) Politeknik Pembangunan Pertanian Malang Tahun Akademik '.$data['tahun_akademik'].', akan dilaksanakan Seminar Hasil Tugas Akhir (TA). Selanjutnya untuk kelancaran kegiatan tersebut maka kami mohon kehadiran saudara.</td>
                </tr>
                <tr><td colspan="3">Adapun Mahasiswa dan waktu pelaksanaan kegiatan tersebut :</td></tr>
                <tr>
                    <td style="width: 200px;">Nama mahasiswa</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 500px;">'.$data['mahasiswa']['nama'].'</td>
                </tr>
                <tr>
                    <td style="width: 200px;">NIM</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 500px;">'.$data['mahasiswa']['nim'].'</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Program Studi</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 500px;">'.ucwords(strtolower($data['prodi']['nama'])).'</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Hari, Tanggal</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 500px;">'.tglKeHari($data['jadwal']).', '.tglIndonesia($data['jadwal'], '-', ' ', true).'</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Pukul</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 500px;">'.substr($data['jam_pelaksanaan'], 0, 5).'</td>
                </tr>';
        if ( $data['jenis_pelaksanaan']['ruang_kelas'] == 1 ) {
            $ruang_kelas = !empty($data['ruang_kelas']['nama']) ? $data['ruang_kelas']['nama'] : '-';
            $html .= '<tr>
                    <td style="width: 200px;">Tempat / Ruang</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 500px;">'.$ruang_kelas.'</td>
                </tr>';
        }
        if ( $data['jenis_pelaksanaan']['zoom'] == 1 ) {
            $html .= '<tr>
                        <td style="width: 200px;">ID Zoom Meeting</td>
                        <td style="width: 10px;">:</td>
                        <td style="width: 500px;">'.$data['id_meeting'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">Password</td>
                        <td style="width: 10px;">:</td>
                        <td style="width: 500px;">'.$data['password_meeting'].'</td>
                    </tr>';
        }
        $html .= '<tr>
                    <td colspan="3" style="text-align: justify;">Demikian atas perhatian dan kerjasama saudara diucapkan terima kasih.</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <br>
                        <br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;"></td>
                    <td style="width: 10px;"></td>
                    <td style="width: 500px; text-align: center;">
                        Koordinator Bagian Administrasi Akademik,<br>Kemahasiswaan dan Alumni
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <br>
                        <br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;"></td>
                    <td style="width: 10px;"></td>
                    <td style="width: 500px; text-align: center;">
                        <b>Dr. Ugik Romadi, SST, M.Si</b><br>NIP. 19820713 200604 1 002
                    </td>
                </tr>
            </tbody>
        </table>';
        $pdf -> writeHTMLCell(0,0,15,70,$html,0,0,false,true,'L',true);

        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(36, 95, 172));
        $pdf->Line(0, 0, 0, 0, $style);

        $html = '<hr style="height: 1px; background-color: #245fac; color: #245fac; border-color: #245fac;">';
        $pdf -> writeHTMLCell(0,0,13,270,$html,0,0,false,true,'L',true);

        $pdf->Image('assets/images/templateSurat/Footer.png', 13, 275, 0, 20, 'PNG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 0, false, false, false);

        ob_end_clean();
        $filename = 'Und. Sempro an. '.$data['mahasiswa']['nama'];
        $path = ubahNama('Und_Sempro_an_'.$data['mahasiswa']['nama'].'.pdf');

        $m_ns = new \Model\Storage\NoSurat_model();
        $d_ns = $m_ns->where('pengajuan_kode', $data['kode'])->update(
            array(
                'filename' => $filename,
                'path' => $path
            )
        );

        $pdf->Output('uploads\\dokumen_undangan\\'.$path, 'F');
    }

    public function export_pdf_kompre($data)
    {
        $style = array(
          'vpadding'      =>'auto',
          'hpadding'      =>'auto',
          'fgcolor'       => array(0, 0, 0),
          'bgcolor'       => false, //array(),
          'module_width'  => 1.2,
          'module_height' => 0.4,
        );

        $this->load->library('Pdf');
        $pdf = new Pdf('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
        $pdf -> setFontSubsetting(false);
        $pdf -> SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf -> SetPrintHeader(false);
        $pdf -> SetPrintFooter(false);
        $pdf -> SetAutoPageBreak(TRUE, 1);
        $pdf -> setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set margins
        // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf -> AddPage();

        // $width_page = 144;
        $pdf->Image('assets/images/templateSurat/logo-header.png', 5, 5, 0, 30, 'PNG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 0, false, false, false);

        $pdf->SetFont('times', '', 10);
        $html = '<table style="border-spacing:0; border-collapse: collapse;">
            <tbody>
                <tr>
                    <td style="width: 50px;">
                    </td>
                    <td style="width: 700px; vertical-align: top;">
                        <table style="border-spacing:0; border-collapse: collapse; color: #245fac;">
                            <tr>
                                <td style="width: 700px; text-align: center; font-size: 14pt;"><b>KEMENTRIAN PERTANIAN</b></td>
                            </tr>
                            <tr>
                                <td style="width: 700px; text-align: center; font-size: 11pt;">BADAN PENYULUHAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA PERTANIAN</td>
                            </tr>
                            <tr>
                                <td style="width: 700px; text-align: center; font-size: 13pt;"><b>POLITEKNIK PEMBANGUNAN PERTANIAN (POLBANGTAN) MALANG</b></td>
                            </tr>
                            <tr>
                                <td style="width: 700px; text-align: center; font-size: 7.5pt;">Jl. Dr. Cipto 144 A Bedali, Lawang - Malang 65200 Kotak Pos 144 Telp.0341- 427771, 427772, 427379, Fax. 427774</td>
                            </tr>
                            <tr>
                                <td style="width: 700px; text-align: center; font-size: 7.5pt;">website : www.polbangtanmalang.ac.id e-mail : official@polbangtanmalang.ac.id</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>';
        $pdf -> writeHTMLCell(0,0,0,5,$html,0,0,false,true,'L',true);

        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(36, 95, 172));
        $pdf->Line(0, 0, 0, 0, $style);

        $html = '<hr style="height: 1px; background-color: #245fac; color: #245fac; border-color: #245fac;">';
        $pdf -> writeHTMLCell(0,0,13,37,$html,0,0,false,true,'L',true);
        $html = '<hr style="height: 1.5px; background-color: #245fac; color: #245fac; border-color: #245fac;">';
        $pdf -> writeHTMLCell(0,0,13,38,$html,0,0,false,true,'L',true);

        $pdf->SetFont('times', '', 12);
        $html = '<table>
            <tbody>
                <tr>
                    <td style="width: 100px;">Nomor</td>
                    <td style="width: 5px;">:</td>
                    <td style="width: 330px;">'.$data['no_surat']['no_surat'].'</td>
                    <td style="width: 200px; text-align: right;">'.tglIndonesia(date('Y-m-d'), '-', ' ', true).'</td>
                </tr>
                <tr>
                    <td>Lampiran</td>
                    <td>:</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Hal</td>
                    <td>:</td>
                    <td>Undangan Ujian Komprehensif</td>
                </tr>
                <tr>
                    <td colspan="4">
                        <br>
                        <br>
                        <br>
                    </td>
                </tr>
            </tbody>
        </table>';
        $pdf -> writeHTMLCell(0,0,15,40,$html,0,0,false,true,'L',true);

        $pdf->Image('assets/images/templateSurat/TTD.png', 105, 195, 0, 38, 'PNG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 0, false, false, false);

        $html = '<table>
            <tbody>
                <tr>
                    <td colspan="3" style="width: 630px;">Kepada Yth Bapak/Ibu</td>
                </tr>';
        $no_dosen = 1;
        foreach ($data['pengajuan_dosen'] as $key => $value) {
            $html .= '<tr>
                    <td colspan="3"><span style="padding-left: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$no_dosen.'. '.$value['nama'].'</span></td>
                </tr>';

            $no_dosen++;
        }
        $html .= '<tr>
                    <td colspan="3">di - </td>
                </tr>
                <tr>
                    <td colspan="3"><span style="padding-left: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tempat</span></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <br>
                        <br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: justify;">Berdasarkan Kalender Akademik (Tentatif) Politeknik Pembangunan Pertanian Malang Tahun Akademik '.$data['tahun_akademik'].', akan dilaksanakan Ujian Komprehensif Tugas Akhir (TA). Selanjutnya untuk kelancaran kegiatan tersebut maka kami mohon kehadiran Bapak/Ibu.</td>
                </tr>
                <tr><td colspan="3">Adapun Mahasiswa dan waktu pelaksanaan kegiatan tersebut :</td></tr>
                <tr>
                    <td style="width: 200px;">Nama mahasiswa</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 500px;">'.$data['mahasiswa']['nama'].'</td>
                </tr>
                <tr>
                    <td style="width: 200px;">NIM</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 500px;">'.$data['mahasiswa']['nim'].'</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Program Studi</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 500px;">'.$data['prodi']['nama'].'</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Hari, Tanggal</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 500px;">'.tglKeHari($data['jadwal']).', '.tglIndonesia($data['jadwal'], '-', ' ', true).'</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Pukul</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 500px;">'.substr($data['jam_pelaksanaan'], 0, 5).'</td>
                </tr>';
        if ( $data['jenis_pelaksanaan']['ruang_kelas'] == 1 ) {
            $ruang_kelas = !empty($data['ruang_kelas']['nama']) ? $data['ruang_kelas']['nama'] : '-';
            $html .= '<tr>
                    <td style="width: 200px;">Tempat / Ruang</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 500px;">'.$ruang_kelas.'</td>
                </tr>';
        }
        if ( $data['jenis_pelaksanaan']['zoom'] == 1 ) {
            $html .= '<tr>
                        <td style="width: 200px;">ID Zoom Meeting</td>
                        <td style="width: 10px;">:</td>
                        <td style="width: 500px;">'.$data['id_meeting'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">Password</td>
                        <td style="width: 10px;">:</td>
                        <td style="width: 500px;">'.$data['password_meeting'].'</td>
                    </tr>';
        }
        $html .= '<tr>
                    <td colspan="3" style="text-align: justify;">Demikian atas perhatian dan kerjasama Bapak/ Ibu diucapkan terima kasih.</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <br>
                        <br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;"></td>
                    <td style="width: 10px;"></td>
                    <td style="width: 500px; text-align: center;">
                        a/n Direktur<br>Koordinator Bagian Administrasi Akademik,<br>Kemahasiswaan dan Alumni
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <br>
                        <br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;"></td>
                    <td style="width: 10px;"></td>
                    <td style="width: 500px; text-align: center;">
                        <b>Dr. Ugik Romadi, SST, M.Si</b><br>NIP. 19820713 200604 1 002
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="font-size: 10pt;">
                        <br>
                        Tembusan YTH :<br>
                        1. Direktur Polbangtan Malang sebagai laporan<br>
                        2. Wakil Direktur I Bidang Akademik dan Kerja Sama<br>
                        3. Ketua Jurusan Pertanian Polbangtan Malang sebagai laporan<br>
                        4. Ketua Program Studi '.$data['prodi']['nama'].'
                    </td>
                </tr>
            </tbody>
        </table>';
        $pdf -> writeHTMLCell(0,0,15,70,$html,0,0,false,true,'L',true);

        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(36, 95, 172));
        $pdf->Line(0, 0, 0, 0, $style);

        $html = '<hr style="height: 1px; background-color: #245fac; color: #245fac; border-color: #245fac;">';
        $pdf -> writeHTMLCell(0,0,13,270,$html,0,0,false,true,'L',true);

        $pdf->Image('assets/images/templateSurat/Footer.png', 13, 275, 0, 20, 'PNG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 0, false, false, false);

        ob_end_clean();
        $filename = 'Undangan Kompre an. '.$data['mahasiswa']['nama'];
        $path = ubahNama('Undangan_Kompre_an_'.$data['mahasiswa']['nama'].'.pdf');

        $m_ns = new \Model\Storage\NoSurat_model();
        $d_ns = $m_ns->where('pengajuan_kode', $data['kode'])->update(
            array(
                'filename' => $filename,
                'path' => $path
            )
        );

        $pdf->Output('uploads\\dokumen_undangan\\'.$path, 'F');
    }

    public function download_file($params)
    {
        $_path = null;
        $_pengajuan_kode = null;
        if ( !empty($params) ) {
            $_params = json_decode(base64_decode($params), true);
            $_path = $_params['path'];
            $_pengajuan_kode = $_params['pengajuan_kode'];

            $m_ns = new \Model\Storage\NoSurat_model();
            $d_ns = $m_ns->where('pengajuan_kode', $_pengajuan_kode)->update(
                array(
                    'g_status' => getStatus('approve')
                )
            );
        }

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: 0");
        header('Content-Disposition: attachment; filename="'.basename($_path).'"');
        header('Content-Length: ' . filesize($_path));
        header('Pragma: public');

        //Clear system output buffer
        flush();

        //Read the size of the file
        readfile($_path);

        //Terminate from the script
        die();
    }

    public function notifikasi($g_status)
    {
        $sql = "
            select p.*, ns.no_surat as no_surat, ns.path as path, jp.nama as jenis_pengajuan from pengajuan p
            right join
                no_surat ns
                on
                    p.kode = ns.pengajuan_kode
            left join
                jenis_pengajuan jp
                on
                    p.jenis_pengajuan_kode = jp.kode
            where
                p.nim = '".$this->userid."' and
                ns.g_status = ".$g_status."
        ";
        $m_ns = new \Model\Storage\NoSurat_model();
        $_no_surat = $m_ns->hydrateRaw($sql);

        $data = null;
        if ( $_no_surat->count() > 0 ) {
            foreach ($_no_surat as $key => $value) {
                $params = array(
                    'path' => $value['path'],
                    'pengajuan_kode' => $value['kode']
                );

                $data[] = array(
                    'title' => strtoupper('Surat Undangan '.$value['jenis_pengajuan'].' ('.$value['no_surat'].')'),
                    'deskripsi' => 'Download Surat Undangan',
                    'jumlah' => 1,
                    'action' => "window.location.assign('transaksi/NoSurat/download_file/".base64_encode((json_encode($params)))."')"
                );
            }
        }

        return $data;
    }
}