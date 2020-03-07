<?php class Web_gallery_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function autocomplete()
	{
		$str = autocomplete_str('nama', 'gambar_gallery');
		return $str;
	}

	private function search_sql()
	{
		if (isset($_SESSION['cari']))
		{
			$cari = $_SESSION['cari'];
			$kw = $this->db->escape_like_str($cari);
			$kw = '%' .$kw. '%';
			$search_sql= " AND (gambar LIKE '$kw' OR nama LIKE '$kw')";
			return $search_sql;
		}
	}

	private function filter_sql()
	{
		if (isset($_SESSION['filter']))
		{
			$kf = $_SESSION['filter'];
			$filter_sql= " AND enabled = $kf";
			return $filter_sql;
		}
	}

	public function paging($p=1, $o=0)
	{
		$sql = "SELECT COUNT(*) AS jml " . $this->list_data_sql();
		$query = $this->db->query($sql);
		$row = $query->row_array();
		$jml_data = $row['jml'];

		$this->load->library('paging');
		$cfg['page'] = $p;
		$cfg['per_page'] = $_SESSION['per_page'];
		$cfg['num_rows'] = $jml_data;
		$this->paging->init($cfg);

		return $this->paging;
	}

	private function list_data_sql()
	{
		$sql = " FROM gambar_gallery WHERE tipe = 0  ";
		$sql .= $this->search_sql();
		$sql .= $this->filter_sql();
		return $sql;
	}

	public function list_data($o=0, $offset=0, $limit=500)
	{
		switch ($o)
		{
			case 1: $order_sql = ' ORDER BY nama'; break;
			case 2: $order_sql = ' ORDER BY nama DESC'; break;
			case 3: $order_sql = ' ORDER BY enabled'; break;
			case 4: $order_sql = ' ORDER BY enabled DESC'; break;
			case 5: $order_sql = ' ORDER BY tgl_upload'; break;
			case 6: $order_sql = ' ORDER BY tgl_upload DESC'; break;
			default:$order_sql = ' ORDER BY id';
		}

		$paging_sql = ' LIMIT ' .$offset. ',' .$limit;

		$sql = "SELECT * " . $this->list_data_sql();
		$sql .= $order_sql;
		$sql .= $paging_sql;

		$query = $this->db->query($sql);
		$data = $query->result_array();

		$j = $offset;
		for ($i=0; $i<count($data); $i++)
		{
			$data[$i]['no'] = $j + 1;

			if ($data[$i]['enabled'] == 1)
				$data[$i]['aktif'] = "Ya";
			else
				$data[$i]['aktif'] = "Tidak";

			$j++;
		}
		return $data;
	}

	public function insert()
	{
		$_SESSION['success'] = 1;
		$_SESSION['error_msg'] = '';
		if (UploadError($_FILES['gambar']))
		{
			$_SESSION['success'] = -1;
			return;
		}

	  $lokasi_file = $_FILES['gambar']['tmp_name'];
	  $tipe_file = TipeFile($_FILES['gambar']);
		$data = $_POST;
		// Bolehkan album tidak ada gambar cover
		if (!empty($lokasi_file))
		{
		  if (!CekGambar($_FILES['gambar'], $tipe_file))
		  {
				$_SESSION['success'] = -1;
				return;
		  }
		  $nama_file  = urlencode(generator(6)."_".$_FILES['gambar']['name']);
			UploadGallery($nama_file, "", $tipe_file);
			$data['gambar'] = $nama_file;
		}

		if ($_SESSION['grup'] == 4)
		{
			$data['enabled'] = 2;
		}

		$outp = $this->db->insert('gambar_gallery', $data);
		if (!$outp) $_SESSION['success'] = -1;
	}

	public function update($id=0)
	{
		$_SESSION['success'] = 1;
		$_SESSION['error_msg'] = '';
		if (UploadError($_FILES['gambar']))
		{
			$_SESSION['success'] = -1;
			return;
		}

	  $lokasi_file = $_FILES['gambar']['tmp_name'];
	  $tipe_file = TipeFile($_FILES['gambar']);
		$data = $_POST;
		// Kalau kosong, gambar tidak diubah
		if (!empty($lokasi_file))
		{
		  if (!CekGambar($_FILES['gambar'], $tipe_file))
		  {
				$_SESSION['success'] = -1;
				return;
		  }
		  $nama_file  = urlencode(generator(6)."_".$_FILES['gambar']['name']);
			UploadGallery($nama_file, $data['old_gambar'], $tipe_file);
			$data['gambar'] = $nama_file;
		}

		if ($_SESSION['grup'] == 4)
		{
			$data['enabled'] = 2;
		}

		unset($data['old_gambar']);
		$outp = $this->db->where('id', $id)->update('gambar_gallery', $data);
		if (!$outp) $_SESSION['success'] = -1;
	}

	public function delete_gallery($id='')
	{
		$this->delete($id);
		$sub_gallery = $this->db->select('id')->
			where('parrent', $id)->
			get('gambar_gallery')->result_array();
		foreach ($sub_gallery as $gallery)
		{
			$this->delete($gallery['id']);
		}
	}

	public function delete_all_gallery()
	{
		$id_cb = $_POST['id_cb'];
		foreach ($id_cb as $id)
		{
			$outp = $this->delete_gallery($id);
		}
	}

	public function delete($id='')
	{
		// Note:
		// Gambar yang dihapus ada kemungkinan dipakai
		// oleh gallery lain, karena ketika mengupload
		// nama file nya belum diubah sesuai dengan
		// judul gallery
		$this->delete_gallery_image($id);

		$sql  = "DELETE FROM gambar_gallery WHERE id = ?";
		$outp = $this->db->query($sql, array($id));
		if (!$outp) $_SESSION['success'] = -1;
	}

	public function delete_all()
	{
		$id_cb = $_POST['id_cb'];
		foreach ($id_cb as $id)
		{
			$outp = $this->delete($id);
		}
	}

	public function delete_gallery_image($id)
	{
		$image = $this->db->select('gambar')->
			get_where('gambar_gallery', array('id'=>$id))->
			row()->gambar;
		$prefix = array('kecil_', 'sedang_');
		foreach ($prefix as $pref)
		{
			if (is_file(FCPATH . LOKASI_GALERI . $pref . $image))
				unlink(FCPATH . LOKASI_GALERI . $pref . $image);
		}
	}

	public function gallery_lock($id='', $val=0)
	{
		$sql = "UPDATE gambar_gallery SET enabled = ? WHERE id = ?";
		$outp = $this->db->query($sql, array($val, $id));

		if ($outp) $_SESSION['success'] = 1;
		else $_SESSION['success'] = -1;
	}

	public function gallery_slider($id='', $val=0)
	{
		if ($val == 1)
		{
			// Hanya satu gallery yang boleh tampil di slider
			$this->db->where('slider', 1)->update('gambar_gallery', array('slider'=>0));
		}
		$this->db->where('id', $id)->update('gambar_gallery', array('slider'=>$val));
	}

	public function get_gallery($id=0)
	{
		$sql = "SELECT * FROM gambar_gallery WHERE id = ?";
		$query = $this->db->query($sql, $id);
		$data = $query->row_array();
		return $data;
	}

	public function list_slide_galeri()
	{
		$gallery_slide_id = $this->db->select('id')->
			where('slider', 1)->
			limit(1)->
			get('gambar_gallery')->row()->id;
		$slide_galeri = $this->db->select('id, nama as judul, gambar')->
			where(array('parrent'=>$gallery_slide_id, 'tipe'=>2))->
			get('gambar_gallery')->result_array();
		return $slide_galeri;
	}

	public function paging2($gal=0, $p=1)
	{
		$sql = "SELECT COUNT(*) AS jml " . $this->list_sub_gallery_sql();
		$query = $this->db->query($sql,$gal);
		$row = $query->row_array();
		$jml_data = $row['jml'];

		$this->load->library('paging');
		$cfg['page'] = $p;
		$cfg['per_page'] = $_SESSION['per_page'];
		$cfg['num_rows'] = $jml_data;
		$this->paging->init($cfg);

		return $this->paging;
	}

	private function list_sub_gallery_sql()
	{
		$sql = " FROM gambar_gallery WHERE parrent = ? AND tipe = 2 ";
		$sql .= $this->search_sql();
		$sql .= $this->filter_sql();
		return $sql;
	}

	public function list_sub_gallery($gal=1, $o=0, $offset=0, $limit=500)
	{
		switch($o)
		{
			case 1: $order_sql = ' ORDER BY nama'; break;
			case 2: $order_sql = ' ORDER BY nama DESC'; break;
			case 3: $order_sql = ' ORDER BY enabled'; break;
			case 4: $order_sql = ' ORDER BY enabled DESC'; break;
			case 5: $order_sql = ' ORDER BY tgl_upload'; break;
			case 6: $order_sql = ' ORDER BY tgl_upload DESC'; break;
			default:$order_sql = ' ORDER BY id';
		}

		$paging_sql = ' LIMIT ' .$offset. ',' .$limit;

		$sql = "SELECT * " . $this->list_sub_gallery_sql();
		$sql .= $order_sql;
		$sql .= $paging_sql;
		$query = $this->db->query($sql, $gal);
		$data = $query->result_array();

		for ($i=0; $i<count($data); $i++)
		{
			$data[$i]['no'] = $i + 1;

			if ($data[$i]['enabled'] == 1)
				$data[$i]['aktif'] = "Ya";
			else
				$data[$i]['aktif'] = "Tidak";
		}
		return $data;
	}

	public function insert_sub_gallery($parrent=0)
	{
		$_SESSION['success'] = 1;
		$_SESSION['error_msg'] = '';
		if (UploadError($_FILES['gambar']))
		{
			$_SESSION['success'] = -1;
			return;
		}

	  $lokasi_file = $_FILES['gambar']['tmp_name'];
	  $tipe_file = TipeFile($_FILES['gambar']);
		$data = $_POST;
		// Bolehkan isi album tidak ada gambar
		if (!empty($lokasi_file))
		{
		  if (!CekGambar($_FILES['gambar'], $tipe_file))
		  {
				$_SESSION['success'] = -1;
				return;
		  }
		  $nama_file  = urlencode(generator(6)."_".$_FILES['gambar']['name']);
			UploadGallery($nama_file, "", $tipe_file);
			$data['gambar'] = $nama_file;
		}

		if ($_SESSION['grup'] == 4)
		{
			$data['enabled'] = 2;
		}

		$data['parrent'] = $parrent;
		$data['tipe'] = 2;
		$outp = $this->db->insert('gambar_gallery', $data);
		if (!$outp) $_SESSION['success'] = -1;
	}

	public function update_sub_gallery($id=0)
	{
		$_SESSION['success'] = 1;
		$_SESSION['error_msg'] = '';
		if (UploadError($_FILES['gambar']))
		{
			$_SESSION['success'] = -1;
			return;
		}

	  $lokasi_file = $_FILES['gambar']['tmp_name'];
	  $tipe_file = TipeFile($_FILES['gambar']);
		$data = $_POST;
		// Kalau kosong, gambar tidak diubah
		if (!empty($lokasi_file))
		{
		  if (!CekGambar($_FILES['gambar'], $tipe_file))
		  {
				$_SESSION['success'] = -1;
				return;
		  }
		  $nama_file  = urlencode(generator(6)."_".$_FILES['gambar']['name']);
			UploadGallery($nama_file,$data['old_gambar'], $tipe_file);
			$data['gambar'] = $nama_file;
		}

		unset($data['old_gambar']);
		$outp = $this->db->where('id', $id)->update('gambar_gallery', $data);
		if (!$outp) $_SESSION['success'] = -1;
	}
}
?>
