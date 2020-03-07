<style type="text/css">
	.nowrap { white-space: nowrap; }
</style>
<div class="content-wrapper">
	<section class="content-header">
		<h1>Impor Data Siskeudes</h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid')?>"><i class="fa fa-home"></i> Home</a></li>
			<li class="active">Impor Data Siskeudes</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<form id="validasi" action="<?= $form_action?>" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="jenis_impor" id="jenis_impor" value="baru">
			<input type="hidden" name="id_keuangan_master" id="id_keuangan_master" value="0">
			<div class='modal-body'>
				<div class="row">
					<div class="col-sm-12">
						<div class="box box-danger">
							<div class="box-body">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="file"  class="control-label">Berkas Database Siskuedes :</label>
										<div class="input-group input-group-sm">
											<input type="text" class="form-control" id="file_path2">
											<input type="file" class="hidden" id="file2" name="keuangan">
											<span class="input-group-btn">
												<button type="button" class="btn btn-info btn-flat"  id="file_browser2"><i class="fa fa-search"></i> Browse</button>
											</span>
										</div>
										<p class="help-block small">Pastikan format berkas .zip berisi data Siskeudes dalam format .csv</p>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-social btn-flat btn-info btn-sm" id="ok" onclick="simpan()"><i class='fa fa-check'></i> Simpan</button>
							</div>

							<hr>
							<div class="row">
								<div class="col-sm-12">
									<h4 class="text-center"><strong>DAFTAR DATA SISKEUDES</strong></h4>
									<div class="table-responsive">
										<table class="table table-bordered table-striped dataTable table-hover nowrap">
											<thead class="bg-gray disabled color-palette">
												<tr>
													<th>No</th>
													<th>Aksi</th>
													<th>Versi</th>
													<th>Tahun Anggaran</th>
													<th>Tanggal Impor</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($main as $data): ?>
													<tr>
														<td><?=$data['no']?></td>
														<td nowrap>
															<a href="#" data-href="<?= site_url("keuangan/delete/$data[id]")?>" class="btn bg-maroon btn-flat btn-sm" title="Hapus" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash-o"></i></a>
														<td><?=$data['versi_database']?></td>
														<td><?=$data['tahun_anggaran']?></td>
														<td><?=tgl_indo_out($data['tanggal_impor'])?></td>
													</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>
</div>

<div class="modal fade in"  id="getCodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title" id="myModalLabel"><i class="fa fa-exclamation-triangle text-red"></i> &nbsp;Konfirmasi</h4>
			</div>
			<div class="modal-body btn-info">
				<p>Data tahun anggaran <span id="tahun"></span> sudah ada pada sistem</p>
				<p>Apakah anda ingin melanjutkan proses impor untuk menindih datanya?</p>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn btn-social btn-flat btn-danger btn-sm" data-dismiss="modal"><i class='fa fa-sign-out'></i> Tutup</button>
				<button type="button" class="btn btn-social btn-flat btn-info btn-sm" onclick="simpanDataUpdate()"><i class='fa fa-check'></i> Lanjutkan impor</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade in"  id="dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header btn-danger">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title" id="myModalLabel"><i class="fa fa-exclamation-triangle"></i> &nbsp;Peringatan</h4>
			</div>
			<div class="modal-body">
				<p id="kata_peringatan"></p>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn btn-social btn-flat btn-danger btn-sm" data-dismiss="modal"><i class='fa fa-sign-out'></i> Tutup</button>
			</div>
		</div>
	</div>
</div>
<div class='modal fade' id='confirm-delete' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
				<h4 class='modal-title' id='myModalLabel'><i class='fa fa-exclamation-triangle text-red'></i> Konfirmasi</h4>
			</div>
			<div class='modal-body btn-info'>
				Apakah Anda yakin ingin menghapus data ini?
			</div>
			<div class='modal-footer'>
				<button type="button" class="btn btn-social btn-flat btn-warning btn-sm" data-dismiss="modal"><i class='fa fa-sign-out'></i> Tutup</button>
				<a class='btn-ok'>
					<button type="button" class="btn btn-social btn-flat btn-danger btn-sm" id="ok-delete"><i class='fa fa-trash-o'></i> Hapus</button>
				</a>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function()
	{
		$('#file2').change(function()
		{
			//on change event
			formdata = new FormData();
			if($(this).prop('files').length > 0)
			{
				file =$(this).prop('files')[0];
				formdata.append("keuangan", file);
			}
		});
	});

	function simpan()
	{
		if ($("#file2").val() == '')
		{
			$("#kata_peringatan").text('Pilih berkas file terlebih dahulu!');
			$("#dialog").modal('show');
			$("#file2").focus();
		}
		else
		{
			$.ajax(
			{
				url: '<?= site_url("keuangan/cek_versi_database")?>',
				type: "POST",
				datatype:"json",
				data: formdata,
				processData: false,
				contentType: false,
				success: function(response) {
					if (response == 0)
					{
						$('#validasi').submit();
					}
					else if (response == 1)
					{
						$("#kata_peringatan").text('File harus dalam format .zip');
						$("#dialog").modal('show');
						$("#file_path2").val('');
						$("#file2").focus();
					}
					else if (response == 2)
					{
						$("#kata_peringatan").text('File tidak berisi data Siskeudes');
						$("#dialog").modal('show');
						$("#file_path2").val('');
						$("#file2").focus();
					}
					else
					{
						var data = jQuery.parseJSON(response);
						$("#id_keuangan_master").val(data.id);
						$("#tahun").text(data.tahun_anggaran);
						$("#getCodeModal").modal('show');
					}
			 	}
			});
		}
	}

	function simpanDataUpdate()
	{
		$("#jenis_impor").val('update');
		$('#validasi').submit();
	}
</script>
