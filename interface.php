<!DOCTYPE html>

<html>

<head>
    <!-- Links para css -->
    <link href="css/interfacestyle.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <!-- Fontes de Caio -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Barlow+Semi+Condensed" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans|Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">

    <meta charset="utf-8">
    <title>Petbox</title>

</head>

<body>
    <div class="grid">
        <!--====== Interface ======-->

        <!--Area onde fica a foto e nome -->
        <div id="colunaEsq">
            <div class="foto">
                <img class="fotoPerfil" src="img/petlogo.png" >
            </div>

            <div>
                <label>
                    <?php
                    echo '<h3 class="nome" >'.$_SESSION['u_first'] .' '. $_SESSION['u_last'].'</h3>';
                    ?>
                </label>
                <br>

            </div>
        </div>



        <!--Area do debito em cada caixa e tipo usuario-->
        <div id="colunaMeio">
            <label>
                <h3 class="titulos">Saldos</h3>
            </label>

            <!-- PetBox Geral -->
            <label>
                <h4 class="subtitulos">Caixa Geral:</h4>
            </label>


            <div class="caixinhas">
                <?php
                    include_once 'includes/dbh.inc.php';
                    $query="SELECT * FROM caixinhas WHERE caixinha_id=1";
                    $results = mysqli_query($conn,$query);
                    $row = mysqli_fetch_array($results);
                    echo '<input type="text" value="R$ '. $row['caixinha_value'].'" class="caixasEspecs" readonly="readonly">';
                ?>
            </div>

            <!-- PetShop Comida -->
            <label>
                <h4 class="subtitulos">Caixa Comida:</h4>
            </label>

            <div class="caixinhas">
                <?php
                    include_once 'includes/dbh.inc.php';
                    $query="SELECT * FROM caixinhas WHERE caixinha_id=2";
                    $results = mysqli_query($conn,$query);
                    $row = mysqli_fetch_array($results);
                    echo '<input type="text" value="R$ '. $row['caixinha_value'].'" class="caixasEspecs" readonly="readonly">';
                ?>
            </div>

        </div>


        <!--Area dos botoes especiais de usuario-->
        <div id="colunaDir">

            <!-- Botão de sair -->
            <form action="includes/logout.inc.php" class="botaoSair" method="POST">

                <button class=" botaoSairInterface" type="submit" name="submit">Sair
                </button>
            </form>

            <!-- Botões centrais para usuário selecionar -->
            <div class="botoesEspeciaisBaixo">


                <div>
                <?php
                if($_SESSION['u_permission'] == 3){
                    echo'<button onclick="document.getElementById(\'cadastroForm\').style.display=\'block\'" class="botaoUsuarioInterface">Cadastrar Petiano</button>';
                }
                ?>
                </div>
                <div>

                <?php
                if($_SESSION['u_permission'] == 3){
                    echo'<button onclick="document.getElementById(\'cadastroForm\').style.display=\'block\'" class="botaoUsuarioInterface" disabled>Histórico Tutor</button>';
                }
                ?>
                </div>


                <form action="includes/desfazeracao.php" method="POST">
                    <div>
                    <?php
                    if($_SESSION['u_permission'] == 3){
                        echo'<input type="submit" name="submit" class="botaoUsuarioInterface " value="Desfazer">';
                    }
                    ?>
                    </div>
                </form>

            </div>
        </div>


        <!--====== Dados ======-->
        <div class="dados">

        </div>

        <!--====== Varys =======-->
        <div class="varys">
            <table id="varysTabelaHtml">
                <tr class="varysHeader">
                        <?php
                        if($_SESSION['u_permission'] >=2){
                                echo'
                            <th>
                                <button onclick="document.getElementById(\'saqueForm\').style.display=\'block\'" class="botaoInterface botoes">Pagamento<br>Saque</button>
                            </th>
                            <th>
                                <button onclick="document.getElementById(\'depositoForm\').style.display=\'block\'" class="botaoInterface botoes">Depósito</button>
                            </th>
                            <th>
                                <button onclick="document.getElementById(\'transferenciaForm\').style.display=\'block\'" class="botaoInterface botoes">Transferência</button>
                            </th>
                            <th>
                                <button onclick="document.getElementById(\'mensalForm\').style.display=\'block\'" class="botaoInterface botoes">Depósito
                                    <br>Mensal</button>
                            </th>
                            ';
                    } else {
                            echo'
                            <th></th><th></th><th></th><th></th>';
                    }
                            ?>
                <th>
                        <input class="bordaArredondada"type="text" id="varysPesquisar" onkeyup="varysPesquisar()" placeholder="Pesquisar" size="5">
                    </th>
                    <th>
                        <button onclick="document.getElementById('configuracaoForm').style.display='block'" class="botaoInterface botoes" >
                            <img src="img/mateus.png" style="width: 24px;" />
                        </button>
                    </th>
                </tr>
                <tr>
                    <th class="info">Nome</th>
                    <th class="info">Ação</th>
                    <th class="info">Valor</th>
                    <th class="info">Origem</th>
                    <th class="info">Destino</th>
                    <th class="info">Data</th>
                </tr>
                    <?php

                        include_once 'includes/dbh.inc.php';
                        $query="SELECT * FROM varys ORDER BY varys.dataAcao DESC";
                        $results = mysqli_query($conn,$query);
                        while ($row = mysqli_fetch_array($results)) {
                            $destino = " ";
                            $origem = " ";
                            if($row['origem'] == "caixinha1"){
                                $origem = "Box Geral";
                            } elseif ($row['origem'] == "caixinha2"){
                                $origem = "Box Comida";
                            }
                            if($row['destino'] == "caixinha1"){
                                $destino = "Box Geral";
                            } elseif ($row['destino'] == "caixinha2"){
                                $destino = "Box Comida";
                            }

                            //Verifica a se a extensão do arquivo é pdf
                            $tmp = explode('.',$row['imagem']);
                            $extensao = strtolower(end($tmp));
                            if( $extensao == 'pdf'){
                              //Mostra a tela de comprovante
                              $func1 = "document.getElementById('comprovanteDiv').style.display='block'";
                              //Pega o caminho para o arquivo à ser mostrado
                              $caminho = explode("../", $row['imagem']);
                              //Adiciona o atributo hidden da tag img
                              $func2 = "document.getElementById('imagemPagamento').setAttribute('hidden','hidden')";
                              //Adiciona o atributo data da tag objeto
                              $func3 = "document.getElementById('pdfPagamento').data = '".$caminho[1]."'";
                              //Remove o atributo hidden da tag objeto
                              $func4 = "document.getElementById('pdfPagamento').removeAttribute('hidden')";
                              //Atualiza o texto da justificativa da movimentação finaceira
<<<<<<< HEAD
                              $justificativa = utf8_encode($row['justificativa']);
=======
                              $justificativa = utf8_decode($row['justificativa']);
>>>>>>> adb4990ca800db9c132c9dd6148615f920ee5512
                              $func5 = "document.getElementById('justificativaTexto').innerHTML = '".$justificativa."';";
                              //$func5 = "document.getElementById('justificativaTexto').innerHTML = 'AECRARALHO ';";
                              //echo 'onclick="'.$func1.';'.$func2.';'.$func3.';"'; die();
                              echo '<tr onclick="'.$func1.';'.$func2.';'.$func3.';'.$func4.';'.$func5.'"><td>'. $row['agente'] .'</td>
                              <td>'. $row['tipo'] .'</td>
                              <td>R$ '. $row['valor'] .'</td>
                              <td>'. $origem .'</td>
                              <td>'. $destino .'</td>
                              <td>'. $row['dataAcao'] .'</td></tr>';

                            }else{
                              //Mostra a tela de comprovante
                              $func1 = "document.getElementById('comprovanteDiv').style.display='block'";
                              //Pega o caminho para o arquivo à ser mostrado
                              $caminho = explode("../", $row['imagem']);
                              //Adiciona o atributo hidden da tag objeto
                              $func2 = "document.getElementById('pdfPagamento').setAttribute('hidden','hidden')";
                              //Adiciona o endereço da imagem
                              $func3 = "document.getElementById('imagemPagamento').src = '".end($caminho)."'";
                              //Remove o atributo hidden da tag img
                              $func4 = "document.getElementById('imagemPagamento').removeAttribute('hidden')";
                              //Atualiza o texto da justificativa da movimentação finaceira
<<<<<<< HEAD
                              $justificativa = utf8_encode($row['justificativa']);
=======
                              $justificativa = utf8_decode($row['justificativa']);
>>>>>>> adb4990ca800db9c132c9dd6148615f920ee5512
                              $func5 = "document.getElementById('justificativaTexto').innerHTML = '".$justificativa."';";
                              //$func5 = "document.getElementById('justificativaTexto').innerHTML = 'AECRARALHO ';";
                              //echo 'onclick="'.$func1.';'.$func2.';'.$func3.';"'; die();
                              echo '<tr onclick="'.$func1.';'.$func2.';'.$func3.';'.$func4.';'.$func5.'"><td>'. $row['agente'] .'</td>
                              <td>'. $row['tipo'] .'</td>
                              <td>R$ '. $row['valor'] .'</td>
                              <td>'. $origem .'</td>
                              <td>'. $destino .'</td>
                              <td>'. $row['dataAcao'] .'</td></tr>';
                            }
                        }
                    ?>
            </table>
        </div>
    </div>


    <!--Formulário de cadastro de usuário-->
    <div id="cadastroForm" class="w3-modal">

        <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
            <div class="w3-center">
                <br>

                <span onclick="document.getElementById('cadastroForm').style.display='none'" class="w3-button w3-xlarge w3-transparent w3-display-topright"
                    title="Fechar Formulario">×</span>

                <img src="img/petlogo.png" alt="petlogo" style="width:16%;" class="w3-circle w3-margin-top">
            </div>

            <form class="w3-container" action="includes/signup.inc.php" method="POST">
                <div class="w3-section">

                    <label>
                        <b>Nome</b>
                    </label>
                    <input name="first" class="w3-input w3-border w3-margin-bottom bordaArredondada" type="text"  placeholder="Entre com o nome de usuario"
                        name="usrname" required>

                    <label>
                        <b>Sobrenome</b>
                    </label>
                    <input name="last" class="w3-input w3-border bordaArredondada" type="text" placeholder="Entre com o sobrenome" name="psw" required>
                    <br>

                    <label>
                        <b>E-mail</b>
                    </label>
                    <input name="email" class="w3-input w3-border bordaArredondada" type="text" placeholder="Entre com o email" name="psw" required>
                    <br>

                    <label>
                        <b>Nome de Usuário</b>
                    </label>
                    <input name="uid" class="w3-input w3-border w3-margin-bottom bordaArredondada" type="text"  placeholder="Entre com o nome de usuario"
                        name="usrname" required>

                    <label>
                        <b>Senha</b>
                    </label>
                    <input name="pwd" class="w3-input w3-border bordaArredondada" type="password" placeholder="Entre com a senha" name="psw" required>
                    <br>

                    <label>
                        <b>Tipo de Usuário:</b>
                    </label>
                    <br>
                    <br>
                    <input type="radio" name="tipo" value="1" checked="checked"> Petiano
                    <br>
                    <input type="radio" name="tipo" value="2"> Administrador
                    <br>
                    <input type="radio" name="tipo" value="3"> Tutor
                    <br>

                    <button name="submit" class="w3-block w3-blue w3-section w3-padding bordaArredondada botoes" type="submit">Cadastrar</button>
                </div>
            </form>

            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">

                <button onclick="document.getElementById('cadastroForm').style.display='none'" type="button" class="w3-button w3-red bordaArredondada">Cancelar</button>

                <!--<span class="w3-right w3-padding w3-hide-small">Forgot <a href="#">password?</a></span>-->
            </div>

        </div>
    </div>

    <!--Formulário de saque de usuário-->
    <div id="saqueForm" class="w3-modal">

        <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
            <div class="w3-center">
                <br>

                <span onclick="document.getElementById('saqueForm').style.display='none'" class="w3-button w3-xlarge w3-transparent w3-display-topright"
                    title="Fechar Formulario">×</span>


            </div>

            <form class="w3-container" enctype="multipart/form-data" action="includes/saque_inc.php" method="POST">
                <div class="w3-section">

                    <label>
                        <b>Valor</b>
                    </label>
                    <input class="w3-input w3-border w3-margin-bottom bordaArredondada" type="number" step=0.01 placeholder="Entre com o valor do saque ou pagamento"
                        name="valor" required>

                    <label>
                        <b>Caixas do Pet:</b>
                    </label>
                    <br>
                    <input type="radio" name="caixa" value="caixinha1" checked> Caixa Geral
                    <br>
                    <input type="radio" name="caixa" value="caixinha2"> Caixa Comida
                    <br>

                    <br>
                    <label>
                      <b>Anexar Comprovante:</b>
                    </label>
                    <br>
                    <input type="hidden" name="size" value="1000000">
                    <input type="file" name="imagem">
                    <br>
                    <br>
                    <label>
                      <b>Justificativa:</b>
                    </label>
                    <br>
                    <textarea rows="4" cols="50" name="justificativa"></textarea>
                    <br>
                    <button class="w3-block w3-blue w3-section w3-padding bordaArredondada botoes" type="submit" name="submit">Registrar Saque/Pagamento</button>
                </div>
            </form>

            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">

                <button onclick="document.getElementById('saqueForm').style.display='none'" type="button" class="w3-button w3-red bordaArredondada">Cancelar</button>

            </div>

        </div>
    </div>

    <!--Formulário de deposito de usuário-->
    <div id="depositoForm" class="w3-modal">

        <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
            <div class="w3-center">
                <br>

                <span onclick="document.getElementById('depositoForm').style.display='none'" class="w3-button w3-xlarge w3-transparent w3-display-topright"
                    title="Fechar Formulario">×</span>


            </div>

            <form class="w3-container" enctype="multipart/form-data" action="includes/deposito_inc.php" method="POST">
                <div class="w3-section">

                    <label>
                        <b>Valor</b>
                    </label>
                    <input class="w3-input w3-border w3-margin-bottom bordaArredondada" type="number" step=0.01 placeholder="Entre com o valor do deposito"
                        name="valor" required>

                    <label>
                        <b>Em nome de:</b>
                    </label>
                    <br>
                         <?php
                        include_once 'includes/dbh.inc.php';
                        $query="SELECT * FROM users";
                        $results = mysqli_query($conn,$query);
                        echo '<select required name="agente">';
                        while ($row = mysqli_fetch_array($results)) {
                            echo '<option value="'. $row['user_uid'] .'">' . $row['user_uid'] . '</option>';
                        } echo '</select>';
                        ?>
                    <br>
                    <br>
                    <label>
                        <b>Caixas do Pet:</b>
                    </label>
                    <br>
                    <input type="radio" name="caixa" value="caixinha1" checked> Caixa Geral
                    <br>
                    <input type="radio" name="caixa" value="caixinha2"> Caixa Comida
                    <br>

                    <br>
                    <label>
                      <b>Anexar Comprovante:</b>
                    </label>
                    <br>
                    <input type="hidden" name="size" value="1000000">
                    <input type="file" name="file">
                    <br>
                    <br>
                    <label>
                      <b>Justificativa:</b>
                    </label>
                    <br>
                    <textarea rows="4" cols="50" name="justificativa"></textarea>
                    <br>


                    <button class="w3-block w3-blue w3-section w3-padding bordaArredondada botoes" type="submit" name="submit">Registrar depósito</button>
                </div>
            </form>

            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">

                <button onclick="document.getElementById('depositoForm').style.display='none'" type="button" class="w3-button w3-red bordaArredondada">Cancelar</button>

                <!--<span class="w3-right w3-padding w3-hide-small">Forgot <a href="#">password?</a></span>-->
            </div>

        </div>
    </div>

    <!--Transferencia -->
    <div id="transferenciaForm" class="w3-modal">

            <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
                <div class="w3-center"><br>

                    <span onclick="document.getElementById('transferenciaForm').style.display='none'" class="w3-button w3-xlarge w3-transparent w3-display-topright" title="Fechar Formulario">×</span>

                    <!--<img src="img/petlogo.png" alt="petlogo" style="width:16%;" class="w3-circle w3-margin-top">-->
                </div>

            <form class="w3-container" action="includes/transferencia_inc.php" method="POST">
                <div class="w3-section">

                    <label><b>Valor</b></label>
                    <input class="w3-input w3-border w3-margin-bottom bordaArredondada"  step=0.01 type="number" placeholder="Valor da Transferência" name="valor" required>

                    <label><b>Tipo de Transferência:</b></label><br><br>
                    <input type="radio" name="transferencia" value="caixinha1->caixinha2" checked> Caixa Geral para Caixa Comida<br>
                    <input type="radio" name="transferencia" value="caixinha2->caixinha1"> Caixa Comida para Caixa Geral<br>

                    <button type="submit" name="submit" class="w3-block w3-blue w3-section w3-padding bordaArredondada botoes">Transferir</button>
                </div>
            </form>

            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">

                <button onclick="document.getElementById('transferenciaForm').style.display='none'" type="button" class="w3-button w3-red bordaArredondada">Cancelar</button>

            </div>

        </div>
    </div>

    <!-- Configuração -->
    <div id="configuracaoForm" class="w3-modal">

            <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
                <div class="w3-center"><br>

                    <span onclick="document.getElementById('configuracaoForm').style.display='none'" class="w3-button w3-xlarge w3-transparent w3-display-topright" title="Fechar Configuração">×</span>

                    <!--<img src="img/petlogo.png" alt="petlogo" style="width:16%;" class="w3-circle w3-margin-top">-->
                </div>

            <form class="w3-container" action="includes/novasenha.inc.php" method="POST">
                <div class="w3-section">

                    <label><b>Senha antiga:</b></label><br><br>
                    <input class="w3-input w3-border w3-margin-bottom bordaArredondada" type="password" placeholder="Senha antiga" name="senhaantiga" required>

                    <label><b>Senha nova:</b></label><br><br>
                    <input class="w3-input w3-border w3-margin-bottom bordaArredondada" type="password" placeholder="Senha nova" name="senhanova" required>

                    <button type="submit" name="submit" class="w3-block w3-blue w3-section w3-padding bordaArredondada botoes">Mudar Senha</button>
                </div>
            </form>

            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">

                <button onclick="document.getElementById('transferenciaForm').style.display='none'" type="button" class="w3-button w3-red bordaArredondada">Cancelar</button>

            </div>

        </div>
    </div>


    <!-- Deposito Mensal -->
    <div id="mensalForm" class="w3-modal">

        <div class="w3-modal-content w3-card-4 w3-animate-zoom bordaArredondada" style="max-width:600px">
            <div class="w3-center"><br>

                <span onclick="document.getElementById('mensalForm').style.display='none'" class="w3-button w3-xlarge w3-transparent w3-display-topright bordaArredondada" title="Fechar Configuração">×</span>
            </div>

            <form class="w3-container" action="includes/depositomensal_inc.php" method="POST">
                <div class="w3-section">
                    <label><b>Lista de Petianos</b></label>
                    <table id="varysTabelaHtml" class="depositoMensalTabela">
                        <br>
                        <br>
                        <tr class="varysHeader">
                            <th>

                            </th>
                            <th>

                            </th>
                            <th>

                            </th>
                            <th>

                            </th>
                            <th>

                            </th>
                            <th>
                                <button onclick="" class="botaoInterface botoes" disabled>
                                    <img src="img/mateus.png" style="width: 24px;" />
                                </button>
                            </th>
                        </tr>
                        <tr>
                            <th class="info">Nome</th>
                            <th class="info"> </th>
                            <th class="info"> </th>
                            <th class="info">Valor</th>
                            <th class="info">Destino</th>
                            <th class="info">Pago</th>
                        </tr>
                        <?php
                        include_once 'includes/dbh.inc.php';
                        $query="SELECT * FROM users";
                        $results = mysqli_query($conn,$query);
                        while ($row = mysqli_fetch_array($results)) {
                            echo '<tr>
                                  <th id="nomePagoMensal" style="bordaArredondada"><input name="agente[]" value="'. $row['user_uid'] .'" readonly></th>
                                  <th class="info"> </th>
                                  <th class="info"> </th>
                                  <th style="bordaArredondada" value="'. $row['user_first'] .'"><input id="valorMensalInput" type="text" value="10" name="valor[]"></th>
                                  <th>
                                  <select id="caixinhaDeDestinoMensal" name="caixa[]">
                                    <option style="bordaArredondada" value="caixinha1">PetBox</option>
                                    <option style="bordaArredondada" value="caixinha2">PetShop</option>
                                  </select>
                                  </th>
                                  <th><input id="pagoCheckbox" type="checkbox" name="pago[]" checked></th>
                                  </tr>';
                        }
                        ?>

                    </table>

                    <button type="submit" name="submit" class="w3-block w3-blue w3-section w3-padding bordaArredondada botoes">Registrar Deposito Mensal</button>
                </div>
            </form>

            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">

                <button onclick="document.getElementById('mensalForm').style.display='none'" type="button" class="w3-button w3-red bordaArredondada">Cancelar</button>

            </div>

        </div>
    </div>

    <!-- Imagem comprovante -->
    <div id="comprovanteDiv" class="w3-modal">

        <div class="w3-modal-content w3-card-4 w3-animate-zoom bordaArredondada" style="max-width:600px;  text-align: center;">
            <div class="w3-center"><br>

                <span onclick="document.getElementById('comprovanteDiv').style.display='none'" class="w3-button w3-xlarge w3-transparent w3-display-topright bordaArredondada" title="Fechar Configuração">×</span>
            </div>

            <img id="imagemPagamento" style="width: 300px;" src="">
            <object id="pdfPagamento" width="400" height="400" data="" hidden="hidden" ></object>
            <br>
            <br>
            <label style="text-align: center;">
              <b>
              Justificativa
              <b>
            </label>
            <h6 id="justificativaTexto">

            </h6>
            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">

                <button onclick="document.getElementById('comprovanteDiv').style.display='none'" type="button" class="w3-button w3-red bordaArredondada">Fechar</button>

            </div>

        </div>
    </div>

</body>
<script>
    function varysPesquisar() {
        // Declare variables
        var input, filter, table, tr, td, i;
        input = document.getElementById("varysPesquisar");
        filter = input.value.toUpperCase();
        table = document.getElementById("varysTabelaHtml");
        tr = table.getElementsByTagName("tr");

        // Itera por todas as linhas da tabela e esconde as que nao baterem com a pesquisa
        for (i = 0; i < tr.length; i++) {
            td0 = tr[i].getElementsByTagName("td")[0];
            td1 = tr[i].getElementsByTagName("td")[1];
            td2 = tr[i].getElementsByTagName("td")[2];
            td3 = tr[i].getElementsByTagName("td")[3];
            td4 = tr[i].getElementsByTagName("td")[4];
            if (td0 || td1 || td2) {
                if (td0.innerHTML.toUpperCase().indexOf(filter) > -1 || td1.innerHTML.toUpperCase().indexOf(filter) > -
                    1 || td2.innerHTML.toUpperCase().indexOf(filter) > -1 || td3.innerHTML.toUpperCase().indexOf(filter) >
                    -1 || td4.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }

    }

</script>

</html>
