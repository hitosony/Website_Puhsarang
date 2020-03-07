<script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/validasi.js"></script>
<form action="<?= $form_action?>" method="post" id="validasi">
	<div class='modal-body'>
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-group">
							<label class="control-label" for="kode_jawaban">Kode</label>
							<input id="kode_jawaban" class="form-control input-sm required" type="text" placeholder="Kode" name="kode_jawaban" value="<?= $analisis_parameter['kode_jawaban']?>">
						</div>
						<div class="form-group">
							<label class="control-label" for="jawaban">Jawaban</label>
							<textarea  id="jawaban" class="form-control input-sm required" placeholder="Jawaban" name="jawaban"><?= $analisis_parameter['jawaban']?></textarea>
						</div>
						<div class="form-group">
							<label class="control-label" for="nilai">Nilai / Ukuran</label>
							<input id="nilai" class="form-control input-sm required" type="text" placeholder="Nilai" name="nilai" value="<?= $analisis_parameter['nilai']?>">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
   	<button type="reset" class="btn btn-social btn-flat btn-danger btn-sm" data-dismiss="modal"><i class='fa fa-sign-out'></i> Tutup</button>
		<button type="submit" class="btn btn-social btn-flat btn-info btn-sm" id="ok"><i class='fa fa-check'></i> Simpan</button>
	</div>
</form>
