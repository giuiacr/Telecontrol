<?php
session_start();
include "../config/conexao.php";

if (isset($_POST['email']) && isset($_POST['senha'])) {
  $email = filter_var($_POST['email'], FILTER_SANITIZE_SPECIAL_CHARS);
  $senha = filter_var($_POST['senha'], FILTER_SANITIZE_SPECIAL_CHARS);

  if (strlen(trim($email)) > 0 && strlen(trim($senha)) > 0) {
    $query = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
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
    } else {
      header("location:login.php?msg=erro_login");
      $mensagem = "Usuário ou senha inválidos!";
    }
  } else {
    header("location:login.php?msg=erro_dados");
    $mensagem = "Usuário ou senha inválidos!";
  }
}
