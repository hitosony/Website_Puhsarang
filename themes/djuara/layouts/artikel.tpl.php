<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view($folder_themes.'/partials/header');?>
<?php if($single_artikel['id']) : ?>
    <?php $this->load->view($folder_themes.'/partials/content_artikel');?>
    <?php else : ?>
      <?php $this->load->view($folder_themes . '/partials/404') ?>
  <?php endif ?>

<?php $this->load->view($folder_themes.'/partials/footer');?>

