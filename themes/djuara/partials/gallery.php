<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="panel">
	<div class="header">
		<h4>Arsip Galeri <?= $desa["nama_desa"];?></h4>
	</div>
	<div class="row">
		<?php $i=1;
		foreach($gallery AS $data):
			if(is_file(LOKASI_GALERI . "sedang_" . $data['gambar'])) : ?>
				<div class="col-4">
					<div class="card">
						<a class="group2" href="<?= AmbilGaleri($data['gambar'],'sedang');?>">
							<img src="<?= AmbilGaleri($data['gambar'],'kecil');?>" style="width: 100%;max-height: 200px">
						</a>
						<a href="<?= site_url()."first/sub_gallery/". $data['id']."\" title=\"".$data["nama"];?>">
							<h6 class="text-center">Judul Album</h6>
						</a>
					</div>
				</div>
			<?php endif;?>
		<?php endforeach;?>
	</div>
	<div class="row mt-3">
		<div class="container">
			<div>Halaman <?= $p;?> dari <?= $paging->end_link;?></div>
			<ul class="pagination pagination-sm no-margin float-right mb-3">
				
				<?php if($paging->start_link){
					echo "<li><a class=\"btn btn-sm btn-primary bg-dark btn-social\" href=\"".site_url("first/gallery/$paging->start_link")."\" title=\"Halaman Pertama\"><i class=\"fa fa-fast-backward\"></i>&nbsp;</a></li>";
				}
				if($paging->prev){
					echo "<li><a class=\"btn btn-sm btn-primary bg-dark btn-social\" href=\"".site_url("first/gallery/$paging->prev")."\" title=\"Halaman Sebelumnya\"><i class=\"fa fa-backward\"></i>&nbsp;</a></li>";
				}

				foreach($pages as $i) {
					$strC = ($p == $i)? "class=\"active\"":"";
					echo "<li ".$strC."><a class=\"btn btn-sm btn-primary bg-dark btn-social\" href=\"".site_url("first/gallery/$i")."\" title=\"Halaman ".$i."\">".$i."</a></li>";
				}

				if($paging->next){
					echo "<li><a class=\"btn btn-sm btn-primary bg-dark btn-social\" href=\"".site_url("first/gallery/$paging->next")."\" title=\"Halaman Selanjutnya\"><i class=\"fa fa-forward\"></i>&nbsp;</a></li>";
				}
				if($paging->end_link){
					echo "<li><a class=\"btn btn-sm btn-primary bg-dark btn-social\" href=\"".site_url("first/gallery/$paging->end_link")."\" title=\"Halaman Terakhir\"><i class=\"fa fa-fast-forward\"></i>&nbsp;</a></li>";
				}
				echo ""; ?>
			</ul>
		</div>
	</div>
</div>
