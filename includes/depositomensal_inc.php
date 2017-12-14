<?php
session_start();
if(isset($_POST['submit']) AND isset($_SESSION['u_id'])){
  $dbServername = "localhost";
  $dbUsername = "root";
  $dbPassword = "";
  $dbName = "loginsys";

  //'inicializa' a conexão
  $mysqli = new MySQLI($dbServername, $dbUsername, $dbPassword, $dbName);

    $agentes = $_POST['agente']; //mysqli_real_escape_string($conn, $_POST['agente'])
    $valores = $_POST['valor'];   //mysqli_real_escape_string($conn, $_POST['valor'])
    $destinos = $_POST['caixa']; //mysqli_real_escape_string($conn, $_POST['caixa'])
    $origem = NULL;
    $tipo = "deposito";
    $deposit = 0;


    if(empty($agentes) || empty($valores)){
        header("Location: ../home.php?index=empty");
        exit();
    } else {
        if (false/*!preg_match("/^[a-zA-ZÁ-ú]*$/", $agentes) || !is_numeric($valores) || $valores<=0*/) {
            header("Location: ../home.php?index=invalidInput");
            exit();
        } else {

            foreach ($agentes as $key => $value) {
              $valorAtual = $mysqli->real_escape_string($valores[$key]);

              if($mysqli->real_escape_string($destinos[$key]) === "caixinha1"){
                  $deposit = 1;
              } elseif ($mysqli->real_escape_string($destinos[$key]) === "caixinha2"){
                  $deposit = 2;
              }

              $sqlDepositar = "UPDATE caixinhas SET caixinha_value=caixinha_value+'$valorAtual' WHERE caixinha_id = '$deposit'";

              $mysqli->query($sqlDepositar);


              if($deposit === 1){
                $sqlDepositarUser = "UPDATE users SET user_saldo1=user_saldo1+'$valores[$key]' WHERE user_uid='$agentes[$key]'";
                $mysqli->query( $sqlDepositarUser);

              } elseif ($deposit === 1){
                $sqlDepositarUser = "UPDATE users SET user_saldo2=user_saldo2+'$valores[$key]' WHERE user_uid='$agentes[$key]'";
                $mysqli->query( $sqlDepositarUser);
              }
              $sqlInserirDeposito = "INSERT INTO varys(tipo, valor, agente, origem, destino) VALUES ('$tipo','$valores[$key]','$agentes[$key]','$origem','$destinos[$key]')";
              $mysqli->query( $sqlInserirDeposito);

            }

            header("Location: ../home.php?depositoMensal=sucess");
            $mysqli->close();
            exit();

            }
        }

} else {
    header("Location: ../home.php");
    exit();
}
