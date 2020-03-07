<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view($folder_themes.'/partials/header');?>
	<div class="container">
	<div class="row">
	<?php
						if($tipe == 2){
							if($tipex==1){
								$this->load->view($folder_themes.'/statistik/statistik_sos.php');
							}
						}elseif($tipe == 3){
							$this->load->view($folder_themes.'/statistik/wilayah.php');
						}elseif($tipe == 4){
							$this->load->view($folder_themes.'/statistik/dpt.php');
						}else{
							$this->load->view(Web_Controller::fallback_default($this->theme, '/statistik/statistik.php'));
						}
				?>
 <div class="col-lg-4 col-md-12 col-12">
    <?php $this->load->view($folder_themes.'/partials/widget.php');?>
  </div>
  </div>
  </div>
<?php $this->load->view($folder_themes.'/partials/footer');?>

