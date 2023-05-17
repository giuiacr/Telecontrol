<?php
 include "../config/conexao.php";
 include "checalogin.php";

$sql = "SELECT * FROM tipo_atendimento WHERE fabrica = $login_fabrica";
$result_atendimento = pg_query($con, $sql);

$filename = 'atendimento_estagio_giullia.csv';
$file_atendimento = fopen($filename, 'w');
while ($row = pg_fetch_assoc($result_atendimento)) {
    fputcsv($file_atendimento, $row);
}
fclose($file_atendimento);

$file_name = basename($filename);
$file_size = filesize($filename);

header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="' . $file_name . '"');
header('Content-Length: ' . $file_size);
header('Pragma: no-cache');
header('Expires: 0');
readfile($filename);

exit;
