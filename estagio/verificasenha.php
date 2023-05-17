<?php
include "checalogin.php";
include "autenticacao.php";
include "../config/conexao.php";

if(isset($_POST["btn_senha"])) {

    // Obter o ID do usuário logado
    $id_usuario = $_SESSION['usuario_id'];
    $erro = array();
    $falha = "";

    // Obter a senha armazenada no banco de dados para o usuário logado
    $sql = "SELECT senha FROM usuario WHERE usuario = $id_usuario";
    $resultado = pg_query($con, $sql);

    if(strlen(pg_last_error($con)) > 0 ) {
      echo "Falha ao fazer checagem da senha!";
    }else{
    
      $senha_armazenada = pg_fetch_result($resultado, 0, "senha");

      echo "senha ". $_POST["senha"];
      echo "senha arm ". $senha_armazenada; 

      // Verificar se a senha inserida pelo usuário é a mesma que está armazenada no banco de dados
      if ($_POST["senha"] == $senha_armazenada) {
         
          ?>
              <script>
                  window.parent.habilitaCampos();
                  window.parent.Shadowbox.close();
              </script>
          <?php 
      } 
      if(!empty($_POST['senha']) && $_POST['senha'] != $senha_armazenada){
        $falha = "Senha incorreta!";
      }
      if(empty($_POST['senha'])){
        $erro['senha'] = "Campo de senha obrigatório!";
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="geral.css">
        <link rel="stylesheet" href="css/shadowbox.css" >
        <script src="js/bootstrap.min.js"></script>
        <script src="js/shadowbox.js"></script>
    </head>
    <body>
    <div class="container center">
          <div class="col-md-4"></div>
          <div class="col-md-4">
          <div class="panel panel-default panel-product">
          <div class="panel-heading text-center">
            Confirmar identidade
          </div>
          <div class="panel-body">
        
            <br>
            <form action="" method="POST">
                    <div class="input-group name-field">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-lock"></i>
                    </span>
                    <input type="password" name="senha" id="senha" placeholder="Insira sua senha" class="form-control <?php echo (!empty($erro['senha'])) ? 'has-error' : ''; ?>">
                  </div>      
                  <?php if (!empty($erro['senha'])): ?>
                        <div class="text-center alerta" role="alert">
                          <strong> <?= $erro['senha'] ?> </strong>
                        </div>
                      <?php endif ?>       
                  <br>
                  <br>
                  <div class="text-center">
                <input type="submit" name="btn_senha" class="btn" value="Confirmar">
                </div>   
           </form>
          
    </div> 
        <?php if (!empty($falha)): ?>
            <div class="alert alert-danger text-center" role="alert">
              <strong> <?php  echo "$falha" ?> </strong>
            </div>
        <?php endif ?> 
    </div>
    <div class="col-md-4"></div>
