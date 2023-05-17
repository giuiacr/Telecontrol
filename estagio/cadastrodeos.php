<?php
include "../config/conexao.php";
include "checalogin.php";
include "autenticacao.php";

function converterData($data){
  $array = explode(" ", $data);

  if(count($array) == 2){
      $dataInvertida = array_reverse(explode("/", $array[0]));
      $dataFormatada = implode("-",$dataInvertida);
    
      $horaFormatada = date('H:i:s', strtotime($array[1]));
      $dataHora = $dataFormatada . ' ' . $horaFormatada;
      return $dataHora;
  }else{
      $dataInvertida = array_reverse(explode("/", $data));
      return $dataFormatada = implode("-",$dataInvertida);
}

}

if (isset($_GET['os'])){

  $os = (int)$_GET["os"];

  $sql = "SELECT os.*, to_char(os.data_abertura, 'DD/MM/YYYY') AS data_ab, 
  to_char(os.data_compra, 'DD/MM/YYYY') AS data_cp, produto.descricao, produto.referencia
  FROM OS
  JOIN produto ON os.produto = produto.produto
  WHERE os = $os";
  $res = pg_query($con, $sql);
  
  if(pg_num_rows($res) > 0){           
    $os = pg_fetch_result($res, 0, "os");
    $atendimento_p = pg_fetch_result($res, 0, "tipo_atendimento");
    $dataab = pg_fetch_result($res, 0, "data_abertura");
    $notafiscal = pg_fetch_result($res, 0, "nota_fiscal"); 
    $datacp = pg_fetch_result($res, 0, "data_compra"); 
    $aparencia = pg_fetch_result($res, 0, "aparencia"); 
    $acessorios = pg_fetch_result($res, 0, "acessorio"); 
    $nome = pg_fetch_result($res, 0, "nome_consumidor"); 
    $documento = pg_fetch_result($res, 0, "cpf_cnpj"); 
    $cep = pg_fetch_result($res, 0, "cep_consumidor"); 
    $estado = pg_fetch_result($res, 0, "estado_consumidor");
    $cidade = pg_fetch_result($res, 0, "cidade_consumidor"); 
    $bairro = pg_fetch_result($res, 0, "bairro_consumidor"); 
    $endereco = pg_fetch_result($res, 0, "endereco_consumidor"); 
    $numero = pg_fetch_result($res, 0, "numero_consumidor");
    $complemento = pg_fetch_result($res, 0, "complemento");
    $telefone = pg_fetch_result($res, 0, "telefone_consumidor"); 
    $celular = pg_fetch_result($res, 0, "celular_consumidor"); 
    $email = pg_fetch_result($res, 0, "email_consumidor"); 
    $produto = pg_fetch_result($res, 0, "produto"); 
    $numserie = pg_fetch_result($res, 0, "numero_serie"); 
    $defeito_p = pg_fetch_result($res, 0, "defeito");  
    $descricao = pg_fetch_result($res, 0, "descricao");
    $referencia = pg_fetch_result($res, 0, "referencia"); 

   function organizar_data($data) {
    $partes = explode('-', $data);
    $nova_data = $partes[2] . '/' . $partes[1] . '/' . $partes[0];
    return $nova_data;
  }
  $dataab = organizar_data($dataab);
  $datacp = organizar_data($datacp);
  }
}

