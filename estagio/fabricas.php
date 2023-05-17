<?php 
include "checalogin.php";
include "autenticacao.php";
include "../config/conexao.php";

  if(isset($_GET['fabrica'])){
      
    $fabrica = (int)$_GET["fabrica"];
  
    $sql = "SELECT * from fabrica where fabrica = $fabrica";
    $res = pg_query($con, $sql);
    if(pg_num_rows($res)>0){
      $nome = pg_fetch_result($res, 0, "nome");
    } 
    
  }

  if ($_POST['btn_gravar'] == 'Gravar') {
      // Recebe as informações do formulário
      $fabrica = (int)$_POST["fabrica"];
      $nome = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
      $erro = array();
    
      //Validação do campo nome da fábrica
      if (empty($nome)) {
        $erro['nome']= "O campo nome da fábrica é obrigatório <br>";
    }
     
    if (empty($erro)) {
      
      if($fabrica == 0){
        $sql_insert = "INSERT INTO fabrica(nome) values('$nome')";
      }else{
        $sql_insert = "UPDATE fabrica SET nome = '$nome' WHERE fabrica = $fabrica";
      }
      $res_insert = pg_query($con, $sql_insert);
      echo nl2br($sql_insert);
      if (strlen(pg_last_error($con)) == 0){
        $sucesso = "Fábrica registrada com sucesso!"; 
        $nome = "";
      }else {
         $erro = "Não foi possível registrar a fábrica!";
      }
    }
  }
  
  ?>
<!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Fábricas</title>
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
            FÁBRICAS
          </div>
          <div class="panel-body">
            <form method="POST">
              <div class="input-group">
              <span class="input-group-addon">
                  <i class="glyphicon glyphicon glyphicon-briefcase"></i>
                </span>
                <input type="text" name="nome" placeholder="Nome da fábrica" class="form-control <?php echo (!empty($erro['nome'])) ? 'has-error' : ''; ?>" value="<?=$nome?>">
              </div>
              <?php if (!empty($erro['nome'])): ?>
                      <div class="text-center alerta" role="alert">
                        <strong> <?= $erro['nome'] ?> </strong>
                      </div>
                    <?php endif ?> 
            
              </div>
              <div class="text-center">
               <input type="submit" name="btn_gravar" class="btn" value="Gravar">
                <br>
                <br>
              </div>   
              <input type="hidden" name="fabrica" value="<?php echo $fabrica ?>">
            </form> 
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
  </body>
      <footer>
          <div class="container"> 
            <div class="col-2"></div>
            <div class="col-8">
          <div class="panel panel-default panel-table-ruim">
          <table class="table" class="table table-striped table-bordered table-hover table-large table-fixed">
                  <tr class="titulo_tabela"> 
                      <td>Fábrica</td>
                      <td></td>
                  </tr>
                      <?php 
                        $sql_fabrica = "select * from fabrica ";
                        $res_fabrica = pg_query($con, $sql_fabrica);
                        for($p=0; $p<pg_num_rows($res_fabrica); $p++){
                          $fabrica = pg_fetch_result($res_fabrica, $p, "fabrica"); 
                          $nome = pg_fetch_result($res_fabrica, $p, "nome"); 
                              echo "<tr class='conteudo-tabela'>
                                  <td>$nome</td>
                                 
                                  <td><a href='fabricas.php?fabrica=$fabrica'><button class=' btn'>Editar</button></a></td>
                              </tr>";
                            }
                          ?>
                        </table>
          </div>
          </div>
          </div>
          <div class="col-2"></div>
      </footer>
    
  </html>