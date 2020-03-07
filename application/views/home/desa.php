<!-- Perubahan script coding untuk bisa menampilkan SID Home dalam bentuk tampilan bootstrap (AdminLTE)  -->
<style type="text/css">
	.text-white {color: white;}
	.pengaturan {float: left; padding-left: 10px;}
</style>
<div class="content-wrapper">
	<section class='content-header'>
		<h1>Tentang OpenSID</h1>
		<ol class='breadcrumb'>
			<li><a href='<?=site_url()?>'><i class='fa fa-home'></i> Home</a></li>
			<li class='active'>Tentang OpenSID</li>
		</ol>
	</section>
	<section class='content' id="maincontent">
		<div class='row'>
			<div class='col-md'>
				<div class='box box-info'>
				 	<div class='box-body'>
						<div class="col-lg-3 col-xs-3">
							<div class="small-box bg-purple">
								<div class="inner">
									<?php foreach ($dusun as $data): ?>
										<h3><?=$data['jumlah']?></h3>
									<?php endforeach; ?>
									<p>Wilayah Dusun</p>
								</div>
								<div class="icon">
									<i class="ion ion-location"></i>
								</div>
								<a href="<?=site_url('sid_core')?>" class="small-box-footer">Lihat Detail  <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div>
						<div class="col-lg-3 col-xs-3">
							<div class="small-box bg-aqua">
								<div class="inner">
									<?php foreach ($penduduk as $data): ?>
										<h3><?=$data['jumlah']?></h3>
									<?php endforeach; ?>
									<p>Penduduk</p>
								</div>
								<div class="icon">
									<i class="ion ion-person"></i>
								</div>
								<a href="<?=site_url('penduduk/clear')?>" class="small-box-footer">Lihat Detail  <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div>
						<div class="col-lg-3 col-xs-3">
							<div class="small-box bg-green">
								<div class="inner">
									<?php foreach ($keluarga as $data): ?>
										<h3><?=$data['jumlah']?></h3>
									<?php endforeach; ?>
									<p>Keluarga</p>
								</div>
								<div class="icon">
									<i class="ion ion-ios-people"></i>
								</div>
								<a href="<?=site_url('keluarga/clear')?>" class="small-box-footer">Lihat Detail  <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div>
						<div class="col-lg-3 col-xs-3">
							<div class="small-box bg-blue">
								<div class="inner">
										<h3><?=$jumlah_surat?></h3>
									<p>Surat Tercetak</p>
								</div>
								<div class="icon">
									<i class="ion-ios-paper"></i>
								</div>
								<a href="<?=site_url('keluar/clear')?>" class="small-box-footer">Lihat Detail  <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div>
						<div class="col-lg-3 col-xs-3">
							<div class="small-box bg-red">
								<div class="inner">
									<?php foreach ($kelompok as $data): ?>
										<h3><?=$data['jumlah']?></h3>
									<?php endforeach; ?>
									<p>Kelompok</p>
								</div>
								<div class="icon">
									<i class="ion ion-android-people"></i>
								</div>
								<a href="<?=site_url('kelompok/clear')?>" class="small-box-footer">Lihat Detail  <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div>
						<div class="col-lg-3 col-xs-3">
							<div class="small-box bg-gray">
								<div class="inner">
									<?php foreach ($rtm as $data): ?>
										<h3><?=$data['jumlah']?></h3>
									<?php endforeach; ?>
									<p>Rumah Tangga</p>
								</div>
								<div class="icon">
									<i class="ion ion-ios-home"></i>
								</div>
								<a href="<?=site_url('rtm/clear')?>" class="small-box-footer">Lihat Detail  <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div>
						<div class="col-lg-3 col-xs-3">
							<div class="small-box bg-yellow">
								<div class="inner">
									<h3><?=$bantuan['jumlah']?></h3>
									<p><?=$bantuan['nama']?></p>
								</div>
								<div class="icon">
									<i class="ion ion-ios-pie"></i>
								</div>
								<div class="small-box-footer">
									<?php if ($this->CI->cek_hak_akses('u')): ?>
										<a href="<?= site_url("{$this->controller}/dialog_pengaturan")?>" class="inner text-white pengaturan" title="Pengaturan Program Bantuan" data-remote="false" data-toggle="modal" data-target="#modalBox" data-title="Pengaturan Program Bantuan"><i class="fa fa-gear"></i></a>
									<?php endif; ?>
									<a href="<?=site_url().$bantuan['link_detail']?>" class="inner text-white">Lihat Detail  <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</section>
</div>



