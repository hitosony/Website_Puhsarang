<?php
class Migrasi_1910_ke_1911 extends CI_model {

  public function up()
  {
  	// WNI sebagai nilai default untuk kolom kewarganegaraan
	  $this->dbforge->modify_column('tweb_penduduk', array('warganegara_id' => array('type' => 'TINYINT', 'constraint' => 4, 'null' => false, 'default' => 1)));
	  // Hapus modul yg salah tambah
	  $this->db->where('url', 'dokumen_sekretariat/peraturan_desa')->delete('setting_modul');
	  // Aktifkan submodul Pemetaan
		$submodul_peta = array('88'=>'plan', '89'=>'point', '90'=>'garis', '91'=>'line', '92'=>'area', '93'=>'polygon');
		foreach ($submodul_peta as $key => $submodul)
		{
			$modul_nonmenu = array(
				'id' => $key,
				'modul' => $submodul,
				'url' => $submodul,
				'aktif' => '1',
				'ikon' => '',
				'urut' => '0',
				'level' => '0',
				'parent' => '8',
				'hidden' => '2',
				'ikon_kecil' => ''
			);
			$sql = $this->db->insert_string('setting_modul', $modul_nonmenu) . " ON DUPLICATE KEY UPDATE modul = VALUES(modul), url = VALUES(url), parent = VALUES(parent)";
			$this->db->query($sql);
		}
		// Update view supaya kolom baru ikut masuk
		$this->db->query("DROP VIEW penduduk_hidup");
		$this->db->query("CREATE VIEW penduduk_hidup AS SELECT * FROM tweb_penduduk WHERE status_dasar = 1");
		// Ubah url menu statistik kependudukan
		$this->db->update('setting_modul', array('url' => 'statistik/clear'), array('id' => 27));
		// Ubah kode surat
		$this->db
			->where('url_surat', 'surat_kuasa')
			->where('kode_surat', 'S-43')
			->update('tweb_surat_format', array('kode_surat' => 'S-47'));
		// Tambah surat
		$data = array(
			'nama'=>'Keterangan Kepemilikan Kendaraan',
			'url_surat'=>'surat_ket_kepemilikan_kendaraan',
			'kode_surat'=>'S-48',
			'jenis'=>1);
		$sql = $this->db->insert_string('tweb_surat_format', $data);
		$sql .= " ON DUPLICATE KEY UPDATE
				nama = VALUES(nama),
				url_surat = VALUES(url_surat),
				kode_surat = VALUES(kode_surat),
				jenis = VALUES(jenis)";
		$this->db->query($sql);
		// Tambah surat
		$data = array(
			'nama'=>'Keterangan Kepemilikan Tanah',
			'url_surat'=>'surat_ket_kepemilikan_tanah',
			'kode_surat'=>'S-49',
			'jenis'=>1);
		$sql = $this->db->insert_string('tweb_surat_format', $data);
		$sql .= " ON DUPLICATE KEY UPDATE
				nama = VALUES(nama),
				url_surat = VALUES(url_surat),
				kode_surat = VALUES(kode_surat),
				jenis = VALUES(jenis)";
		$this->db->query($sql);
  	$this->jdih();
  	// Tambah foreign key constraint untuk semua tabel keuangan
		$sql = "SELECT *
	    FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS
	    WHERE CONSTRAINT_NAME = 'id_keuangan_ref_bank_desa_master_fk'
			AND TABLE_NAME = 'keuangan_ref_bank_desa'";
	  $query = $this->db->query($sql);
	  if ($query->num_rows() == 0)
	  {
	  	$tabel_keuangan = array('keuangan_ref_bank_desa', 'keuangan_ref_bel_operasional', 'keuangan_ref_bidang', 'keuangan_ref_bunga', 'keuangan_ref_desa', 'keuangan_ref_kecamatan', 'keuangan_ref_kegiatan', 'keuangan_ref_korolari', 'keuangan_ref_neraca_close', 'keuangan_ref_perangkat', 'keuangan_ref_potongan', 'keuangan_ref_rek1', 'keuangan_ref_rek2', 'keuangan_ref_rek3', 'keuangan_ref_rek4', 'keuangan_ref_sbu', 'keuangan_ref_sumber', 'keuangan_ta_anggaran', 'keuangan_ta_anggaran_log', 'keuangan_ta_anggaran_rinci', 'keuangan_ta_bidang', 'keuangan_ta_desa', 'keuangan_ta_jurnal_umum', 'keuangan_ta_jurnal_umum_rinci', 'keuangan_ta_kegiatan', 'keuangan_ta_mutasi', 'keuangan_ta_pajak', 'keuangan_ta_pajak_rinci', 'keuangan_ta_pemda', 'keuangan_ta_pencairan', 'keuangan_ta_perangkat', 'keuangan_ta_rab', 'keuangan_ta_rab_rinci', 'keuangan_ta_rab_sub', 'keuangan_ta_rpjm_bidang', 'keuangan_ta_rpjm_kegiatan', 'keuangan_ta_rpjm_misi', 'keuangan_ta_rpjm_pagu_indikatif', 'keuangan_ta_rpjm_pagu_tahunan', 'keuangan_ta_rpjm_sasaran', 'keuangan_ta_rpjm_tujuan', 'keuangan_ta_rpjm_visi', 'keuangan_ta_saldo_awal', 'keuangan_ta_spj', 'keuangan_ta_spj_bukti', 'keuangan_ta_spj_rinci', 'keuangan_ta_spj_sisa', 'keuangan_ta_spjpot', 'keuangan_ta_spp', 'keuangan_ta_spp_rinci', 'keuangan_ta_sppbukti', 'keuangan_ta_spppot', 'keuangan_ta_sts', 'keuangan_ta_sts_rinci', 'keuangan_ta_tbp', 'keuangan_ta_tbp_rinci', 'keuangan_ta_triwulan', 'keuangan_ta_triwulan_rinci');
	  	foreach ($tabel_keuangan as $keuangan)
	  	{
				$this->dbforge->add_column(
					$keuangan,
					array("CONSTRAINT `id_{$keuangan}_master_fk` FOREIGN KEY (`id_keuangan_master`) REFERENCES `keuangan_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE")
				);
	  	}
	  }
	  // Ubah dokumen menjadi informasi publik
		$this->db->where('id', 52)->update('setting_modul', array('modul'=>'Informasi Publik', 'aktif'=>'1'));
		$attr = json_encode(array('kategori_publik' => 3)); // Kategori info publik 'Informasi Setiap Saat'
		$this->db->where('kategori', '1')->where('id_pend', '0')
			->update('dokumen', array('attr' => $attr));
		// Aktifkan submodul Kelompok
		$modul_nonmenu = array(
			'id' => 94,
			'modul' => 'Kategori Kelompok',
			'url' => 'kelompok_master',
			'aktif' => '1',
			'ikon' => '',
			'urut' => '0',
			'level' => '0',
			'parent' => '24',
			'hidden' => '2',
			'ikon_kecil' => ''
		);
		$sql = $this->db->insert_string('setting_modul', $modul_nonmenu) . " ON DUPLICATE KEY UPDATE modul = VALUES(modul), url = VALUES(url), parent = VALUES(parent)";
		$this->db->query($sql);
  }
  
