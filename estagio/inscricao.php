<?php
include "../config/conexao.php";
if ($_POST['btn_gravar'] == 'Confirmar') {
    // Recebe as informações do formulário
    $nome = filter_var($_POST["nome"], FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_SPECIAL_CHARS);
    $senha = filter_var($_POST["senha"], FILTER_SANITIZE_SPECIAL_CHARS);
    $confirmar_senha = filter_var($_POST["confirmarsenha"], FILTER_SANITIZE_SPECIAL_CHARS);
    $fabrica = filter_var($_POST['fabrica'], FILTER_SANITIZE_SPECIAL_CHARS);

    $erro = "";

    //Validação do campo nome
    if(empty($nome)){
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
    if (empty($confirmar_senha)) {
        $erro .= "O campo confirmar senha é obrigatório <br>";
    } elseif ($senha != $confirmar_senha) {
        $erro .= "As senhas informadas não coincidem <br>";
    }
    if(empty($fabrica)){
      $erro .= "O campo fabrica é obrigatório <br>";
    }

     // se houver mensagens de erro, salve na sessão e redirecione para a página anterior
     if (strlen(trim($erro))== 0) {
      $sql_insert = "INSERT INTO usuario(nome, email, senha, fabrica) values('$nome', '$email', '$senha', $fabrica)";
      $res_insert = pg_query($con, $sql_insert);
      if (strlen(pg_last_error($con)) > 0){
        $erro .= "Não foi possível cadastrar usuário!";
      }else {
        $sucesso = "Cadastro realizado com sucesso!";
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
          <title>Inscrição</title>
          <link rel="stylesheet" href="css/bootstrap.min.css">
          <link rel="stylesheet" href="geral.css">
          <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
      </head>
      <body>
      <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
          <!-- Navbar -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="inscricao.php"><img src="logo.png"></a>
          </div>
          </div>
        </div>
      </nav>
      <div class="container">
          <div class="col-md-4"></div>

          <div class="col-md-4">
            <div class="panel panel-default panel-subscribe">
              <div class="panel-heading text-center">
                INSCREVA-SE
              </div>
              <div class="panel-body">
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                    <div class="input-group name-field">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-user"></i>
                    </span>
                    <input type="text" name="nome" id="nome" placeholder="Nome" class="form-control <?php echo (!empty($erro)) ? 'has-error' : ''; ?>" class="email">
                  </div>             
                  <br>
                    <div class="input-group email-field">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-envelope"></i>
                    </span>
                    <input type="email" name="email" id="email" placeholder="E-mail" class="form-control <?php echo (!empty($erro)) ? 'has-error' : ''; ?>" class="email">
                  </div>             
                  <br>
                  <div class="input-group email-field">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-briefcase"></i>
                    </span>
                    <label name="fabrica" for="selectfabrica"></label>
                    <select class="form-control fabrica <?php echo (!empty($erro)) ? 'has-error' : ''; ?>" name="fabrica" id="selectfabrica">
                      <option value=''>Selecione a fábrica</option>
                    <?php
                    $sql_fabrica = "SELECT * FROM fabrica";
                    $res_fabrica = pg_query($con, $sql_fabrica);
                    for($p=0; $p<pg_num_rows($res_fabrica); $p++){
                      $fabrica = pg_fetch_result($res_fabrica, $p, "fabrica"); 
                      $nome = pg_fetch_result($res_fabrica, $p, "nome");
                          echo "<option value='$fabrica'>$nome</option>";
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
                    class="password">
                  </div>
                  <br>
                  <div class="input-group confirm-password">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-lock"></i>
                    </span>
                    <input type="password" name="confirmarsenha" id="confirmarsenha" placeholder="Confirmar senha" class="form-control <?php echo (!empty($erro)) ? 'has-error' : ''; ?>" class="cpassword">
                  </div>
                  <br>
                  <div class="text-center">
               <input type="submit" name="btn_gravar" class="btn" value="Confirmar">
                <br>
                <br>
                    <footer >Já é membro? <a class="subscribe-link" href="login.php">Faça login aqui</a></footer>
                  </div>   
                </form>
                <?php if (!empty($erro)): ?>
                  <div class="alert alert-danger text-center" role="alert">
                    <strong> <?php  echo "$erro" ?> </strong>
                  </div>
                <?php endif ?> 
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
            

              </div>
          </div>

          <div class="col-md-4"></div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      </body>
      </html>