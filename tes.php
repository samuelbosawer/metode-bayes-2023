

<?php
// Data array dua dimensi contoh
$data_array = array(
    array('nama' => 'John', 'nilai' => 80),
    array('nama' => 'Jane', 'nilai' => 95),
    array('nama' => 'Mike', 'nilai' => 75),
    array('nama' => 'Alice', 'nilai' => 88),
);

// Fungsi pembanding kustom untuk mengurutkan berdasarkan nilai secara descending
function compareByNilai($a, $b) {
    if ($a['nilai'] == $b['nilai']) {
        return 0;
    }
    return ($a['nilai'] < $b['nilai']) ? 1 : -1;
}

// Mengurutkan data array dua dimensi menggunakan usort dengan fungsi pembanding kustom
usort($data_array, 'compareByNilai');

// Output hasil terurut
print_r($data_array);
?>