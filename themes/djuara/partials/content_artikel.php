<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<section class="content">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-12 col-12">
        <div class="panel">
          <div class="header">

            <h4 class="title"><?= $single_artikel['judul'] ?></h4>

          </div>
          <div class=" mt-4 mb-2" style="font-size: 12px;">
            <span>
              <i class="fa fa-calendar"></i>
              <?= tgl_indo($single_artikel['tgl_upload']) ?>&nbsp;
            </span>
            <span>
              <i class="fa fa-user"></i>
              <?= $single_artikel['owner'] ?>&nbsp;
            </span>
            <?php if($single_artikel['kategori']) : ?>
            <span>
              <i class="fa fa-tag"></i>
              <?= $single_artikel['kategori'] ?>&nbsp;
            </span>
            <?php endif ?>
          </div>
          <?php if($single_artikel['gambar'] != '' && is_file(FCPATH.LOKASI_FOTO_ARTIKEL.'sedang_'.$single_artikel['gambar'])) : ?>
          <img src="<?= base_url(LOKASI_FOTO_ARTIKEL.'sedang_'.$single_artikel['gambar']);?>" width="100%">
          <?php endif ?>
          <article class="mt-3 text-justify">
            <?= $single_artikel['isi'] ?>
          </article>

          <?php if($single_artikel['dokumen'] && $single_artikel['dokumen'] != NULL) : ?>
          <div class="py-2 pl-4 mt-5 bg-light align-middle d-flex align-items-center" style="border-left: 3px solid teal">
            <h4 class="h5 font-weight-bold m-0">Dokumen Lampiran</h4>
            <span class="px-3">:</span>
            <div><a class="d-inline-block" href="<?= base_url(LOKASI_DOKUMEN.$single_artikel['dokumen']) ?>"><?= $single_artikel['link_dokumen'] ?></a></div>
          </div>
          <?php endif ?>

          <?php if($single_artikel['gambar1'] && $single_artikel['gambar1'] != NULL) : ?>
          <?php if(is_file(LOKASI_FOTO_ARTIKEL . "sedang_" . $single_artikel['gambar1'])) : ?>
          <figure class="foto-artikel">
            <a href="<?= AmbilFotoArtikel($single_artikel['gambar1'],'sedang') ?>" class="item-foto" class="item-foto" data-fancybox="images">
              <img data-src="<?= AmbilFotoArtikel($single_artikel['gambar1'],'sedang') ?>" alt="<?= $single_artikel['nama'] ?>" class="img-fluid mt-3 lazy" title="<?= $single_artikel['nama'] ?>">
            </a>
          </figure>
          <?php endif ?>
          <?php endif ?>

          <?php if($single_artikel['gambar2'] && $single_artikel['gambar2'] != NULL) : ?>
          <?php if(is_file(LOKASI_FOTO_ARTIKEL . "sedang_" . $single_artikel['gambar2'])) : ?>
          <figure class="foto-artikel">
            <a href="<?= AmbilFotoArtikel($single_artikel['gambar2'],'sedang') ?>" class="item-foto" class="item-foto" data-fancybox="images">
              <img data-src="<?= AmbilFotoArtikel($single_artikel['gambar2'],'sedang') ?>" alt="<?= $single_artikel['nama'] ?>" class="img-fluid mt-1 lazy" title="<?= $single_artikel['nama'] ?>">
            </a>
          </figure>
          <?php endif ?>
          <?php endif ?>

          <?php if($single_artikel['gambar3'] && $single_artikel['gambar3'] != NULL) : ?>
          <?php if(is_file(LOKASI_FOTO_ARTIKEL . "sedang_" . $single_artikel['gambar3'])) : ?>
          <figure class="foto-artikel">
            <a href="<?= AmbilFotoArtikel($single_artikel['gambar3'],'sedang') ?>" class="item-foto" class="item-foto" data-fancybox="images">
              <img data-src="<?= AmbilFotoArtikel($single_artikel['gambar3'],'sedang') ?>" alt="<?= $single_artikel['nama'] ?>" class="img-fluid mt-1 lazy" title="<?= $single_artikel['nama'] ?>">
            </a>
          </figure>
          <?php endif ?>
          <?php endif ?>

         <div class="row">
           <div class="col-12">
          <a class="btn btn-sm btn-primary btn-fb mt-2" id="fb" style="color:white" name="fb_share" href="http://www.facebook.com/sharer.php?u=<?= current_url() ?>" target="_blank"><i class="fa fa-facebook-square"></i>&nbsp;Share</a>
          <a class="btn btn-sm btn-primary btn-twitter ml-1 mt-2" id="rt" style="color: white;" href="http://twitter.com/share?url=<?=current_url()?>" class="twitter-share-button" target="_blank"><i class="fa fa-twitter"></i>&nbsp;Tweet</a>
         <a class="btn btn-sm btn-primary btn-google-plus ml-1 mt-2" id="gpshare" style="color:white" href="https://plus.google.com/share?url=<?= current_url() ?>" target="_blank"><i class="fa fa-google-plus" style="color:white"></i>&nbsp;Bagikan</a>
          <a class="btn btn-sm btn-primary btn-whatsapp mt-2" id="wa_share" style="color:white" href="https://api.whatsapp.com/send?text=<?= current_url() ?>" target="_blank"><i class="fa fa-whatsapp" style="color:white"></i>&nbsp;WhatsApp</a>
          </div>
           </div>
         </div>
          <div class="contact_bottom mt-3">
            <?php if(is_array($komentar)): ?>
               <div class="header mb-4">

            <h4 class="title">Komentar</h4>

          </div>
            <div class="contact_bottom">
              <div class="s-body">
                <?php foreach($komentar AS $data): ?>
                <?php if($data['enabled']==1): ?>
                <table class="table table-bordered table-striped dataTable table-hover nowrap">
                  <thead class="bg-gray disabled color-palette">
                    <tr>
                      <th><i class="fa fa-comment"></i> <?= $data['owner']?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <font color='green'><small><?= tgl_indo2($data['tgl_upload'])?></small></font><br/><?= $data['komentar']?>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <?php endif; ?>
                <?php endforeach; ?>
              </div>
            </div>

            <?php elseif($single_artikel['boleh_komentar']): ?>
            <?php endif; ?>
          </div>
          <div class="form-group group-komentar">
            <?php if($single_artikel['boleh_komentar']): ?>
            <div class="s s-default">
              <!-- Tampilkan hanya jika 'flash_message' ada -->
              <div class="header">
                <h4 class="title">Kirim Komentar</h4>
              </div><hr />

              <?php $label = !empty($_SESSION['validation_error']) ? 'label-danger' : 'label-info'; ?>
              <?php if ($flash_message): ?>
              <div class="s-header <?= $label?>"><?= $flash_message?></div>
              <?php endif; ?>
              <div class="contact_bottom">
                <form class="contact_form form form col-md-8" id="form-komentar" name="form" action="<?= site_url('first/add_comment/'.$single_artikel['id'])?>" method="POST" onSubmit="return validasi(this);">
                  <div class="form-group">
                    <label for="owner" style="margin-right: 20px">Nama</label>
                    <input class="form-control" type="text" name="owner" id="owner" maxlength="100" placeholder="ketik di sini" value="<?= !empty($_SESSION['post']['owner']) ? $_SESSION['post']['owner'] : $_SESSION['nama'] ?>">
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <tr class="komentar alamat">
                    <input class="form-control" type="text" name="email" maxlength="100" placeholder="email@gmail.com" value="<?= $_SESSION['post']['email'] ?>">
                  </div>
                  <div class="form-group">
                    <label for="no_hp" style="margin-right: 20px">No. Hp</label>
                     <input class="form-control" type="text" name="no_hp" id="no_hp" maxlength="15" placeholder="ketik di sini" value="<?= $_SESSION['post']['no_hp'] ?>">
                  </div>
                  <div class="form-group">
                    <label for="komentar">Isi Pesan</label>
                    <textarea name="komentar" id="komentar" class="form-control"><?= $_SESSION['post']['komentar']?></textarea>
                  </div>
                  <table width="100%">
                    <!--
                <tr class="komentar alamat">
                  <td>E-mail</td>
                  <td>
                    <input class="form-group" type="text" name="email" maxlength="100" placeholder="email@gmail.com" value="<?= $_SESSION['post']['email'] ?>">
                  </td>
                </tr>-->
                <tr class="captcha"><td>&nbsp;</td>
                  <td>
                    <img id="captcha" src="<?= base_url().'securimage/securimage_show.php'?>" alt="CAPTCHA Image"/>
                    <a href="#" onclick="document.getElementById('captcha').src = '<?= base_url()."securimage/securimage_show.php?"?>' + Math.random(); return false">[ Ganti gambar ]</a>
                  </td>
                </tr>
                <tr class="captcha_code">
                  <td>&nbsp;</td>
                  <td>
                    <input class="form-control" type="text" name="captcha_code" maxlength="6" value="<?= $_SESSION['post']['captcha_code']?>"/> Isikan kode di gambar
                  </td>
                </tr>
                <tr class="submit">
                  <td>&nbsp;</td>
                  <td><input class="btn btn-primary float-right" type="submit" value="Kirim"></td>
                </tr>
                <tr class="submit">
                  <td><br><br></td>
                </tr>
              </table>
            </form>
          </div>
        </div>
        <?php else: ?>
        <span class='info'></span>
        <?php endif; ?>
      </div>
    </div>

  </div>

  <div class="col-lg-4 col-md-12 col-12">
    <?php $this->load->view($folder_themes.'/partials/widget.php');?>
  </div>
</div>
</div>
</section>