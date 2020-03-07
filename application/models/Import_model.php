<?php

define("KOLOM_IMPOR_KELUARGA", serialize(array(
  "alamat" => "1",
  "dusun" => "2",
  "rw"  => "3",
  "rt" => "4",
  "nama" => "5",
  "no_kk" => "6",
  "nik"  => "7",
  "sex" => "8",
  "tempatlahir" => "9",
  "tanggallahir"  => "10",
  "agama_id" => "11",
  "pendidikan_kk_id" => "12",
  "pendidikan_sedang_id" => "13",
  "pekerjaan_id" => "14",
  "status_kawin"  => "15",
  "kk_level" => "16",
  "warganegara_id" => "17",
  "nama_ayah"  => "18",
  "nama_ibu" => "19",
  "golongan_darah_id" => "20",
  "akta_lahir" => "21",
  "dokumen_pasport" => "22",
  "tanggal_akhir_paspor" => "23",
  "dokumen_kitas" => "24",
  "ayah_nik" => "25",
  "ibu_nik" => "26",
  "akta_perkawinan" => "27",
  "tanggalperkawinan" => "28",
  "akta_perceraian" => "29",
  "tanggalperceraian" => "30",
  "cacat_id" => "31",
  "cara_kb_id" => "32",
  "hamil" => "33",
  "ktp_el" => "34",
  "status_rekam" => "35",
  "alamat_sekarang" => "36")));

class Import_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		ini_set('memory_limit', '512M');
		set_time_limit(3600);
		$this->load->library('Spreadsheet_Excel_Reader');
		$this->kode_sex = array_change_key_case(unserialize(KODE_SEX));
		$this->kode_hubungan = array_change_key_case(unserialize(KODE_HUBUNGAN));
		$this->kode_agama = array_change_key_case(unserialize(KODE_AGAMA));
		$this->kode_pendidikan = array_change_key_case(unserialize(KODE_PENDIDIKAN));
		$this->kode_pekerjaan = array_change_key_case(unserialize(KODE_PEKERJAAN));
		$this->kode_status = array_change_key_case(unserialize(KODE_STATUS));
		$this->kode_golongan_darah = array_change_key_case(unserialize(KODE_GOLONGAN_DARAH));
		$this->kode_wajib_ktp = array_change_key_case(unserialize(WAJIB_KTP));
		$this->kode_ktp_el = array_change_key_case(unserialize(KTP_EL));
		$this->kode_status_rekam = array_change_key_case(unserialize(STATUS_REKAM));
		$this->kode_status_dasar = array_change_key_case(unserialize(STATUS_DASAR));
		$this->kode_cacat = array_change_key_case(unserialize(KODE_CACAT));
	}

