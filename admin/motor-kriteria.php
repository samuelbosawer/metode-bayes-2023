
<?php
   require_once('includes/session-conn.php');
   include('includes/header.php');
   include('includes/sidebar.php'); 

   $id = $_GET['id'];
   $m =mysqli_query($conn,"SELECT * FROM `motor` WHERE `id_motor` = '$id' ");
   $motor = mysqli_fetch_all($m, MYSQLI_ASSOC);

  //  Get data kriteria
   $datas =mysqli_query($conn,"SELECT * FROM `motor`,`kriteria_motor`,`kriteria` WHERE `motor`.`id_motor` = `kriteria_motor`.`id_motor` AND `motor`.`id_motor` = '$id' AND  `kriteria_motor`.`id_kriteria` = `kriteria`.`id_kriteria` ORDER BY motor.id_motor DESC ");
?>






  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Kriteria Motor <?= $motor[0]['alternatif']?> </h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="motor-index">Motor</a></li>
          <li class="breadcrumb-item active">Kriteria Motor</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
    <div class="container">
      <div class="row">
        <div class="col-12 p-3">
        </div>
        <div class="col-12">
          <div class="table-responsive">
            <table id="myTable" class="table  table-hover table-bordered">
              <thead>
                <tr class="bg-dark text-white ">
                  <th scope="col">#</th>
                  <th scope="col">Kriteria</th>
                  <th scope="col">Range Atas</th>
                  <th scope="col">Range Bawah</th>
                </tr>
              </thead>
              <tbody class="">
                <?php $i = 0; foreach($datas as $data) : ?>
                <tr>
                  <th scope="row"><?= ++$i?></th>
                  <td><?= $data['nama_kriteria'] ?></td>
                  <td>
                    <?php if($data['range_atas_m'] == '0')
                      {
                        echo "";
                      }else{
                        echo $data['range_atas_m'];
                      }
                    ?>
                  </td>
                  <td><?= $data['range_bawah_m']?></td>
                </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    </section>

  </main><!-- End #main -->

 

  <?php
   include('includes/footer.php');
?>

