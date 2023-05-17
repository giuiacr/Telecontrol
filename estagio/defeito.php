<?php
include "../config/conexao.php";
include "checalogin.php";
include "autenticacao.php";

if(isset($_GET["defeito"])){
      
  $defeito = (int)$_GET["defeito"];

  $sql = "SELECT * from defeito where defeito = $defeito";
  $res = pg_query($con, $sql);
  if(pg_num_rows($res)>0){
    $codigo = pg_fetch_result($res, 0, "codigo");
    $descricao = pg_fetch_result($res, 0, "descricao");
  }
  
  echo "$codigo -- $descricao";
  
}

if ($_POST['btn_gravar'] == 'Gravar') {
    // Recebe as informações do formulário
    $codigo = filter_var($_POST["codigo"], FILTER_SANITIZE_SPECIAL_CHARS);
    $descricao = filter_var($_POST["descricao"], FILTER_SANITIZE_SPECIAL_CHARS);
    $defeito = (int)$_POST["defeito"];
    $erro = array();

    // Validação do campo senha
    if (empty($codigo)) {
        $erro['codigo']= "O campo código é obrigatório";
    } elseif (strlen($codigo) < 10) {
        $erro['codigo']= "O código deve conter pelo menos 10 caracteres";
    }

    // Validação do campo defeito
    if (empty($descricao)) {
        $erro['descricao']= "O campo descrição é obrigatório";
    }

    if (empty($erro)) {

      if($defeito == 0){
      $sql_insert = "INSERT INTO defeito(codigo, descricao, fabrica) values('$codigo', '$descricao', $login_fabrica)"; 
    }else{
      $sql_insert = "UPDATE defeito SET codigo = '$codigo', descricao = '$descricao' WHERE defeito = $defeito";
    }

    $res_insert = pg_query($con, $sql_insert);
    if(strlen(pg_last_error($con))==0){
      $sucesso = "Cadastro do defeito realizado com sucesso!";
      $codigo = "";
      $descricao = "";
      $defeito = "";
    }else{
      $erro = "Falha ao cadastrar defeito";
    }      
      }    
     }
    if (isset($_POST['excluir'])){
      $id = $_GET["defeito"];
      $sql_delete = "DELETE from defeito WHERE defeito = $id";
      $res_delete = pg_query($con, $sql_delete);
      $codigo = "";
      $descricao = "";
      $id = "";
      header("Location: defeito.php");
    }
  ?>
<!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Defeito</title>
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <script src="js/bootstrap.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <link rel="stylesheet" href="geral.css">
  </head>
  <body class="body">
  <!-- Navbar -->
  <?php include "navbar.php";?>
  <!-- Corpo do site -->
  <div class="container"></div>
  <div class="col-md-4"></div>

      <div class="col-md-4">
        <div class="panel panel-default panel-product">
          <div class="panel-heading text-center">
            DEFEITOS
          </div>
          <div class="panel-body">
            <form action="" method="POST">

              <div class="input-group">
                <span class="input-group-addon">
                  <i class="glyphicon glyphicon-barcode"></i>
                </span>
                <input type="text" name="codigo" placeholder="Código" class="form-control codigo <?php echo (!empty($erro['codigo'])) ? 'has-error' : ''; ?>" value="<?=$codigo?>">
              </div>
              <br>
              <?php if (!empty($erro['codigo'])): ?>
              <div class="alert alert-danger text-center alert-input" role="alert">
                <strong> <?= $erro['codigo'] ?> </strong>
              </div>
            <?php endif ?> 
              <br>
              <div class="input-group">
              <span class="input-group-addon">
                  <i class="glyphicon glyphicon-menu-hamburger"></i>
                </span>
                <input type="reference" name="descricao" placeholder="Descrição" class="form-control descricao <?php echo (!empty($erro['descricao'])) ? 'has-error' : ''; ?>" value="<?=$descricao?>">
              </div>
              <br>
              <?php if (!empty($erro['descricao'])): ?>
              <div class="alert alert-danger text-center alert-input" role="alert">
                <strong> <?= $erro['descricao'] ?> </strong>
              </div>
            <?php endif ?> 
              <br>
              <input type="hidden" name="defeito" value="<?=$defeito ?>">
            <input type="hidden" name="fabrica" value="<?=$login_fabrica ?>">
              </div>
              <div class="text-center">
                <input type="submit" name="btn_gravar" class="btn" value="Gravar">
              <br>
                <br>
              </div>      
            </form> 
            
            <?php  
             if (!empty($sucesso)): ?>
                <div class="alert alert-success text-center" role="alert">
                <strong> 
            <?php  echo "$sucesso" ?> 
          </strong>
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
      

      <div class="col-md-4"></div>

   
     <div class="container"> 
            <div class="col-2"></div>
            <div class="col-8">
          <div class="panel panel-default panel-table-ruim">
          <table class="table" class="table table-striped table-bordered table-hover table-large table-fixed">
            <?php
              $sql_defeito = "SELECT * from defeito WHERE fabrica = $login_fabrica";
              $res_defeito = pg_query($con, $sql_defeito);
              if(pg_num_rows($res_defeito) > 0){
            ?>
                  <tr class="titulo_tabela">
                      <td>Código</td>
                      <td>Descrição</td>
                      <td></td>
                      <td><a href="importadefeitocsv.php"><button class="btn btn-primary">Excel</button></a></td>
                  </tr>
                      <?php 
                        
                        for($p=0; $p<pg_num_rows($res_defeito); $p++){
                          $defeito = pg_fetch_result($res_defeito, $p, "defeito"); 
                          $codigo = pg_fetch_result($res_defeito, $p, "codigo"); 
                          $descricao = pg_fetch_result($res_defeito, $p, "descricao"); 
                              echo "<tr class='conteudo-tabela'>
                                  <td>$codigo</td>
                                  <td>$descricao</td>
                                  <td><a href='defeito.php?defeito=$defeito'><button class=' btn'>Editar</button></a></td>
                                  <td><a href='defeito.php?defeito=$defeito'><form action='defeito.php?defeito=$defeito' method='post'><button type='submit' name='excluir' class=' btn'>Excluir</button></form></a></td> 
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