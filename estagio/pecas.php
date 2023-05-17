    <?php
    include "../config/conexao.php";
    include "checalogin.php";
    include "autenticacao.php";
    include "navbar.php";
    
 if(isset($_GET['peca'])){
      
      $peca = (int)$_GET["peca"];

      $sql = "SELECT * from peca where peca = $peca";
      $res = pg_query($con, $sql);
      
      if(pg_num_rows($res)>0){
        $referencia = pg_fetch_result($res, 0, "referencia");
        $descricao = pg_fetch_result($res, 0, "descricao");
      }
    }
    
    
    if ($_POST['btn_gravar'] == 'Gravar') {
        // Recebe as informações do formulário
        $referencia = filter_var($_POST["referencia"], FILTER_SANITIZE_SPECIAL_CHARS);
        $descricao = filter_var($_POST["descricao"], FILTER_SANITIZE_SPECIAL_CHARS);
        $peca = (int)$_POST["peca"];
        $erro = array();
      
        //Validação do campo nome
        if(empty($referencia)){
          $erro['referencia']= "O campo referência é obrigatório <br>";
        }
        // Validação do campo e-mail
        if (empty($descricao)) {
            $erro['descricao']= "O campo descrição é obrigatório <br>";
        }
        // se houver mensagens de erro, salve na sessão e redirecione para a página anterior
        if (empty($erro)) {

          if($peca == 0 ){
            $sql_insert = "INSERT INTO peca(referencia, descricao, fabrica) values('$referencia', '$descricao', $login_fabrica)";
          }else{
            $sql_insert = "UPDATE peca SET referencia = '$referencia', descricao = '$descricao' WHERE peca = $peca";
          }
         
          $res_insert = pg_query($con, $sql_insert);
          echo nl2br($sql_insert);
          if(strlen(pg_last_error($con))==0){
            $sucesso = "Cadastro da peça realizado com sucesso!";
            $referencia = "";
            $descricao = "";
            $peca = "";
          }else{
            $erro = "Falha ao gravar peça";
          }
          
        }
    }
    if (isset($_POST['excluir'])){
      $id = $_GET["peca"];
      $sql_delete = "DELETE from peca WHERE peca = $id";
      $res_delete = pg_query($con, $sql_delete);
      $referencia = "";
      $descricao = "";
      $id = "";
      header("Location: pecas.php");
    }
    
    ?>
    <!DOCTYPE html>
      <html lang="en">
    
    <bod<head>
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
  </head>y>
    <!-- Navbar -->
    <?php  ?>
      <!-- Corpo do site -->
      <div class="container">
        <div class="row">
      <div class="col-md-4"></div>

          <div class="col-md-4">
            <div class="panel panel-default panel-product">
              <div class="panel-heading text-center">
                PEÇAS
              </div>
              <div class="panel-body">
                <form action="" method="POST">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-comment"></i>
                    </span>
                    <input type="text" name="referencia" placeholder="Referência" class="form-control <?php echo (!empty($erro['referencia'])) ? 'has-error' : ''; ?>" maxlength="10" value="<?=$referencia?>">
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
                    <input type="text" name="descricao" placeholder="Descrição" class="form-control <?php echo (!empty($erro['descricao'])) ? 'has-error' : ''; ?>" maxlength="50" value="<?=$descricao?>">
                  </div>
                  <?php if (!empty($erro['descricao'])): ?>
                        <div class="text-center alerta" role="alert">
                          <strong> <?= $erro['descricao'] ?> </strong>
                        </div>
                      <?php endif ?>
                  </div>
                  
                  <br>
                  <input type="hidden" name="peca" value="<?=$peca?>">
                  <input type="hidden" name="fabrica" value="<?=$login_fabrica ?>">
                  </div>
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
        </div>
        <div class="col-md-4"></div>
   
       <div class="container"> 
            <div class="col-2"></div>
            <div class="col-8">
          <div class="panel panel-default panel-table">
          <table class="table" class="table table-striped table-bordered table-hover table-large table-fixed">
            <?php
            $sql_peca = "SELECT * from peca WHERE fabrica = $login_fabrica";
            $res_peca = pg_query($con, $sql_peca);
            if(pg_num_rows($res_peca) > 0){
            ?>
                  <tr class="titulo_tabela">
                      <td>Referência</td>
                      <td>Descrição</td>
                      <td></td>
                      <td><a href="importapecacsv.php"><button class="btn btn-primary">Excel</button></a></td>
                  </tr>
                      <?php 
                        for($p=0; $p<pg_num_rows($res_peca); $p++){
                          $peca = pg_fetch_result($res_peca, $p, "peca"); 
                          $referencia = pg_fetch_result($res_peca, $p, "referencia"); 
                          $descricao = pg_fetch_result($res_peca, $p, "descricao"); 
                              echo "<tr class='conteudo-tabela'>
                                  <td>$referencia</td>
                                  <td>$descricao</td>
                                  <td><a href='pecas.php?peca=$peca'><button class=' btn'>Editar</button></a></td>
                                  <td><a href='pecas.php?peca=$peca'><form action='pecas.php?peca=$peca' method='post'><button type='submit' name='excluir' class=' btn'>Excluir</button></form></a></td> 
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