/* 	========================================================
		IMPORT EXCEL
		========================================================
*/
	private function file_import_valid()
	{
		// error 1 = UPLOAD_ERR_INI_SIZE; lihat Upload.php
		// TODO: pakai cara upload yg disediakan Codeigniter
		if ($_FILES['userfile']['error'] == 1)
		{
			$upload_mb = max_upload();
			$_SESSION['error_msg'] .= " -> Ukuran file melebihi batas " . $upload_mb . " MB";
			$_SESSION['success'] = -1;
			return false;
		}

		$mime_type_excel = array("application/vnd.ms-excel", "application/octet-stream");
		if (!in_array($_FILES['userfile']['type'], $mime_type_excel))
		{
			$_SESSION['error_msg'] .= " -> Jenis file salah: " . $_FILES['userfile']['type'];
			$_SESSION['success'] = -1;
			return false;
		}

		return true;
	}

	/**
	 * Konversi tulisan menjadi kode angka
	 *
	 * @access	protected
	 * @param		array		tulisan => kode angka
	 * @param 	string	tulisan yang akan dikonversi
	 * @return	integer kode angka, -1 kalau tidak ada kodenya
	 */
	protected function get_kode($daftar_kode, $nilai)
	{
		$nilai = strtolower($nilai);
		$nilai = preg_replace("/\s*\/\s*/", '/', $nilai);
		if (!empty($nilai) and $nilai != '-' and !array_key_exists($nilai, $daftar_kode))
			return -1; // kode salah
		return $daftar_kode[$nilai];
	}

	protected function get_konversi_kode($daftar_kode, $nilai)
	{
		if (ctype_digit($nilai))
			return $nilai;
		else
			return $this->get_kode($daftar_kode, $nilai);
	}

	protected function data_import_valid($isi_baris)
	{
		// Kolom yang harus diisi
		if ($isi_baris['nama'] == "" OR $isi_baris['nik'] == "" OR $isi_baris['dusun'] == "" OR $isi_baris['rt'] == "" OR $isi_baris['rw'] == "")
			return 'nama/nik/dusun/rt/rw kosong';
		// Validasi data setiap kolom ber-kode
		if ($isi_baris['sex'] != "" AND !($isi_baris['sex'] >= 1 && $isi_baris['sex'] <= 2)) return 'kode sex tidak dikenal';
		if ($isi_baris['agama_id'] != "" AND !($isi_baris['agama_id'] >= 1 && $isi_baris['agama_id'] <= 7)) return 'kode agama tidak dikenal';
		if ($isi_baris['pendidikan_kk_id'] != "" AND !($isi_baris['pendidikan_kk_id'] >= 1 && $isi_baris['pendidikan_kk_id'] <= 10)) return 'kode pendidikan tidak dikenal';
		if ($isi_baris['pendidikan_sedang_id'] != "" AND !($isi_baris['pendidikan_sedang_id'] >= 1 && $isi_baris['pendidikan_sedang_id'] <= 18)) return 'kode pendidikan_sedang tidak dikenal';
		if ($isi_baris['pekerjaan_id'] != "" AND !($isi_baris['pekerjaan_id'] >= 1 && $isi_baris['pekerjaan_id'] <= 89)) return 'kode pekerjaan tidak dikenal';
		if ($isi_baris['status_kawin'] != "" AND !($isi_baris['status_kawin'] >= 1 && $isi_baris['status_kawin'] <= 4)) return 'kode status_kawin tidak dikenal';
		if ($isi_baris['kk_level'] != "" AND !($isi_baris['kk_level'] >= 1 && $isi_baris['kk_level'] <= 11)) return 'kode status hubungan tidak dikenal';
		if ($isi_baris['warganegara_id'] != "" AND !($isi_baris['warganegara_id'] >= 1 && $isi_baris['warganegara_id'] <= 3)) return 'kode warganegara tidak dikenal';
		if ($isi_baris['golongan_darah_id'] != "" AND !($isi_baris['golongan_darah_id'] >= 1 && $isi_baris['golongan_darah_id'] <= 13)) return 'kode golongan_darah tidak dikenal';

		if ($isi_baris['cacat_id'] != "" AND !($isi_baris['cacat_id'] >= 1 && $isi_baris['cacat_id'] <= 7)) return 'kode cacat tidak dikenal';
		if ($isi_baris['cara_kb_id'] != "" AND !($isi_baris['cara_kb_id'] >= 1 && $isi_baris['cara_kb_id'] <= 8) AND $isi_baris['cara_kb_id']!="99") return 'kode cara_kb tidak dikenal';
		if ($isi_baris['hamil'] != "" AND !($isi_baris['hamil'] >= 0 && $isi_baris['hamil'] <= 1)) return 'kode hamil tidak dikenal';
		if ($isi_baris['ktp_el'] != "" AND !($isi_baris['ktp_el'] >= 1 && $isi_baris['ktp_el'] <= 2)) return 'kode ktp_el tidak dikenal';
		if ($isi_baris['status_rekam'] != "" AND !($isi_baris['status_rekam'] >= 1 && $isi_baris['status_rekam'] <= 8)) return 'kode status_rekam tidak dikenal';

		// Validasi data lain
		if (!ctype_digit($isi_baris['nik']) OR (strlen($isi_baris['nik']) != 16 AND $isi_baris['nik'] != '0')) return 'nik salah';

		return '';
	}

	protected function format_tanggal($kolom_tanggal)
	{
		$tanggal = ltrim(trim($kolom_tanggal),"'");
		if (strlen($tanggal) == 0)
		{
			return $tanggal;
		}

		// Ganti separator tanggal supaya tanggal diproses sebagai dd-mm-YYYY.
		// Kalau pakai '/', strtotime memrosesnya sebagai mm/dd/YYYY.
		// Lihat panduan strtotime: http://php.net/manual/en/function.strtotime.php
		$tanggal = str_replace('/', '-', $tanggal);
		$tanggal = date("Y-m-d", strtotime($tanggal));
		return $tanggal;
	}

	private function get_isi_baris($data, $i)
	{
		$kolom_impor_keluarga = unserialize(KOLOM_IMPOR_KELUARGA);
		$isi_baris['alamat'] = trim($data->val($i, $kolom_impor_keluarga['alamat']));
		$dusun = ltrim(trim($data->val($i, $kolom_impor_keluarga['dusun'])), "'");
		$dusun = str_replace('_', ' ', $dusun);
		$dusun = strtoupper($dusun);
		$dusun = str_replace('DUSUN ', '', $dusun);
		$isi_baris['dusun'] = $dusun;

		$isi_baris['rw'] = ltrim(trim($data->val($i, $kolom_impor_keluarga['rw'])), "'");
		$isi_baris['rt'] = ltrim(trim($data->val($i, $kolom_impor_keluarga['rt'])), "'");

		$nama = trim($data->val($i, $kolom_impor_keluarga['nama']));
		$nama = preg_replace('/[^a-zA-Z0-9,\.\']/', ' ', $nama);
		$isi_baris['nama'] = $nama;

		// Data Disdukcapil adakalanya berisi karakter tambahan pada no_kk dan nik
		// yang tidak tampak (non-printable characters),
		// jadi perlu dibuang
		$no_kk= trim($data->val($i, $kolom_impor_keluarga['no_kk']));
		$no_kk = preg_replace('/[^0-9]/', '', $no_kk);
		$isi_baris['no_kk'] = $no_kk;

		$nik = trim($data->val($i, $kolom_impor_keluarga['nik']));
		$nik = preg_replace('/[^0-9]/', '', $nik);
		$isi_baris['nik'] = $nik;

		$isi_baris['sex'] = $this->get_konversi_kode($this->kode_sex, trim($data->val($i, $kolom_impor_keluarga['sex'])));
		$isi_baris['tempatlahir']= trim($data->val($i, $kolom_impor_keluarga['tempatlahir']));

		$isi_baris['tanggallahir'] = $this->format_tanggal($data->val($i, $kolom_impor_keluarga['tanggallahir']));

		$isi_baris['agama_id']= $this->get_konversi_kode($this->kode_agama, trim($data->val($i, $kolom_impor_keluarga['agama_id'])));
		$isi_baris['pendidikan_kk_id']= $this->get_konversi_kode($this->kode_pendidikan, trim($data->val($i, $kolom_impor_keluarga['pendidikan_kk_id'])));
		// TODO: belum ada kode_pendudukan_sedang
		$pendidikan_sedang_id= trim($data->val($i, $kolom_impor_keluarga['pendidikan_sedang_id']));
		if ($pendidikan_sedang_id == "")
			$pendidikan_sedang_id = 18;
		$isi_baris['pendidikan_sedang_id'] = $pendidikan_sedang_id;

		$isi_baris['pekerjaan_id']= $this->get_konversi_kode($this->kode_pekerjaan, trim($data->val($i, $kolom_impor_keluarga['pekerjaan_id'])));
		$isi_baris['status_kawin']= $this->get_konversi_kode($this->kode_status, trim($data->val($i, $kolom_impor_keluarga['status_kawin'])));
		$isi_baris['kk_level']= $this->get_konversi_kode($this->kode_hubungan, trim($data->val($i, $kolom_impor_keluarga['kk_level'])));
		// TODO: belum ada kode_warganegara
		$isi_baris['warganegara_id']= trim($data->val($i, $kolom_impor_keluarga['warganegara_id']));

		$nama_ayah = trim($data->val($i,$kolom_impor_keluarga['nama_ayah']));
		if ($nama_ayah == "")
		{
			$nama_ayah = "-";
		}
		$isi_baris['nama_ayah'] = $nama_ayah;

		$nama_ibu = trim($data->val($i,$kolom_impor_keluarga['nama_ibu']));
		if ($nama_ibu == "")
		{
			$nama_ibu = "-";
		}
		$isi_baris['nama_ibu'] = $nama_ibu;

		$isi_baris['golongan_darah_id'] = $this->get_konversi_kode($this->kode_golongan_darah, trim($data->val($i, $kolom_impor_keluarga['golongan_darah_id'])));
		$isi_baris['akta_lahir'] = trim($data->val($i, $kolom_impor_keluarga['akta_lahir']));
		$isi_baris['dokumen_pasport'] = trim($data->val($i, $kolom_impor_keluarga['dokumen_pasport']));
		$isi_baris['tanggal_akhir_paspor'] = $this->format_tanggal($data->val($i, $kolom_impor_keluarga['tanggal_akhir_paspor']));

		$isi_baris['dokumen_kitas'] = trim($data->val($i, $kolom_impor_keluarga['dokumen_kitas']));
		$isi_baris['ayah_nik'] = trim($data->val($i, $kolom_impor_keluarga['ayah_nik']));
		$isi_baris['ibu_nik'] = trim($data->val($i, $kolom_impor_keluarga['ibu_nik']));
		$isi_baris['akta_perkawinan'] = trim($data->val($i, $kolom_impor_keluarga['akta_perkawinan']));
		$isi_baris['tanggalperkawinan'] = $this->format_tanggal($data->val($i, $kolom_impor_keluarga['tanggalperkawinan']));
		$isi_baris['akta_perceraian'] = trim($data->val($i, $kolom_impor_keluarga['akta_perceraian']));
		$isi_baris['tanggalperceraian'] = $this->format_tanggal($data->val($i, $kolom_impor_keluarga['tanggalperceraian']));
		// TODO: belum ada kode_cacat
		$isi_baris['cacat_id'] = trim($data->val($i, $kolom_impor_keluarga['cacat_id']));
		// TODO: belum ada kode_cara_kb
		$isi_baris['cara_kb_id'] = trim($data->val($i, $kolom_impor_keluarga['cara_kb_id']));
		$isi_baris['hamil'] = trim($data->val($i, $kolom_impor_keluarga['hamil']));
		$isi_baris['ktp_el'] = $this->get_konversi_kode($this->kode_ktp_el, trim($data->val($i, $kolom_impor_keluarga['ktp_el'])));
		$isi_baris['status_rekam']= $this->get_konversi_kode($this->kode_status_rekam, trim($data->val($i, $kolom_impor_keluarga['status_rekam'])));
		$isi_baris['alamat_sekarang'] = trim($data->val($i, $kolom_impor_keluarga['alamat_sekarang']));
		return $isi_baris;
	}

	protected function tulis_tweb_wil_clusterdesa(&$isi_baris)
	{
		// Masukkan wilayah administratif ke tabel tweb_wil_clusterdesa apabila
		// wilayah administratif ini belum ada

		// --- Masukkan dusun apabila belum ada
		$query = "SELECT id FROM tweb_wil_clusterdesa WHERE dusun = ?";
		$hasil = $this->db->query($query, $isi_baris['dusun']);
		$res = $hasil->row_array();
		if (empty($res))
		{
			$query = "INSERT INTO tweb_wil_clusterdesa(rt, rw, dusun) VALUES (0, 0, '".$isi_baris['dusun']."')";
			$hasil = $this->db->query($query);
			$query = "INSERT INTO tweb_wil_clusterdesa(rt, rw, dusun) VALUES (0, '-', '".$isi_baris['dusun']."')";
			$hasil = $this->db->query($query);
			$query = "INSERT INTO tweb_wil_clusterdesa(rt, rw, dusun) VALUES ('-','-','".$isi_baris['dusun']."')";
			$hasil = $this->db->query($query);
		}

		// --- Masukkan rw apabila belum ada
		$query = "SELECT id FROM tweb_wil_clusterdesa WHERE dusun = ? AND rw = ?";
		$hasil = $this->db->query($query, array($isi_baris['dusun'], $isi_baris['rw']));
		$res = $hasil->row_array();
		if (empty($res))
		{
			$query = "INSERT INTO tweb_wil_clusterdesa(rt,rw,dusun) VALUES (0, '".$isi_baris['rw']."', '".$isi_baris['dusun']."')";
			$hasil = $this->db->query($query);
			$query = "INSERT INTO tweb_wil_clusterdesa(rt,rw,dusun) VALUES ('-', '".$isi_baris['rw']."', '".$isi_baris['dusun']."')";
			$hasil = $this->db->query($query);
			$isi_baris['id_cluster'] = $this->db->insert_id();
		}

		// --- Masukkan rt apabila belum ada
		$query = "SELECT id FROM tweb_wil_clusterdesa WHERE
							dusun = '".$isi_baris['dusun']."' AND rw='".$isi_baris['rw']."' AND rt='".$isi_baris['rt']."'";
		$hasil = $this->db->query($query);
		$res = $hasil->row_array();
		if ( ! empty($res))
		{
			$isi_baris['id_cluster'] = $res['id'];
		}
		else
		{
			$query = "INSERT INTO tweb_wil_clusterdesa(rt,rw,dusun) VALUES ('".$isi_baris['rt']."', '".$isi_baris['rw']."', '".$isi_baris['dusun']."')";
			$hasil = $this->db->query($query);
			$isi_baris['id_cluster'] = $this->db->insert_id();
		}
	}

	protected function tulis_tweb_keluarga(&$isi_baris)
	{
		// Penduduk dengan no_kk adalah penduduk lepas
		if ($isi_baris['no_kk'] == '')
		{
			return false;
		}
		// Masukkan keluarga ke tabel tweb_keluarga apabila
		// keluarga ini belum ada
		$keluarga_baru = false;
		$query = "SELECT id from tweb_keluarga WHERE no_kk=?";
		$hasil = $this->db->query($query, $isi_baris['no_kk']);
		$res = $hasil->row_array();
		if ( ! empty($res))
		{
			// Update keluarga apabila sudah ada
			$isi_baris['id_kk'] = $res['id'];
			$id = $res['id'];
			$this->db->where('id', $id);
			// Hanya update apabila alamat kosong
			// karena alamat keluarga akan diupdate menggunakan data kepala keluarga di tulis_tweb_pendududk
			$this->db->where('alamat', NULL);
			$data['alamat'] = $isi_baris['alamat'];
			$hasil = $this->db->update('tweb_keluarga', $data);
		}
		else
		{
			$data['no_kk'] = $isi_baris['no_kk'];
			$data['alamat'] = $isi_baris['alamat'];
			$hasil = $this->db->insert('tweb_keluarga', $data);
			$isi_baris['id_kk'] = $this->db->insert_id();
			$keluarga_baru = true;
		}
		return $keluarga_baru;
	}

	protected function tulis_tweb_penduduk($isi_baris)
	{
		// Siapkan data penduduk
		$kolom_baris = array('nama', 'nik', 'id_kk', 'kk_level', 'sex', 'tempatlahir', 'tanggallahir', 'agama_id', 'pendidikan_kk_id', 'pendidikan_sedang_id', 'pekerjaan_id', 'status_kawin', 'warganegara_id', 'nama_ayah', 'nama_ibu', 'golongan_darah_id', 'akta_lahir', 'dokumen_pasport', 'tanggal_akhir_paspor', 'dokumen_kitas', 'ayah_nik', 'ibu_nik', 'akta_perkawinan', 'tanggalperkawinan', 'akta_perceraian', 'tanggalperceraian', 'cacat_id', 'cara_kb_id', 'hamil', 'id_cluster', 'ktp_el', 'status_rekam', 'alamat_sekarang', 'alamat_sebelumnya', 'status_dasar');
		foreach ($kolom_baris as $kolom)
		{
			$data[$kolom] = $isi_baris[$kolom];
		}
		$data['status'] = '1';  // penduduk impor dianggap aktif
		// Jangan masukkan atau update isian yang kosong
		foreach ($data as $key => $value)
		{
			if (empty($value))
			{
				unset($data[$key]);
			}
		}
		// Masukkan penduduk ke tabel tweb_penduduk apabila
		// penduduk ini belum ada
		// Penduduk dianggap baru apabila NIK tidak diketahui (nilai 0)
		$penduduk_baru = false;
		if ($isi_baris['nik'] != 0)
		{
			// Update data penduduk yang sudah ada
			$query = "SELECT id from tweb_penduduk WHERE nik = ?";
			$hasil = $this->db->query($query, $isi_baris['nik']);
			$res = $hasil->row_array();
			if (!empty($res))
			{
				if ($data['status_dasar'] != -1)
				{
					// Hanya update apabila status dasar valid (data SIAK)
					$data['updated_at'] = date('Y-m-d H:i:s');
					$data['updated_by'] = $this->session->user;
					$id = $res['id'];
					$this->db->where('id',$id);
					$hasil = $this->db->update('tweb_penduduk', $data);
				}
			}
			else
			{
				if ($data['status_dasar'] == -1) $data['status_dasar'] = 9; // Tidak Valid
				$data['created_by'] = $this->session->user;
				$hasil = $this->db->insert('tweb_penduduk', $data);
				$id = $this->db->insert_id();
				$penduduk_baru = $id;
			}
		}
		else
		{
			if ($data['status_dasar'] == -1) $data['status_dasar'] = 9; // Tidak Valid
			$data['created_by'] = $this->session->user;
			$hasil = $this->db->insert('tweb_penduduk', $data);
			$id = $this->db->insert_id();
			$penduduk_baru = $id;
		}

		// Update nik_kepala dan id_cluster di keluarga apabila baris ini kepala keluarga
		// dan sudah ada NIK
		if ($data['kk_level'] == 1)
		{
      $this->db->where('id', $data['id_kk']);
      $this->db->update('tweb_keluarga', array('nik_kepala' => $id, 'id_cluster' => $isi_baris['id_cluster'], 'alamat' => $isi_baris['alamat']));
		}
		return $penduduk_baru;
	}

	private function hapus_data_penduduk()
	{
		$tabel_penduduk = array('tweb_wil_clusterdesa', 'tweb_keluarga', 'tweb_penduduk', 'log_bulanan', 'log_keluarga', 'log_penduduk', 'log_perubahan_penduduk', 'log_surat', 'tweb_rtm');
		foreach ($tabel_penduduk as $tabel)
		{
			$this->db->empty_table($tabel);
		}
	}

	private function cari_baris_pertama($data, $baris)
	{
		if ($baris <=1 )
			return 0;

		$baris_pertama = 1;
		for ($i=2; $i<=$baris; $i++)
		{
			// Baris dengan kolom dusun = '###' menunjukkan telah sampai pada baris data terakhir
			if ($data->val($i,1) == '###')
			{
				$baris_pertama = $i - 1;
				break;
			}
			// Baris dengan dusun/rw/rt kosong menandakan baris tanpa data
			if ($data->val($i, 1) == '' AND $data->val($i, 2) == '' AND $data->val($i, 3) == '')
			{
				continue;
			}
			else
			{
				// Ketemu baris data pertama
				$baris_pertama = $i;
				break;
			}
		}
		return $baris_pertama;
	}

	public function import_excel($hapus=false)
	{
		$_SESSION['error_msg'] = '';
		$_SESSION['success'] = 1;
		if ($this->file_import_valid() == false)
		{
			return;
		}

		$data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);

		// membaca jumlah baris dari data excel
		$baris = $data->rowcount($sheet_index = 0);
		if ($this->cari_baris_pertama($data, $baris) <= 1)
		{
			$_SESSION['error_msg'] .= " -> Tidak ada data";
			$_SESSION['success'] = -1;
			return;
		}
		$baris_data = $baris;

		$this->db->query("SET character_set_connection = utf8");
		$this->db->query("SET character_set_client = utf8");

		// Pengguna bisa menentukan apakah data penduduk yang ada dihapus dulu
		// atau tidak sebelum melakukan impor
		if ($hapus) { $this->hapus_data_penduduk(); }

		$gagal = 0;
		$baris_gagal = "";
		$baris_kosong = 0;
		// Import data excel mulai baris ke-2 (karena baris pertama adalah nama kolom)
		for ($i=2; $i<=$baris; $i++)
		{
			// Baris dengan kolom dusun = '###' menunjukkan telah sampai pada baris data terakhir
			if($data->val($i, 1) == '###')
			{
				$baris_data = $i - 1;
				break;
			}

			// Baris dengan dusun/rw/rt kosong menandakan baris tanpa data
			if ($data->val($i, 1) == '' AND $data->val($i, 2) == '' AND $data->val($i, 3) == '')
			{
				$baris_kosong++;
				continue;
			}

			$isi_baris = $this->get_isi_baris($data, $i);
			$error_validasi = $this->data_import_valid($isi_baris);
			if (empty($error_validasi))
			{
				$this->tulis_tweb_wil_clusterdesa($isi_baris);
				$this->tulis_tweb_keluarga($isi_baris);
				$this->tulis_tweb_penduduk($isi_baris);
			}
			else
			{
				$gagal++;
				$baris_gagal .= $i." (".$error_validasi.")<br>";
			}
		}

		$sukses = $baris_data - $baris_kosong - $gagal - 1;

		if ($gagal==0)
			$baris_gagal = "tidak ada data yang gagal di import.";
		else $_SESSION['success'] = -1;

		$_SESSION['gagal'] = $gagal;
		$_SESSION['sukses'] = $sukses;
		$_SESSION['baris'] = $baris_gagal;
	}

	/* 	====================
			Selesai IMPORT EXCEL
			====================
	*/

	public function import_bip($hapus=false)
	{
		$_SESSION['error_msg'] = '';
		$_SESSION['success'] = 1;
		if ($this->file_import_valid() == false)
		{
			return;
		}

		$data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);

		$this->db->query("SET character_set_connection = utf8");
		$this->db->query("SET character_set_client = utf8");

		// Pengguna bisa menentukan apakah data penduduk yang ada dihapus dulu
		// atau tidak sebelum melakukan impor
		if ($hapus) { $this->hapus_data_penduduk(); }

	  require_once APPPATH.'/models/Bip_model.php';
		$bip = new BIP_Model($data);
		$bip->impor_bip();
	}

	// Impor Pengelompokan Data Rumah Tangga
	public function pbdt_individu()
	{
		$data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);

		$sheet = 0;
		$baris = $data->rowcount($sheet_index = $sheet);
		$kolom = $data->colcount($sheet_index = $sheet);

		$gg = 0;
		for ($i=2; $i<=$baris; $i++)
		{
			//ID RuTa
			$id_rtm	= $data->val($i, 2, $sheet);

			//Level
			$rtm_level = $data->val($i, 3, $sheet);
			if ($rtm_level > 1) $rtm_level = 2;

			//NIK
			$nik = $data->val($i, 1, $sheet);

			$sql = "SELECT nama FROM tweb_penduduk WHERE nik = ?";
			$query = $this->db->query($sql, $nik);
			$pdd = $query->row_array();

			$nama = "--> GAGAL";
			if ($pdd)
			{
				$upd['id_rtm'] = $id_rtm;
				$upd['rtm_level'] = $rtm_level;
				$upd['updated_at'] = date('Y-m-d H:i:s');
				$upd['updated_by'] = $this->session->user;

				$this->db->where('nik', $nik);
				$outp = $this->db->update('tweb_penduduk', $upd);
				$nama = $pdd['nama'];

				echo "<a>".$id_rtm." ".$rtm_level." ".$nik." ".$nama."</a><br>";
			}
			else
			{
				$penduduk = "";
				$penduduk['id_cluster']	= 0;
				$penduduk['status']	= 2;
				$penduduk['nama']	= $data->val($i, 8, $sheet);
				$penduduk['nik'] = $nik;
				$penduduk['id_rtm']	= $id_rtm;
				$penduduk['rtm_level'] = $rtm_level;
				$penduduk['created_by'] = $this->session->user;

				$outp = $this->db->insert('tweb_penduduk', $penduduk);

				echo "<a style='color:#f00;'>".$id_rtm." ".$rtm_level." ".$nik." ".$nama."</a><br>";

				$gg++;
			}
		}

		$a = "TRUNCATE tweb_rtm; ";
		$this->db->query($a);

		$a = "INSERT INTO tweb_rtm (no_kk, nik_kepala) SELECT id_rtm, id FROM tweb_penduduk WHERE tweb_penduduk.id_rtm > 0 AND rtm_level = 1; ";
		$outp = $this->db->query($a);

		$_SESSION['ggl'] = $gg;

		if ($outp) $_SESSION['success'] = 1;
		else $_SESSION['success'] = -1;

		echo "<br>JUMLAH GAGAL : $gg</br>";
		echo "<a href='".site_url()."database/import'>LANJUT</a>";
	}

}

?>
