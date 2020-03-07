<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Gis extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		session_start();

		$this->load->model('penduduk_model');
		$this->load->model('plan_lokasi_model');
		$this->load->model('plan_area_model');
		$this->load->model('plan_garis_model');
		$this->load->model('header_model');
		$this->load->model('wilayah_model');
		$this->modul_ini = 9;
		$this->load->database();
	}

	public function clear()
	{
		unset($_SESSION['log']);
		unset($_SESSION['cari']);
		unset($_SESSION['filter']);
		unset($_SESSION['sex']);
		unset($_SESSION['warganegara']);
		unset($_SESSION['fisik']);
		unset($_SESSION['mental']);
		unset($_SESSION['menahun']);
		unset($_SESSION['golongan_darah']);
		unset($_SESSION['dusun']);
		unset($_SESSION['rw']);
		unset($_SESSION['rt']);
		unset($_SESSION['agama']);
		unset($_SESSION['umur_min']);
		unset($_SESSION['umur_max']);
		unset($_SESSION['pekerjaan_id']);
		unset($_SESSION['status']);
		unset($_SESSION['pendidikan_id']);
		unset($_SESSION['status_penduduk']);
		unset($_SESSION['layer_penduduk']);
		unset($_SESSION['layer_keluarga']);
		unset($_SESSION['layer_desa']);
		unset($_SESSION['layer_wilayah']);
		unset($_SESSION['layer_lokasi']);
		unset($_SESSION['layer_area']);
		$_SESSION['layer_keluarga'] == 0;
		unset($_SESSION['layer_dusun']);
		unset($_SESSION['layer_rw']);
		unset($_SESSION['layer_rt']);
		unset($_SESSION['layer_garis']);
		redirect('gis');
	}

	public function index()
	{
		$variabel_sesi = array('cari', 'filter', 'sex', 'agama');
		foreach ($variabel_sesi as $variabel)
		{
			$data[$variabel] = $this->session->userdata($variabel) ?: '';
		}

		if (isset($_SESSION['dusun']))
		{
			$data['dusun'] = $_SESSION['dusun'];
			$data['list_rw'] = $this->penduduk_model->list_rw($data['dusun']);
			if (isset($_SESSION['rw']))
			{
				$data['rw'] = $_SESSION['rw'];
				$data['list_rt'] = $this->penduduk_model->list_rt($data['dusun'],$data['rw']);
				if (isset($_SESSION['rt']))
					$data['rt'] = $_SESSION['rt'];
				else $data['rt'] = '';
			}
			else $data['rw'] = '';
		}
		else
		{
			$data['dusun'] = '';
			$data['rw'] = '';
			$data['rt'] = '';
		}
		$variabel_sesi = array('layer_penduduk', 'layer_keluarga', 'layer_desa', 'layer_wilayah', 'layer_lokasi', 'layer_area', 'layer_dusun', 'layer_rw', 'layer_rt', 'layer_garis');
		foreach ($variabel_sesi as $variabel)
		{
			$data[$variabel] = $this->session->userdata($variabel) ?: 0;
		}

		$data['list_dusun'] = $this->penduduk_model->list_dusun();
		$data['wilayah'] = $this->penduduk_model->list_wil();
		$data['list_agama'] = $this->penduduk_model->list_agama();
		$data['list_pendidikan_kk'] = $this->penduduk_model->list_pendidikan_kk();
		$data['desa'] = $this->penduduk_model->get_desa();
		$data['lokasi'] = $this->plan_lokasi_model->list_data();
		$data['garis'] = $this->plan_garis_model->list_data();
		$data['area'] = $this->plan_area_model->list_data();
		$data['penduduk'] = $this->penduduk_model->list_data_map();
		$data['keyword'] = $this->penduduk_model->autocomplete();
		$data['dusun_gis'] = $this->wilayah_model->list_dusun();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		$data['list_lap'] = $this->list_lap();
		$header = $this->header_model->get_data();
		$header['minsidebar'] = 1;
		$nav['act'] = 9;
		$nav['act_sub'] = 62;
		$this->load->view('header', $header);
		$this->load->view('nav',$nav);
		$this->load->view('gis/maps', $data);
		$this->load->view('footer');
	}

	private function list_lap()
	{
		$data = array(
			'13' => 'Umur',
			'0' => 'Pendidikan dalam KK',
			'14' => 'Pendidikan sedang Ditempuh',
			'1' => 'Pekerjaan',
			'2' => 'Status Perkawinan',
			'3' => 'Agama',
			'4' => 'Jenis Kelamin',
			'5' => 'Warga Negara',
			'6' => 'Status Penduduk',
			'7' => 'Golongan Darah',
			'9' => 'Penyandang Cacat',
			'10' => 'Sakit Menahun',
			'16' => 'Akseptor KB',
			'17' => 'Akte Kelahiran',
			'18' => 'Kepemilikan KTP',
			'19' => 'Jenis Asuransi'
		);
		return $data;
	}

	public function search()
	{
		$cari = $this->input->post('cari');
		if ($cari != '')
		{
			$_SESSION['cari'] = $cari;
			if(empty($_SESSION['layer_penduduk']) AND empty($_SESSION['layer_keluarga']))
				$_SESSION['layer_penduduk'] = 1;
		}
		else unset($_SESSION['cari']);
		redirect('gis');
	}

	public function filter()
	{
		$filter = $this->input->post('filter');
		if ($filter != "")
		{
			$_SESSION['filter'] = $filter;
			if (empty($_SESSION['layer_penduduk']) AND empty($_SESSION['layer_keluarga']))
			$_SESSION['layer_penduduk'] = 1;
		}
		else unset($_SESSION['filter']);
		redirect('gis');
	}

	public function layer_penduduk()
	{
		$layer_penduduk = $this->input->post('layer_penduduk');
		if ($layer_penduduk == "")
			$_SESSION['layer_penduduk'] = 0;
		else
		{
			$_SESSION['layer_penduduk'] = 1;
			$_SESSION['layer_keluarga'] = 0;
		}
		redirect('gis');
	}

	public function layer_wilayah()
	{
		$_SESSION['layer_wilayah'] = $this->input->post('layer_wilayah') ? 1 : 0;
		redirect('gis');
	}

	public function layer_area()
	{
		$_SESSION['layer_area'] = $this->input->post('layer_area') ? 1 : 0;
		redirect('gis');
	}

	public function layer_lokasi()
	{
		$_SESSION['layer_lokasi'] = $this->input->post('layer_lokasi') ? 1 : 0;
		redirect('gis');
	}

	public function layer_keluarga()
	{
		$layer_keluarga = $this->input->post('layer_keluarga');
		if ($layer_keluarga == "")
		{
			$_SESSION['layer_keluarga'] = 0;
		}
		else
		{
			$_SESSION['layer_keluarga'] = 1;
			$_SESSION['layer_penduduk'] = 0;
		}
		redirect('gis');
	}

	public function layer_desa()
	{
		$_SESSION['layer_desa'] = $this->input->post('layer_desa') ? 1 : 0;
		redirect('gis');
	}

	public function sex()
	{
		$sex = $this->input->post('sex');
		if ($sex != "") {
			$_SESSION['sex'] = $sex;
			if (empty($_SESSION['layer_penduduk']) AND empty($_SESSION['layer_keluarga']))
				$_SESSION['layer_penduduk'] = 1;
		}
		else unset($_SESSION['sex']);
		redirect('gis');
	}

	public function dusun()
	{
		$dusun = $this->input->post('dusun');
		if ($dusun != "")
		{
			$_SESSION['dusun']=$dusun;
			if (empty($_SESSION['layer_penduduk']) AND empty($_SESSION['layer_keluarga']))
				$_SESSION['layer_penduduk'] = 1;
		}
		else unset($_SESSION['dusun']);
		redirect('gis');
	}

	public function rw()
	{
		$rw = $this->input->post('rw');
		if ($rw != "")
		{
			$_SESSION['rw'] = $rw;
			if (empty($_SESSION['layer_penduduk']) AND empty($_SESSION['layer_keluarga']))
				$_SESSION['layer_penduduk'] = 1;
		}
		else unset($_SESSION['rw']);
		redirect('gis');
	}

	public function rt()
	{
		$rt = $this->input->post('rt');
		if ($rt != "")
		{
			$_SESSION['rt'] = $rt;
			if(empty($_SESSION['layer_penduduk']) AND empty($_SESSION['layer_keluarga']))
				$_SESSION['layer_penduduk'] = 1;
		}
		else unset($_SESSION['rt']);
		redirect('gis');
	}

	public function agama()
	{
		$agama = $this->input->post('agama');
		if ($agama != "")
		{
			$_SESSION['agama'] = $agama;
			if (empty($_SESSION['layer_penduduk']) AND empty($_SESSION['layer_keluarga']))
				$_SESSION['layer_penduduk'] = 1;
		}
		else unset($_SESSION['agama']);
		redirect('gis');
	}

	public function ajax_adv_search()
	{
		$data['dusun'] = $this->penduduk_model->list_dusun();
		$data['agama'] = $this->penduduk_model->list_agama();
		$data['pendidikan_kk'] = $this->penduduk_model->list_pendidikan_kk();
		$data['pekerjaan'] = $this->penduduk_model->list_pekerjaan();
		$data['form_action'] = site_url("gis/adv_search_proses");

		$this->load->view("gis/ajax_adv_search_form", $data);
	}

	public function adv_search_proses()
	{
		$adv_search = $_POST;
		$i = 0;
		while ($i++ < count($adv_search))
		{
			$col[$i] = key($adv_search);
			next($adv_search);
		}
		$i = 0;
		while ($i++ < count($col))
		{
			if ($adv_search[$col[$i]] == "")
				UNSET($adv_search[$col[$i]]);
			else
			{
				$_SESSION[$col[$i]] = $adv_search[$col[$i]];
				if (empty($_SESSION['layer_penduduk']) AND empty($_SESSION['layer_keluarga']))
					$_SESSION['layer_penduduk'] = 1;
			}
		}
		redirect('gis');
	}

	public function layer_dusun()
	{
		$_SESSION['layer_dusun'] = $this->input->post('layer_dusun') ? 1 : 0;
		redirect('gis');
	}

	public function layer_rw()
	{
		$_SESSION['layer_rw'] = $this->input->post('layer_rw') ? 1 : 0;
		redirect('gis');
	}

	public function layer_rt()
	{
		$_SESSION['layer_rt'] = $this->input->post('layer_rt') ? 1 : 0;
		redirect('gis');
	}

	public function layer_garis()
	{
		$_SESSION['layer_garis'] = $this->input->post('layer_garis') ? 1 : 0;
		redirect('gis');
	}
}
