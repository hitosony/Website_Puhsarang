<style type="text/css">
	.nowrap { white-space: nowrap; }
</style>
<div class="content-wrapper">
	<section class="content-header">
		<h1>Laporan Keuangan</h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid')?>"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="<?= site_url('keuangan/laporan')?>">Laporan Keuangan</a></li>
			<li class="active">Grafik Pendapatan Desa</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<div class="row">
			<?php $this->load->view('keuangan/filter_laporan'); ?>
			<div class="col-md-9">
				<?php include("donjo-app/views/keuangan/grafik_r_pd_chart.php"); ?>
			</div>
		</div>
	</section>
</div>

