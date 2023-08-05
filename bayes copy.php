<?php 
require_once('conn.php');


if($_POST == null)
{
    echo"
    <script>  
          alert('Data Motor tidak di temukan!! '); 
          window.location.href = 'pencarian';
          </script> 
  ";
  die;
}




$bb_pengguna        = null; 
$bb_batas           = null;
$cc_motor           = null;
$k_maksimal         = null;
$k_maksimal_batas   = null;
$k_tengki           = null;
$k_tengki_batas     = null;
$harga              = null;
$harga_batas        = null;
$jarak              = null;
$jarak_batas        = null;
$jalan              = null;
$tinggi             = null;
$tinggi_batas       = null;
foreach($_POST as $post)
{

    if($post !== 'null')
    {
        $subkriteria =mysqli_query($conn,"SELECT * FROM `sub_kriteria` WHERE `sub_kriteria`.`id_sub` = '$post' ");
        foreach($subkriteria as $sk)
        {
            if($sk['satuan'] === 'kg')
            {
                $bb_pengguna = $sk['range_atas'];
                $bb_batas = $sk['range_bawah'];
                
                $bb_query = $bb_batas .' '. $bb_pengguna .' AND';

               
               
            };
            if($sk['satuan'] === 'CC')
            {
                $cc_motor = $sk['range_atas'];
                $cc_motor_batas = $sk['range_bawah'];

                
            };
    
            if($sk['satuan'] === 'kmph')
            {
                $k_maksimal = $sk['range_atas'];
                $k_maksimal_batas = $sk['range_bawah'];
            };
    
            if($sk['satuan'] === 'liter')
            {
                $k_tengki = $sk['range_atas'];
                $k_tengki_batas = $sk['range_bawah'];
            };
    
            if($sk['satuan'] === 'Rp')
            {
                $harga = $sk['range_atas'];
                $harga_batas = $sk['range_bawah'];
            };
    
            if($sk['satuan'] === 'cm')
            {
                $tinggi = $sk['range_atas'];
                $tinggi_batas = $sk['range_bawah'];
            };
    
            if($sk['satuan'] === 'km/jam')
            {
                $jarak = $sk['range_atas'];
                $jarak_batas = $sk['range_bawah'];
            };
    
            if($sk['satuan'] === '')
            {
                $jalan = $sk['range_bawah'];
            };
        }
    }
   

}

    // $motor = mysqli_query($conn,"SELECT * FROM `motor`,`kriteria_motor`,`kriteria` WHERE `motor`.`id_motor` = `kriteria_motor`.`id_motor`  AND  `kriteria_motor`.`id_kriteria` = `kriteria`.`id_kriteria` ORDER BY motor.id_motor DESC ");
    // $motor = mysqli_fetch_all($motor, MYSQLI_ASSOC);
    // var_dump($motor);






$query = "SELECT * FROM `motor`  ";
$merek = $_POST['merek'];
$class = $_POST['class'];
if($merek != null AND $class != null){
    $query = "SELECT * FROM `motor` WHERE class ='$class' AND jenis_motor = '$merek' ";
}

if($merek != null ){
    $query = "SELECT * FROM `motor` WHERE jenis_motor = '$merek' ";
}

if( $class != null){
    $query = "SELECT * FROM `motor` WHERE class ='$class' ";
}

$datas =mysqli_query($conn,$query);
$data = mysqli_fetch_all($datas, MYSQLI_ASSOC);
if($data == null)
{
    echo"
    <script>  
          alert('Data Motor tidak di temukan!! '); 
          window.location.href = 'pencarian';
          </script> 
  ";
  die;
}

foreach($data as $d)
{
    $id_motor = $d['id_motor'];
    $motor_lama = mysqli_query($conn,"SELECT * FROM `motor`,`kriteria_motor`,`kriteria` WHERE `motor`.`id_motor` = `kriteria_motor`.`id_motor` AND `motor`.`id_motor` = '$id_motor' AND  `kriteria_motor`.`id_kriteria` = `kriteria`.`id_kriteria` ORDER BY motor.id_motor DESC ");

    foreach($motor_lama as $m)
    {
        $range_atas = $m['range_atas_m'];
        $range_bawah = $m['range_bawah_m'];
        $nama_kriteria = $m['nama_kriteria'];
        $newString = str_replace(' ', '_', $nama_kriteria);
        $atas = $newString.'_atas';
        $bawah = $newString.'_bawah';
        $d[$atas] =  $range_atas;
        $d[$bawah] =  $range_bawah;
    }
    $motor[] = $d;
}

