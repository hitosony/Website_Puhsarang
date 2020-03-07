<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view($folder_themes.'/partials/header');?>
	<div class="container">
	<div class="row">
		<div class="col-lg-8 col-md-12 col-12">
			<?php $this->load->view($folder_themes.'/partials/gallery.php');?>
		</div>
		<div class="col-lg-4 col-md-12 col-12">
	    	<?php $this->load->view($folder_themes.'/partials/widget.php');?>
	  	</div>
  	</div>
 	</div>
<?php $this->load->view($folder_themes.'/partials/footer');?>

