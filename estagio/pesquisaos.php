<?php   
  include "../config/conexao.php";
  include "checalogin.php";
  include "autenticacao.php";


  function organizar_data($data) {
    $partes = explode('/', $data);
    $nova_data = $partes[2] . '-' . $partes[1] . '-' . $partes[0];
    return $nova_data;
}

  if (isset($_POST['btn_pesquisar']) && $_POST['btn_pesquisar'] == 'Pesquisar') {
    $limpar = array('(', ')', '-', '.', ' ', '/');
    $cond = "";
    $erro = "";

    if (empty($_POST['datainicio']) && empty($_POST['datafim']) && empty($_POST['documento']) && empty($_POST['numserie']) && empty($_POST['descricao'])) {
        $erro = "Não é possível pesquisar com todos os campos vazios";
    } else {

        if (empty($_POST['datainicio']) && empty($_POST['documento']) && empty($_POST['numserie']) && empty($_POST['descricao'])){
          $erro = "Sem período válido, insiria a data de início!";
        }

        if (empty($_POST['datafim']) && empty($_POST['documento']) && empty($_POST['numserie']) && empty($_POST['descricao'])){
          $erro = "Sem período válido, insiria a data de fim!";
        }

        if (!empty($_POST['datainicio']) &&  !empty($_POST['datafim'])){
          $datainicio = filter_var($_POST['datainicio'], FILTER_SANITIZE_SPECIAL_CHARS);
          $datafim = filter_var($_POST['datafim'], FILTER_SANITIZE_SPECIAL_CHARS);
          $datainicio_banco = organizar_data($datainicio);
          $datafim_banco = organizar_data($datafim);
          $radio = filter_var($_POST['radio_data'], FILTER_SANITIZE_SPECIAL_CHARS);

          $cond .= " AND $radio BETWEEN '$datainicio_banco' AND '$datafim_banco'";

        }

        if (!empty($_POST['documento'])) {
            $documento = $_POST['documento'];
            $documento = str_replace($limpar, '', $documento);

            $cond .= " AND cpf_cnpj = '$documento'";
            
        }

        if (!empty($_POST['descricao'])) {
            $descricao = $_POST['descricao'];

            $cond .= " AND descricao LIKE '%$descricao%'";
                    
        }
        
        if (!empty($_POST['numserie'])) {
            $numserie = $_POST['numserie'];
            $cond .= " AND numero_serie = '$numserie'";
                    
        }

        
        

        if (strlen(trim($erro)) == 0) {
          $sql = "SELECT os.*, 
                     to_char(os.data_abertura, 'DD/MM/YYYY') AS data_abertura_formatada, 
                     to_char(os.data_compra, 'DD/MM/YYYY') AS data_compra_formatada, 
                     cpf_cnpj, 
                     numero_serie, 
                     produto.descricao, 
                     produto.referencia
                  FROM OS
                  JOIN produto ON os.produto = produto.produto
                  WHERE os.fabrica = $login_fabrica AND os > 0 $cond"; //devo colocar AND fabrica = $login_fabrica ??
      
          $res = pg_query($con, $sql);
     

          if (strlen(pg_last_error($con)) > 0) {
              $erro = "Não foi possível encontrar resultados";
          }else if(pg_num_rows($res) == 0){
              $erro = "Não há resultados para essa pesquisa!";
          } 
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
    <title>Pesquisa de OS</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="geral.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <link rel="stylesheet" href="css/shadowbox.css" >
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
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
            PESQUISA DE OS
          </div>
          <div class="panel-body">
            <form method="POST">
              <br>

              <!-- CPF ou CPNJ -->
              <div class="input-group">
                <span class="input-group-addon">
                    <i class="glyphicon glyphicon-credit-card"></i>
                </span>
                  <input type="text" name="documento" placeholder="CPF ou CNPJ" class="form-control documento" maxlength="14">
                </div>
                <br>

                  <!-- Descrição -->
                
                  <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-pencil"></i>
                  </span>
                  <input type="text" name="descricao" placeholder="Descrição" class="form-control descricao" maxlength="50">
                </div>
                <br>
                
                <div>
                  <label class="active">
                    <input type="radio" name="radio_data" id="dataab" value="data_abertura" checked> Data de abertura
                  </label>
                  <br>
                  <label class="">
                    <input type="radio" name="radio_data" id="datadig" value="data_digitacao"> Data de digitação
                  </label>
                  <br>
                  <label class="">
                    <input type="radio" name="radio_data" id="datafech" value="data_fechamento"> Data de fechamento
                  </label>
                 
                </div>

              <!-- Data de inicio -->
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-calendar"></i>
                  </span>
                  <input type="text" name="datainicio" placeholder="Data de inicio" class="form-control data" value="<?=$datainicio?>">
                </div>
                <br>

                <!-- Data de fim -->
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-calendar"></i>
                  </span>
                  <input type="text" name="datafim" placeholder="Data de fim" class="form-control data" value="<?=$datafim?>"> 
                </div>
                <br>

                <!-- Número de série -->

                <div class="input-group">
                  <span class="input-group-addon">
                  <i class="glyphicon glyphicon-barcode"></i>
                  </span>
                  <input type="text" name="numserie" placeholder="Número de série" class="form-control numserie" maxlength="10">
                </div>
                <br>

                <div class="text-center">
                <input type="submit" name="btn_pesquisar" class="btn" value="Pesquisar">
                <input type="hidden" name="produto" value="" class="produto">
                <input type="hidden" name="os" value="<?=$os?>">
                  <br>
                  <br>
                </div>   
              </form>
              <?php if (!empty($erro)): ?>
                        <div class="alert alert-danger text-center" role="alert">
                          <strong> <?php  echo "$erro" ?> </strong>
                        </div>
                      <?php endif ?> 
                      
                
    </div>
      </div>
        </div>

    <div class="col-md-4"></div>
      </div>

    <script src="js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
    $(".data").mask("99/99/9999 99:99");
    $('.telefone').mask('(99) 9999-9999');
    $('.celular') .mask('(99) 99999-9999');
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
  </script>
 <?php 
      if(isset($_POST['btn_pesquisar']) && pg_num_rows(($res))) {
      ?>
          <div class="container table-responsive"> 
            <div class="col-2"></div>
            <div class="col-8">
            <table class="table" id="tabela_os" class="table table-striped table-bordered table-hover table-large table-fixed table-pesquisa">
                <thead>
                    <tr class="titulo_tabela">
                         <th></th>
                         <th>Data de abertura</th>
                        <th>Atendimento</th>
                        <th>Nota fiscal</th>
                        <th>Data da compra</th>
                        <th>Aparência</th>
                        <th>Acessórios</th>
                        <th>Nome</th>
                        <th>Documento</th>
                        <th>CEP</th>
                        <th>Estado</th>
                        <th>Cidade</th>
                        <th>Bairro</th>
                        <th>Endereço</th>
                        <th>Número</th>
                        <th>Telefone</th>
                        <th>Celular</th>
                        <th>E-mail</th>
                        <th>Produto</th>
                        <th>Núm. de série</th>
                        <th>Descrição</th>
                        <th>Referência</th>
                        <th>Defeito</th>
                       

                    </tr>
                </thead>
                <tbody>
              
                        <?php 
                         
                          for($p=0; $p<pg_num_rows($res); $p++){
                            $os = pg_fetch_result($res, $p, "os");
                            $atendimento = pg_fetch_result($res, $p, "tipo_atendimento");
                            $dataab = pg_fetch_result($res, $p, "data_abertura_formatada");
                            $notafiscal = pg_fetch_result($res, $p, "nota_fiscal"); 
                            $datacp = pg_fetch_result($res, $p, "data_compra_formatada"); 
                            $aparencia = pg_fetch_result($res, $p, "aparencia"); 
                            $acessorios = pg_fetch_result($res, $p, "acessorio"); 
                            $nome = pg_fetch_result($res, $p, "nome_consumidor"); 
                            $documento = pg_fetch_result($res, $p, "cpf_cnpj"); 
                            $cep = pg_fetch_result($res, $p, "cep_consumidor"); 
                            $estado = pg_fetch_result($res, $p, "estado_consumidor"); 
                            $cidade = pg_fetch_result($res, $p, "cidade_consumidor"); 
                            $bairro = pg_fetch_result($res, $p, "bairro_consumidor"); 
                            $endereco = pg_fetch_result($res, $p, "endereco_consumidor"); 
                            $numero = pg_fetch_result($res, $p, "numero_consumidor"); 
                            $telefone = pg_fetch_result($res, $p, "telefone_consumidor"); 
                            $celular = pg_fetch_result($res, $p, "celular_consumidor"); 
                            $email = pg_fetch_result($res, $p, "email_consumidor"); 
                            $produto = pg_fetch_result($res, $p, "produto"); 
                            $numserie = pg_fetch_result($res, $p, "numero_serie"); 
                            $descricao = pg_fetch_result($res, $p, "descricao");
                            $referencia = pg_fetch_result($res, $p, "referencia"); 
                            $defeito = pg_fetch_result($res, $p, "defeito");  
                            
                            ?>
                            <tr class='conteudo-tabela'>
                                    <td><a href="cadastrodeos.php?os=<?=$os?>"><button class=' btn'>Editar</button></td>
                                    <td><?=$dataab?></td>
                                    <td><?=$atendimento?></td>
                                    <td><?=$notafiscal?></td>
                                    <td><?=$datacp?></td>
                                    <td><?=$aparencia?></td>
                                    <td><?=$acessorios?></td>
                                    <td><?=$nome?></td>
                                    <td class="documento"><?=$documento?></td>
                                    <td class="cep"><?=$cep?></td>
                                    <td><?=$estado?></td>
                                    <td><?=$cidade?></td>
                                    <td><?=$bairro?></td>
                                    <td><?=$endereco?></td>
                                    <td><?=$numero?></td>
                                    <td class="telefone"><?=$telefone?></td>
                                    <td class="celular"><?=$celular?></td>
                                    <td><?=$email?></td>
                                    <td><?=$produto?></td>
                                    <td><?=$numserie?></td>
                                    <td><?=$descricao?></td>
                                    <td><?=$referencia?></td>
                                      <td><?=$defeito?></td>
                              </tr>";
                                </tr>
                                <?php
                              }
                            ?>
                </tbody>
                          </table>
            </div>
            </div>
            </div>
            <div class="col-2"></div>
      <?php } ?>
    
    </body>
    </html>
