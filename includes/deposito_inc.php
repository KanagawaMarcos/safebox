<?php
session_start();
if(isset($_POST['submit']) AND isset($_SESSION['u_id'])){
    include_once 'dbh.inc.php';
    $agente = mysqli_real_escape_string($conn, $_POST['tipo']);
    $valor = mysqli_real_escape_string($conn, $_POST['valor']);
    $destino = mysqli_real_escape_string($conn, $_POST['caixa']);
    $origem = NULL;
    $tipo = "deposito";
    $deposit = 0;
    if($destino === "caixinha1"){
        $deposit = 1;
    } elseif ($destino === "caixinha2"){
        $deposit = 2;
    }
    if(empty($agente) || empty($valor)){
        header("Location: ../home.php?index=empty");
        exit();
    } else {
        if (!preg_match("/^[a-zA-ZÁ-ú]*$/", $agente) || !is_numeric($valor) || $valor<=0) {
            header("Location: ../home.php?index=invalidInput");
            exit();
        } else {
            $sql = "SELECT * FROM users WHERE user_uid='$agente'";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
            if($resultCheck > 0){
                //o usuário existe
                $sqlDepositar = "UPDATE caixinhas SET caixinha_value=caixinha_value+'$valor' WHERE caixinha_id = '$deposit'";
                mysqli_query($conn, $sqlDepositar);
                if($deposit === 1){
                    $sqlDepositarUser = "UPDATE users SET user_saldo1=user_saldo1+'$valor' WHERE user_uid='$agente'";
                    mysqli_query($conn, $sqlDepositarUser);
                } elseif ($deposit === 1){
                    $sqlDepositarUser = "UPDATE users SET user_saldo2=user_saldo2+'$valor' WHERE user_uid='$agente'";
                    mysqli_query($conn, $sqlDepositarUser);
                }
                $sqlInserirDeposito = "INSERT INTO varys(tipo, valor, agente, origem, destino) VALUES ('$tipo','$valor','$agente','$origem','$destino')";
                mysqli_query($conn, $sqlInserirDeposito);
                header("Location: ../home.php?deposit=sucess");
                exit();
            } else {
                header("Location: ../home.php?index=error");
                exit();
            }
        }
    }
} else {
    header("Location: ../home.php");
    exit();
}
