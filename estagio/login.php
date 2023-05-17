  <?php
  session_start();
  include "../config/conexao.php";

  if (isset($_POST['email']) && isset($_POST['senha'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_SPECIAL_CHARS);
    $senha = filter_var($_POST['senha'], FILTER_SANITIZE_SPECIAL_CHARS);
    $mensagem = "Usuário ou senha inválidos!";

    if (empty($email)) {
      $mensagem;
  } elseif (empty($senha)) {
        $mensagem;
    } elseif (strlen($senha) < 6) {
        $mensagem;
    }

    if (strlen(trim($email)) > 0 && strlen(trim($senha)) > 0) {
      $query = "SELECT * FROM usuario WHERE email = '$email' AND senha = '$senha'";
      $res_select = pg_query($con, $query);
      $num_rows = pg_num_rows($res_select);

      if ($num_rows > 0) {
        
        $_SESSION['nome'] = pg_fetch_result($res_select, 0, 'nome');
        $_SESSION['fabrica'] = pg_fetch_result($res_select, 0, 'fabrica');
        $_SESSION['usuario_id'] = pg_fetch_result($res_select, 0, 'usuario');
  
  

        $_SESSION['logado'] = true;
        $_SESSION['usuario'] = 'Administrador';
      
        header('location:home.php');
        exit;
      } elseif(empty($email)) {
        header("location:login.php?msg=erro_login");
        $mensagem;
      }
    } else {
      header("location:login.php?msg=erro_dados");
    }
  }
  ?>
  <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="geral.css">
    </head>
    <body class="body">
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="login.php"><img src="logo.png"></a>
        </div>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
    <div class="container">
        <div class="col-md-4"></div>

        <div class="col-md-4">
          <div class="panel panel-default panel-login">
            <div class="panel-heading text-center">
              LOGIN
            </div>
            <div class="panel-body">
              <form action="" method="POST">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-envelope"></i>
                  </span>
                  <input type="text" name="email" placeholder="E-mail" class="form-control">
                </div>
                <br>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-lock"></i>
                  </span>
                  <input type="password" name="senha" placeholder="Senha" class="form-control">
                </div>
                <br>
                <div class="text-center">
                  <button type="submit" class="btn">Entrar</button>
                  <br>
                  <br>
                  <input type="checkbox"> Lembrar-se
                  <br>
                  <br>
                  <footer class="login-footer">Não é membro? <a class="subscribe-link" href="inscricao.php">Inscreva-se aqui</a></footer>
                </div>   
              </form>
            </div>

            <?php if (isset($mensagem)): ?>
  <div class="alert alert-danger text-center" role="alert">
      <strong><span><i class="glyphicon glyphicon-alert"></i></span></strong> <?php echo $mensagem; ?>
  </div>
  <?php endif; ?>
        </div>

        <div class="col-md-4"></div>
      </div>
    <script src="js/bootstrap.min.js"></script>
    </body>
    </html>