if($motor == null)
{
    echo"
    <script>  
          alert('Data Motor tidak di temukan!! '); 
          window.location.href = 'pencarian';
          </script> 
  ";
  die;
}


// SORTIR DATA 
$dataSortir = null;
$datas = null;
foreach ($motor as $datas)
{


    // if(
    //     $bb_pengguna != null AND $bb_batas != null 
    //     AND $cc_motor != null
    //     AND  $k_maksimal != null  AND  $k_maksimal_batas  != null
    //     AND  $k_tengki != null AND $k_tengki_batas != null
    //     AND 

    // ) 
    // {

    // }
    $harga_m = true;
    if(isset($datas['Harga_Motor_atas']) && isset($harga) )
     {    
            $harga_m =  $datas['Harga_Motor_atas'] >= (int) $harga  && (int) $datas['Harga_Motor_atas'] <= (int) $harga_batas  ;
         
     }


     $bb = true;
    if(isset($datas['Berat_Badan_Pengguna_atas']) && isset($bb_pengguna))
    {  
    $bb =    $datas['Berat_Badan_Pengguna_atas'] >= $bb_pengguna  && $datas['Berat_Badan_Pengguna_atas'] <= $bb_batas;
    }
       

    $cc = true;
    if(isset($datas['CC_motor_atas']) && isset($cc_motor))
    {  
        $cc = $datas['CC_motor_atas'] == $cc_motor;
            
        if(isset($cc_motor_batas) && $cc_motor_batas != null)
            {
                $cc = ($datas['CC_motor_atas'] >= $cc_motor  && $datas['CC_motor_bawah'] <= $cc_motor_batas);
            }
     }
       
     $kecepatan = true;
    if(isset($datas['Kecepatan_Maksimal_atas']) && isset($k_maksimal))
    { 
        $kecepatan =   $datas['Kecepatan_Maksimal_atas'] >= $k_maksimal  && $datas['Kecepatan_Maksimal_atas'] <= $k_maksimal_batas;
    }
         

    $tengki = true;
    if(isset($datas['Kapasitas_tengki_atas']) && isset($k_tengki))
    { 
        $tengki = $datas['Kapasitas_tengki_atas'] >= $k_tengki  AND $datas['Kapasitas_tengki_atas'] <= $k_tengki_batas;
    }
         

    $jarak_p = true;
     if(isset($datas['Jarak_Pengguna_atas']) && isset($datas['Jarak_Pengguna_bawa']) && isset($jarak))
     {
           $jarak_p = $datas['Jarak_Pengguna_atas'] >= $jarak  AND $datas['Jarak_Pengguna_bawa'] <= $jarak_batas;
     }

    $tinggi_bb = true;
    if(isset($datas['Tinggi_Badan_atas']) && isset($tinggi))
    { 
            $tinggi_bb =  $datas['Tinggi_Badan_atas'] >= $tinggi  AND $datas['Tinggi_Badan_atas'] <= $tinggi_batas;
           
    }

    $jalan_m = true;
    if(isset($datas['kondisi_jalan_yang_dilalui_bawah']) && isset($jalan))
    {
        $jalan_m = ($datas['kondisi_jalan_yang_dilalui_bawah'] == $jalan);
       
    }

        //  if($harga_m && $bb && $tengki && $jarak_p && $tinggi_bb && $kecepatan  )
         if($harga_m && $bb && $tengki && $cc && $kecepatan && $jarak_p && $tinggi_bb && $jalan_m )
         {
             $dataSortir[]  = $datas;
         }



    
    
}

// if(($dataSortir) == null)
// {
//     $dataSortir = $motor;
    
// }


// if($dataSortir == null)
// {
//     echo"
//     <script>  
//           alert('Data Motor tidak di temukan!! '); 
//           window.location.href = 'pencarian';
//           </script> 
//   ";
//   die;
// }

