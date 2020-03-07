<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<section class="footer-section mt-5" style="font-size: 14px;">
  <div class="footer bg-dark py-3" style="min-height: 100px;color: #ffffff;">
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-6 col-lg-4">
          <div class="logo-footer"> 
            <div class="logo float-left mr-2">
              <img src="<?= LogoDesa($desa['logo']) ?>" width="50px;">
            </div>
            <div class="desa-identity d-block pt-2">
              <h6 class="nama-desa"><?= strtoupper($this->setting->sebutan_desa) ?> <?= strtoupper($desa['nama_desa']); ?></h6>
              <a class="ket-desa"><?= ucfirst($this->setting->sebutan_kecamatan_singkat) ?> 
                <?= ucwords($desa['nama_kecamatan']) ?>
                <?= ucfirst($this->setting->sebutan_kabupaten_singkat) ?>
                <?= ucwords($desa['nama_kabupaten']) ?></a>
              </div>
            </div>
            <div class="desc-footer mt-2 ml-2" style="clear: both;"> 

            <ol class="fa-ul">
             <?php if (!empty($desa['telepon'])): ?>
             <li class="mt-3">
              <span class="fa-li"><i class="fa fa-phone"></i></span> <?= $desa['telepon']?>
            </li>
            <?php endif; ?>
            <?php if (!empty($desa['email_desa'])): ?>
            <li class="">
              <span class="fa-li"><i class="fa fa-envelope"></i></span> <?= $desa['email_desa']?>
            </li>
            <?php endif;?>
            <li class="">
              <span class="fa-li"><i class="fa fa-building"></i></span> <?= $desa['alamat_kantor']?><br><?= ucwords($this->setting->sebutan_kecamatan." ".$desa['nama_kecamatan'])?> <?= ucwords($this->setting->sebutan_kabupaten." ".$desa['nama_kabupaten'])?> Provinsi <?= $desa['nama_propinsi']?> Kode Pos <?= $desa['kode_pos']?>
            </li>
          </ol>
          </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
         <div class="header-footer">
          <h6 class="title mt-2">Ikuti Kami </h6>
        </div>
        <div class="socials pt-3">
          <?php if($sosmed[nested_array_search('Facebook',$sosmed)]['enabled'] == 1 && $sosmed[nested_array_search('Facebook', $sosmed)]['link']) : ?>
          <a class="btn btn-primary btn-sm btn-social btn-fb" href="<?= $sosmed[nested_array_search('Facebook',$sosmed)]['link'] ?>" target="_blank"><i class="fa fa-facebook-f"></i></a>
          <?php endif ?>
          <?php if($sosmed[nested_array_search('Twitter', $sosmed)]['enabled'] == 1 && $sosmed[nested_array_search('Twitter', $sosmed)]['link']) : ?>
          <a class="btn btn-primary btn-sm btn-social" href="<?= $sosmed[nested_array_search('Twitter', $sosmed)]['link'] ?>" target="_blank"><i class="fa fa-twitter"></i></a>
          <?php endif ?>
          <?php if($sosmed[nested_array_search('Google Plus', $sosmed)]['enabled'] == 1 && $sosmed[nested_array_search('Google Plus', $sosmed)]['link']) : ?>
          <a class="btn btn-primary btn-sm btn-social btn-google-plus" href="<?= $sosmed[nested_array_search('Google Plus', $sosmed)]['link'] ?>" target="_blank"><i class="fa fa-google-plus"></i></a>
          <?php endif ?>
          <?php if($sosmed[nested_array_search('Instagram', $sosmed)]['enabled'] == 1 && $sosmed[nested_array_search('Instagram', $sosmed)]['link']) : ?>
          <a class="btn btn-primary btn-sm btn-social btn-instagram" href="<?= $sosmed[nested_array_search('Instagram', $sosmed)]['link'] ?>" target="_blank"><i class="fa fa-instagram"></i></a>
          <?php endif ?>
          <?php if($sosmed[nested_array_search('YouTube', $sosmed)]['enabled'] == 1 && $sosmed[nested_array_search('YouTube', $sosmed)]['link']) : ?>
          <a class="btn btn-primary btn-sm btn-social btn-youtube" href="<?= $sosmed[nested_array_search('YouTube', $sosmed)]['link'] ?>" target="_blank"><i class="fa fa-youtube"></i></a>
          <?php endif ?>
          <?php if($sosmed[nested_array_search('WhatsApp', $sosmed)]['enabled'] == 1 && $sosmed[nested_array_search('WhatsApp', $sosmed)]['link']) : ?>
          <a class="btn btn-primary btn-sm btn-social btn-whatsapp" href="<?= $sosmed[nested_array_search('WhatsApp', $sosmed)]['link'] ?>" target="_blank"><i class="fa fa-whatsapp"></i></a>
          <?php endif ?>
        </div>
      </div>
      <div class="col-12 col-md-12 col-lg-4">
        <div class="header-footer">
          <h6 class="title mt-2">Kategori Artikel</h6>

        </div>
              <?php foreach ($menu_kiri as $data): ?>
              <a style="padding: 5px;" class="badge badge-primary mt-3" href="<?= site_url()."first/kategori/".$data['id']?>"><?= $data['nama']?></a>
              <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
