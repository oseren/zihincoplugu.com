<?php include "include/config.php"; ?>

<?php
function url_slug($str) {

    $turkish_chars = array(
        'ç' => 'c',
        'ğ' => 'g',
        'ı' => 'i',
        'ş' => 's',
        'ö' => 'o',
        'ü' => 'u',
        'Ç' => 'C',
        'Ğ' => 'G',
        'İ' => 'I',
        'Ş' => 'S',
        'Ö' => 'O',
        'Ü' => 'U'
    );

    $str = mb_strtolower(trim($str), 'UTF-8');
    $str = strtr($str, $turkish_chars);
    $str = preg_replace('/[^a-zA-Z0-9]/', ' ', $str);
    $str = trim($str);
    $str = preg_replace('/\s+/', '-', $str);
    return $str;

}

function reverse_url_slug($str) {

    // URL kodlamasını çöz
    $str = urldecode($str);

    $str = trim($str);
    return $str;

}

function month_to_turkish($tarih) {

    $aylar = array(
        'Jan' => 'Ocak',
        'Feb' => 'Şubat',
        'Mar' => 'Mart',
        'Apr' => 'Nisan',
        'May' => 'Mayıs',
        'Jun' => 'Haziran',
        'Jul' => 'Temmuz',
        'Aug' => 'Ağustos',
        'Sep' => 'Eylül',
        'Oct' => 'Ekim',
        'Nov' => 'Kasım',
        'Dec' => 'Aralık'
    );

    return strtr(date('d M Y', strtotime($tarih)), $aylar);
}

$sqlname = $config -> prepare("SELECT websitename,favicon FROM main");
$sqlname -> execute();
$rowname = $sqlname -> get_result();
$dataname = $rowname -> fetch_assoc(); 
?>