<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php if($w_cos) : ?>
  <?php foreach($w_cos as $data) : ?>
    <?php if($data['jenis_widget'] == 1) : ?>
      <?php include("donjo-app/views/widgets/".trim($data['isi'])); ?>
      <?php elseif($data['jenis_widget'] == 2): ?>
        <?php include(LOKASI_WIDGET.trim($data['isi'])); ?> 
        <?php else : ?>
          <div class="panel">
          <div class="header">
              <h5 class="title"><?= strip_tags($data['judul']) ?></h5>
            </div>
            <div class="card-body">
              <?= html_entity_decode($data['isi'])  ?>
            </div>
          </div>
    <?php endif ?>
  <?php endforeach ?>
<?php endif ?>