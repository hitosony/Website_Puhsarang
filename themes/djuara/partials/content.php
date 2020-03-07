<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<section class="content">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-12 col-12">
        <?php 
      if(($this->router->fetch_class() == 'first' || $this->router->fetch_class() == 'index') && $this->router->fetch_method() == 'index' && !isset($_GET['cari'])):?>
        <div class="panel">
          <div class="header">
            <h4 class="title">Berita Utama</h4>
          </div>
          <div class="headlines">
            <?php if(empty($_GET['cari']) AND $headline AND $this->uri->segment(2) != 'kategori') : ?>
            <?php $abstrak_headline = potong_teks($headline['isi'], 250); ?>
            <?php $url = site_url('first/artikel/'.$headline['thn'].'/'.$headline['bln'].'/'.$headline['hri'].'/'.$headline['slug']) ?>
            <div class="col-12 mt-4 px-0">
              <div class="headline">
                <div class="jumbotron jumbotron">
                  <div class="d-flex justify-content-between">
                    <div class="headline-berita">
                      <?php if(is_file(LOKASI_FOTO_ARTIKEL .'sedang_'.$headline['gambar'])): ?>
                      <img src="<?= base_url(LOKASI_FOTO_ARTIKEL.'sedang_'.$headline['gambar']);?>" width="100%">
                    <?php endif;?>
                      <h2 class="judul-artikel"><a href="<?= $url ?>"><?= $headline['judul'] ?></a></h2>
                      <p><?= $abstrak_headline ?></p>
                    </div>
                    <?php if(is_file(LOKASI_FOTO_ARTIKEL .'kecil_'.$headline['gambar'])) : ?>
                      <div class="headline-gambar d-none d-lg-block">
                        <img data-src="<?= AmbilFotoArtikel($headline['gambar'], 'kecil') ?>" class="img-fluid lazy">
                      </div>

                    <?php endif ?>
                  </div>
                  <a href="<?= $url;?>"><b>Baca Selengkapnya</b></a>
                </div>
              </div>
            </div>

          <?php endif ?>
        </div>

      </div>
      <?php endif;?>


      <?php $title = (!empty($judul_kategori))? $judul_kategori : "Berita Terkini" ?>

      <?php if (is_array($title)): ?>
        <?php foreach ($title as $item): ?>
          <?php $title= $item ?>
        <?php endforeach; ?>
      <?php endif; ?>
        <div class="panel">
          <div class="header">
            <h4 class="title"><?= $title; ?></h4>
          </div>
          <?php if($artikel) : ?>
            <?php foreach($artikel as $data) : ?>
              <?php //$url = site_url('first/artikel/'.$data['id']) ?>
              <?php $url = site_url('first/artikel/'.$data['thn'].'/'.$data['bln'].'/'.$data['hri'].'/'.$data['slug']) ?>
              <?php $abstrak = potong_teks($data['isi'], 180) ?>
              <div class="card">
                <div class="row">
                  <div class="col-12 col-md-4">
                    <?php if($data['gambar'] && is_file(LOKASI_FOTO_ARTIKEL.'kecil_'.$data['gambar'])) : ?>
                      <a href="<?= $url ?>"><img src="<?= AmbilFotoArtikel($data['gambar'],'kecil') ?>" width="100%" height="200px"></a>
                      <?php else:?>
                        <a href="<?= $url ?>"><img src="<?= base_url("$this->theme_folder/$this->theme/assets/img/notfound200.png") ?>" width="100%" height="200px" onerror="this.src='<?= base_url("$this->theme_folder/$this->theme/assets/img/notfound200.png") ?>'"></a>
                      <?php endif;?>
                    </div>
                    <div class="col-12 col-md-8">
                       
                      <a href="<?= $url ?>"><h5 class="mt-3 mt-md-0"><b><?= $data['judul'] ?></b></h5></a>
                      <?php if($data['kategori'] && trim($data['kategori'] != '')) : ?>
                       <a href="<?= site_url('first/kategori/' . $data['id_kategori']) ?>">
                          <span class="badge badge-info mb-2"><?= $data['kategori'] ?></span>
                        </a>
                        <?php else:?>
                        <a href="<?= site_url('first/kategori/' . $data['id_kategori']) ?>">
                          <span class="badge badge-info bg-white mb-2">-</span>
                        </a>
                      <?php endif ?>
                      <div class="float-right">
                      <a><i class="fa fa-user mt-2"> <?= $data['owner'] ?></i></a> &nbsp;
                      <a><i class="fa fa-calendar"> <?= tgl_indo($data['tgl_upload']) ?></i></a>&nbsp;
                      </div>
                      <p class="text-justify deskripsi-konten"><?= $abstrak ?>...</p>

                      <a href="<?= $url;?>"><b>Baca Selengkapnya</b></a>
                    </div>
                  </div>

                </div>

                
              <?php endforeach;?>
              <?php else : ?>
                <div class="col-12 text-center pt-3 pb-5 d-flex flex-column">
                  <p>Belum ada artikel yang dituliskan dalam <strong><?= $title ?></strong>.</p>
                  <p>Silakan kunjungi situs web kami dalam waktu dekat.</p>
                </p>
              </div>
            <?php endif ?>

            <?php if($artikel) : ?>
              <?php $paging_page ? $paging_page : $paging_page = 'arsip' ?>
              <?php 
              if ($paging_page == 'arsip') {
                $pages = array();
                for($i=$paging->start_link; $i<=$paging->end_link; $i++) {
                  array_push($pages, $i);
                }
              }
              ?>
              <?php if((int) $paging->end_link > 1) : ?>
                <div class="paging mt-4 mb-5 mx-auto">
                  <div class="col-12 col-sm-12">
                    <div class="halaman-ke">
                      <span>Halaman <?= $p ?> dari <?= $paging->end_link ?></span>
                    </div>
                    <ul class="pagination pagination-md justify-content-center">
                      <?php if($paging->start_link) : ?>
                        <li class="page-item">
                          <a class="btn btn-sm btn-social bg-dark text-white" href="<?= site_url('first/'.$paging_page.'/'.$paging->start_link)?>" class="page-link" title="Halaman Awal">
                            <i class="fa fa-fast-backward"></i>
                          </a>
                        </li>
                      <?php endif ?>
                      <?php foreach ($pages as $i): ?>
                        <li class="page-item <?php ($p == $i) and print('active') ?>">
                          <a class="btn btn-sm btn-social bg-dark text-white" class="page-link" href="<?= site_url('first/'.$paging_page.'/'.$i. $paging->suffix) ?>" title="Halaman <?= $i ?>"><?= $i ?></a>
                        </li>
                      <?php endforeach; ?>
                      <?php if($paging->next) : ?>
                        <li class="page-item">
                          <a class="btn btn-sm btn-social bg-dark text-white" href="<?= site_url('first/'.$paging_page.'/'.$paging->next . $paging->suffix)?>" class="page-link" title="Halaman Selanjutnya">
                            <i class="fa fa-forward"></i>
                          </a>
                        </li>
                      <?php endif ?>
                      <?php if($paging->end_link) : ?>
                        <li class="page-item">
                          <a class="btn btn-sm btn-social bg-dark text-white" href="<?= site_url('first/'.$paging_page.'/'.$paging->end_link . $paging->suffix)?>" class="page-link" title="Halaman Akhir">
                            <i class="fa fa-fast-forward"></i>
                          </a>
                        </li>
                      <?php endif ?>
                    </ul>
                  </div>
                </div>
              <?php endif ?>
            <?php endif ?>
          </div>


      </div>

      <div class="col-lg-4 col-md-12 col-12">
        <?php $this->load->view($folder_themes.'/partials/widget.php');?>
      </div>
    </div>
  </div>
</section>