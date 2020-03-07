<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta content="utf-8" http-equiv="encoding">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name='viewport' content='width=device-width, initial-scale=1' />
  <meta name='google' content='notranslate' />
  <meta name='theme' content='Djuara' />
  <meta name='designer' content='Kusmanto Pratama' />
  <meta name='theme:designer' content='Kusmanto Pratama' />
  <meta name='theme:version' content='1.3.5' />
  <meta name='keywords' content="sid, sistem informasi desa, web, blog, informasi, website, djuara, desa, kecamatan, kabupaten, indonesia, kampung, <?= $desa['nama_desa']; ?>, <?= $desa['nama_kecamatan']; ?>, <?= $desa['nama_kabupaten']; ?>" />
  <?= (isset($single_artikel['slug']) && $single_artikel['slug'] != "")?'<meta name="slug" content="'.$single_artikel['slug'].'">':'';?>
  <meta property="og:site_name" content="<?= $desa_title ?>"/>
  <meta property="og:type" content="article"/>
  <title><?php
    if ($single_artikel["judul"] == "")
    echo $this->setting->website_title
    . ' ' . ucwords($this->setting->sebutan_desa)
    . (($desa['nama_desa']) ? ' ' . $desa['nama_desa'] : '');
    else echo $single_artikel["judul"]. ' - ' . ucwords($this->setting->sebutan_desa)
    . (($desa['nama_desa']) ? ' ' . $desa['nama_desa'] : '');
    ?></title>

    <?php if(is_file(LOKASI_LOGO_DESA . "favicon.ico")): ?>
    <link rel="shortcut icon" href="<?php echo base_url()?><?php echo LOKASI_LOGO_DESA?>favicon.ico" />
    <?php else: ?>
    <link rel="shortcut icon" href="<?php echo base_url()?>favicon.ico" />
    <?php endif; ?>

    <?php if(isset($single_artikel)): ?>
    <meta property="og:title" content="<?= $single_artikel["judul"];?>"/>
    <meta property="og:url" content="<?= site_url()?>first/artikel/<?= $single_artikel['id'];?>"/>
    <meta property="og:image" content="<?= base_url()?><?= LOKASI_FOTO_ARTIKEL?>sedang_<?= $single_artikel['gambar'];?>"/>
    <meta property="og:description" content="<?= potong_teks($single_artikel['isi'], 300)?> ..."/>
    <?php else: ?>
    <meta property="og:title" content="<?= ucwords($this->setting->sebutan_desa).' '.$desa['nama_desa'];?>"/>
    <meta property="og:url" content="<?= site_url()?>"/>
    <meta property="og:image" content="<?= LogoDesa($desa['logo']);?>"/>
    <meta property="og:description" content="<?= $this->setting->website_title.' '.ucwords($this->setting->sebutan_desa).' '.$desa['nama_desa'];?>"/>
    <?php endif; ?>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url("$this->theme_folder/$this->theme/assets/css/style.css") ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url("$this->theme_folder/$this->theme/assets/css/responsive.css") ?>">
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous"></script>
    <script src="<?= base_url("assets/js/jquery.cycle2.min.js") ?>"></script>
    <script src="<?= base_url("assets/js/jquery.cycle2.carousel.js") ?>"></script>
    <script src="<?= base_url("assets/js/leaflet.js")?>"></script>

    <title><?php $desa_title = trim(ucwords($this->setting->sebutan_desa) . ' ' . $desa['nama_desa']); ?></title>
    <style type="text/css">
    <?php $title = "";?>
    <?php $subjudul = "";?>

  </style>
</head>
<body class="">
  <div class="header-top bg-dark" style="padding: 10px;">
    <div class="container">
      <div class="socials">
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
        <a target="_blank" href="<?= site_url('siteman');?>" class="btn btn-default btn-sm float-right" style="color:#ffffff"><i class="fa fa-user"></i> Login</a>
      </div>
    </div>
  </div>
  <header class="djuara-header">
   <nav class="navbar navbar-expand-lg bg-light" id="navbar">
    <div class="container"><a class="navbar-brand" href="<?= site_url();?>"><img id="logobrand" src="<?= LogoDesa($desa['logo']) ?>" height="50px" width="50px" /></a>
      <div class="desa-identity d-block">
        <h6 class="nama-desa"><?= strtoupper($this->setting->sebutan_desa) ?> <?= strtoupper($desa['nama_desa']); ?></h6>
        <a class="ket-desa"><?= ucfirst($this->setting->sebutan_kecamatan_singkat) ?> 
          <?= ucwords($desa['nama_kecamatan']) ?>
          <?= ucfirst($this->setting->sebutan_kabupaten_singkat) ?>
          <?= ucwords($desa['nama_kabupaten']) ?></a>
        </div>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span class="icon-bar top-bar"></span>
          <span class="icon-bar middle-bar"></span>
          <span class="icon-bar bottom-bar"></span>       
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="<?= site_url('first');?>">Beranda <span class="sr-only">(current)</span></a>
            </li>
            <?php foreach($menu_kiri as $data){?>

            <?php
            $namamenu = $data['nama'];
            $arr = explode(' ',trim($namamenu));

            if($arr[1] == 'Desa'){
            $nama = $arr[0];
          }else{
          $nama = $namamenu;
        }
        ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo site_url("first/kategori/".$data['id']);?>"><?php echo $nama;?></a>
        </li>
        <?php } ?>
        <?php foreach($menu_atas as $data){?>
        <?php  if(count($data['submenu'])>0) :?>
        <?php
        $namamenu = $data['nama'];
        $arr = explode(' ',trim($namamenu));

        if($arr[0] == 'Profil'  || $arr[0] == 'Pemerintahan'){
        $nama = $arr[0];
      }else{
      $nama = $namamenu;
    }
    ?>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $nama;?></a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <?php foreach($data['submenu'] as $submenu): ?>
        <a class="dropdown-item"  href="<?php echo $submenu['link']?>"><?php echo $submenu['nama']?></a>
        <?php endforeach;?>
      </div>
    </li>
    <?php else:?>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo $data['link']?>"><?php echo $data['nama'];?></a>
    </li>
    <?php endif;?>
    <?php } ?>

  </ul>
  <form action="<?= site_url('first');?>" method="get">

    <div class="searchbar">
      <input class="search_input" type="text" name="cari" placeholder="Search...">
      <a href="#" class="search_icon"><i class="fa fa-search"></i></a>
    </div>
  </form>

