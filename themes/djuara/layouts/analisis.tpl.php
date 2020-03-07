<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view($folder_themes.'/partials/header');?>
	<div class="container">
	<div class="row">
	<div class="col-lg-8 col-md-12 col-12">
		<div id="contentcolumn">
			<div class="innertube">
				<?php
					if($list_jawab){
							echo "<div class='box'>";
							$this->load->view($folder_themes.'/partials/analisis.php');
							echo "</div>";
					}else{ ?>
						<div class="panel">
							<div class="header">
								<h4 class="judul">DAFTAR AGREGASI DATA ANALISIS DESA</h4>
								<h5>Klik untuk melihat lebih detail</h5>
							</div>
							<?php foreach($list_indikator AS $data){?>
								<div class="box-header">
									<a href="<?php echo site_url()?>first/data_analisis/<?php echo $data['id']?>/<?php echo $data['subjek_tipe']?>/<?php echo $data['id_periode']?>">
									<h4><?php echo $data['indikator']?></h4>
									</a>
								</div>
								<div class="box-body" style="font-size:12px;">
									<table>
										<tr>
											<td width="100">Pendataan </td>
											<td width="20"> :</td>
											<td> <?php echo $data['master']?></td>
										</tr>
										<tr>
											<td>Subjek </td>
											<td> : </td>
											<td> <?php echo $data['subjek']?></td>
										</tr>
										<tr>
											<td>Tahun </td>
											<td> :</td>
											<td> <?php echo $data['tahun']?></td>
										</tr>
									</table>
								</div>
							<?php
							}
						} ?>
					</div>
				</div>
			</div>
	</div>
 <div class="col-lg-4 col-md-12 col-12">
    <?php $this->load->view($folder_themes.'/partials/widget.php');?>
  </div>
  </div>
  </div>
<?php $this->load->view($folder_themes.'/partials/footer');?>

