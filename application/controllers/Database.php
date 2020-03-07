<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

class Database extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		session_start();
		$this->load->dbforge();
		$this->load->model('header_model');
		$this->load->model('import_model');
		$this->load->model('export_model');
		$this->load->model('database_model');
		$this->modul_ini = 11;
	}

	public function clear()
	{
		unset($_SESSION['cari']);
		unset($_SESSION['filter']);
		redirect('export');
	}

	public function index()
	{
		// Untuk development: menghapus session tracking. Tidak ada kaitan dengan database.
		// Di sini untuk kemudahan saja.
		// TODO: cari tempat yang lebih cocok
    if (defined('ENVIRONMENT') AND ENVIRONMENT == 'development')
    {
    	log_message('debug', "Reset tracking");
			unset($_SESSION['track_web']);
			unset($_SESSION['track_admin']);
			unset($_SESSION['siteman_timeout']);
    }

		$nav['act'] = 11;
		$nav['act_sub'] = 45;
		$nav['act_tab'] = 1;
		$header = $this->header_model->get_data();

		$this->load->view('header', $header);
		$this->load->view('nav', $nav);
		$this->load->view('export/tab_menu');
		$this->load->view('export/exp');
		$this->load->view('footer');
	}

	public function import()
	{
		$nav['act'] = 11;
		$nav['act_sub'] = 45;
		$nav['act_tab'] = 2;
		$data['form_action'] = site_url("database/import_dasar");
		$data['form_action3'] = site_url("database/ppls_individu");
		$header = $this->header_model->get_data();

		$this->load->view('header', $header);
		$this->load->view('nav', $nav);
		$this->load->view('export/tab_menu');
		$this->load->view('import/imp', $data);
		$this->load->view('footer');
	}

	public function import_bip()
	{
		$nav['act'] = 11;
		$nav['act_sub'] = 45;
		$nav['act_tab'] = 3;
		$data['form_action'] = site_url("database/import_data_bip");
		$header = $this->header_model->get_data();

		$this->load->view('header', $header);
		$this->load->view('nav', $nav);
		$this->load->view('export/tab_menu');
		$this->load->view('import/bip', $data);
		$this->load->view('footer');
	}

	public function migrasi_cri()
	{
		$nav['act'] = 11;
		$nav['act_sub'] = 45;
		$nav['act_tab'] = 5;
		$data['form_action'] = site_url("database/migrasi_db_cri");
		$header = $this->header_model->get_data();
		$this->load->view('header', $header);
		$this->load->view('nav',$nav);
		$this->load->view('export/tab_menu');
		$this->load->view('database/migrasi_cri', $data);
		$this->load->view('footer');
	}

	public function backup()
	{
		$nav['act'] = 11;
		$nav['act_sub'] = 45;
		$nav['act_tab'] = 4;
		$data['form_action'] = site_url("database/restore");
		$header = $this->header_model->get_data();

		$this->load->view('header', $header);
		$this->load->view('nav', $nav);
		$this->load->view('export/tab_menu');
		$this->load->view('database/backup', $data);
		$this->load->view('footer');
	}

	/*
		$opendk - tidak kosong untuk header sesuai dengan format impor OpenDK
	*/
	public function export_excel($opendk = '')
	{
		$judul = array(
			'Alamat' => 'alamat',
			'Dusun' => 'dusun',
			'RW' => 'rw',
			'RT' => 'rt',
			'Nama' => 'nama',
			'Nomor KK' => 'nomor_kk',
			'Nomor NIK' => 'nomor_nik',
			'Jenis Kelamin' => 'jenis_kelamin',
			'Tempat Lahir' => 'tempat_lahir',
			'Tanggal Lahir' => 'tanggal_lahir',
			'Agama' => 'agama',
			'Pendidikan (dlm KK)' => 'pendidikan_dlm_kk',
			'Pendidikan (sdg ditempuh)' => 'pendidikan_sdg_ditempuh',
			'Pekerjaan' => 'pekerjaan',
			'Kawin' => 'kawin',
			'Hub. Keluarga' => 'hubungan_keluarga',
			'Kewarganegaraan' => 'kewarganegaraan',
			'Nama Ayah' => 'nama_ayah',
			'Nama Ibu' => 'nama_ibu',
			'Gol. Darah' => 'gol_darah',
			'Akta Lahir' => 'akta_lahir',
			'Nomor Dokumen Paspor' => 'nomor_dokumen_pasport',
			'Tanggal Akhir Paspor' => 'tanggal_akhir_pasport',
			'Nomor Dokumen KITAS' => 'nomor_dokumen_kitas',
			'NIK Ayah' => 'nik_ayah',
			'NIK Ibu' => 'nik_ibu',
			'Nomor Akta Perkawinan' => 'nomor_akta_perkawinan',
			'Tanggal Perkawinan' => 'tanggal_perkawinan',
			'Nomor Akta Perceraian' => 'nomor_akta_perceraian',
			'Tanggal Perceraian' => 'tanggal_perceraian',
			'Cacat' => 'cacat',
			'Cara KB' => 'cara_kb',
			'Hamil' => 'hamil',
			'KTP-el' => 'ktp_el',
			'Status Rekam' => 'status_rekam',
			'Alamat Sekarang' => 'alamat_sekarang'
		);
		$data['main'] = $this->export_model->export_excel();
		$tgl =  date('d_m_Y');
		if ($opendk)
		{
			$data['judul'] = array_values($judul);
			// Kolom tambahan khusus OpenDK
			$data['judul'][] = 'id';
			$data['judul'][] = 'status_dasar';
			$data['judul'][] = 'created_at';
			$data['judul'][] = 'updated_at';
			$data['nama_file'] = 'penduduk_'.$tgl.'_opendk';
		}
		else
		{
			$data['judul'] = array_keys($judul);
			$data['nama_file'] = 'penduduk_'.$tgl;
		}
		$data['opendk'] = $opendk;
		$this->load->view('export/penduduk_excel', $data);
	}

	public function export_dasar()
	{
		$this->export_model->export_dasar();
	}

	public function import_dasar()
	{
		$hapus = isset($_POST['hapus_data']);
		$this->import_model->import_excel($hapus);
		redirect('database/import/1');
	}

	public function import_data_bip()
	{
		$hapus = isset($_POST['hapus_data']);
		$this->import_model->import_bip($hapus);
		redirect('database/import_bip/1');
	}

	public function migrasi_db_cri()
	{
		$this->database_model->migrasi_db_cri();
		redirect('database/migrasi_cri/1');
	}

	public function kosongkan()
	{
		$nav['act'] = 11;
		$nav['act_sub'] = 45;
		$nav['act_tab'] = 6;
		$header = $this->header_model->get_data();

		$this->load->view('header', $header);
		$this->load->view('nav',$nav);
		$this->load->view('export/tab_menu');
		$this->load->view('database/kosongkan', $data);
		$this->load->view('footer');
	}

	public function kosongkan_db()
	{
		$this->redirect_hak_akses('h', "database/kosongkan");
		$this->database_model->kosongkan_db();
		redirect('database/kosongkan');
	}

	// Impor Pengelompokan Data Rumah Tangga
	public function ppls_individu()
	{
		$this->import_model->pbdt_individu();
	}

	public function exec_backup()
	{
		$this->export_model->backup();
	}

	public function restore()
	{
		$this->redirect_hak_akses('h', "database/backup");
		$this->export_model->restore();
		redirect('database/backup');
	}

	public function export_csv()
	{
		$data['main'] = $this->export_model->export_excel();
		$this->load->view('export/penduduk_csv', $data);
	}
}