  private function jdih()
  {
  	// Penambahan Field Tahun pada table dokumen untuk keperluan filter JDIH
		if ($this->db->table_exists('dokumen'))
		{
			$res = $this->db->get('dokumen')->result_array();
	  	if (!$this->db->field_exists('tahun','dokumen'))
			{
				$fields = array(
	        'tahun' => array(
            'type' => 'INT',
            'constraint' => '4'
	        )
				);
				$this->dbforge->add_column('dokumen',$fields);
				foreach ($res as $v)
				{
					$tgl =  json_decode($v['attr'], TRUE);
          if ($v['kategori'] == 2)
          {
            $tahun = date('Y',strtotime($tgl['tgl_kep_kades']));
          }
          elseif($v['kategori'] == 3)
          {
            $tahun = date('Y',strtotime($tgl['tgl_ditetapkan']));
          }
					$data = array(
						'tahun' => $tahun,
					);
					$this->db->where('id', $v['id']);
					$this->db->update('dokumen', $data);
				}
			}
			else
			{
				foreach ($res as $v)
				{
					$tgl =  json_decode($v['attr'], TRUE);
          if ($v['kategori'] == 2)
          {
            $tahun = date('Y',strtotime($tgl['tgl_kep_kades']));
          }
          elseif($v['kategori'] == 3)
          {
            $tahun = date('Y',strtotime($tgl['tgl_ditetapkan']));
          }
					$data = array(
						'tahun' => $tahun,
					);
					$this->db->where('id', $v['id']);
					$this->db->update('dokumen', $data);
				}
			}
		}
  	// Penambahan table dokumen_kategori untuk dynamic categories dokumen
		if (!$this->db->table_exists('ref_dokumen'))
		{
			$fields = array(
        'id' => array(
          'type' => 'INT',
          'constraint' => 5,
          'unsigned' => TRUE,
          'auto_increment' => TRUE
        ),
        'nama' => array(
          'type' => 'VARCHAR',
          'constraint' => '100'
        )
			);
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->add_field($fields);
			$this->dbforge->create_table('ref_dokumen');
		}
		else
		{
      $this->db->truncate('ref_dokumen');
    }
		$object = array(
			array(
				'id' => 1,
				'nama' => 'Informasi Publik'
			),
			array(
				'id' => 2,
				'nama' => 'SK Kades'
			),
			array(
				'id' => 3,
				'nama' => 'Perdes'
			)
		);
		$this->db->insert_batch('ref_dokumen', $object);
  	// Perubahan Sub Menu pada Sekretariat > SK Kades dan Perdes menjadi Sekretariat > Produk Hukum
		if ($this->db->table_exists('setting_modul'))
		{
			$array = array( 59, 60 );
			$this->db->where_in('id', $array);
			$this->db->delete('setting_modul');
			$object = array(
				'id' => 95,
				'modul' => 'Peraturan Desa',
				'url' => 'dokumen_sekretariat/peraturan_desa',
				'aktif' => 1,
				'ikon' => 'fa-book',
				'urut' => 3,
				'level' => 2,
				'hidden' => 0,
				'ikon_kecil' => '',
				'parent' => 15
			);
			$this->db->insert('setting_modul', $object);
		}
	  // Ganti nama modul yg salah
	  $this->db->where('id', 95)->update('setting_modul', array('modul' => 'Produk Hukum'));
  	// Perbesar kolom 'path' untuk peta wilayah
	  $this->dbforge->modify_column('tweb_wil_clusterdesa', array('path' => array('type' => 'TEXT', 'null' => true)));
	}
}
