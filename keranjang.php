<?php
require_once('conn.php');
session_start();
if ($_SESSION != null ){
    if ($_SESSION['role'] == 1 ) {
      echo "
        <script>
            window.location.href = 'admin/index';
         </script>
      ";
    }elseif ($_SESSION['role'] == 2 ) {
      echo "
        <script>
            window.location.href = 'admin-dealer/index';
         </script>
      ";
    }
   
  } else{
    echo "
    <script>
        window.location.href = 'index';
     </script>
  ";
  };



$id_akun = $_SESSION['id_pendaftaran'];
if(isset($_POST['hapus']))
{
  $id = $_POST['id_pemesanan'];
  $sql = "DELETE FROM `transaksi` WHERE `transaksi`.`id_transaksi` = '$id'";
   $contributors = mysqli_query($conn, $sql);
 
      echo "
        <script>  
          alert('Data  berhasil dihapus !!'); 
          document.location.href = 'index';
        </script>
    
      ";
}



if(isset($_POST['submit']))
{
  $id_m = $_POST['id'];
  $c = mysqli_query($conn,"SELECT * FROM transaksi WHERE id_pendaftaran = '$id_akun' AND status_pemesanan = '0' ");

  $motor= mysqli_query($conn,"SELECT * FROM motor WHERE id_motor = '$id_m' ");
  foreach($motor as $m)
  {
    if($m['harga'] == '')
    {
      echo "
        <script>  
          alert('Belum ada harga motor !!'); 
          document.location.href = 'index';
        </script>
    
      ";
      die;
    }
  }
  


  if($c->num_rows>0)
  {
    echo "
    <script>  
      alert('Data item sudah ada silahkan diselesaikan dulu pemesanannya !'); 
    </script>
  ";
  }else{
    $idCek = mysqli_query($conn,"SELECT * FROM transaksi ORDER BY RIGHT(id_transaksi,3) DESC ");
    $id = mysqli_fetch_all($idCek, MYSQLI_ASSOC);
    $id_transaksi="pm-1";
    if($idCek->num_rows >0)
    {
      $idLama = $id[0]["id_transaksi"];
      if($idLama != null)
      {
        $idNew =   (int) substr($idLama, 3, 5);
        ++$idNew;
        $id_transaksi = 'pm-'.$idNew;
      }
    }
    $query = "INSERT INTO transaksi (`id_transaksi`, `id_motor`,`status_pemesanan`,`id_pendaftaran`)  VALUES ('$id_transaksi','$id_m','0','$id_akun')";
    mysqli_query($conn,$query);
  }
}

$cek = mysqli_query($conn,"SELECT * FROM transaksi WHERE id_pendaftaran = '$id_akun' AND status_pemesanan = '0' ");
if($cek->num_rows == 0) {
    echo "
    <script>  
      alert('Data belum ada !!'); 
      document.location.href = 'index';
    </script>

  ";
 }
 





require_once 'vendor/autoload.php';

  


//Set Your server key
Midtrans\Config::$serverKey = 'SB-Mid-server-CPFhEb941poDUZmwImeJ-GiQ';
$clientKey = 'SB-Mid-client-BUTGasgCVx-oE9Fj';

// Uncomment for production environment
// Midtrans\Config::$isProduction = true;

// Enable sanitization
Midtrans\Config::$isSanitized = true;

// Enable 3D-Secure
Midtrans\Config::$is3ds = true;

// Uncomment for append and override notification URL
// Midtrans\Config::$appendNotifUrl = "https://example.com";
// Midtrans\Config::$overrideNotifUrl = "https://example.com";
// Required
$datas = mysqli_query($conn,"SELECT * FROM `transaksi`, `motor`, `pendaftaran` WHERE transaksi.id_pendaftaran = '$id_akun' AND transaksi.status_pemesanan = '0' AND motor.id_motor = transaksi.id_motor AND pendaftaran.id_pendaftaran = '$id_akun' ");
$id = mysqli_fetch_all($datas, MYSQLI_ASSOC);

// Required
foreach($datas as $data)
{
  

  
  $transaction_details = array(
    'order_id' => rand(),
    'gross_amount' => $data['harga'], // no decimal allowed for creditcard
);

// Optional
$item1_details = array(
    'id' => $data['id_motor'],
    'price' => $data['harga'],
    'quantity' => 1,
    'name' => $data['alternatif'],
);

}


// Optional
$item_details = array($item1_details);
$dc = mysqli_query($conn,"SELECT * FROM `pendaftaran` WHERE id_pendaftaran = '$id_akun' ");
$dataCustomer = mysqli_fetch_all($dc, MYSQLI_ASSOC);

// Optional
$billing_address = array(
    'first_name'    =>  $dataCustomer[0]['nama_depan'],
    'last_name'     =>  $dataCustomer[0]['nama_belakang'],
    'address'       =>  $dataCustomer[0]['alamat_jalan'],
    'city'          =>  $dataCustomer[0]['alamat_distrik'].' '.$dataCustomer[0]['alamat_kelurahan'],
    'postal_code'   =>  "99123",
    'phone'         =>  "",
    'country_code'  => 'IDN'
);

// Optional
$shipping_address = array(
    'first_name'    => "Dealer",
    'last_name'     => "",
    'address'       => "",
    'city'          => "Jayapura",
    'postal_code'   => "99123",
    'phone'         => "08113366345",
    'country_code'  => 'IDN'
);

