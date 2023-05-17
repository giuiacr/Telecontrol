<?php
include "../config/conexao.php";
include "checalogin.php";

if(isset($_GET['usuario'])){
      
    $usuario = (int)$_GET["usuario"];

    $sql = "SELECT * from usuario where usuario = $usuario";
    $res = pg_query($con, $sql);
    
    if(pg_num_rows($res)>0){
      $nome_usuario = pg_fetch_result($res, 0, 'nome');
      $usuario = pg_fetch_result($res, 0, 'usuario');
      $email = pg_fetch_result($res, 0, 'email');
      $senha = pg_fetch_result($res, 0, 'senha');
      $fabrica_p = pg_fetch_result($res, 0, 'fabrica');
    }
    
  }
  if ($_POST['btn_gravar'] == 'Enviar') {
    // Recebe as informações do formulário
    $nome_usuario = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
    $usuario = (int)$_POST['usuario'];
    $email = filter_var($_POST['email'], FILTER_SANITIZE_SPECIAL_CHARS);
    $senha = filter_var($_POST['senha'], FILTER_SANITIZE_SPECIAL_CHARS);
    $fabrica_p = (int)$_POST['fabrica'];          
    $erro = "";
   
    if(empty($nome_usuario)){
        $erro .= "O campo nome é obrigatório <br>";
      }
      // Validação do campo e-mail
      if (empty($email)) {
          $erro .= "O campo e-mail é obrigatório <br>";
      } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $erro .= "O e-mail informado é inválido <br>";
      }
  
      // Validação do campo senha
      if (empty($senha)) {
          $erro .= "O campo senha é obrigatório <br>";
      } elseif (strlen($senha) < 6) {
          $erro .= "A senha deve conter pelo menos 6 caracteres <br>";
      }
  
      // Validação do campo confirmar senha
      // if (empty($confirmar_senha)) {
      //     $erro .= "O campo confirmar senha é obrigatório <br>";
      // } elseif ($senha != $confirmar_senha) {
      //     $erro .= "As senhas informadas não coincidem <br>";
      // }
      if(empty($fabrica_p)){
        $erro .= "O campo fábrica é obrigatório <br>";
      }
      if($usuario > 0){
        $sql_insert = "UPDATE usuario SET nome = '$nome_usuario', email = '$email', fabrica = $fabrica_p WHERE usuario = $usuario";
      }

      $res_insert = pg_query($con, $sql_insert);
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Perfil</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="geral.css">
        <link rel="stylesheet" href="css/shadowbox.css" >
        <script src="js/bootstrap.min.js"></script>
        <script src="js/shadowbox.js"></script>
        <script>
          $(function () {
            Shadowbox.init();
            $(".editar").click(function(){
              Shadowbox.open({
              content:    "verificasenha.php",
              player: "iframe",
              title:  "",
              width:  900,
              height: 600
              });

            });
          });

          function habilitaCampos(){
            $(".form-control").attr({"disabled":false});
          }


        </script>
    </head>
   
    <body class="body">
        <!-- Navbar -->
        <?php include "navbar.php";?>
    <!-- Corpo do site -->
    <div class="container">
          <div class="col-md-4"></div>

          <div class="col-md-4">
            <div class="panel panel-default panel-edita">
              <div class="panel-heading text-center">
                Informações pessoais
              </div>
              <div class="panel-body">
                <form action="" method="POST">
                    <div class="input-group name-field">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-user"></i>
                    </span>
                    <input type="text" name="nome" id="nome" placeholder="Nome" class="form-control <?php echo (!empty($erro)) ? 'has-error' : ''; ?>" class="email" value="<?=$nome_usuario?>" disabled>
                  </div>             
                  <br>
                    <div class="input-group email-field">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-envelope"></i>
                    </span>
                    <input type="email" name="email" id="email" placeholder="E-mail" class="form-control <?php echo (!empty($erro)) ? 'has-error' : ''; ?>" class="email" value="<?=$email?>" disabled>
                  </div>             
                  <br>
                  <div class="input-group fabrica-field">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-briefcase"></i>
                    </span>
                    <label name="fabrica" for="selectfabrica"></label>
                    <select class="form-control fabrica <?php echo (!empty($erro)) ? 'has-error' : ''; ?>" name="fabrica" id="selectfabrica" disabled>
                      <option value=''>Selecione a fábrica</option>
                    <?php
                    $sql = "SELECT * FROM fabrica";
                    $res = pg_query($con, $sql);
                    for($f=0; $f<pg_num_rows($res); $f++){
                    $fabrica = pg_fetch_result($res, $f, "fabrica"); 
                    $nome = pg_fetch_result($res, $f, "nome");
                    $selected = '';
                      if($fabrica_p == $fabrica){
                      $selected = ' selected ';
                       }
                      echo "<option value='$fabrica' $selected>$nome</option>";
                 }       
                  ?>
                    </select>
                  </div>             
                  <br>
                  <div class="input-group password-field">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-lock"></i>
                    </span>
                    <input type="password" name="senha" id="senha" placeholder="Senha" class="form-control <?php echo (!empty($erro)) ? 'has-error' : ''; ?>"
                    class="password" value="<?=$senha?>" disabled>
                  </div>
                  <br>     
                    <input type="hidden" name="usuario" id="usuario" value="<?=$login_usuario_id?>">
                    <input type="hidden" name="fabrica" id="fabrica" value="<?=$login_fabrica?>">
                    <br>
                <div class="text-center">
               <!-- Botão para abrir a modal de edição -->
               <button type="button" class="editar btn" data-toggle="modal" data-target="#myModal">
                  Editar
               </button>
               <input type="submit" name="btn_gravar" class="btn" value="Confirmar">
               </div>

       
    </body>
</html>