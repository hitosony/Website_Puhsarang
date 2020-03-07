<?php class Plan_line_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function autocomplete()
	{
		$str = autocomplete_str('nama', 'line');
		return $str;
	}

	private function search_sql()
	{
		if (isset($_SESSION['cari']))
		{
			$cari = $_SESSION['cari'];
			$kw = $this->db->escape_like_str($cari);
			$kw = '%' .$kw. '%';
			$search_sql = " AND (nama LIKE '$kw')";
			return $search_sql;
		}
	}

	private function filter_sql()
	{
		if (isset($_SESSION['filter']))
		{
			$kf = $_SESSION['filter'];
			$filter_sql = " AND enabled = $kf";
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
		$sql = "FROM line WHERE tipe = 0 ";
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
		$data = $_POST;
	  $lokasi_file = $_FILES['simbol']['tmp_name'];
	  $tipe_file = $_FILES['simbol']['type'];
	  $nama_file = $_FILES['simbol']['name'];
	  $nama_file = str_replace(' ', '-', $nama_file); 	 // normalkan nama file
	  if (!empty($lokasi_file))
	  {
			if ($tipe_file == "image/png" OR $tipe_file == "image/gif")
			{
				UploadSimbol($nama_file);
				$data['simbol'] = $nama_file;
				$outp = $this->db->insert('line',$data);
			}
	  }
	  else
	  {
			unset($data['simbol']);
			$outp = $this->db->insert('line',$data);
		}
		if ($outp) $_SESSION['success'] = 1;
		else $_SESSION['success'] = -1;
	}

	public function update($id=0)
	{
	  $data = $_POST;
	  $lokasi_file = $_FILES['simbol']['tmp_name'];
	  $tipe_file = $_FILES['simbol']['type'];
	  $nama_file = $_FILES['simbol']['name'];
	  $nama_file = str_replace(' ', '-', $nama_file); 	 // normalkan nama file
	  if (!empty($lokasi_file))
	  {
			if ($tipe_file == "image/png" OR $tipe_file == "image/gif")
			{
				UploadSimbol($nama_file);
				$data['simbol'] = $nama_file;
				$this->db->where('id',$id);
				$outp = $this->db->update('line',$data);
			}
			$_SESSION['success'] = 1;
	  }
		unset($data['simbol']);
		$this->db->where('id',$id);
		$outp = $this->db->update('line',$data);

		if ($outp) $_SESSION['success'] = 1;
		else $_SESSION['success'] = -1;
	}

	public function delete($id='')
	{
		$sql = "DELETE FROM line WHERE id = ?";
		$outp = $this->db->query($sql, array($id));

		if ($outp) $_SESSION['success'] = 1;
		else $_SESSION['success'] = -1;
	}

	public function delete_all()
	{
		$id_cb = $_POST['id_cb'];

		if (count($id_cb))
		{
			foreach ($id_cb as $id)
			{
				$sql = "DELETE FROM line WHERE id = ?";
				$outp = $this->db->query($sql, array($id));
			}
		}
		else $outp = false;

		if ($outp) $_SESSION['success'] = 1;
		else $_SESSION['success'] = -1;
	}

	public function list_sub_line($line=1)
	{
		$sql = "SELECT * FROM line WHERE parrent = ? AND tipe = 2 ";
		$query = $this->db->query($sql, $line);
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

	public function insert_sub_line($parrent=0)
	{
	  $lokasi_file = $_FILES['simbol']['tmp_name'];
	  $tipe_file = $_FILES['simbol']['type'];
	  $nama_file = $_FILES['simbol']['name'];
	  $nama_file = str_replace(' ', '-', $nama_file); 	 // normalkan nama file
	  if (!empty($lokasi_file))
	  {
			if ($tipe_file == "image/png" OR $tipe_file == "image/gif")
			{
				UploadSimbol($nama_file);
				$data = $_POST;
				$data['simbol'] = $nama_file;
				$data['parrent'] = $parrent;
				$data['tipe'] = 2;
				$outp = $this->db->insert('line', $data);
				if ($outp) $_SESSION['success'] = 1;
			}
			else
			{
				$_SESSION['success'] = -1;
			}
	  }
	  else
	  {
			$data = $_POST;
			unset($data['simbol']);
			$data['parrent'] = $parrent;
			$data['tipe'] = 2;
			$outp = $this->db->insert('line', $data);
		}
		if ($outp) $_SESSION['success'] = 1;
	 	else $_SESSION['success'] = -1;
	}

	public function update_sub_line($id=0)
	{
	  $data = $_POST;
	  $lokasi_file = $_FILES['simbol']['tmp_name'];
	  $tipe_file = $_FILES['simbol']['type'];
	  $nama_file = $_FILES['simbol']['name'];
	  $nama_file = str_replace(' ', '-', $nama_file); 	 // normalkan nama file
	  if (!empty($lokasi_file))
	  {
			if ($tipe_file == "image/png" OR $tipe_file == "image/gif")
			{
				UploadSimbol($nama_file);
				$data['simbol'] = $nama_file;
				$this->db->where('id', $id);
				$outp = $this->db->update('line', $data);
			}
			$_SESSION['success'] = 1;
	  }
	  else
	  {
			unset($data['simbol']);
			$this->db->where('id', $id);
			$outp = $this->db->update('line', $data);
		}
		if($outp) $_SESSION['success'] = 1;
		else $_SESSION['success'] = -1;
	}

	public function delete_sub_line($id='')
	{
		$sql = "DELETE FROM line WHERE id = ?";
		$outp = $this->db->query($sql, array($id));

		if ($outp) $_SESSION['success'] = 1;
		else $_SESSION['success'] = -1;
	}

	public function delete_all_sub_line()
	{
		$id_cb = $_POST['id_cb'];

		if (count($id_cb))
		{
			foreach ($id_cb as $id)
			{
				$sql = "DELETE FROM line WHERE id = ?";
				$outp = $this->db->query($sql, array($id));
			}
		}
		else $outp = false;

		if ($outp) $_SESSION['success'] = 1;
		else $_SESSION['success'] = -1;
	}

	public function line_lock($id='', $val=0)
	{
		$sql = "UPDATE line SET enabled = ? WHERE id = ?";
		$outp = $this->db->query($sql, array($val, $id));

		if ($outp) $_SESSION['success'] = 1;
		else $_SESSION['success'] = -1;
	}

	public function get_line($id=0)
	{
		$sql = "SELECT * FROM line WHERE id = ?";
		$query = $this->db->query($sql,$id);
		$data = $query->row_array();
		return $data;
	}

}
?>
