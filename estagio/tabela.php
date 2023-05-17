<?php
include "checalogin.php";
include "autenticacao.php";
include "../config/conexao.php";

?>
 
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="tabela.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    </head>
    <body>
        <div class="container">
            <nav class="nav text-center" id="pesquisa">
                PESQUISA PRODUTO
            </nav> 
        </div>
            <br>
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-4">
                    <div class="radios">Pesquisar por:
                    <br>
                  <label class="active">
                    <input type="radio" name="radio_produto" id="referencia" value="referencia" class="escolha" checked> referência
                  </label>
                  <label>   </label>
                  <label class="">
                    <input type="radio" name="radio_produto" id="descricao" value="descricao" class="escolha"> descrição
                  </label>
                    </div>
                        <div class="input-group barra-pesquisa">
                            <input type="search" name="barra-pesquisa" placeholder="Pesquise aqui..." class="form-control" value="">
                                <span class="input-group-addon">
                                    <i><button class="glyphicon glyphicon-search btn_produto"></button></i>
                                </span>
                        </div>
                    </div>
                </div>
           </form>        
        <?php
            $sql = "SELECT * FROM produto WHERE fabrica = $login_fabrica";
            $res = pg_query($con, $sql);
            if (pg_num_rows($res) > 0){
        ?>  
        
        <table class="table" id= "resultado_tipo_solicitacao" class="table table-striped table-bordered table-hover table-large table-fixed">
            <thead>
                <tr class="titulo_coluna">
                    <th class="ocultar">Produto</th>
                    <th>Referência</th>
                    <th>Descrição</th>
                    <th></th>
                    <!-- <th>Garantia</th>
                    <th>Ativo</th> -->
                </tr>
             </th>
            </thead>
            <tbody>
            <?php 
                for ($i = 0; $i < pg_num_rows($res); $i ++){
                    $produto = pg_fetch_result($res, $i, 'produto');
                    $referencia = pg_fetch_result($res, $i, 'referencia');
                    $descricao = pg_fetch_result($res, $i, 'descricao');
                    // $garantia = pg_fetch_result($res, $i, 'garantia');
                    // $ativo = pg_fetch_result($res, $i, 'ativo');
          
            ?>
            <tr>
                <td class="ocultar"><a href="#" onclick="window.parent.retornaProduto(<?= $produto?>, '<?= $referencia?>', '<?= $descricao?>'); window.parent.Shadowbox.close()"><?= $produto ?></a></td>
                <td><?= $referencia ?></td> 
                <td><?= $descricao ?></td>
                <td><a href='#' onclick="window.parent.retornaProduto(<?= $produto?>, '<?= $referencia?>', '<?= $descricao?>'); window.parent.Shadowbox.close()"><button class='btn'>Selecionar</button></a></td>
            </tr>
        <?php } ?>
      </tbody>
    </table>
    <?php }else ?>
            </tbody>
        </table>
        </div>
    </body>
    </body>
    <script src="js/bootstrap.min.js"></script>
   
</html>