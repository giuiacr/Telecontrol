<?php
 include "../config/conexao.php";
 include "checalogin.php";


$sql = "SELECT * FROM peca WHERE fabrica = $login_fabrica";
$result_peca = pg_query($con, $sql);

$filename = 'peca_estagio_giullia.csv';
$file_peca = fopen($filename, 'w');
while ($row = pg_fetch_assoc($result_peca)) {
    fputcsv($file_peca, $row);
}
fclose($file_peca);

$file_name = basename($filename);
$file_size = filesize($filename);

header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="' . $file_name . '"');
header('Content-Length: ' . $file_size);
header('Pragma: no-cache');
header('Expires: 0');
readfile($filename);

exit;
