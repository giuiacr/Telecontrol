<?php
include "../config/conexao.php";
include "checalogin.php";
include "autenticacao.php";

?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de OS</title>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="geral.css">
    <link rel="stylesheet" href="css/shadowbox.css" >
    <script src="js/bootstrap.min.js"></script>
    <script src="js/shadowbox.js"></script>
    </head>
   
    <body>
        <!-- Navbar -->
    <?php include "navbar.php";?>
    <!-- Corpo do site -->

<div class="container">
    <div class="row">
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="carrossel.png" alt="...">
      <div class="caption">
      <div class="titulo"><h3 class="text-center">Os benefícios?</h3></div>
        <div class="texto"><p>A coleta seletiva de resíduos sólidos tem como objetivo reduzir o impacto ambiental causado pela produção de resíduos. Ela é responsável por destinar corretamente os materiais para reaproveitamento...</p></div>
        <div class="botao"><p class="text-center"><a href="beneficios.php" class="btn btn-primary" role="button">Saiba mais</a></p></div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="carrossel2.png" alt="...">
      <div class="caption">
      <div class="titulo"><h3 class="text-center">Proteja-se na WEB?</h3></div>
        <div class="texto"><p>Entenda quais perigos nos cercam na internet e como se proteger. Anualmente a comunidade internacional escolhe uma data de Fevereiro para ser o Dia da Internet Segura
          
        ...</p></div>
        <div class="botao"><p class="text-center"><a href="proteger.php" class="btn btn-primary" role="button">Saiba mais</a></p></div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="carrossel3.png" alt="...">
      <div class="caption">
      <div class="titulo"><h3 class="text-center">SAC e Clientes</h3></div>
        <div class="texto"><p>O serviço de atendimento ao cliente é fundamental para conquistar a satisfação e, assim, a fidelização do consumidor. Saiba como tornar seu SAC mais eficiente e aumentar sua retenção...</p></div>
        <div class="botao"><p class="text-center"><a href="materiasac.php" class="btn btn-primary" role="button">Saiba mais</a></p></div>
      </div>
    </div>
  </div>
</div>
</div>

        
    </body>
</html>