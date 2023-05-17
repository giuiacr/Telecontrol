<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
<body>
    

<header>
<nav class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="home.php"><img src="logo.png"></a>
                </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                <ul class="nav navbar-nav">
                    <li><a class="navbar-words" href="home.php">Home</a></li>    
                    <li><a class="navbar-words" href="produtos.php">Produtos <span class="sr-only"><></span></a></li>
                    <li><a class="navbar-words" href="pecas.php">Peças</a></li>
                    <li><a class="navbar-words" href="atendimento.php">Atendimento<span class="sr-only"><></span></a></li>
                    <li><a class="navbar-words" href="defeito.php">Defeito<span class="sr-only"><></span></a></li>
                    <li><a class="navbar-words" href="fabricas.php">Fábricas</a></li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle-os" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Ordem de Serviço<span class="caret"></span></a>
                      <ul class="dropdown-menu">
                        <li><a href="cadastrodeos.php">Cadastro de OS</a></li>
                        <li><a href="pesquisaos.php">Pesquisa de OS</a></li>
                      </ul>
                    </li>
                </ul>
                </ul>
                <ul class="nav navbar-nav navbar-right"> 
                <li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Olá, <?=$login_nome?><span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li ><a href="editarperfil.php?usuario=<?=$login_usuario_id?>" class="menu_perfil">Editar perfil</a></li>
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></i></span>
                      </a></li>
                  </ul>
                </li>
                
                </ul>
            </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
</header>
</body>
</html>