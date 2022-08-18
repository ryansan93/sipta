<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Public_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data = $this->includes;

		$data['title_menu'] = 'Dashboard';

		$content['list_notif'] = $this->list_notif();
		// $content['jml_notif'] = count($this->list_notif());
		$data['view'] = $this->load->view('home/dashboard', $content, true);

		$this->load->view($this->template, $data);
	}

	public function list_notif()
	{
		$notif = null;
		$arr_fitur = $this->session->userdata()['Fitur']; 
		foreach ($arr_fitur as $key => $v_fitur) {
			foreach ($v_fitur['detail'] as $key => $v_mdetail) {
				$akses = hakAkses('/'.$v_mdetail['path_detfitur']);
				if ( $akses['a_approve'] == 1 ) {
					$status = getStatus('submit');

					$data = Modules::run( $v_mdetail['path_detfitur'].'/notifikasi', $status);

					if ( !empty($data) ) {
						foreach ($data as $key => $value) {
							if ( $value['jumlah'] > 0 ) {
								$notif[$key][$v_mdetail['path_detfitur']] = $value;
								$notif[$key][$v_mdetail['path_detfitur']]['path'] = $v_mdetail['path_detfitur'];
								$notif[$key][$v_mdetail['path_detfitur']]['nama_fitur'] = $v_mdetail['nama_detfitur'];
							}
						}
					}
				}
			}
        }

        // NOTIFIKASI JADWAL SEMINAR
        $akses = hakAkses('/transaksi/Pengajuan');
        if ( $akses['a_submit'] == 1 ) {
	        $today = date('Y-m-d');
	        $m_njs = new \Model\Storage\NotifikasiJadwalSeminar_model();
	        $d_njs = $m_njs->where('nim', $this->userid)->where('tgl_tujuan', '>=', $today)->with(['jenis_pengajuan_asal', 'jenis_pengajuan_tujuan'])->get();

	        if ( $d_njs->count() > 0 ) {
	        	$d_njs = $d_njs->toArray();


	        	foreach ($d_njs as $k_njs => $v_njs) {
	        		$key = '/transaksi/Pengajuan'.'|'.$k_njs;

	        		$data = array(
		                'title' => 'Notifikasi Jadwal Pengajuan',
		                'deskripsi' => 'Maksimal Pengajuan <b>'.$v_njs['jenis_pengajuan_tujuan']['nama'].'</b> Tanggal <b>'.strtoupper(tglIndonesia($v_njs['tgl_tujuan'], '-', ' ', true)).'</b>',
		                'jumlah' => 1,
		                'action' => "window.open('transaksi/Pengajuan')"
		            );

	        		$notif[$key]['/transaksi/Pengajuan'] = $data;
					$notif[$key]['/transaksi/Pengajuan']['path'] = '/transaksi/Pengajuan';
					$notif[$key]['/transaksi/Pengajuan']['nama_fitur'] = 'Pengajuan TA';
	        	}
	        }
		}

        return $notif;
	}
}