// Perhitungan berdasarkan kriteria 
// $k =mysqli_query($conn,"SELECT * FROM `sub_kriteria`,`kriteria` WHERE `sub_kriteria`.`id_kriteria` = `kriteria`.`id_kriteria` ORDER BY sub_kriteria.id_sub DESC ");
// $kr = mysqli_fetch_all($k, MYSQLI_ASSOC);
$konversi = null;

foreach($dataSortir as $motor)
{

    // $motor['bb_pengguna'] = 0;
    if(isset($motor['Berat_Badan_Pengguna_atas']))
    {
        $bb_pengguna = $motor['Berat_Badan_Pengguna_atas'];
        $k = mysqli_query($conn,"SELECT * FROM `sub_kriteria`,`kriteria` WHERE `sub_kriteria`.`id_kriteria` = `kriteria`.`id_kriteria` AND sub_kriteria.satuan = 'kg' AND range_atas <= $bb_pengguna ");
        foreach($k as $kriteria)
        {
            $motor['bb_pengguna'] = $kriteria['tingkat_kepercayaan'];
        }

        $bb_pengguna = $motor['Berat_Badan_Pengguna_atas'];
        $k = mysqli_query($conn,"SELECT * FROM `sub_kriteria`,`kriteria` WHERE `sub_kriteria`.`id_kriteria` = `kriteria`.`id_kriteria` AND sub_kriteria.satuan = 'kg' AND range_atas >= $bb_pengguna ");
        foreach($k as $kriteria)
        {
            $motor['bb_pengguna'] = $kriteria['tingkat_kepercayaan'];
        }
    
    }else{
        $motor['bb_pengguna'] = 0.11;
    }


    // $motor['cc_motor'] = 0;
    if(isset($motor['CC_motor_atas']))
    {
        $motor['cc_motor'] = 0.7;
        $cc_motor = $motor['CC_motor_atas'];
        $k = mysqli_query($conn,"SELECT * FROM `sub_kriteria`,`kriteria` WHERE `sub_kriteria`.`id_kriteria` = `kriteria`.`id_kriteria` AND sub_kriteria.satuan = 'CC' AND range_atas = $cc_motor ");
        foreach($k as $kriteria)
        {
            $motor['cc_motor'] = $kriteria['tingkat_kepercayaan'];
        }

        $k = mysqli_query($conn,"SELECT * FROM `sub_kriteria`,`kriteria` WHERE `sub_kriteria`.`id_kriteria` = `kriteria`.`id_kriteria` AND sub_kriteria.satuan = 'CC' AND range_atas = $cc_motor ");
        foreach($k as $kriteria)
        {
            $motor['cc_motor'] = $kriteria['tingkat_kepercayaan'];
        }
    
    }else{
        $motor['cc_motor'] = 0.7;

    }  

    // $motor['k_maksimal'] = 0;
    if(isset($motor['Kecepatan_Maksimal_atas']))
    {
        $k_maksimal = $motor['Kecepatan_Maksimal_atas'];
        $k = mysqli_query($conn,"SELECT * FROM `sub_kriteria`,`kriteria` WHERE `sub_kriteria`.`id_kriteria` = `kriteria`.`id_kriteria` AND sub_kriteria.satuan = 'kmph' AND range_atas <= $k_maksimal AND range_bawah >= $k_maksimal ");
        foreach($k as $kriteria)
        {
            $motor['k_maksimal'] = $kriteria['tingkat_kepercayaan'];
        }

        $k_maksimal = $motor['Kecepatan_Maksimal_atas'];
        $k = mysqli_query($conn,"SELECT * FROM `sub_kriteria`,`kriteria` WHERE `sub_kriteria`.`id_kriteria` = `kriteria`.`id_kriteria` AND sub_kriteria.satuan = 'kmph' AND range_atas >= $k_maksimal AND range_bawah <= $k_maksimal ");
        foreach($k as $kriteria)
        {
            $motor['k_maksimal'] = $kriteria['tingkat_kepercayaan'];
        }
    }
  
    // $motor['k_tengki'] = 0;
    if(isset($motor['Kapasitas_tengki_atas']))
    {
        $k_tengki = $motor['Kapasitas_tengki_atas'];
        $k = mysqli_query($conn,"SELECT * FROM `sub_kriteria`,`kriteria` WHERE `sub_kriteria`.`id_kriteria` = `kriteria`.`id_kriteria` AND sub_kriteria.satuan = 'liter' AND range_atas <= $k_tengki AND range_bawah >= $k_tengki ");
        foreach($k as $kriteria)
        {
            $motor['k_tengki'] = $kriteria['tingkat_kepercayaan'];
        }

        $k_tengki = $motor['Kapasitas_tengki_atas'];
        $k = mysqli_query($conn,"SELECT * FROM `sub_kriteria`,`kriteria` WHERE `sub_kriteria`.`id_kriteria` = `kriteria`.`id_kriteria` AND sub_kriteria.satuan = 'liter' AND range_atas >= $k_tengki AND range_bawah <= $k_tengki ");
        foreach($k as $kriteria)
        {
            $motor['k_tengki'] = $kriteria['tingkat_kepercayaan'];
        }
    
    }

    $motor['harga'] = 0;
    if(isset($motor['Harga_Motor_atas']))
    {
        $harga = $motor['Harga_Motor_atas'];
        $k = mysqli_query($conn,"SELECT * FROM `sub_kriteria`,`kriteria` WHERE `sub_kriteria`.`id_kriteria` = `kriteria`.`id_kriteria` AND sub_kriteria.satuan = 'Rp' AND sub_kriteria.range_atas <= $harga AND sub_kriteria.range_bawah >= $harga ");
        foreach($k as $kriteria)
        {
            $motor['harga'] = $kriteria['tingkat_kepercayaan'];
        }

        $k = mysqli_query($conn,"SELECT * FROM `sub_kriteria`,`kriteria` WHERE `sub_kriteria`.`id_kriteria` = `kriteria`.`id_kriteria` AND sub_kriteria.satuan = 'Rp' AND sub_kriteria.range_atas >= $harga AND sub_kriteria.range_bawah <= $harga ");
        foreach($k as $kriteria)
        {
            $motor['harga'] = $kriteria['tingkat_kepercayaan'];
        }
    }
 

    // $motor['tinggi_badan'] = 0;
     if(isset($motor['Tinggi_Badan_atas']))
     {
         // $Tinggi_Badan_bawah =($motor['Tinggi_Badan_bawah']);
         
         $tinggi_badan = $motor['Tinggi_Badan_atas'];
         $k = mysqli_query($conn,"SELECT * FROM `sub_kriteria`,`kriteria` WHERE `sub_kriteria`.`id_kriteria` = `kriteria`.`id_kriteria` AND sub_kriteria.satuan = 'CM' AND range_atas <= $tinggi_badan ");
         foreach($k as $kriteria)
         {
             $motor['tinggi_badan'] = $kriteria['tingkat_kepercayaan'];
         }
 
       
     
     }else{
         $motor['tinggi_badan'] =0.18;
     }
 

    // $motor['jarak_awal'] = 0;
    // $motor['jarak_akhir'] = 0;
    if(isset($motor['Jarak_Pengguna_atas']) AND isset($motor['Jarak_Pengguna_bawah']))
    {
        $jarak_awal = $motor['Jarak_Pengguna_atas'];
        $jarak_akhir = $motor['Jarak_Pengguna_bawah'];
        $k = mysqli_query($conn,"SELECT * FROM `sub_kriteria`,`kriteria` WHERE `sub_kriteria`.`id_kriteria` = `kriteria`.`id_kriteria` AND sub_kriteria.satuan = 'km/jam' AND range_atas >= $jarak_awal AND range_bawah <= $jarak_akhir ");
        foreach($k as $kriteria)
        {
            $motor['jarak_awal'] = $kriteria['tingkat_kepercayaan'];
            $motor['jarak_akhir'] = $kriteria['tingkat_kepercayaan'];
        }

        $k = mysqli_query($conn,"SELECT * FROM `sub_kriteria`,`kriteria` WHERE `sub_kriteria`.`id_kriteria` = `kriteria`.`id_kriteria` AND sub_kriteria.satuan = 'km/jam' AND range_atas <= $jarak_awal AND range_bawah >= $jarak_akhir ");
        foreach($k as $kriteria)
        {
            $motor['jarak_awal'] = $kriteria['tingkat_kepercayaan'];
            $motor['jarak_akhir'] = $kriteria['tingkat_kepercayaan'];
        }
    }
 
    // $motor['kondisi_jalan'] =0;
    if(isset($motor['kondisi_jalan_yang_dilalui_bawah']))
    {
        $kondisi_jalan = $motor['kondisi_jalan_yang_dilalui_bawah'];
        $k = mysqli_query($conn,"SELECT * FROM `sub_kriteria`,`kriteria` WHERE `sub_kriteria`.`id_kriteria` = `kriteria`.`id_kriteria`  AND  range_bawah = '$kondisi_jalan' ");
        foreach($k as $kriteria)
        {
            $motor['kondisi_jalan'] = $kriteria['tingkat_kepercayaan'];
        }
    }

   
    $konversi[] = $motor;

}

