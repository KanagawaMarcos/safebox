<?php
session_start();
if(isset($_POST['submit']) AND isset($_SESSION['u_id'])){
    include_once 'dbh.inc.php';
    $valor = mysqli_real_escape_string($conn, $_POST['valor']);
    $agente = $_SESSION['u_uid'];
    $destino = NULL;
    $origem = mysqli_real_escape_string($conn, $_POST['caixa']);
    $tipo = "saque";
    //traduz o id onde será depositado
    $saqueid = 0;
    if($origem === "caixinha1"){
        $saqueid = 1;
    } elseif ($origem === "caixinha2"){
        $saqueid = 2;
    } else {
        header("Location: ../home.php?index=unknowError");
        exit();
    }
    //olha se é possível realizar o saque
    $sql = "SELECT * FROM caixinhas WHERE caixinha_id='$saqueid'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if($row['caixinha_value'] < $valor){
        header("Location: ../home.php?index=tooHigh");
        exit();
    }
    if(empty($agente) || empty($valor)){
        header("Location: ../home.php?index=empty");
        exit();
    } else {
        if (!preg_match("/^[a-zA-Z]*$/", $agente) || !is_numeric($valor) || $valor<=0) {
            header("Location: ../home.php?index=invalidInput");
            exit();
        } else {
            $sqlSearch = "SELECT * FROM users WHERE user_uid='$agente'";
            $searchResult = mysqli_query($conn, $sqlSearch);
            $resultCheck = mysqli_num_rows($searchResult);
            if($resultCheck > 0){
                //o usuário existe
                $sqlDepositar = "UPDATE caixinhas SET caixinha_value=(caixinha_value - '$valor') WHERE caixinha_id = '$saqueid'";
                mysqli_query($conn, $sqlDepositar);
                $sqlInserirSaque = "INSERT INTO varys(tipo, valor, agente, origem, destino) VALUES ('$tipo','$valor','$agente','$origem','$destino')";
                mysqli_query($conn, $sqlInserirSaque);
                header("Location: ../home.php?saque=sucess");
                exit();
            } else {
                header("Location: ../home.php?index=error");
                exit();
            }
        }
    }
} else {
    header("Location: ../index.php");
    exit();
}
