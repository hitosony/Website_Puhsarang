<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sid_Core extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		session_start();
		$this->load->model('header_model');
		$this->load->model('wilayah_model');
		$this->load->model('config_model');
                $this->load->library('form_validation');
		$this->modul_ini = 200;
	}

	public function clear()
	{
		unset($_SESSION['cari']);
		unset($_SESSION['filter']);
		redirect('sid_core');
	}

	public function index($p = 1, $o = 0)
	{
		$data['p'] = $p;
		$data['o'] = $o;

		if (isset($_SESSION['cari']))
			$data['cari'] = $_SESSION['cari'];
		else $data['cari'] = '';

		if (isset($_SESSION['filter']))
			$data['filter'] = $_SESSION['filter'];
		else $data['filter'] = '';

		if (isset($_POST['per_page']))
			$_SESSION['per_page'] = $_POST['per_page'];

		$data['per_page'] = $_SESSION['per_page'];
		$data['paging'] = $this->wilayah_model->paging($p, $o);
		$data['main'] = $this->wilayah_model->list_data($o, $data['paging']->offset, $data['paging']->per_page);
		$data['keyword'] = $this->wilayah_model->autocomplete();
		$data['total'] = $this->wilayah_model->total();

		$nav['act'] = 2;
		$nav['act_sub'] = 20;
		$header = $this->header_model->get_data();

		$this->load->view('header', $header);
		$this->load->view('nav', $nav);
		$this->load->view('sid/wilayah/wilayah', $data);
		$this->load->view('footer');
	}

	public function cetak()
	{
		$data['desa'] = $this->header_model->get_data();
		$data['main'] = $this->wilayah_model->list_data(0, 0, 1000);
		$data['total'] = $this->wilayah_model->total();

		$this->load->view('sid/wilayah/wilayah_print', $data);
	}

	public function excel()
	{
		$data['desa'] = $this->header_model->get_data();
		$data['main'] = $this->wilayah_model->list_data(0, 0, 1000);
		$data['total'] = $this->wilayah_model->total();

		$this->load->view('sid/wilayah/wilayah_excel', $data);
	}

	public function form($id = '')
	{
		$data['penduduk'] = $this->wilayah_model->list_penduduk();

		if ($id)
		{
			$temp = $this->wilayah_model->cluster_by_id($id);
			$data['dusun'] = $temp['dusun'];
			$data['individu'] = $this->wilayah_model->get_penduduk($temp['id_kepala']);
			if (empty($data['individu']))
				$data['individu'] = NULL;
			else
			{
				$ex = $data['individu'];
				$data['penduduk'] = $this->wilayah_model->list_penduduk_ex($ex['id']);
			}
			$data['form_action'] = site_url("sid_core/update/$id");
		}
		else
		{
			$data['dusun'] = null;
			$data['form_action'] = site_url("sid_core/insert");
		}

                $data['dusun_id'] = $this->wilayah_model->get_dusun_maps($id);

		$nav['act'] = 2;
		$nav['act_sub'] = 20;
		$header = $this->header_model->get_data();

		$this->load->view('header', $header);
		$this->load->view('nav', $nav);
		$this->load->view('sid/wilayah/wilayah_form', $data);
		$this->load->view('footer');
	}

	public function search()
	{
		$cari = $this->input->post('cari');
		if ($cari != '')
			$_SESSION['cari'] = $cari;
		else unset($_SESSION['cari']);
		redirect('sid_core');
	}

	public function insert($dusun = '')
	{
		$this->wilayah_model->insert();
		redirect('sid_core');
	}

	public function update($id = '')
	{
		$this->wilayah_model->update($id);
		redirect('sid_core');
	}

	public function delete($id = '')
	{
		$this->redirect_hak_akses('h', 'sid_core');
		$this->wilayah_model->delete($id);
		redirect('sid_core');
	}

	public function sub_rw($id_dusun = '')
	{
		$dusun = $this->wilayah_model->cluster_by_id($id_dusun);
		$nama_dusun = $dusun['dusun'];
		$data['dusun'] = $dusun['dusun'];
		$data['id_dusun'] = $id_dusun;
		$data['main'] = $this->wilayah_model->list_data_rw($id_dusun );
		$data['total'] = $this->wilayah_model->total_rw($nama_dusun );

		$nav['act'] = 2;
		$nav['act_sub'] = 20;
		$header = $this->header_model->get_data();

		$this->load->view('header', $header);
		$this->load->view('nav', $nav);
		$this->load->view('sid/wilayah/wilayah_rw', $data);
		$this->load->view('footer');
	}


	public function cetak_rw($id_dusun = '')
	{
		$dusun = $this->wilayah_model->cluster_by_id($id_dusun);
		$nama_dusun = $dusun['dusun'];
		$data['dusun'] = $dusun['dusun'];
		$data['id_dusun'] = $id_dusun;
		$data['main'] = $this->wilayah_model->list_data_rw($id_dusun );
		$data['total'] = $this->wilayah_model->total_rw($nama_dusun );

		$this->load->view('sid/wilayah/wilayah_rw_print', $data);
	}

	public function excel_rw($id_dusun = '')
	{
		$dusun = $this->wilayah_model->cluster_by_id($id_dusun);
		$nama_dusun = $dusun['dusun'];
		$data['dusun'] = $dusun['dusun'];
		$data['id_dusun'] = $id_dusun;
		$data['main'] = $this->wilayah_model->list_data_rw($id_dusun );
		$data['total'] = $this->wilayah_model->total_rw($nama_dusun );

		$this->load->view('sid/wilayah/wilayah_rw_excel', $data);
	}

	public function form_rw($id_dusun = '', $rw = '')
	{
		$temp = $this->wilayah_model->cluster_by_id($id_dusun);
		$dusun = $temp['dusun'];
		$data['dusun'] = $temp['dusun'];
		$data['id_dusun'] = $id_dusun;

		$data['penduduk'] = $this->wilayah_model->list_penduduk();

		if ($rw)
		{
			$data['rw'] = $rw;
			$temp = $this->wilayah_model->get_rw($dusun, $rw);
			$data['individu'] = $this->wilayah_model->get_penduduk($temp['id_kepala']);
			if (empty($data['individu']))
				$data['individu'] = NULL;
			else
			{
				$ex = $data['individu'];
				$data['penduduk'] = $this->wilayah_model->list_penduduk_ex($ex['id']);
			}
			$data['form_action'] = site_url("sid_core/update_rw/$id_dusun/$rw");
		}
		else
		{
			$data['rw'] = NULL;
			$data['form_action'] = site_url("sid_core/insert_rw/$id_dusun");
		}

		$nav['act'] = 2;
		$nav['act_sub'] = 20;
		$header = $this->header_model->get_data();

		$this->load->view('header', $header);
		$this->load->view('nav', $nav);
		$this->load->view('sid/wilayah/wilayah_form_rw', $data);
		$this->load->view('footer');
	}

  public function insert_rw($dusun = '')
	{
		$this->wilayah_model->insert_rw($dusun);
		redirect("sid_core/sub_rw/$dusun");
	}

	public function update_rw($dusun = '', $rw = '')
	{
		$this->wilayah_model->update_rw($dusun, $rw);
		redirect("sid_core/sub_rw/$dusun");
	}

	public function delete_rw($id_dusun = '', $id = '')
	{
		$this->redirect_hak_akses('h', "sid_core/sub_rw/$id_dusun");
		$this->wilayah_model->delete_rw($id);
		redirect("sid_core/sub_rw/$id_dusun");
	}

	public function sub_rt($id_dusun = '', $rw = '')
	{

		$temp = $this->wilayah_model->cluster_by_id($id_dusun);
		$dusun = $temp['dusun'];
		$data['dusun'] = $temp['dusun'];
		$data['id_dusun'] = $id_dusun;

		$data['rw'] = $rw;
		$data['main'] = $this->wilayah_model->list_data_rt($dusun, $rw);
		$data['total'] = $this->wilayah_model->total_rt($dusun, $rw);

		$nav['act'] = 2;
		$nav['act_sub'] = 20;
		$header = $this->header_model->get_data();

		$this->load->view('header', $header);
		$this->load->view('nav', $nav);
		$this->load->view('sid/wilayah/wilayah_rt', $data);
		$this->load->view('footer');
	}

	public function cetak_rt($id_dusun = '', $rw = '')
	{
		$temp = $this->wilayah_model->cluster_by_id($id_dusun);
		$dusun = $temp['dusun'];
		$data['dusun'] = $temp['dusun'];
		$data['id_dusun'] = $id_dusun;

		$data['rw'] = $rw;
		$data['main'] = $this->wilayah_model->list_data_rt($dusun, $rw);
		$data['total'] = $this->wilayah_model->total_rt($dusun, $rw);

		$this->load->view('sid/wilayah/wilayah_rt_print', $data);
	}

	public function excel_rt($id_dusun = '', $rw = '')
	{
		$temp = $this->wilayah_model->cluster_by_id($id_dusun);
		$dusun = $temp['dusun'];
		$data['dusun'] = $temp['dusun'];
		$data['id_dusun'] = $id_dusun;

		$data['rw'] = $rw;
		$data['main'] = $this->wilayah_model->list_data_rt($dusun, $rw);
		$data['total'] = $this->wilayah_model->total_rt($dusun, $rw);

		$this->load->view('sid/wilayah/wilayah_rt_excel', $data);
	}

	public function list_dusun_rt($dusun = '', $rw = '')
	{
		$data['dusun'] = $dusun;
		$data['rw'] = $rw;
		$data['main'] = $this->wilayah_model->list_data_rt($dusun, $rw);

		$nav['act'] = 2;
		$nav['act_sub'] = 20;
		$header = $this->header_model->get_data();
		$this->load->view('header', $header);
		$this->load->view('nav', $nav);
		$this->load->view('sid/wilayah/list_dusun_rt', $data);
		$this->load->view('footer');
	}

	public function form_rt($id_dusun = '', $rw = '', $rt = '')
	{
		$temp = $this->wilayah_model->cluster_by_id($id_dusun);

		$data['dusun'] = $temp['dusun'];
		$data['id_dusun'] = $id_dusun;

		$data['rw'] = $rw;
		$data['penduduk'] = $this->wilayah_model->list_penduduk();

		if ($rt)
		{
			$temp2 = $this->wilayah_model->cluster_by_id($rt);
			$id_cluster = $temp2['id'];
			$data['rt'] = $temp2['rt'];
			$data['individu'] = $this->wilayah_model->get_penduduk($temp2['id_kepala']);
			if (empty($data['individu']))
				$data['individu'] = NULL;
			else
			{
				$ex = $data['individu'];
				$data['penduduk'] = $this->wilayah_model->list_penduduk_ex($ex['id']);
			}
			$data['form_action'] = site_url("sid_core/update_rt/$id_dusun/$rw/$id_cluster");
		}
		else
		{
			$data['rt'] = NULL;
			$data['form_action'] = site_url("sid_core/insert_rt/$id_dusun/$rw");
		}

		$nav['act'] = 2;
		$nav['act_sub'] = 20;
		$header = $this->header_model->get_data();

		$this->load->view('header', $header);
		$this->load->view('nav', $nav);
		$this->load->view('sid/wilayah/wilayah_form_rt', $data);
		$this->load->view('footer');
	}

	public function insert_rt($dusun = '', $rw = '')
	{
		$this->wilayah_model->insert_rt($dusun, $rw);
		redirect("sid_core/sub_rt/$dusun/$rw");
	}

	public function update_rt($dusun = '', $rw = '', $id_cluster = 0)
	{
		$this->wilayah_model->update_rt($id_cluster);
		redirect("sid_core/sub_rt/$dusun/$rw");
	}

	public function delete_rt($id_cluster = '')
	{
		$this->redirect_hak_akses('h', "sid_core/sub_rt/$id_dusun/$rw");
		$temp = $this->wilayah_model->cluster_by_id($id_cluster);
		$id_dusun = $temp['id_dusun'];
		$rw = $temp['rw'];
		$this->wilayah_model->delete_rt($id_cluster);
		redirect("sid_core/sub_rt/$id_dusun/$rw");
	}

	public function warga($id = '')
	{
		$temp = $this->wilayah_model->cluster_by_id($id);
		$id_dusun = $temp['id'];
		$dusun = $temp['dusun'];

		$_SESSION['per_page'] = 100;
		$_SESSION['dusun'] = $dusun;
		redirect("penduduk/index/1/0");
	}

	public function warga_kk($id = '')
	{
		$temp = $this->wilayah_model->cluster_by_id($id);
		$id_dusun = $temp['id'];
		$dusun = $temp['dusun'];
		$_SESSION['per_page'] = 50;
		$_SESSION['dusun'] = $dusun;
		redirect("keluarga/index/1/0");
	}

	public function warga_l($id = '')
	{
		$temp = $this->wilayah_model->cluster_by_id($id);
		$id_dusun = $temp['id'];
		$dusun = $temp['dusun'];

		$_SESSION['per_page'] = 100;
		$_SESSION['dusun'] = $dusun;
		$_SESSION['sex'] = 1;
		redirect("penduduk/index/1/0");
	}

	public function warga_p($id = '')
	{
		$temp = $this->wilayah_model->cluster_by_id($id);
		$id_dusun = $temp['id'];
		$dusun = $temp['dusun'];

		$_SESSION['per_page'] = 100;
		$_SESSION['dusun'] = $dusun;
		$_SESSION['sex'] = 2;
		redirect("penduduk/index/1/0");
	}

  public function ajax_kantor_dusun_maps($id='')
	{
		$nav['act_sub'] = 20;
		$sebutan_desa = ucwords($this->setting->sebutan_desa);
		$data['wil_atas'] = $this->config_model->get_data();
    $data['wil_ini'] = $this->wilayah_model->get_dusun_maps($id);
    $data['nama_wilayah'] = ucwords($this->setting->sebutan_dusun." ".$data['wil_ini']['dusun']." ".$sebutan_desa." ".$data['wil_atas']['nama_desa']);
    $data['wilayah'] = ucwords($this->setting->sebutan_dusun);
    $data['breadcrumb'] = array(
    	array('link' => site_url('sid_core'), 'judul' => "Daftar ".$data['wilayah']),
    );
		$data['form_action'] = site_url("sid_core/update_kantor_dusun_map/$id");
    $header = $this->header_model->get_data();
    $namadesa =  $data['wil_atas']['nama_desa'];

    if (!empty($data['wil_atas']['lat'] && !empty($data['wil_atas']['lng'] && !empty($data['wil_atas']['path']))))
		{
      $this->load->view('header', $header);
			$this->load->view('nav', $nav);
			$this->load->view("sid/wilayah/ajax_kantor_maps", $data);
      $this->load->view('footer');
    }
		else
		{
			$_SESSION['success'] = -1;
      $_SESSION['error_msg'] = "Lokasi Kantor $sebutan_desa $namadesa Belum Dilengkapi";
			redirect("sid_core");
    }
	}

  public function ajax_wilayah_dusun_maps($id='')
	{
		$nav['act_sub'] = 20;
    $sebutan_desa = ucwords($this->setting->sebutan_desa);
		$data['wil_atas'] = $this->config_model->get_data();
    $data['wil_ini'] = $this->wilayah_model->get_dusun_maps($id);
    $data['nama_wilayah'] = ucwords($this->setting->sebutan_dusun." ".$data['wil_ini']['dusun']." ".$sebutan_desa." ".$data['wil_atas']['nama_desa']);
    $data['wilayah'] = ucwords($this->setting->sebutan_dusun);
    $data['breadcrumb'] = array(
    	array('link' => site_url('sid_core'), 'judul' => "Daftar ".$data['wilayah']),
    );
		$data['form_action'] = site_url("sid_core/update_wilayah_dusun_map/$id");
    $header = $this->header_model->get_data();
    $namadesa =  $data['wil_atas']['nama_desa'];
    if (!empty($data['wil_atas']['lat'] && !empty($data['wil_atas']['lng'] && !empty($data['wil_atas']['path']))))
		{
		$this->load->view('header', $header);
		$this->load->view('nav', $nav);
		$this->load->view("sid/wilayah/ajax_wilayah_maps", $data);
		$this->load->view('footer');
		}
		else
		{
      $_SESSION['success'] = -1;
      $_SESSION['error_msg'] = "Peta Lokasi/Wilayah $sebutan_desa $namadesa Belum Dilengkapi";
			redirect("sid_core");
		}
	}

  public function update_kantor_dusun_map($id='')
	{
    $sebutan_dusun = ucwords($this->setting->sebutan_dusun);
    $namadusun =  $this->input->post('dusun');
    $iddusun =  $this->input->post('id');

    $update_kantor = $this->wilayah_model->update_kantor_dusun_map($id);

    if ($update_kantor)
    {
	  	$this->wilayah_model->update_kantor_dusun_map($id);
		}
		else
		{
	    redirect("sid_core");
	    $_SESSION['success'] = 1;
    }
	}

  public function update_wilayah_dusun_map($id='')
	{
		$sebutan_dusun = ucwords($this->setting->sebutan_dusun);
		$namadusun =  $this->input->post('dusun');
		$iddusun =  $this->input->post('id');

		$update_wilayah = $this->wilayah_model->update_wilayah_dusun_map($id);

		if ($update_wilayah)
		{
			$this->wilayah_model->update_wilayah_dusun_map($id);
		}
		else
		{
			redirect("sid_core");
      $_SESSION['success'] = 1;
		}
	}

	public function ajax_kantor_rw_maps($id_dusun = '',$rw='')
	{
		$nav['act_sub'] = 20;
		$temp = $this->wilayah_model->cluster_by_id($id_dusun);
		$dusun = $temp['dusun'];
    $data['id_dusun'] = $id_dusun;

    $sebutan_dusun = ucwords($this->setting->sebutan_dusun);
		$data['wil_atas'] = $this->wilayah_model->get_dusun_maps($id_dusun);
		$data['wil_ini'] = $this->wilayah_model->get_rw_maps($dusun, $rw);
    $data['nama_wilayah'] = 'RW '.$data['wil_ini']['rw']." ".ucwords($sebutan_dusun." ".$data['wil_ini']['dusun']);
    $data['breadcrumb'] = array(
    	array('link' => site_url('sid_core'), 'judul' => "Daftar ".$sebutan_dusun),
    	array('link' => site_url("sid_core/sub_rw/$id_dusun"), 'judul' => 'Daftar RW')
    );
    $data['wilayah'] = 'RW';
    $data['form_action'] = site_url("sid_core/update_kantor_rw_map/$id_dusun/$rw");
    $header = $this->header_model->get_data();

    if (!empty($data['wil_atas']['path'] && !empty($data['wil_atas']['lat'] && !empty($data['wil_atas']['lng']))))
		{
			$this->load->view('header', $header);
			$this->load->view('nav', $nav);
	    $this->load->view("sid/wilayah/ajax_kantor_maps", $data);
	    $this->load->view('footer');
    }
		else
		{
			$_SESSION['success'] = -1;
      $_SESSION['error_msg'] = "Lokasi Kantor $sebutan_dusun $dusun Belum Dilengkapi";
      redirect("sid_core/sub_rw/$id_dusun");
		}
	}

  public function ajax_wilayah_rw_maps($id_dusun = '',$rw='')
	{
		$nav['act_sub'] = 20;
		$temp = $this->wilayah_model->cluster_by_id($id_dusun);
		$dusun = $temp['dusun'];
    $data['id_dusun'] = $id_dusun;

    $sebutan_dusun = ucwords($this->setting->sebutan_dusun);
		$data['wil_atas'] = $this->wilayah_model->get_dusun_maps($id_dusun);
		$data['wil_ini'] = $this->wilayah_model->get_rw_maps($dusun, $rw);
    $data['nama_wilayah'] = 'RW '.$data['wil_ini']['rw']." ".ucwords($sebutan_dusun." ".$data['wil_ini']['dusun']);
    $data['breadcrumb'] = array(
    	array('link' => site_url('sid_core'), 'judul' => "Daftar ".$sebutan_dusun),
    	array('link' => site_url("sid_core/sub_rw/$id_dusun"), 'judul' => 'Daftar RW')
    );
    $data['wilayah'] = 'RW';
    $data['form_action'] = site_url("sid_core/update_wilayah_rw_map/$id_dusun/$rw");
    $header = $this->header_model->get_data();

		if (!empty($data['wil_atas']['path'] && !empty($data['wil_atas']['lat'] && !empty($data['wil_atas']['lng']))))
		{
      $this->load->view('header', $header);
			$this->load->view('nav', $nav);
			$this->load->view("sid/wilayah/ajax_wilayah_maps", $data);
			$this->load->view('footer');
    }
		else
		{
      $_SESSION['success'] = -1;
      $_SESSION['error_msg'] = "Peta Lokasi/Wilayah $sebutan_dusun $dusun Belum Dilengkapi";
			redirect("sid_core/sub_rw/$id_dusun");
		}
	}

	public function update_kantor_rw_map($id_dusun = '',$rw='')
	{
    $update_kantor = $this->wilayah_model->update_kantor_rw_map($id);

    if ($update_kantor)
		{
	    $this->wilayah_model->update_kantor_rw_map($id);
    }
		else
		{
      redirect("sid_core/sub_rw/$id_dusun");
      $_SESSION['success'] = 1;
    }
	}

  public function update_wilayah_rw_map($id_dusun = '',$rw='')
	{
		$update_wilayah = $this->wilayah_model->update_wilayah_rw_map($id);

	  if ($update_wilayah)
    {
			$this->wilayah_model->update_wilayah_rw_map($id);
    }
		else
		{
			redirect("sid_core/sub_rw/$id_dusun");
      $_SESSION['success'] = 1;
		}
	}

  public function ajax_kantor_rt_maps($id_dusun = '',$rw='',$id='')
	{
		$nav['act_sub'] = 20;
		$temp = $this->wilayah_model->cluster_by_id($id_dusun);
		$dusun = $temp['dusun'];
    $data['id_dusun'] = $id_dusun;

    $sebutan_dusun = ucwords($this->setting->sebutan_dusun);
    $data['wil_atas'] = $this->wilayah_model->get_dusun_maps($id_dusun);
		$data_rw = $this->wilayah_model->get_rw_maps($dusun, $rw);
    $data['wil_ini'] = $this->wilayah_model->get_rt_maps($id);
    $data['nama_wilayah'] = 'RT '.$data['wil_ini']['rt'].' RW '.$data['wil_ini']['rw'].' '.ucwords($sebutan_dusun." ".$data['wil_ini']['dusun']);
    $data['breadcrumb'] = array(
    	array('link' => site_url('sid_core'), 'judul' => "Daftar ".$sebutan_dusun),
    	array('link' => site_url("sid_core/sub_rw/$id_dusun"), 'judul' => 'Daftar RW'),
    	array('link' => site_url("sid_core/sub_rt/$id_dusun/{$data_rw['rw']}"), 'judul' => 'Daftar RT')
    );
    $data['wilayah'] = 'RT';
    $data['form_action'] = site_url("sid_core/update_wilayah_rt_map/$id_dusun/$rw/$id");
    $header = $this->header_model->get_data();

    if (!empty($data['wil_atas']['path'] && !empty($data['wil_atas']['lat'] && !empty($data['wil_atas']['lng']))))
		{
			$this->load->view('header', $header);
			$this->load->view('nav', $nav);
	    $this->load->view("sid/wilayah/ajax_kantor_maps", $data);
	    $this->load->view('footer');
    }
		else
		{
			$_SESSION['success'] = -1;
      $_SESSION['error_msg'] = "Lokasi Kantor $sebutan_dusun $dusun Belum Dilengkapi";
			redirect("sid_core/sub_rt/$id_dusun/$rw");
		}
	}

  public function ajax_wilayah_rt_maps($id_dusun = '',$rw='',$id='')
	{
		$nav['act_sub'] = 20;
		$temp = $this->wilayah_model->cluster_by_id($id_dusun);
		$dusun = $temp['dusun'];
    $data['id_dusun'] = $id_dusun;

    $sebutan_dusun = ucwords($this->setting->sebutan_dusun);
    $data['wil_atas'] = $this->wilayah_model->get_dusun_maps($id_dusun);
		$data_rw = $this->wilayah_model->get_rw_maps($dusun, $rw);
    $data['wil_ini'] = $this->wilayah_model->get_rt_maps($id);
    $data['nama_wilayah'] = 'RT '.$data['wil_ini']['rt'].' RW '.$data['wil_ini']['rw'].' '.ucwords($sebutan_dusun." ".$data['wil_ini']['dusun']);
    $data['breadcrumb'] = array(
    	array('link' => site_url('sid_core'), 'judul' => "Daftar ".$sebutan_dusun),
    	array('link' => site_url("sid_core/sub_rw/$id_dusun"), 'judul' => 'Daftar RW'),
    	array('link' => site_url("sid_core/sub_rt/$id_dusun/{$data_rw['rw']}"), 'judul' => 'Daftar RT')
    );
    $data['wilayah'] = 'RT';
    $data['form_action'] = site_url("sid_core/update_wilayah_rt_map/$id_dusun/$rw/$id");
    $header = $this->header_model->get_data();

		if (!empty($data['wil_atas']['path'] && !empty($data['wil_atas']['lat'] && !empty($data['wil_atas']['lng']))))
		{
      $this->load->view('header', $header);
			$this->load->view('nav', $nav);
			$this->load->view("sid/wilayah/ajax_wilayah_maps", $data);
			$this->load->view('footer');
    }
		else
		{
			$_SESSION['success'] = -1;
      $_SESSION['error_msg'] = "Peta Lokasi/Wilayah $sebutan_dusun $dusun Belum Dilengkapi";
			redirect("sid_core/sub_rt/$id_dusun/$rw");
		}
	}

	public function update_kantor_rt_map($id_dusun = '',$rw='',$id='')
	{
    $update_kantor = $this->wilayah_model->update_kantor_rt_map($id);

    if ($update_kantor)
		{
	    $this->wilayah_model->update_kantor_rt_map($id);
    }
		else
		{
	    redirect("sid_core/sub_rt/$id_dusun/$rw");
	    $_SESSION['success'] = 1;
    }
	}

  public function update_wilayah_rt_map($id_dusun = '',$rw='',$id='')
	{
    $update_kantor = $this->wilayah_model->update_wilayah_rt_map($id);

    if ($update_kantor)
		{
	    $this->wilayah_model->update_wilayah_rt_map($id);
    }
		else
		{
	    redirect("sid_core/sub_rt/$id_dusun/$rw");
	    $_SESSION['success'] = 1;
    }
	}

}
