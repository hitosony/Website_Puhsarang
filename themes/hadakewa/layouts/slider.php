<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<script type="text/javascript">
	$(document).ready(function() {
    $('.slider').cycle({
			pauseOnHover: true,
			// Untuk menghilangkan titik-titik di cycle pager
			pagerTemplate: '<span></span>'
		});
	});
	function tampil_artikel(id_artikel){
		href = window.location.href;
		first = '/first';
		url = href.substring(0,href.indexOf(first)+first.length)+'/artikel/'+id_artikel;
		window.location = url;
	}
</script>

<link type='text/css' href="<?php echo base_url()?>assets/front/css/slider.css" rel='Stylesheet' />

<div class="box">
	<div class="slider">
    <span class="cycle-prev"><img src="<?php echo base_url()?>assets/images/back_button.png" alt="Back"></span> <!-- Untuk membuat tanda panah di kiri slider -->
    <span class="cycle-next"><img src="<?php echo base_url()?>assets/images/next_button.png" alt="Next"></span><!-- Untuk membuat tanda panah di kanan slider -->
    <span class="cycle-pager"></span>  <!-- Untuk membuat tanda bulat atau link pada slider -->
  	<?php foreach ($slider_gambar['gambar'] as $gambar) : ?>
    	<?php if(is_file($slider_gambar['lokasi'].'sedang_'.$gambar['gambar'])) : ?>
		    <img src="<?php echo base_url().$slider_gambar['lokasi'].'sedang_'.$gambar['gambar']?>" data-artikel="<?php echo $gambar['id']?>" onclick="tampil_artikel($(this).data('artikel'));">
		   <?php endif; ?>
	   <?php endforeach; ?>
	</div>
</div>