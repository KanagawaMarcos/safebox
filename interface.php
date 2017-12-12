<!DOCTYPE html>

<html>

<head>
    <link href="css/interfacestyle.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
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
            <div class="nome">
                <label>
                    <?php
                    echo '<h3 style="color: aliceblue">'.$_SESSION['u_first'] .' '. $_SESSION['u_last'].'</h3>';
                    ?>
                </label>
                <br>
            </div>
        </div>

        <!--Area do debito em cada caixa e tipo usuario-->
        <div id="colunaMeio">
            <label>
                <h3 style="color: aliceblue; margin: 20px 0px;">Saldo</h3>
            </label>
            <label>
                <h4 style="color: aliceblue;text-align: center;">PetBox (Geral):</h4>
            </label>
            <div class="caixaGeral" style="text-align: center;">
                <?php
                    include_once 'includes/dbh.inc.php';
                    $query="SELECT * FROM caixinhas WHERE caixinha_id=1";
                    $results = mysqli_query($conn,$query);
                    $row = mysqli_fetch_array($results);
                    echo '<input type="text" style="color: black;text-align: center;" value="R$ '. $row['caixinha_value'].'" class="caixaGeralDebitoValor" readonly="readonly">';
                ?>
            </div>
            <label>
                <h4 style="color: aliceblue;text-align: center;">PetShop (Comida):</h4>
            </label>
            <div class="caixaComida" style="text-align: center;">
                <?php
                    include_once 'includes/dbh.inc.php';
                    $query="SELECT * FROM caixinhas WHERE caixinha_id=2";
                    $results = mysqli_query($conn,$query);
                    $row = mysqli_fetch_array($results);
                    echo '<input type="text" style="color: black;text-align: center;" value="R$ '. $row['caixinha_value'].'" class="caixaGeralDebitoValor" readonly="readonly">';
                ?>
            </div>
        </div>

        <!--Area dos botoes especiais de usuario-->
        <div id="colunaDir">
            <form action="includes/logout.inc.php" class="botoesEspeciaisCima" method="POST">
                
                <button class="botaoInterface botaoEspeciais" type="submit" name="submit"><img src="img/icon.png" style="width: 20px;"/></button>
            </form>
            
            <div class="botoesEspeciaisBaixo">
                <br>
                <div>
                <button onclick="document.getElementById('cadastroForm').style.display='block'" class="botaoInterface botaoEspeciais">Cadastrar Petiano</button></div>
                <div>    
                <button onclick="document.getElementById('cadastroForm').style.display='block'" class="botaoInterface botaoEspeciais">Histórico Tutor</button></div>
                <form action="includes/desfazeracao.php" method="POST">
                    <div>
                        <input type="submit" name="submit" class="botaoInterface botaoEspeciais" value="Desfazer">
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
                    <th>
                        <button onclick="document.getElementById('saqueForm').style.display='block'" class="botaoInterface botoes">Saque</button>
                    </th>
                    <th>
                        <button onclick="document.getElementById('depositoForm').style.display='block'" class="botaoInterface botoes">Depósito</button>
                    </th>
                    <th>
                        <button onclick="document.getElementById('transferenciaForm').style.display='block'" class="botaoInterface botoes">Transferência</button>
                    </th>
                    <th>
                        <button onclick="document.getElementById('mensalForm').style.display='block'" class="botaoInterface botoes">Depósito
                            <br>Mensal</button>
                    </th>
                    <th>
                        <input class="bordaArredondada"type="text" id="varysPesquisar" onkeyup="varysPesquisar()" placeholder="    Pesquisar" size="10">
                    </th>
                    <th>
                        <button onclick="document.getElementById('configuracaoForm').style.display='block'" class="botaoInterface botoes">
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
                        $query="SELECT * FROM varys";
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
                            echo '<tr><td>'. $row['agente'] .'</td>
                            <td>'. $row['tipo'] .'</td>
                            <td>R$ '. $row['valor'] .'</td>
                            <td>'. $origem .'</td>
                            <td>'. $destino .'</td>
                            <td>'. $row['dataAcao'] .'</td></tr>';
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

            <form class="w3-container" action="includes/saque_inc.php" method="POST">
                <div class="w3-section">

                    <label>
                        <b>Valor</b>
                    </label>
                    <input class="w3-input w3-border w3-margin-bottom bordaArredondada" type="number" step=0.01 placeholder="Entre com o valor do saque"
                        name="valor" required>

                    <label>
                        <b>Caixas do Pet:</b>
                    </label>
                    <br>
                    <input type="radio" name="caixa" value="caixinha1" checked> Caixa Geral
                    <br>
                    <input type="radio" name="caixa" value="caixinha2"> Caixa Comida
                    <br>

                    <button class="w3-block w3-blue w3-section w3-padding bordaArredondada botoes" type="submit" name="submit">Registrar Saque</button>
                </div>
            </form>

            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">

                <button onclick="document.getElementById('saqueForm').style.display='none'" type="button" class="w3-button w3-red bordaArredondada">Cancelar</button>

                <!--<span class="w3-right w3-padding w3-hide-small">Forgot <a href="#">password?</a></span>-->
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

            <form class="w3-container" action="includes/deposito_inc.php" method="POST">
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


                    <label>
                        <b>Caixas do Pet:</b>
                    </label>
                    <br>
                    <input type="radio" name="caixa" value="caixinha1" checked> Caixa Geral
                    <br>
                    <input type="radio" name="caixa" value="caixinha2"> Caixa Comida
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
                    <label><b>Nome de usuário</b></label>
                    <input class="w3-input w3-border w3-margin-bottom bordaArredondada" type="text" placeholder="Nome de usuário" name="username" required>
                    
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

                <!--<img src="img/petlogo.png" alt="petlogo" style="width:16%;" class="w3-circle w3-margin-top">-->
            </div>

            <form class="w3-container">
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
                                <button onclick="" class="botaoInterface botoes">
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
                            echo '<tr required name="agente">
                                  <th id="nomePagoMensal" style="bordaArredondada" name="nome" value="'. $row['user_uid'] .'">' . $row['user_first'] . '</th>
                                  <th class="info"> </th>
                                  <th class="info"> </th>
                                  <th style="bordaArredondada" value="'. $row['user_first'] .'"><input id="valorMensalInput" type="text" value="10" name = "valor"></th>
                                  <th>
                                  <select id="caixinhaDeDestinoMensal" name="selected">
                                    <option style="bordaArredondada" value="1">PetBox</option>
                                    <option style="bordaArredondada" value="2">PetShop</option>
                                  </select>
                                  </th>
                                  <th><input id="pagoCheckbox" type="checkbox" name = "tipo" value="'. $row['user_uid'] .'" checked></th>
                                  </tr>';
                        }
                        ?>

                    </table>

                    <button onclick="" type="submit" name="submit" class="w3-block w3-blue w3-section w3-padding bordaArredondada botoes">Registrar Deposito Mensal</button>
                </div>
            </form>

            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">

                <button onclick="document.getElementById('mensalForm').style.display='none'" type="button" class="w3-button w3-red bordaArredondada">Cancelar</button>

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