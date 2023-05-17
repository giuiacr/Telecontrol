<?php
 include "../config/conexao.php";
 include "checalogin.php";

$sql = "SELECT * FROM defeito WHERE fabrica = $login_fabrica";
$result_defeito = pg_query($con, $sql);

$filename = 'defeito_estagio_giullia.csv';
$file_defeito = fopen($filename, 'w');
while ($row = pg_fetch_assoc($result_defeito)) {
    fputcsv($file_defeito, $row);
}
fclose($file_defeito);

$file_name = basename($filename);
$file_size = filesize($filename);

header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="' . $file_name . '"');
header('Content-Length: ' . $file_size);
header('Pragma: no-cache');
header('Expires: 0');
readfile($filename);

exit;
