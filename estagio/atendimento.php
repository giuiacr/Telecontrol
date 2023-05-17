<?php 
include "../config/conexao.php";
include "checalogin.php";
include "autenticacao.php";

  if(isset($_GET["tipo_atendimento"])){
      
    $atendimento = (int)$_GET["tipo_atendimento"];
  
    $sql = "SELECT * from tipo_atendimento where tipo_atendimento = $atendimento";
    $res = pg_query($con, $sql);
    if(pg_num_rows($res)>0){
      $codigo = pg_fetch_result($res, 0, "codigo");
      $descricao = pg_fetch_result($res, 0, "descricao");
      $ativo = (pg_fetch_result($res, 0, 'ativo') == "t") ? 'true' : 'false';
      
    }
    
    echo "$codigo -- $descricao -- $ativo"; 
    
  }
  

  if ($_POST['btn_gravar'] == 'Gravar') {
      // Recebe as informações do formulário
      $codigo = filter_var($_POST["codigo"], FILTER_SANITIZE_SPECIAL_CHARS);
      $descricao = filter_var($_POST["descricao"], FILTER_SANITIZE_SPECIAL_CHARS);
      $atendimento = (int)$_POST["tipo_atendimento"];
      $ativo = (int)($_POST['checkbox'] == "t") ? 'true' : 'false';
      $erro = array();
    
      //Validação do campo nome
      if(empty($codigo)){
        $erro['codigo']= "O campo codigo é obrigatório <br>";
      }elseif (strlen($codigo) < 9) {
        $erro['codigo']= "O código deve conter pelo menos 9 caracteres <br>";
    }
      // Validação do campo e-mail
      if (empty($descricao)) {
          $erro['descricao']= "O campo descrição é obrigatório <br>";
      }
     
    if (empty($erro)) {
      
      if($atendimento == 0){
        $sql_insert = "INSERT INTO tipo_atendimento(codigo, descricao, ativo, fabrica) values('$codigo', '$descricao', $ativo, $login_fabrica)";
       

      }else{
        $sql_insert = "UPDATE tipo_atendimento SET codigo = '$codigo', descricao = '$descricao', ativo = $ativo WHERE tipo_atendimento = $atendimento";
      }
      $res_insert = pg_query($con, $sql_insert);
      echo nl2br($sql_insert);
      if (strlen(pg_last_error($con)) == 0){
         $sucesso = "Atendimento registrado com sucesso!";
        $codigo = "";
        $descricao = "";
        $atendimento = "";
        $ativo = "";
      }else {
         $erro = "Não foi possível registrar o atendimento!";
      }
    }

  }
  if (isset($_POST['excluir'])){
    $id = $_GET["tipo_atendimento"];
    $sql_delete = "DELETE from tipo_atendimento WHERE tipo_atendimento = $id";
    $res_delete = pg_query($con, $sql_delete);
    $codigo = "";
    $descricao = "";
    $id = "";
    $ativo = "";
    header("Location: atendimento.php");
  }
  
  ?>
