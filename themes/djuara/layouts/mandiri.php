<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view($folder_themes.'/partials/header');?>
	<div class="container">
	<div class="row">
	<?php
		$views_partial_layout = '';
		switch($m){
			case 1 :
				$views_partial_layout = $folder_themes.'/mandiri/mandiri.php';
				break;
			case 2 :
				$views_partial_layout = $folder_themes.'/mandiri/layanan.php';
				break;
			case 4 :
				$views_partial_layout = $folder_themes.'/mandiri/bantuan.php';
			    break;
			default:
				$views_partial_layout = $folder_themes.'/mandiri/lapor.php';
			}
			$this->load->view($views_partial_layout);
	?>
 <div class="col-lg-4 col-md-12 col-12">
    <?php $this->load->view($folder_themes.'/partials/widget.php');?>
  </div>
  </div>
  </div>
<?php $this->load->view($folder_themes.'/partials/footer');?>