if ($_POST['btn_gravar'] == 'Gravar') {
    // variáveis 
     //dados da compra
    $atendimento_p = filter_var($_POST['atendimento'], FILTER_SANITIZE_SPECIAL_CHARS);
    $dataab = filter_var($_POST['dataab'],FILTER_SANITIZE_SPECIAL_CHARS);
    $notafiscal = filter_var($_POST['notafiscal'], FILTER_SANITIZE_SPECIAL_CHARS);
    $datacp = filter_var($_POST['datacp'], FILTER_SANITIZE_SPECIAL_CHARS);
    $aparencia = filter_var($_POST['aparencia'], FILTER_SANITIZE_SPECIAL_CHARS);
    $acessorios = filter_var($_POST['acessorios'], FILTER_SANITIZE_SPECIAL_CHARS);
     //dados do consumidor
    $nome = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
    $documento = filter_var($_POST['documento'], FILTER_SANITIZE_SPECIAL_CHARS);
    $cep = filter_var($_POST['CEP'], FILTER_SANITIZE_SPECIAL_CHARS);
    $estado = filter_var($_POST['estado'], FILTER_SANITIZE_SPECIAL_CHARS); 
    $cidade = filter_var($_POST['cidade'], FILTER_SANITIZE_SPECIAL_CHARS);
    $bairro = filter_var($_POST['bairro'], FILTER_SANITIZE_SPECIAL_CHARS);
    $endereco = filter_var($_POST['endereco'], FILTER_SANITIZE_SPECIAL_CHARS);
    $numero = filter_var($_POST['numero'], FILTER_SANITIZE_SPECIAL_CHARS);
    $complemento = filter_var($_POST['complemento'], FILTER_SANITIZE_SPECIAL_CHARS);
    $telefone = filter_var($_POST['telefone'], FILTER_SANITIZE_SPECIAL_CHARS);
    $celular = filter_var($_POST['celular'], FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_SPECIAL_CHARS);
     //dados do produto
    $produto = filter_var($_POST['produto'], FILTER_SANITIZE_SPECIAL_CHARS);
    $numserie = filter_var($_POST['numserie'], FILTER_SANITIZE_SPECIAL_CHARS);
    $descricao = filter_var($_POST['descricao'], FILTER_SANITIZE_SPECIAL_CHARS);
    $referencia = filter_var($_POST['referencia'], FILTER_SANITIZE_SPECIAL_CHARS);
    $defeito_p = filter_var($_POST['defeito'], FILTER_SANITIZE_SPECIAL_CHARS);
    $limpar = array('(', ')', '-', '.', ' ', '/');
    $telefone = str_replace($limpar, '', $telefone);
    $celular = str_replace($limpar, '', $celular);
    $documento = str_replace($limpar, '', $documento);
    $cep = str_replace($limpar, '', $cep);
    $erro = array();
        // Verifica as variáveis relacionadas à compra do produto
        if(empty($atendimento_p)) {
          $erro['atendimento']= "Preencha o campo atendimento <br>";
        }
        if(empty($dataab)) {
          $erro['dataab']= "Preencha o campo data de abertura <br>";
        }
        if(empty($notafiscal)) {
          $erro['notafiscal']= "Preencha o campo nota fiscal <br>";
        }
        if(empty($datacp)) {
          $erro['datacp']= "Preencha o campo data de compra <br>";
        }
        if(empty($aparencia)) {
          $erro['aparencia']= "Preencha o campo aparencia <br>";
        }
        if(empty($acessorios)) {
          $erro['acessorios']= "Preencha o campo acessorios <br>";
        }
        if(empty($documento)) {
          $erro['documento']= "Preencha o campo documento <br>";
        }
        if(empty($cep)) {
          $erro['cep']= "Preencha o campo CEP <br>";
        }
        if(empty($estado)) {
          $erro['estado']= "Preencha o campo estado <br>";
        }
        if(empty($cidade)) {
          $erro['cidade']= "Preencha o campo cidade <br>";
        }
        if(empty($bairro)) {
          $erro['bairro']= "Preencha o campo bairro <br>";
        }
        if(empty($endereco)) {
            $erro['endereco']= "Preencha o campo número <br>";
          }
        if(empty($numero)) {
          $erro['numero']= "Preencha o campo número <br>";
        }
        if(empty($complemento)) {
          $erro['complemento']= "Preencha o campo complemento <br>";
        }
        if(empty($telefone)) {
          $erro['telefone']= "Preencha o campo telefone <br>";
        }
        if(empty($celular)) {
          $erro['celular']= "Preencha o campo celular <br>";
        }
        if(empty($email)) {
          $erro['email']= "Preencha o campo e-mail <br>";
        }
        if(empty($produto)) {
          $erro['produto']= "Preencha o campo produto <br>";
        }
        if(empty($numserie)) {
          $erro['numserie']= "Preencha o campo número de série <br>";
        }
        if(empty($defeito_p)) {
          $erro['defeito']= "Preencha o campo defeito <br>";
        }
        if(empty($descricao)) {
          $erro['descricao']= "Preencha o campo descrição <br>";
        }
        if(empty($referencia)) {
          $erro['referencia']= "Preencha o campo referência <br>";
        }
       
         
       if(empty($erro)){
        // Se todas as variáveis estiverem preenchidas corretamente, insere os dados na base de dados
        if($os == 0) {
          $sql_insert = "INSERT INTO os(tipo_atendimento, data_abertura, nota_fiscal, data_compra, aparencia, acessorio, nome_consumidor, cpf_cnpj, cep_consumidor, estado_consumidor, cidade_consumidor, bairro_consumidor, endereco_consumidor, numero_consumidor, complemento, telefone_consumidor, celular_consumidor, email_consumidor, produto, numero_serie, defeito, fabrica) values($atendimento_p, '$dataab', '$notafiscal', '$datacp', '$aparencia', '$acessorios', '$nome', '$documento', '$cep', '$estado', '$cidade', '$bairro', '$endereco', $numero, '$complemento', '$telefone', '$celular', '$email', $produto, '$numserie', $defeito_p, $login_fabrica)";
       }else{ 
        
        $sql_insert = "UPDATE os SET tipo_atendimento = '$atendimento_p',
            data_abertura = '$dataab', 
            nota_fiscal = '$notafiscal', 
            data_compra = '$datacp', 
            aparencia = '$aparencia', 
            acessorio = '$acessorios', 
            nome_consumidor = '$nome', 
            cpf_cnpj = '$documento', 
            cep_consumidor = '$cep', 
            estado_consumidor = '$estado', 
            cidade_consumidor = '$cidade', 
            bairro_consumidor = '$bairro', 
            endereco_consumidor = '$endereco', 
            numero_consumidor = '$numero',
            complemento = '$complemento',
            telefone_consumidor = '$telefone', 
            celular_consumidor = '$celular', 
            email_consumidor = '$email', 
            produto = '$produto', 
            numero_serie = '$numserie', 
            defeito = '$defeito_p'";
           
          
       } 
       
       $res_insert = pg_query($con, $sql_insert);
      
       nl2br($sql_insert);
       if(strlen(pg_last_error($con)) == 0){
        $sucesso = "Cadastro/edição da OS realizado com sucesso!";
        $atendimento_p = "";
        $dataab = "";
        $notafiscal = "";
        $datacp = "";
        $aparencia = "";
        $acessorios = "";
        $nome = "";
        $documento = "";
        $cep = "";
        $estado = "";
        $cidade = "";
        $bairro = "";
        $endereco = "";
        $numero = "";
        $complemento = "";
        $telefone = "";
        $celular = "";
        $email = "";
        $produto = "";
        $numserie = "";
        $descricao = "";
        $defeito_p = "";
       }else{
         $erro = "Falha ao cadastrar OS";
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
    <title>Cadastro de OS</title>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="geral.css">
    <link rel="stylesheet" href="css/shadowbox.css" >
    <script src="js/bootstrap.min.js"></script>
    <script src="js/shadowbox.js"></script>
    <script>


      $(function () {
        //declare function 
        Shadowbox.init();
        $(".pesquisar").click(function(){
          var nome = $(".nome").val(); 
          console.log("nome ", nome);

          Shadowbox.open({
          content:    "tabela.php",
          player: "iframe",
          title:  "",
          width:  900,
          height: 600
          });
        });
      });

      function retornaProduto (produto, referencia, descricao){
        $(".produto").val(produto);
        $(".referencia") .val(referencia);
        $(".descricao") .val(descricao);

      }
    </script>
  </head>
  <body>  
    <!-- Navbar -->
    <?php include "navbar.php";?>
    <!-- Corpo do site -->

   <div class="container">
    <div class="col-md-4"></div>
      <div class="col-md-4">
        <div class="panel panel-default panel-product">
          <div class="panel-heading text-center">
            CADASTRO DE OS
          </div>
          <div class="panel-body">
            <form method="POST">
              <br>
              <div class="title text-center">DADOS DA COMPRA</div>
              <br>
              <!-- Atendimento -->
              <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-th-list"></i>
                  </span>
                  <label name="atendimento" for="selectatendimento"></label>
                    <select class="form-control atendimento <?php echo (!empty($erro['atendimento'])) ? 'has-error' : ''; ?>" name="atendimento" id="selectatendimento">
                      <option value=''>Selecione tipo de atendimento</option>
                    <?php
                    $sql = "SELECT * FROM tipo_atendimento WHERE fabrica = $login_fabrica";
                    $res = pg_query($con, $sql);
                    for ($t = 0; $t < pg_num_rows($res); $t ++){
                      
                          $ativo_tipo_atendimento = pg_fetch_result($res, $t, 'ativo');
                          $atendimento = pg_fetch_result($res, $t, 'tipo_atendimento');
                          $codigo_tipo_atendimento = pg_fetch_result($res, $t, 'codigo');
                          $descricao_tipo_atendimento = pg_fetch_result($res, $t, 'descricao');
                          $selected_atendimento = '';
                          
                            if($atendimento_p == $atendimento){
                            $selected_atendimento = ' selected ';
                          }
                          if($ativo_tipo_atendimento == 't'){
                          
                          echo "<option value='$atendimento' $selected_atendimento>$codigo_tipo_atendimento - $descricao_tipo_atendimento</option>";

                }
                } 
                  ?>

                    </select>
                </div>
                <?php if (!empty($erro['atendimento'])): ?>
              <div class="text-center alerta" role="alert">
                <strong> <?= $erro['atendimento'] ?> </strong>
              </div>
            <?php endif ?> 
                <br>

              <!-- Data de abertura -->

                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-calendar"></i>
                  </span>
                  <input type="text" name="dataab" id="dataab" placeholder="Data de abertura" class="form-control data <?php echo (!empty($erro['dataab'])) ? 'has-error' : ''; ?>" value="<?=$dataab?>">
                </div>
                <?php if (!empty($erro['dataab'])): ?>
              <div class="text-center alerta" role="alert">
                <strong> <?= $erro['dataab'] ?> </strong>
              </div>
            <?php endif ?> 
                <br>

              <!-- Nota fiscal -->

                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-qrcode"></i>
                  </span>
                  <input type="text" name="notafiscal" id="notafiscal" placeholder="Nota fiscal" class="form-control notafiscal <?php echo (!empty($erro['notafiscal'])) ? 'has-error' : ''; ?>" maxlength="10" value="<?=$notafiscal?>">
                </div>
                <?php if (!empty($erro['notafiscal'])): ?>
              <div class="text-center alerta" role="alert">
                <strong> <?= $erro['notafiscal'] ?> </strong>
              </div>
            <?php endif ?> 
                <br>

                <!-- Data de compra -->

                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-calendar"></i>
                  </span>
                  
                  <input type="text" name="datacp" id="datacp" placeholder="Data de compra" class="form-control data <?php echo (!empty($erro['datacp'])) ? 'has-error' : ''; ?>" value="<?=$datacp?>">
                </div>
                <?php if (!empty($erro['datacp'])): ?>
                    <div class="text-center alerta" role="alert">
                    <strong> <?= $erro['datacp'] ?> </strong>
                    </div>
                <?php endif ?> 
                <br>

                <!-- Aparência do produto -->

                <div class="input-group">
                <span class="input-group-addon">
                    <i class="glyphicon glyphicon-picture"></i>
                  </span>
                  <input type="text" name="aparencia" id="aparencia" placeholder="Qual a aparência do produto?" class="form-control aparencia <?php echo (!empty($erro['aparencia'])) ? 'has-error' : ''; ?>" maxlength="50" value="<?=$aparencia?>">
                </div>
                <?php if (!empty($erro['aparencia'])): ?>
                    <div class="text-center alerta" role="alert">
                    <strong> <?= $erro['aparencia'] ?> </strong>
                    </div>
                <?php endif ?> 
                <br>

                <!-- Acessórios -->

                <div class="input-group">
                <span class="input-group-addon">
                    <i class="glyphicon glyphicon-paperclip"></i>
                  </span>
                  <input type="text" name="acessorios" id="acessorio" placeholder="Acessórios" class="form-control acessorios <?php echo (!empty($erro['acessorio'])) ? 'has-error' : ''; ?>" maxlength="50" value="<?=$acessorios?>">
                </div>
                <?php if (!empty($erro['acessorios'])): ?>
                    <div class="text-center alerta" role="alert">
                    <strong> <?= $erro['acessorios'] ?> </strong>
                    </div>
                <?php endif ?> 
                <br>
            
                <!-- Dados do consumidor -->

              <div class="title text-center">DADOS DO CONSUMIDOR </div>
              <br>

            <!-- Nome do consumidor  -->

              <div class="input-group">
                <span class="input-group-addon">
                    <i class="glyphicon glyphicon-user"></i>
                </span>
                <input type="text" name="nome" id="nome" placeholder="Nome" class="form-control nome <?php echo (!empty($erro['nome'])) ? 'has-error' : ''; ?>" maxlength="50" value="<?=$nome?>">
              </div>
              <?php if (!empty($erro['nome'])): ?>
                <div class="text-center alerta" role="alert">
                    <strong> <?= $erro['nome'] ?> </strong>
                </div>
              <?php endif ?> 
                <br>

                <!-- CPF ou CNPJ -->

              <div class="input-group">
                <span class="input-group-addon">
                    <i class="glyphicon glyphicon-credit-card"></i>
                </span>
                  <input type="text" name="documento" id="documento" placeholder="CPF ou CNPJ" class="form-control documento <?php echo (!empty($erro['documento'])) ? 'has-error' : ''; ?>" value="<?=$documento?>">
                </div>
                <?php if (!empty($erro['documento'])): ?>
                    <div class="text-center alerta" role="alert">
                        <strong> <?= $erro['documento'] ?> </strong>
                    </div>
                <?php endif ?> 
                <br>

                <!-- CEP -->

                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-pushpin"></i>
                  </span>
                  <input type="text" name="CEP" id="cep" placeholder="CEP" class="form-control cep <?php echo (!empty($erro['cep'])) ? 'has-error' : ''; ?>" maxlength="11" value="<?=$cep?>">
               </div>
               <?php if (!empty($erro['cep'])): ?>
                    <div class="text-center alerta" role="alert">
                        <strong> <?= $erro['cep'] ?> </strong>
                    </div>
                <?php endif ?> 
                <br>

                <!-- Estado -->

             <?php if($os == 0){ ?>
   <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-globe"></i>
                  </span>
                  <label name="estado" for="exampleFormControlSelect1" ></label>
                    <select id="estado" class="form-control estado <?php echo (!empty($erro['estado'])) ? 'has-error' : ''; ?>" id="selectestado" name="estado" <?php if($os == 0){?> value="" <?php }else{ ?> value="<?= $estado?>" <?php }?>>
                      <option value="">selecione</option>
                      <option value="AC">AC</option>
                      <option value="AL">AL</option>
                      <option value="AP">AP</option>
                      <option value="AM">AM</option>
                      <option value="BA">BA</option>
                      <option value="CE">CE</option>
                      <option value="DF">DF</option>
                      <option value="ES">ES</option>
                      <option value="GO">GO</option>
                      <option value="MA">MA</option>
                      <option value="MT">MT</option>
                      <option value="MS">MS</option>
                      <option value="MG">MG</option>
                      <option value="PA">PA</option>
                      <option value="PB">PB</option>
                      <option value="PR">PR</option>
                      <option value="PE">PE</option>
                      <option value="PI">PI</option>
                      <option value="RJ">RJ</option>
                      <option value="RN">RN</option>
                      <option value="RS">RS</option>
                      <option value="RO">RO</option>
                      <option value="RR">RR</option>
                      <option value="SC">SC</option>
                      <option value="SP">SP</option>
                      <option value="SE">SE</option>
                      <option value="TO">TO</option>
                      </select>
                </div> 
                
                <?php }else{ ?>
                <?php if (!empty($erro['estado'])): ?>
                    <div class="text-center alerta" role="alert">
                        <strong> <?= $erro['estado'] ?> </strong>
                    </div>
                <?php endif ?>
                <br>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-globe"></i>
                  </span>
                  <label name="estado" for="exampleFormControlSelect1"></label>
                  <select id="estado-selected" class="form-control estado <?php echo (!empty($erro['estado'])) ? 'has-error' : ''; ?>" id="selectestado" name="estado">
                    <option value="">selecione</option>
                    <option value="AC" <?= $estado == 'AC' ? 'selected' : '' ?>>AC</option>
                    <option value="AL" <?= $estado == 'AL' ? 'selected' : '' ?>>AL</option>
                    <option value="AP" <?= $estado == 'AP' ? 'selected' : '' ?>>AP</option>
                    <option value="AM" <?= $estado == 'AM' ? 'selected' : '' ?>>AM</option>
                    <option value="BA" <?= $estado == 'BA' ? 'selected' : '' ?>>BA</option>
                    <option value="CE" <?= $estado == 'CE' ? 'selected' : '' ?>>CE</option>
                    <option value="DF" <?= $estado == 'DF' ? 'selected' : '' ?>>DF</option>
                    <option value="ES" <?= $estado == 'ES' ? 'selected' : '' ?>>ES</option>
                    <option value="GO" <?= $estado == 'GO' ? 'selected' : '' ?>>GO</option>
                    <option value="MA" <?= $estado == 'MA' ? 'selected' : '' ?>>MA</option>
                    <option value="MT" <?= $estado == 'MT' ? 'selected' : '' ?>>MT</option>
                    <option value="MS" <?= $estado == 'MS' ? 'selected' : '' ?>>MS</option>
                    <option value="MG" <?= $estado == 'MG' ? 'selected' : '' ?>>MG</option>
                    <option value="PA" <?= $estado == 'PA' ? 'selected' : '' ?>>PA</option>
                    <option value="PB" <?= $estado == 'PB' ? 'selected' : '' ?>>PB</option>
                    <option value="PR" <?= $estado == 'PR' ? 'selected' : '' ?>>PR</option>
                    <option value="PE" <?= $estado == 'PE' ? 'selected' : '' ?>>PE</option>
                    <option value="PI" <?= $estado == 'PI' ? 'selected' : '' ?>>PI</option>
                    <option value="RJ" <?= $estado == 'RJ' ? 'selected' : '' ?>>RJ</option>
                    <option value="RN" <?= $estado == 'RN' ? 'selected' : '' ?>>RN</option>
                    <option value="RS" <?= $estado == 'RS' ? 'selected' : '' ?>>RS</option>
                    <option value="RO" <?= $estado == 'RO' ? 'selected' : '' ?>>RO</option>
                    <option value="RR" <?= $estado == 'RR' ? 'selected' : '' ?>>RR</option>
                    <option value="SC" <?= $estado == 'SC' ? 'selected' : '' ?>>SC</option>
                    <option value="SP" <?= $estado == 'SP' ? 'selected' : '' ?>>SP</option>
                    <option value="SE" <?= $estado == 'SE' ? 'selected' : '' ?>>SE</option>
                    </select>
                </div>
                
                <?php } ?>
                <?php if (!empty($erro['estado'])): ?>
                    <div class="text-center alerta" role="alert">
                        <strong> <?= $erro['estado'] ?> </strong>
                    </div>
                <?php endif ?> 
                <br>

                <!-- Cidade -->

                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-tent"></i>
                  </span>
                  <input type="text" name="cidade" id="cidade" placeholder="Cidade" class="form-control cidade <?php echo (!empty($erro['cidade'])) ? 'has-error' : ''; ?>" maxlength="50" value="<?=$cidade?>">
                </div>
                <?php if (!empty($erro['cidade'])): ?>
                    <div class="text-center alerta" role="alert">
                        <strong> <?= $erro['cidade'] ?> </strong>
                    </div>
                <?php endif ?> 
                <br>

                <!-- Bairro -->

                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-road"></i>
                  </span>
                  <input type="text" name="bairro" id="bairro" placeholder="Bairro" class="form-control bairro <?php echo (!empty($erro['bairro'])) ? 'has-error' : ''; ?>" maxlength="50" value="<?=$bairro?>">
                </div>
                <?php if (!empty($erro['bairro'])): ?>
                    <div class="text-center alerta" role="alert">
                        <strong> <?= $erro['bairro'] ?> </strong>
                    </div>
                <?php endif ?> 
                <br>

                <!-- Endereço -->

                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-home"></i>
                  </span>
                  <input type="text" name="endereco" id="endereco" placeholder="Endereço: Rua" class="form-control endereco <?php echo (!empty($erro['endereco'])) ? 'has-error' : ''; ?>" maxlength="50" value="<?=$endereco?>">
                </div>
                <?php if (!empty($erro['endereco'])): ?>
                    <div class="text-center alerta" role="alert">
                        <strong> <?= $erro['endereco'] ?> </strong>
                    </div>
                <?php endif ?> 
                <br>

               <!-- Número -->

               <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-asterisk"></i>
                  </span>
                  <input type="text" name="numero" id="numero" placeholder="Número" class="form-control numero <?php echo (!empty($erro['numero'])) ? 'has-error' : ''; ?>" maxlength="4" value="<?=$numero?>">
                </div>
                <?php if (!empty($erro['numero'])): ?>
                    <div class="text-center alerta" role="alert">
                        <strong> <?= $erro['numero'] ?> </strong>
                    </div>
                <?php endif ?> 
                <br>

                <!-- Complemento -->
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-plus"></i>
                  </span>
                  <input type="text" name="complemento" id="complemento" placeholder="Complemento" class="form-control complemento <?php echo (!empty($erro['complemento'])) ? 'has-error' : ''; ?>" maxlength="20" value="<?=$complemento?>">
                </div>
                <?php if (!empty($erro['complemento'])): ?>
                    <div class="text-center alerta" role="alert">
                        <strong> <?= $erro['complemento'] ?> </strong>
                    </div>
                <?php endif ?> 
                <br>

                <!-- Telefone fixo -->
                
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-earphone"></i>
                  </span>
                  <input type="text" name="telefone" id="telefone" placeholder="Telefone" class="form-control telefone <?php echo (!empty($erro['telefone'])) ? 'has-error' : ''; ?>" maxlength="10" value="<?=$telefone?>">
                </div>
                <?php if (!empty($erro['telefone'])): ?>
                    <div class="text-center alerta" role="alert">
                        <strong> <?= $erro['telefone'] ?> </strong>
                    </div>
                <?php endif ?> 
                <br>

                <!-- Celular -->
                
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-phone"></i>
                  </span>
                  <input type="text" name="celular" id="celular" placeholder="Celular" class="form-control celular <?php echo (!empty($erro['celular'])) ? 'has-error' : ''; ?>" maxlength="14" value="<?=$celular?>">
                </div>
                <?php if (!empty($erro['celular'])): ?>
                    <div class="text-center alerta" role="alert">
                        <strong> <?= $erro['celular'] ?> </strong>
                    </div>
                <?php endif ?> 
                <br>

                <!-- E-mail do consumidor -->

                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-envelope"></i>
                  </span>
                  <input type="text" name="email" id="email" placeholder="E-mail" class="form-control email <?php echo (!empty($erro['email'])) ? 'has-error' : ''; ?>" value="<?=$email?>">
                </div>
                <?php if (!empty($erro['email'])): ?>
                    <div class="text-center alerta" role="alert">
                        <strong> <?= $erro['email'] ?> </strong>
                    </div>
                <?php endif ?> 
                <br>

                <!-- Dados do produto -->
                <div class="title text-center">DADOS DO PRODUTO</div>
                <br>
                <div><span  class="pesquisar input-group-addon btn-produto" data-toggle="modal" data-target="#myModal"> PRODUTO <i class="glyphicon glyphicon-search"></i></span>
                </div>
                <br>

                <!-- Número de série -->

                <div class="input-group">
                  <span class="input-group-addon">
                  <i class="glyphicon glyphicon-barcode"></i>
                  </span>
                  <input type="text" name="numserie" id="numserie" placeholder="Número de série" class="form-control numserie <?php echo (!empty($erro['numserie'])) ? 'has-error' : ''; ?>" maxlength="10" value="<?=$numserie?>">
                </div>
                <?php if (!empty($erro['numserie'])): ?>
                    <div class="text-center alerta" role="alert">
                        <strong> <?= $erro['numserie'] ?> </strong>
                    </div>
                <?php endif ?> 
                <br> 
                <!-- Referência -->

                <div class="input-group">
              <span class="input-group-addon">
                  <i class="glyphicon glyphicon-comment"></i>
                </span>
                <input type="text" name="referencia" id="referencia" placeholder="Referência" class="form-control referencia <?php echo (!empty($erro['referencia'])) ? 'has-error' : ''; ?>" maxlength="10" value="<?=$referencia?>">
              </div>
              <?php if (!empty($erro['referencia'])): ?>
                    <div class="text-center alerta" role="alert">
                        <strong> <?= $erro['referencia'] ?> </strong>
                    </div>
                <?php endif ?> 
              <br>

                <!-- Descrição -->
                
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-pencil"></i>
                  </span>
                  <input type="text" name="descricao" id="descricao" placeholder="Descrição" class="form-control descricao <?php echo (!empty($erro['descricao'])) ? 'has-error' : ''; ?>" maxlength="50" value="<?=$descricao?>">
                </div>
                <?php if (!empty($erro['descricao'])): ?>
                    <div class="text-center alerta" role="alert">
                        <strong> <?= $erro['descricao'] ?> </strong>
                    </div>
                <?php endif ?> 
                <br>

                <!-- Defeito -->

                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-wrench"></i>
                  </span>
                  <label name="defeito" id="defeito" for="selectdefeito"></label>
                    <select class="form-control defeito <?php echo (!empty($erro['defeito'])) ? 'has-error' : ''; ?>" name="defeito" id="selectdefeito">
                      <option value=''>Selecione defeito</option>
                    <?php
                    $sql = "SELECT * FROM defeito WHERE fabrica = $login_fabrica";
                    $res = pg_query($con, $sql);
                    for ($d = 0; $d < pg_num_rows($res); $d ++){
                          $defeito = pg_fetch_result($res, $d, 'defeito');
                          $codigo = pg_fetch_result($res, $d, 'codigo');
                          $descricao = pg_fetch_result($res, $d, 'descricao');
                          $selected = '';
                      if($defeito_p == $defeito){
                        $selected = ' selected ';
                      }
                          echo "<option value='$defeito' $selected >$codigo - $descricao</option>";
                 } 
                  ?>

                    </select>
                </div>
                <?php if (!empty($erro['defeito'])): ?>
                    <div class="text-center alerta" role="alert">
                        <strong> <?= $erro['defeito'] ?> </strong>
                    </div>
                <?php endif ?> 
                <br>

                <!-- Botão de envio -->

                </div> 
                <input type="hidden" name="produto" class="produto" value="<?=$produto?>">
                <input type="hidden" name="os" class="os" value="<?=$os?>">
                <input type="hidden" name="fabrica" value="<?=$_fabrica ?>">
                <div class="text-center">
                <input type="submit" name="btn_gravar" class="btn" value="Gravar">
                <!-- <a href="#"><button class="btn">Excel(ainda vamos aprender)</button></a> -->
               
                  <br>
                  <br>
                </div>   
              </form>
              
              <!-- PHP mensagens de erro e sucesso -->
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

    <div class="col-md-4"></div>
   
    <script type="text/javascript">
    $(".data").mask("99/99/9999 99:99");
    $('.telefone').mask('(99) 9999-9999');
    $('.celular') .mask('(99) 99999-9999');
    $('.cep') .mask('99999-999');
    var options = {
		onKeyPress : function(documento, e, field, options) {
			var masks = ['000.000.000-000', '00.000.000/0000-00'];
			var mask = (documento.length > 14) ? masks[1] : masks[0];
			$('.documento').mask(mask, options);
		}
	};
	$('.documento').mask('000.000.000-000', options);
  
  $("#cep").blur(function(){
    var cep = $(this).val();

    $.ajax({
        url: "http://viacep.com.br/ws/"+ cep +"/json/",
        type: "GET",
        beforeSend: function(){
            $(this).text("Aguarde...");
        },
        async: false,
        timeout: 10000,
        success: function(dados) {
          console.log (dados);
            $("#endereco").val(dados.logradouro);
            $("#bairro").val(dados.bairro);
            $("#cidade").val(dados.localidade);
            $("#estado").find("option[value='" + dados.uf + "']").prop("selected", true);
        }
    });
});
  
  </script>

    </body>
    </html>