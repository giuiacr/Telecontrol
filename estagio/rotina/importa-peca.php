 <?php

include ('../../config/conexao.php');

$dir = dirname(__FILE__);
$caminho = $dir . "/pecas_black_new.csv" ;

$content = file_get_contents($caminho);
$linhas = explode("\n", "$content");

foreach($linhas as $linha){
    $limpar = explode(";", $linha);
    $referencia = $limpar[0];
    $descricao = $limpar[1];
    echo $referencia . $descricao;
    $sql_insert = "INSERT INTO peca(referencia, descricao, fabrica) values ('$referencia', '$descricao', '1')";
    echo nl2br($sql_insert);
    $res = pg_query($con, $sql_insert);
}