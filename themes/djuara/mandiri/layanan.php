<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="col-lg-8 col-md-12 col-12">
<div class="panel">
          <div class="header">
            <h4 class="title">DAFTAR REKAM CETAK SURAT</h4>
          </div>
	<table class="table table-striped mt-5">
		<thead>
			<tr>
				<th>No</th>
				<th align="left">Nomor Surat</th>
				<th align="left">Jenis Surat</th>
				<th align="left">Nama Staf</th>
				<th align="left">Tanggal</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($surat_keluar as $data): ?>
				<tr>
					<td align="center" width="2"><?php echo $data['no']?></td>
					<td><?php echo $data['no_surat']?></td>
					<td><?php echo $data['format']?></td>
					<td><?php echo $data['pamong']?></td>
					<td><?php echo tgl_indo2($data['tanggal'])?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div class="teks">
		<?php //$this->load->view('surat/signature.php');?>
	</div>

</div>
</div>