</div>
</div>

</nav>
</header>

<?php 
if(($this->router->fetch_class() == 'first' || $this->router->fetch_class() == 'index') && $this->router->fetch_method() == 'index' && !isset($_GET['cari'])):?>
<section class="image-slider">
  <div class="bg-jumbotron">
    <div class="glass-blue">
     <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
        <?php $i=1; foreach ($slider_gambar['gambar'] as $gambar) : ?>
        <div class="carousel-item <?= ($i==1)?'active':''?>">
          <?php if(is_file(LOKASI_FOTO_ARTIKEL .'sedang_'.$gambar['gambar'])): ?>
          <img width="100%" id="img-slider" class="d-block w-100" src="<?php echo base_url().$slider_gambar['lokasi'].'sedang_'.$gambar['gambar']?>" data-artikel="<?php echo $gambar['id']?>" onclick="tampil_artikel($(this).data('artikel'));" onerror="this.src='<?= base_url("$this->theme_folder/$this->theme/assets/img/imgslidenotfound.jpg") ?>'">
          <?php else: ?>
            <img width="100%" id="img-slider" class="d-block w-100" src="<?= base_url("$this->theme_folder/$this->theme/assets/img/imgslidenotfound.jpg") ?>" data-artikel="<?php echo $gambar['id']?>" onclick="tampil_artikel($(this).data('artikel'));" onerror="this.src='<?= base_url("$this->theme_folder/$this->theme/assets/img/imgslidenotfound.jpg") ?>'">
          <?php endif;?>
          <!-- <img class="d-block w-100" src="https://via.placeholder.com/1240x450" alt="First slide"> -->
          <div class="carousel-caption d-none d-md-block">
            <h5><?= $gambar['judul'];?></h5>

          </div>
        </div>
        <?php $i++; endforeach;?>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </div>
</div>
</section>
<section class="rtext">
  <div class="running-text bg-dark">
    <div class="container">
      <table>
        <tr>
          <td><div class="label-runningtext">Pengumuman</div></td>
          <td width="100%">
             <?php if (!empty($teks_berjalan)): ?>
          <marquee onmouseover="this.stop()" onmouseout="this.start()">
          <?php foreach ($teks_berjalan AS $teks): ?>
                <?= $teks['teks']?>
                <?php if ($teks['tautan']): ?>
                <?= $teks['judul_tautan']?>
                <?php endif; ?>
        <?php endforeach; ?>
        </marquee>
      <?php endif;?>
        </td>
        </tr>
      </table>
    </div>
  </div>
</section>
<?php else:?>
<section class="banner">
  <div class="image-banner parallax-window" data-parallax="scroll" data-image-src="<?= base_url("$this->theme_folder/$this->theme/assets/img/bg-banner.jpg") ?>">
    <div class="glass">
      <?php $judul = $this->router->fetch_method();?>
      <?php $title = (!empty($judul_kategori))? $judul_kategori : ucfirst($judul); ?>
      <?php $subjudul = end($this->uri->segment_array());?>
      <?php if(is_numeric($subjudul)){
        $subjudul = "";
      }?>

      <?php if (is_array($title)): ?>
      <?php foreach ($title as $item): ?>
      <?php $title= $item ?>
      <?php endforeach; ?>
      <?php endif; ?>
      <h1 class="text-center pt-5"><?= $title;?></h1>
      <h5 class="text-center"><?= str_replace('-', ' ', ucfirst($subjudul));?></h5>

    </div>
  </div>
</section>
<?php endif;?>

  <div class="container">
    <div class="col-12">
      <div class="text-left">
        <div class="bc mt-4">
          <a href="<?= site_url('first');?>"> <i class="fa fa-home"></i> Beranda </a>
          <?php if($title != ""):?>
          <i class="fa fa-chevron-right" style="font-size: 11px;"></i>
          <a><?= $title;?></a>
        <?php endif;?>
        <?php if($subjudul != ""):?>
          <i class="fa fa-chevron-right" style="font-size: 11px;"></i>
          <a><?= $subjudul;?></a>
        <?php endif;?>
        </div>
      </div>
    </div>
  </div>
