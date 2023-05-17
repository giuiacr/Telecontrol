<?php
include "../config/conexao.php";
include "checalogin.php";
include "autenticacao.php";

 
 if(isset($_GET["produto"])){
      
    $produto = (int)$_GET["produto"];

    $sql = "SELECT * from produto where produto = $produto";
    $res = pg_query($con, $sql);
    if(pg_num_rows($res)>0){
      $referencia = pg_fetch_result($res, 0, "referencia");
      $descricao = pg_fetch_result($res, 0, "descricao");
      $garantia = pg_fetch_result($res, 0, 'garantia');
      $ativo = (pg_fetch_result($res, 0, 'ativo') == "t") ? 'true' : 'false';
    }
    

  }
  
    if ($_POST['btn_gravar'] == 'Gravar') {
      // Recebe as informações do formulário
      $ativo = (int)($_POST['checkbox'] == "t") ? 'true' : 'false';
      $produto = filter_var((int)$_POST['produto'], FILTER_SANITIZE_SPECIAL_CHARS);
      $referencia = filter_var($_POST['referencia'], FILTER_SANITIZE_SPECIAL_CHARS);
      $descricao = filter_var($_POST['descricao'], FILTER_SANITIZE_SPECIAL_CHARS);
      $garantia = (int)$_POST['garantia'];
      $erro = array();

      if(empty($referencia)){
        $erro['referencia']= "O campo referência é obrigatório <br>";
      }
      // Validação do campo descrição
      if (empty($descricao)) {
        $erro['descricao']= "O campo descrição é obrigatório <br>";
    }
    //Validação do campo garantia
      if(empty($garantia)){
        $erro['garantia']= "O campo garantia é obrigatório <br>";
      }

      if (empty($erro)) {
        
      if($produto == 0 ){
        $sql_insert = "INSERT INTO produto(referencia, descricao, garantia, ativo, fabrica) values('$referencia', '$descricao', $garantia, $ativo, $login_fabrica)";
      }else{
        $sql_insert = "UPDATE produto SET referencia = '$referencia', descricao = '$descricao', garantia = $garantia, ativo = $ativo WHERE produto = $produto";
      }
      
        $res_insert = pg_query($con, $sql_insert);
        echo nl2br($sql_insert);
        if (strlen(pg_last_error($con)) == 0){
          $sucesso = "Produto registrado com sucesso!";
          $referencia = "";
          $descricao = "";
          $garantia ="";
          $ativo = "";
        }else {
          $erro = "Falha ao registrar produto";
        }
     
      }
        }
        if (isset($_POST['excluir'])){
          $id = $_GET["produto"];
          $sql_delete = "DELETE from produto WHERE produto = $id";
          $res_delete = pg_query($con, $sql_delete);
          $referencia = "";
          $descricao = "";
          $id = "";
          $garantia = "";
          $ativo = "";
          header("Location: produtos.php");
        }  
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Produtos</title>
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <link rel="stylesheet" href="geral.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> 

  </head>
  <body>
  <!-- Navbar -->
  <?php include "navbar.php";?>
  <!-- Corpo do site -->
  <div class="container"></div>   
  <div class="col-md-4"></div>

      <div class="col-md-4">
        <div class="panel panel-default panel-product">
          <div class="panel-heading text-center">
            PRODUTOS
          </div>
          <div class="panel-body">
            <form action="" method="POST">
              
            <div class="input-group">
              <span class="input-group-addon">
                  <i class="glyphicon glyphicon-comment"></i>
                </span>
                <input type="text" name="referencia" placeholder="Referência" class="form-control <?php echo (!empty($erro['referencia'])) ? 'has-error' : ''; ?>" value="<?=$referencia?>" maxlength="10">
              </div>
              <?php if (!empty($erro['referencia'])): ?>
              <div class="text-center alerta"  role="alert">
                <strong> <?= $erro['referencia'] ?> </strong>
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
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="glyphicon glyphicon-calendar"></i>
                </span>
                <input type="text" name="garantia" placeholder="Tempo de garantia (em meses)" class="form-control <?php echo (!empty($erro['garantia'])) ? 'has-error' : ''; ?>" value="<?=$garantia?>">
              </div>
              <?php if (!empty($erro['garantia'])): ?>
              <div class="text-center alerta" role="alert">
                <strong> <?= $erro['garantia'] ?> </strong>
              </div>
            <?php endif ?> 
              <br>
             <div class="active-product text-center checkbox">
              <input type="checkbox" name="checkbox" value="t" class="ativo" <?= ($ativo == "true") ? ' checked ' : ''?>> Meu produto está ativo
              </div>
              <br>
              <input type="hidden" name="produto" value="<?=$produto?>">
              <input type="hidden" name="fabrica" value="<?=$login_fabrica ?>">
              <div class="text-center">
               <input type="submit" name="btn_gravar" class="btn" value="Gravar">
               <br>
               <br>
              </div>     
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
      <br>
      <br>
      <br>
      <div class="col-md-4"></div>
           <div class="container"> 
            <div class="col-2"></div>
            <div class="col-8">
          <div class="panel panel-default panel-table-ruim">

          <table class="table" class="table table-striped table-bordered table-hover table-large table-fixed">
                  <tr class="titulo_tabela">
                    <?php 
                     $sql_produto = "SELECT * from produto WHERE fabrica = $login_fabrica";
                        $res_produto = pg_query($con, $sql_produto);
                        if(pg_num_rows($res_produto) > 0){
                    ?>
                      <td>Produto</td>
                      <td>Referência</td>
                      <td>Descrição</td>
                      <td>Garantia</td>
                      <td>Ativo</td>   
                      <td></td>
                      <td><a href="importaprodutocsv.php"><button class="btn btn-primary">Excel</button></a></td>  
                  </tr>
                  <?php 
                       
                        for($p=0; $p<pg_num_rows($res_produto); $p++){
                          $produto = pg_fetch_result($res_produto, $p, "produto"); 
                          $referencia = pg_fetch_result($res_produto, $p, "referencia"); 
                          $descricao = pg_fetch_result($res_produto, $p, "descricao"); 
                          $garantia = pg_fetch_result($res_produto, $p, "garantia");
                          $ativo = (pg_fetch_result($res_produto, $p, "ativo") == "t") ? 'true' : 'false';
                              echo "<tr class='conteudo-tabela'>
                                  <td>$produto</td>
                                  <td>$referencia</td>
                                  <td>$descricao</td>
                                  <td>$garantia</td>
                                  <td>$ativo</td>
                                  <td><a href='produtos.php?produto=$produto'><button class='btn'>Editar</button></a></td>
                                  <td><a href='produtos.php?produto=$produto'><form action='produtos.php?produto=$produto' method='post'><button type='submit' name='excluir' class=' btn'>Excluir</button></form></a></td> 
                              </tr>";
                            }
                          ?>
          
                        </table>
          </div>
          </div>
          <div class="col-2"></div>
          </div> 
          <?php }else{
            $mensagem = "Sem resultados";
            ?>
            <br>
                  <div class="alert alert-danger text-center" role="alert"><strong> <?php  echo "$mensagem" ?></strong></div>
          <?php } ?>
      </body>
  </html>