// Optional
$customer_details = array(
    'first_name'    =>  $dataCustomer[0]['nama_depan'],
    'last_name'     =>  $dataCustomer[0]['nama_belakang'],
    'email'         =>  $dataCustomer[0]['email'],
    'phone'         => "",
    'billing_address'  => $billing_address,
    'shipping_address' => $shipping_address
);

// Optional, remove this to display all available payment methods
$enable_payments = array('bri_va');

// Fill transaction details
$transaction = array(
    'enabled_payments' => $enable_payments,
    'transaction_details' => $transaction_details,
    'customer_details' => $customer_details,
    'item_details' => $item_details,
);

$snapToken = Midtrans\Snap::getSnapToken($transaction);
// echo "snapToken = ".$snapToken;
// if(isset($_POST['bayar']))
// {

// $id_p = $id[0]["id_transaksi"];
// $query = "UPDATE `transaksi` SET `id_midtrans` = '$snapToken', status_pemesanan = '1' WHERE `id_transaksi` = '$id_p';";
// mysqli_query($conn,$query);
// return mysqli_affected_rows($conn);


// }




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
</head>
<body>
    <!-- .row start -->
    <!-- <button id="pay-button">Pay!</button> -->
    <!-- <pre><div id="result-json">JSON result will appear here after payment:<br></div></pre>  -->
<!-- <script type="text/javascript"> -->

</script>
<!-- .col start -->
<div class="col-6 mx-auto my-5 text-center">
    <h1 class="display-4 fw-bolder text-dark">
        <i class="fa-solid fa-cart-shopping me-2"></i> Keranjang 
    </h1>
    <p class="text-muted pt-4">Anda Hanya Dapat Membeli Satu Item </p>
</div>
<!-- .col end -->

<!-- .row end -->
<?php
$datas = mysqli_query($conn,"SELECT * FROM `transaksi`, `motor`, `pendaftaran` WHERE transaksi.id_pendaftaran = '$id_akun' AND transaksi.status_pemesanan = '0' AND motor.id_motor = transaksi.id_motor AND pendaftaran.id_pendaftaran = '$id_akun' ");
?>

<!-- .row start -->
<div class="container mb-5 ">
        <div class="row justify-content-between">
          <div class="col-lg-6">
            <h4 style="font-weight: 600" class="mb-4">Item Pembelian</h4>
            <?php foreach($datas as $data):?>
            <div class="row m-2">
              <div class="col-2">
                <?php if($data['gambar'] == null) : ?>
                  <img src="assets/img/motor.png" width="40" alt="" />
                <?php else : ?>
                  <img src="assets/img/data/<?= $data['gambar']?>" width="40" alt="" />
                <?php endif ?>
              </div>
              <div class="col-4">
                <h5 style="font-weight: 600" class="m-0"><?= $data['alternatif']?></h5>
                <p class="m-0 text-muted">Rp. <?= number_format($data['harga'],0,',','.') ?></p>
              </div>
            
              <div class="col-2 text-right">
                <form class="d-line" action="" method="POST">
                    <input name="id_pemesanan" type="hidden" value="<?= $data['id_transaksi']?>">
                    <button name="hapus" type="submit" onclick= "return confirm ('Anda yakin ingin hapus data ini ?')" class="btn btn-sm btn-danger" style="color: white">
                      <i class="fas fa-times-circle"></i>
                    </button>
                </form>
              </div>
            </div>
            <?php endforeach ?>
          </div>
          <div class="col-lg-5">
            <div class="card rounded-0 detail">
              <div class="card-body">
                <h5 class="card-title">Informasi Biaya</h5>
                <div class="row mb-3">
                  <div class="col">
                    <h6 class="m-0"><?= $data['alternatif']?></h6>
                  </div>
                  <div class="col d-flex justify-content-end">
                    <h6 class="m-0 align-self-center text-success">
                    Rp. <?= number_format($data['harga'],0,',','.') ?>
                    </h6>
                  </div>
                </div>
               
                <hr />
              
              
                <div class="row mb-3">
                  <div class="col">
                    <h6 class="m-0">Total harga</h6>
                  </div>
                  <div class="col d-flex justify-content-end">
                    <h6 class="m-0 align-self-center text-primary">
                    Rp. <?= number_format($data['harga'],0,',','.') ?>
                    </h6>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col">
                <a href="index.php"
                  type="button "
                  class="btn btn-block btn-secondary"
                
                >
                  Kembali
                </a>
              </div>
              <div class="col">
                <form action="" method="post" class="d-inlien">

                <button
                  type="submit" name="bayar" id="pay-button"
                  class="btn btn-block btn-success"
                  
                >
                  Checkout
                </button>
                </form>
               
              </div>
            </div>
          </div>

         
        </div>
      </div>
<!-- .row end -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo $clientKey; ?>"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function(){
            // SnapToken acquired from previous step
            snap.pay('<?php echo $snapToken?>', {
                // Optional
                onSuccess: function(result){
                    /* You may add your own js here, this is just example */ 
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onPending: function(result){
                    /* You may add your own js here, this is just example */ 
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onError: function(result){
                    /* You may add your own js here, this is just example */ 
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                }
            });
        };

          // For example trigger on button clicked, or any time you need
  var payButton = document.getElementById('pay-button');
  payButton.addEventListener('click', function () {
    // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
    window.snap.pay('<?= $snapToken?>');
    // customer will be redirected after completing payment pop-up
  });
</script>  
</body>
</html>