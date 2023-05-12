<?php
//EXERCÍCIO 01:

//variáveis:
$nome = "Giullia";
$idade = "22 anos";
$faculdade = "Unimar";
$linguagem = "java";
$empresa = "Telecontrol";


//resolução:
echo "EXERCÍCIOS DE PHP <br> <br> Olá amigos! <br> Meu nome é $nome, tenho $idade, estudo na $faculdade e atualmente estagio na $empresa. <br> Minha linguagem de origem é $linguagem!<br>";

//EXERCÍCIO 02:

//variáveis:
$nota = "10";

//resolução:
if($nota >= 8 && $nota <= 10){
    echo "<br> Sua nota foi $nota! Rendimento: EXCELENTE. <br>";
}
elseif($nota < 8 && $nota > 7){
    echo "Sua nota foi $nota! Rendimento: BOM. <br>";
}
elseif($nota < 7 && $nota > 5){
    echo "Sua nota foi $nota! Rendimento: MÉDIO. <br>";
}
elseif($nota < 5 && $nota > 3){
    echo "Sua nota foi $nota! Rendimento: RUIM. <br>";
}
elseif($nota < 3){
    echo "Sua nota foi $nota! Rendimento: PÉSSIMO. <br>";
}
//EXERCÍCIO 03:

//variáveis:
$mes = "3";

//resolução:

switch($mes) {
    case 1;
    echo "<br> Estamos em Janeiro. <br>";

    break;

    case 2;
    echo "<br> Estamos em Fevereiro. <br>";

    break;

    case 3;
    echo "<br> Estamos em Março. <br>";

    break;

    case 4;
    echo "<br> Estamos em Abril. <br>";

    break;

    case 5;
    echo "<br> Estamos em Maio. <br>";

    break;

    case 6;
    echo "<br> Estamos em Junho. <br>";

    break;

    case 7;
    echo "<br> Estamos em Julho. <br>";

    break;

    case 8;
    echo "<br> Estamos em Agosto. <br>";

    break;

    case 9;
    echo "<br> Estamos em Setembro. <br>";

    break;

    case 10;
    echo "<br> Estamos em Outubro. <br>";

    break;

    case 11;
    echo "<br> Estamos em Novembro. <br>";

    break;

    case 12;
    echo "<br> Estamos em Dezembro. <br>";

    break;
}

//EXECÍCIO 04:


    $i = 1;
    while ($i <= 10) {
        $j = 1;
        echo "<br> Tabuada do $i ";
        while ($j <= 10) {
            echo " <br> $j x $i = " . $j * $i;
            $j += 1;
        }
        echo("<br>");
        $i += 1;
    }