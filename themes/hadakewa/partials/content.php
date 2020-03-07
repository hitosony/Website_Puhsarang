<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php if (count($slide_galeri)>0 OR count($slide_artikel)>0): ?>
<?php $this->load->view($folder_themes."/layouts/slider.php") ?>
<?php endif; ?>

<?php if ($headline): ?>
	<?php $abstrak_headline = potong_teks($headline['isi'], 700) ?>
	<div id="headline" class="box box-danger">
		<div class="box-header with-border">
			<h3 class="box-title">
				<a href="<?= site_url('first/artikel/'.$headline['thn'].'/'.$headline['bln'].'/'.$headline['hri'].'/'.$headline['slug']) ?>"> <?= $headline['judul'] ?></a>
			</h3>
			<div class="pull-right small">
				<?= $headline['owner'].", ". tgl_indo2($headline['tgl_upload'])?>
			</div>
		</div>
		<div class="box-body">
			<?php if ($headline["gambar"] != ""): ?>
				<?php if (is_file(LOKASI_FOTO_ARTIKEL."sedang_".$headline['gambar'])): ?>
					<a class="group2" href="<?= AmbilFotoArtikel($headline['gambar'], 'sedang') ?>" title=""><img src="<?= AmbilFotoArtikel($headline['gambar'], 'sedang') ?>" /></a>
					<?php else: ?>
						<img style="margin-right: 10px; margin-bottom: 5px; float: left;" src="<?= base_url('assets/images/404-image-not-found.jpg') ?>" width="300" height="180"/>
					<?php endif; ?>
				<?php endif; ?>
				<div class="post">
					<?= $abstrak_headline ?>
					<a href="<?= site_url('first/artikel/'.$headline['thn'].'/'.$headline['bln'].'/'.$headline['hri'].'/'.$headline['slug']) ?>">
						<div class="readmore">Selengkapnya <i class="fa fa-arrow-right"></i></a></div>
					</a>
				</div>
			</div>
		</div>
	<?php endif; ?>

<!--
 List Konten
-->
<?php $title = (!empty($judul_kategori))? $judul_kategori : "Artikel Terkini" ?>

<?php if (is_array($title)): ?>
	<?php foreach ($title as $item): ?>
		<?php $title= $item ?>
	<?php endforeach; ?>
<?php endif; ?>

<div class="box box-primary" style="margin-left:.2	5em;">
	<div class="box-header with-border">
		<h3 class="box-title"><?= $title ?></h3>
	</div>
	<div class="box-body">

		<?php if ($artikel): ?>
			<div>
				<ul class="artikel-list artikel-list-in-box">
					<?php foreach ($artikel as $data): ?>
						<?php $abstrak = potong_teks($data['isi'], 300) ?>
						<li class="artikel">
							<h3 class="judul">
								<a href="<?= site_url('first/artikel/'.$data['thn'].'/'.$data['bln'].'/'.$data['hri'].'/'.$data['slug']) ?>"><?= $data["judul"] ?></a>
							</h3>

							<div class="teks">
								<div class="kecil">
									<i class="fa fa-clock-o"></i> <?= tgl_indo2($data['tgl_upload']) ?>
									<i class="fa fa-user"></i> <?= $data['owner'] ?>
									<?php if (trim($data['kategori']) != ''): ?>
										<i class='fa fa-tag'></i> <a href="<?= site_url('first/kategori/'.$data['id_kategori']) ?>"><?= $data['kategori'] ?></a>
									<?php endif; ?>
								</div>
								<div class="img">
									<?php if ($data['gambar']!=''): ?>
										<?php if (is_file(LOKASI_FOTO_ARTIKEL."kecil_".$data['gambar'])): ?>
											<img src="<?= AmbilFotoArtikel($data['gambar'],'kecil') ?>" alt="<?= $data["judul"] ?>"/>
											<?php else: ?>
												<img src="<?= base_url('assets/images/404-image-not-found.jpg') ?>" alt="<?= $data["judul"] ?>" />
											<?php endif;?>
										<?php endif; ?>
									</div>
									<div class="post">
										<?= $abstrak ?>
										<a href="<?= site_url('first/artikel/'.$data['thn'].'/'.$data['bln'].'/'.$data['hri'].'/'.$data['slug']) ?>">
											<div class="readmore">Selengkapnya <i class="fa fa-arrow-right"></i></a></div>
										</a>
									</div>
								</div>
								<br class="clearboth gb"/>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>

		<!--
			Pengaturan halaman
		-->
		<?php else: ?>
			<div class="artikel" id="artikel-blank">
				<div class="box box-warning box-solid">
					<div class="box-header"><h3 class="box-title">Maaf, belum ada data</h3></div>
					<div class="box-body">
						<p>Belum ada artikel yang dituliskan dalam <?= $title ?></p>
						<p>Silakan kunjungi situs web kami dalam waktu dekat.</p>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>

	<?php if ($artikel): ?>
		<div class="box-footer">
			<div>Halaman <?= $p ?> dari <?= $paging->end_link ?></div>
			<ul class="pagination pagination-sm no-margin">
				<?php if ($paging->start_link): ?>
					<li><a href="<?= site_url("first/".$paging_page."/$paging->start_link" . $paging->suffix) ?>" title="Halaman Pertama"><i class="fa fa-fast-backward"></i>&nbsp;</a></li>
				<?php endif; ?>
				<?php if ($paging->prev): ?>
					<li><a href="<?= site_url("first/".$paging_page."/$paging->prev" . $paging->suffix) ?>" title="Halaman Sebelumnya"><i class="fa fa-backward"></i>&nbsp;</a></li>
				<?php endif; ?>

				<?php foreach ($pages as $i): ?>
					<li <?= ($p == $i) ? 'class="active"' : "" ?>>
						<a href="<?= site_url("first/".$paging_page."/$i" . $paging->suffix) ?>" title="Halaman <?= $i ?>"><?= $i ?></a>
					</li>
				<?php endforeach; ?>

				<?php if ($paging->next): ?>
					<li><a href="<?= site_url("first/".$paging_page."/$paging->next" . $paging->suffix) ?>" title="Halaman Selanjutnya"><i class="fa fa-forward"></i>&nbsp;</a></li>
				<?php endif; ?>
				<?php if ($paging->end_link): ?>
					<li><a href="<?= site_url("first/".$paging_page."/$paging->end_link" . $paging->suffix) ?>" title="Halaman Terakhir"><i class="fa fa-fast-forward"></i>&nbsp;</a></li>
				<?php endif; ?>
			</ul>
		</div>
	<?php endif; ?>
</div>