</section>
<section class="bottom-footer" style="padding: 10px;color: #ffffff;background-color: #000000;min-height: 50px">
  <div class="footer-bottom" >
    <div class="container">
      <div class="row"> 
      <div class="col-12 col-md-6">
        <p>&copy; <a target="_blank" href="https://opendesa.id/">OpenDesa</a>, <i clas="fa fa-circle-o"></i> OpenSID  <?= AmbilVersi()?> didukung <a href="https://www.facebook.com/groups/OpenSID/">Komunitas OpenSID</a></p>
      </div>
      <div class="col-12 col-md-6 text-md-right">
       <p>Tema <a href="https://github.com/kusmantopratama/OpenSID-Djuara" id="theme-version">Djuara v.1.0.0</a> Oleh : <a href="https://www.facebook.com/k.tamapratama" id="author-name">Kusasdmanto Pratama</a></p>
                
      </div>
      </div>
    </div>
  </div>
</section>
<!-- Optional JavaScript -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="<?= base_url("$this->theme_folder/$this->theme/assets/js/parallax.js") ?>"></script>
<script src="<?= base_url("$this->theme_folder/$this->theme/assets/js/custom.js") ?>"></script>
<script type="text/javascript">
  window.onscroll = function() {myFunction()};
  
  var navbar = document.getElementById("navbar");
  var sticky = navbar.offsetTop;
  $("#terkini").removeClass('fade');
  function myFunction() {
    if (window.pageYOffset >= sticky) {
      navbar.classList.add("fixed-top")
      $('.bc').hide();
    } else {
      navbar.classList.remove("fixed-top");
      $('.bc').show();

    }
  }




</script>
</body>
</html>





























































































































































<script type="text/javascript">
  var a = $("#theme-version").html();
  var b = $("#author-name").html();
  var sisipi = '<section class="bottom-footer" style="padding: 10px;color: #ffffff;background-color: #000000;min-height: 50px"><div class="footer-bottom" ><div class="container"><div class="row"> <div class="col-12 col-md-6"><p>&copy; <a target="_blank" href="https://opendesa.id/">OpenDesa</a>, <i clas="fa fa-circle-o"></i> OpenSID  <?= AmbilVersi()?> didukung <a href="https://www.facebook.com/groups/OpenSID/">Komunitas OpenSID</a></p></div><div class="col-12 col-md-6 text-md-right"><p>Tema <a href="https://github.com/kusmantopratama/OpenSID-Djuara" id="theme-version">Djuara v.1.0.0 </a> Oleh : <a href="https://www.facebook.com/k.tamapratama" id="author-name">Kusmanto Pratama</a></p></div></div></div></div></section>';
  if(a == "Djuara v.1.0.0" && b == "Kusmanto Pratama"){
    // alert("ok");
  }else{
    // alert("Bangsat Kau");
    //alert(a);
    $('.bottom-footer').remove();
    $('body').append(sisipi);
  }
</script>