<!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Atendimento</title>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="geral.css">
    <link rel="stylesheet" href="css/shadowbox.css" >
    <script src="js/bootstrap.min.js"></script>
    <script src="js/shadowbox.js"></script>
  </head>
  <body class="body">
  <!-- Navbar -->
  <?php include "navbar.php";?>
  <!-- Corpo do site -->
  <class class="container"></class>   
  <div class="col-md-4"></div>

      <div class="col-md-4">
        <div class="panel panel-default panel-product">
          <div class="panel-heading text-center">
            ATENDIMENTO
          </div>
          <div class="panel-body">
            <form method="POST">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="glyphicon glyphicon-barcode"></i>
                </span>
                <input type="text" name="codigo" placeholder="Código" class="form-control <?php echo (!empty($erro['codigo'])) ? 'has-error' : ''; ?>" value="<?=$codigo?>"  maxlength="10">
              </div>
              <?php if (!empty($erro['codigo'])): ?>
                      <div class="text-center alerta" role="alert">
                        <strong> <?= $erro['codigo'] ?> </strong>
                      </div>
                    <?php endif ?> 
              <br>
              <div class="input-group">
              <span class="input-group-addon">
                  <i class="glyphicon glyphicon-menu-hamburger"></i>
                </span>
                <input type="text" name="descricao" placeholder="Descrição" class="form-control <?php echo (!empty($erro['descricao'])) ? 'has-error' : ''; ?>" value="<?=$descricao?>">
              </div>
              <?php if (!empty($erro['descricao'])): ?>
                      <div class="text-center alerta" role="alert">
                        <strong> <?= $erro['descricao'] ?> </strong>
                      </div>
                    <?php endif ?> 
              <br>
              <div class="active-product text-center checkbox">
              <input type="checkbox" name="checkbox" value="t" class="ativo" <?= ($ativo == "true") ? ' checked ' : ''?>> Atendimento ativo
              </div>
              <br>
              </div>
              <div class="text-center">
               <input type="submit" name="btn_gravar" class="btn" value="Gravar">
                <br>
                <br>
              </div>   
              <input type="hidden" name="tipo_atendimento" value="<?=$atendimento ?>">
              <input type="hidden" name="fabrica" value="<?=$login_fabrica ?>">
            </form> 
           
                    <?php if (!empty($sucesso)): ?>
                      <div class="alert alert-success text-center" role="alert">
                        <strong> <?php  echo "$sucesso" ?> </strong>
                      </div>
            <?php endif ?>
            
            <?php if(!empty($erro)): ?>
              <style>
                .has-error {
                  border-color: red;
             }
              </style>
            <?php endif; ?>
  </div>
          </div>
      </div>        
      <div class="container"> 
            <div class="col-2"></div>
            <div class="col-8">
          <div class="panel panel-default panel-table-ruim">
          <table class="table" class="table table-striped table-bordered table-hover table-large table-fixed">
            <?php
             $sql_atendimento = "SELECT * from tipo_atendimento WHERE fabrica = $login_fabrica";
             $res_atendimento = pg_query($con, $sql_atendimento);
             if(pg_num_rows($res_atendimento) > 0) {
             ?>
                  <tr class="titulo_tabela"> 
                      <td>Código</td>
                      <td>Descrição</td>
                      <td>Ativo</td>
                      <td></td>
                      <td><a href="importaatendimentocsv.php"><button class="btn btn-primary">Excel</button></a></td>
                      <td></td>
                  </tr>
                      <?php 
                        for($p=0; $p<pg_num_rows($res_atendimento); $p++){
                          $atendimento = pg_fetch_result($res_atendimento, $p, "tipo_atendimento"); 
                          $codigo = pg_fetch_result($res_atendimento, $p, "codigo"); 
                          $descricao = pg_fetch_result($res_atendimento, $p, "descricao");
                          $ativo = (pg_fetch_result($res_atendimento, $p, "ativo") == "t") ? 'true' : 'false'; 
                              echo "<tr class='conteudo-tabela'>
                                  <td>$codigo</td>
                                  <td>$descricao</td>
                                  <td>$ativo</td>
                                  <td><a href='atendimento.php?tipo_atendimento=$atendimento'><button class=' btn'>Editar</button></a></td>
                                  
                                  <td><a href='atendimento.php?tipo_atendimento=$atendimento'><form action='atendimento.php?tipo_atendimento=$atendimento' method='post'><button type='submit' name='excluir' class=' btn'>Excluir</button></form></a></td> 
                                 
                                  </tr>";
                            }
                          ?>
                        </table>
          </div>
          </div> 
          
          </div>
          <div class="col-2"></div>
         <?php }else{
            $mensagem = "Sem resultados";
            ?>
            <br>
                  <div class="alert alert-danger text-center" role="alert"><strong> <?php  echo "$mensagem" ?></strong></div>
          <?php } ?>
  </body>
    
    
  </html>