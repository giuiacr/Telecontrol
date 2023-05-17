<?php
 include "../config/conexao.php";
 include "checalogin.php";
 

$sql = "SELECT * FROM produto WHERE fabrica = $login_fabrica";
$result_produto = pg_query($con, $sql);

$filename = 'produto_estagio_giullia.csv';
$file_produto = fopen($filename, 'w');
while ($row = pg_fetch_assoc($result_produto)) {
    fputcsv($file_produto, $row);
}
fclose($file_produto);

$file_name = basename($filename);
$file_size = filesize($filename);

header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="' . $file_name . '"');
header('Content-Length: ' . $file_size);
header('Pragma: no-cache');
header('Expires: 0');
readfile($filename);

exit;