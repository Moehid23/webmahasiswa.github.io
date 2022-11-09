<?php

require_once __DIR__ . '/vendor/autoload.php';
require 'function.php';
$mahasiswa = query("SELECT * FROM mahasiswa");

$mpdf = new \Mdpf\Mpdf ();
$html - '<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mahasiswa</title>
    <link rel="stylesheet" href="css/print.css">
    </head>
<body>
<h1?>daftar mahasiswa</h1>
<table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No.</th>
            <th>Gambar</th>
            <th>Nama</th>
            <th>NRP</th>
            <th>Jurusan</th>
            <th>Email</th>
        </tr>';
foreach($mahasiswa as $row){
    $html .= '<tr>
    <td>'.$i++.'</td>
    <td><img src="img/'.$row["gambar"].'"width="50"></td>
    <td>'.$row["nama"].'</td>
    <td>'.$row["nrp"].'</td>
    <td>'.$row["email"].'</td>
    <td>'.$row["jurusan"].'</td>
    </tr>';
}
$html .= '</table>
</body>
</html>';
$mpdf->WriteHTML($html);
$mpdf->Output('daftar-mahasisfa.pdf,\Mpdf\Output\Destination::INLINE');
?>
