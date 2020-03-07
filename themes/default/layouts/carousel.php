<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!--
	Untuk bisa menghentikan scroller, perlu menambah plugin jquery.pause
	dan mengubah jquery.cycle2.carousel.js, mengikuti contoh di
	https://github.com/malsup/cycle2/issues/178
 -->
<script src="<?= base_url()?>assets/front/js/jquery.pause.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
	    $('.carousel').cycle({
			fx: 'carousel',
			speed: 5000,
			timeout: '1',
			easing: 'linear',
			pauseOnHover: true
		});
	});

	function tampil_artikel(id_artikel){
		href = window.location.href;
		first = '/first';
		url = href.substring(0,href.indexOf(first)+first.length)+'/artikel/'+id_artikel;
		window.location = url;
	}
</script>
<div class="carousel">
  <?php foreach ($slide_artikel as $gambar) : ?>
  	<?php if (is_file(LOKASI_FOTO_ARTIKEL.'kecil_'.$gambar['gambar'])) : ?>
	    <img src="<?= base_url().LOKASI_FOTO_ARTIKEL.'kecil_'.$gambar['gambar']?>" data-artikel="<?= $gambar['id']?>" onclick="tampil_artikel($(this).data('artikel'));">
	   <?php endif; ?>
  <?php endforeach; ?>
</div>