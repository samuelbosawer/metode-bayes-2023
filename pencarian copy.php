<?php

session_start();
require_once('conn.php');
// $datas = mysqli_query($conn,"SELECT * FROM motor ORDER BY id_motor DESC");



if(isset($_POST["submit"])){
  // error_reporting(0);
  require_once('bayes.php');
    {
        foreach($result as $res)
        {
          
                $dateTimeNow = date("Y-m-d H:i:s");
                $id_motor = $res['id_motor'];
                $nilai = $res['hasil'];
                $query = "INSERT INTO `rekomendasi` (`id_rekomendasi`, `id_motor`, `nilai`,`tanggal`)  VALUES ('', '$id_motor','$nilai','$dateTimeNow')";
                mysqli_query($conn,$query);
        }


    }
}
// $kriteria = mysqli_query($conn, "SELECT * FROM kriteria WHERE id_kriteria = 'k-1' OR id_kriteria = 'k-2' OR id_kriteria = 'k-7' ;");
$kriteria = mysqli_query($conn, "SELECT * FROM kriteria ");
$sub_kriteria = mysqli_query($conn, "SELECT * 
FROM sub_kriteria;");

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Sistem Pendukung Keputusan Pemilihan Sepeda Motor Baru Menggunakan Metode Bayes </title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <!-- <link href="assets/img/favicon.png" rel="icon"> -->
  <!-- <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon"> -->

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Updated: Mar 10 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/logis-bootstrap-logistics-website-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

 <!-- ======= Header ======= -->
 <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="index" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <!-- <h5 class="fw-bold text-white"></h5> -->
      </a>

      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="index#" class="">Beranda</a></li>
          <li><a href="index#tentang" class="">Tentang Kami</a></li>
          <li class="dropdown "><a href="#"><span>Motor</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
            <ul>
              <li><a href="motor.php?motor=honda">Honda</a></li>
              <li><a href="motor.php?motor=yamaha">Yamaha</a></li>
              <li><a href="motor.php?motor=kawasaki">Kawasaki</a></li>
            
            </ul>
          </li>
          <li><a href="pencarian.php" class="">Pencarian Bayes</a></li>
        </ul>
      </nav><!-- .navbar -->
      <div class="justify-content-right">
        <?php
          if ($_SESSION != null ){
            if ($_SESSION['role'] == '1') {
              echo '
              <a href="logout"  class="btn btn-primary ml-5">Keluar</a>
              <a href="admin" class="btn btn-primary ml-5">Panel</a>
            ';
            }
            if ($_SESSION['role'] == '2') {
              echo '
              <a href="logout" class="btn btn-primary ml-5">Keluar</a>
              <a href="admin-dealer" class="btn btn-primary ml-5">Panel</a>
            ';
            }
          elseif ($_SESSION['role'] == '3')
          {
            echo '<a href="logout" class="btn btn-primary ml-5">Keluar</a>
            <a href="#" class="btn btn-primary ml-5">'.$_SESSION['nama_depan'].'</a>
            <a href="keranjang" class="btn btn-primary ml-5"><i class="bi bi-bag-fill"></i></a>
            <a href="pemesanan" class="btn btn-primary ml-5"><i class="bi bi-card-text"></i></a>
            ' 
            ;
             
          }
          }else{
            echo '
            <a href="login" class="btn btn-primary ml-5">Masuk</a>
            <a href="register" class="btn btn-primary ml-5">Daftar</a>
          ';
          }
        ?>
      </div>
    </div>
  </header><!-- End Header -->
  <!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero d-flex align-items-center">
    <div class="container">
      <div class="row gy-4 text-center">
        <div class="col-lg-12 order-2 order-lg-1 d-flex flex-column justify-content-center">
          <h2 data-aos="fade-up">Pencarian Bayes <i class="bi bi-search"></i>  </h2>
        </div>
      </div>
    </div>
  </section><!-- End Hero Section -->

  <main id="main">

  
    <!-- ======= Call To Action Section ======= -->
    <section class="about pt-5 mt-5 mb-5">
    <div class="container" data-aos="fade-up">

  

<!-- <div class="row gy-4 text-white">
  <div class="col-lg-6">
    <select class="form-select p-3">
      <option selected class="fw-bolder">Pilih Pencarian</option>
      <option value="1">Pencarian Metode Bayes</option>
      <option value="2">Pencarian Biasa</option>
    </select>
  </div> -->
  <div class="row container mt-1">
      <?php if(isset($_POST['submit'])): ?>
        <div class="col-12 text-dark text-center">
          <div class="section-header">
                  <h2 class="">Hasil Rekomendasi ada <?= count($result)?> motor </h2>
          </div>
        </div>
          <div class="table-responsive">
            <table class="table table-striped
            table-hover	
            table-borderless
            ">
              <thead class="table-light">
                <tr>
                  <th>Jenis Motor</th>
                  <th>Class</th>
                  <th>Alternatif</th>
                </tr>
                </thead>
                <tbody class="table-group-divider">
                  <tr class="table-primary" >
                    <td scope="row">Item</td>
                    <td>Item</td>
                    <td>Item</td>
                  </tr>
                 
                </tbody>
                <tfoot>
                  
                </tfoot>
            </table>
          </div>
          
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
              <div class="card">
                <div class="card-img">
                  <?php if($data['gambar'] == null) : ?>
                      <img src="assets/img/motor.png" alt="" class="" width="300" height="200">
                    <?php else :?>
                      <img src="assets/img/data/<?=$data['gambar']?>" alt="" class="" width="300" height="200">
                  <?php endif?>
                </div>
                <div class="p-3"> 
                  <h4 class="mb-0 "><?=$data['alternatif']?></h4>
                  <h5 class="text-dark"> ✅ Hasil perhitungan   <?= $data['hasil']?>  </h5>
                  <!-- <div class="bg-success text-white mb-3 rounded">
                   <div class="p-3">
                       <h4 class="">Perhitungan</h4>
                        <p class="mt-0 mb-0">     <?= $data['perhitungan']?>  </p>
                    </div>
                  </div> -->
                  <div class="">
                  <div class="">
            <?php
          if ($_SESSION != null ){
            if ($_SESSION['role'] == '3') {
                echo '
                <form action="keranjang" class="d-inline-flex" method="POST"> 
                  <input type="hidden" value="'. $data["id_motor"].'" name="id">
                  <button type="submit" class="btn btn-success" name="submit">  <i class="bi bi-bag-fill"></i> Pesan </button>
                </form>
                ';
              }else{
                echo ' <button data-bs-toggle="modal" data-bs-target="#role" class="btn btn-success">  <i class="bi bi-bag-fill"></i> Pesan </button>';
              }
            
            }else{
              echo' <button data-bs-toggle="modal" data-bs-target="#role" class="btn btn-success">  <i class="bi bi-bag-fill"></i> Pesan </button>';
            }?>

            <form action="detail.php" method="post" class="d-inline">
              <input type="hidden" value="<?=$data['perhitungan']?>" name="perhitungan">
              <input type="hidden" value="<?=$data['id_motor']?>" name="id_motor">
              <button type="submit"  class="btn btn-primary">  <i class="bi bi-eye-fill"></i> Detail </button>

            </form>
             
            </div>
                  </div>
                </div>
            
              </div>
            </div><!-- End Card Item -->

        <?php endforeach?>
        <?php else:?>
      <?php endif?>
 </div>
 <form action="" method="post">

  <div class="row container mt-5">
    <div class="row text-center">
    <div class="col-12 ">
            <div class="mb-3">
              <h3>Pencarian Metode Bayes</h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 text-dark">
   
        <?php foreach($kriteria as $k):?>
          <div class="col-12 ">
              <div class="mb-3">
                    <label for="" class="form-label "><?= $k['nama_kriteria']?></label>
                    <div class="input-group">
                    <select class="form-select" name="<?= $k['id_kriteria']?>" id="<?= $k['id_kriteria']?>">
                    <option value="null" id="">Pilih </option>

                            <?php foreach($sub_kriteria as $sk) : ?>
                              <?php if($sk["id_kriteria"] == $k['id_kriteria']): ?>

                                <option value='<?= $sk['id_sub']?>'>
                                    <?php if($sk['satuan'] == 'Rp')
                                    { 
                                      echo number_format( $sk['range_bawah'],0,',','.');
                                    }else 
                                    echo $sk['range_bawah']?>

                                      <?php if($sk['range_bawah'] !== ">" AND  $sk['range_bawah'] !== "<" AND  $sk['range_bawah'] !== '' ) if($sk['range_atas'] != 0  )   echo "-" ?>

                                          
                                        <?php if($sk['range_atas'] != 0  ){
                                          if($sk['satuan'] == 'Rp')
                                          { 
                                            echo number_format( $sk['range_atas'],0,',','.');
                                          }else 
                                          echo $sk['range_atas'];
                                        }
                                        ?>
                                        <?php if($sk['range_atas'] != 0  ) echo "(". $sk['satuan'] . ")"?>

                                  </option>
                              <?php else :?>
                              
                              <?php endif ?>
                            <?php endforeach ?>
                      </select>
                    </div>
                </div>
              </div>
              <?php endforeach?>
             
              
            </div>
            <div class="col-md-4 text-dark  ">
              <div class="text-center">
                <h5>Filter </h5>
              </div>
                <div class="col-12 ">
                <div class="mb-3">
                  <label for="" class="form-label">Merek</label>
                  <select class="form-select " name="merek" id="">
                    <option value="">Pilih</option>
                    <option value="Honda">Honda</option>
                    <option value="Yamaha">Yamaha</option>
                    <option value="Kawasaki">Kawasaki</option>
                  </select>
                </div>
              </div> 
              <div class="col-12 ">
                <div class="mb-3">
                  <label for="" class="form-label">Class Motor</label>
                  <select class="form-select " name="class" id="">
                   <option value="">Pilih</option>
                    <option value="MATIC">MATIC</option>
                    <option value="CUB">CUB</option>
                    <option value="SPORT">SPORT</option>
                  </select>
                </div>
              </div> 
          </div>
            </div>
            
          <button class="btn btn-primary px-5" name="submit" type="submit"> Cari </button>
   
  </div>
                                        
  </form>




  




  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer mt-5">

    <div class="container mt-4">
      <div class="copyright">
        &copy; Copyright <strong><span> </span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/logis-bootstrap-logistics-website-template/ -->
        <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
      </div>
    </div>

  </footer><!-- End Footer -->
  <!-- End Footer -->
<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div class="modal fade" id="role" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleId">Info</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body h1 text-center">
        <?php if ($_SESSION == null ): ?>
         Anda harus login terlebih dahulu !!
      
        <?php else :?>
          Tidak bisa melakukan pemesanan anda buka customer !!
        <?php endif?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Optional: Place to the bottom of scripts -->
<script>
  const myModal = new bootstrap.Modal(document.getElementById('modalId'), options)

</script>
  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script>
      function isIntegerKey(event) {
        // Mendapatkan kode tombol dari event
        var keyCode = event.which ? event.which : event.keyCode;
        
        // Tombol kunci yang diizinkan untuk angka (0-9) dan tombol khusus untuk navigasi dan menghapus (misalnya Backspace, Arrow keys)
        var allowedKeys = [8, 37, 39, 46]; // Backspace, Left Arrow, Right Arrow, Delete
        
        // Memeriksa apakah kode tombol tidak termasuk dalam daftar tombol yang diizinkan
        if ((keyCode < 48 || keyCode > 57) && !allowedKeys.includes(keyCode)) {
          // Mengembalikan false untuk mencegah karakter yang tidak valid dimasukkan
          return false;
        }
      }
</script>
</body>