if($konversi == null)
{
    echo"
    <script>  
          alert('Data Motor tidak di temukan!! '); 
          window.location.href = 'pencarian';
          </script> 
  ";
  die;
}
// Perhitungan
$k =mysqli_query($conn,"SELECT * FROM `kriteria` ");
$kr = mysqli_fetch_all($k, MYSQLI_ASSOC);

$countKonversi = count($konversi);
$countKriteria = count($kr);
$result = null;
foreach($konversi as $hitung)
{
    $h1 = 1 - $hitung['bb_pengguna'];
    $h2 = 1 - $hitung['cc_motor'];
    $h3 = 1 - $hitung['k_maksimal'];
    $h4 = 1 - $hitung['k_tengki'];
    $h5 = 1 - $hitung['harga'];
    $h6 = 1 - $hitung['tinggi_badan'];
    $h7 = 1 - $hitung['jarak_awal'];
    $h8 = 1 - $hitung['kondisi_jalan'];
    $kk = round($countKriteria/$countKonversi,2);
    $x = ($hitung['bb_pengguna'] * $hitung['cc_motor'] * $hitung['k_maksimal'] * $hitung['k_tengki'] * $hitung['harga'] * $hitung['tinggi_badan'] *  $hitung['jarak_awal'] * $hitung['kondisi_jalan'] ) ;
    $x = $x * $kk;
    $y = ($h1 * $h2 * $h3 * $h4 * $h5 * $h6 * $h7 * $h8 * $kk);

    $tambah = $x + $y ;
    $hasil = $x/$tambah;
    $perhitungan = '('.$hitung['bb_pengguna']. '*' .$hitung['cc_motor'] . '*' . $hitung['k_maksimal'] . '*' . $hitung['k_tengki'] . '*' . $hitung['harga'] . '*' . $hitung['tinggi_badan'] . '*' .  $hitung['jarak_awal'] . '*' . $hitung['kondisi_jalan']  . ')*' . $kk .'<br>/<br> ('.$hitung['bb_pengguna']. '*' .$hitung['cc_motor'] . '*' . $hitung['k_maksimal'] . '*' . $hitung['k_tengki'] . '*' . $hitung['harga'] . '*' . $hitung['tinggi_badan'] . '*' .  $hitung['jarak_awal'] . '*' . $hitung['kondisi_jalan'] .'*'  .$kk.')<br> + <br> ('.$h1 .'*'. $h2. '*'. $h3. '*'. $h4 .'*'. $h5 .'*'. $h6 .'*'. $h7 .'*'. $h8 .'*'. $kk.') = '. round($hasil,6);
  

        $hitung['hasil'] = round($hasil,6);
        $hitung['perhitungan'] = $perhitungan;
        $result[] = $hitung;
       
    
    
}

usort($result, 'compareByNilai');

// Fungsi pembanding kustom untuk mengurutkan berdasarkan nilai secara descending
function compareByNilai($a, $b) {
    if ($a['hasil'] == $b['hasil']) {
        return 0;
    }
    return ($a['hasil'] < $b['hasil']) ? 1 : -1;
}















