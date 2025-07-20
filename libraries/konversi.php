<?php
function rupiah($angka)
{
    $hasil = "Rp" . number_format($angka, '2', ',', '.');
    return $hasil;
}
function tanggalIndonesia($dateYmd)
{
    $tahun = substr($dateYmd, 0, 4);
    $bulan = substr($dateYmd, 5, 2);
    $tanggal = substr($dateYmd, 8, 2);
    $bulan_indonesia = "";

    switch ($bulan) {
        case '01':
            $bulan_indonesia = "Januari";
            break;
        case '02':
            $bulan_indonesia = "Februari";
            break;
        case '03':
            $bulan_indonesia = "Maret";
            break;
        case '04':
            $bulan_indonesia = "April";
            break;
        case '05':
            $bulan_indonesia = "Mei";
            break;
        case '06':
            $bulan_indonesia = "Juni";
            break;
        case '07':
            $bulan_indonesia = "Juli";
            break;
        case '08':
            $bulan_indonesia = "Agustus";
            break;
        case '09':
            $bulan_indonesia = "September";
            break;
        case '10':
            $bulan_indonesia = "Oktober";
            break;
        case '11':
            $bulan_indonesia = "November";
            break;
        case '12':
            $bulan_indonesia = "Desember";
            break;
    }

    $tanggal_indonesia = $tanggal . " " . $bulan_indonesia . " " . $tahun;

    return $tanggal_indonesia;
}
