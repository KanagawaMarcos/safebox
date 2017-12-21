<?php
session_start();
if(isset($_POST['submit'])){
    include_once 'dbh.inc.php';
    //sentido da transferencia
    $transferencia = mysqli_real_escape_string($conn, $_POST['transferencia']);
    //valor da transferencia
    $valor = mysqli_real_escape_string($conn, $_POST['valor']);
    //não há agente
    $agente = NULL;
    if($transferencia === "caixinha1->caixinha2" AND $valor>0){
        $origem = "caixinha1";
        $destino = "caixinha2";
        $tipo = "transferencia";
        //pesquisa o valor da caixinha e compara com o quanto será retirado
        $sql = "SELECT * FROM caixinhas WHERE caixinha_id=1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if($row['caixinha_value'] < $valor){
            header("Location: ../home.php?index=tooHigh");
            exit();
        }
        $sqlDepositar = "UPDATE caixinhas SET caixinha_value=(caixinha_value - '$valor') WHERE caixinha_id = 1";
        mysqli_query($conn, $sqlDepositar);
        $sqlDepositar = "UPDATE caixinhas SET caixinha_value=(caixinha_value + '$valor') WHERE caixinha_id = 2";
        mysqli_query($conn, $sqlDepositar);
        $agente = $_SESSION['u_uid'];
        $sqlInserirTransfer = "INSERT INTO varys(tipo, valor, agente, origem, destino) VALUES ('$tipo','$valor','$agente','$origem','$destino')";
        mysqli_query($conn, $sqlInserirTransfer);
        header("Location: ../home.php?transfer=sucess");
        exit();
    } elseif ($transferencia === "caixinha2->caixinha1" AND $valor>0){
        $origem = "caixinha2";
        $destino = "caixinha1";
        $tipo = "transferencia";
        //pesquisa o valor da caixinha e compara com o quanto será retirado
        $sql = "SELECT * FROM caixinhas WHERE caixinha_id=2";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if($row['caixinha_value'] < $valor){
            header("Location: ../home.php?index=tooHigh");
            exit();
        }
        $sqlDepositar = "UPDATE caixinhas SET caixinha_value=(caixinha_value - '$valor') WHERE caixinha_id = 2";
        mysqli_query($conn, $sqlDepositar);
        $sqlDepositar = "UPDATE caixinhas SET caixinha_value=(caixinha_value + '$valor') WHERE caixinha_id = 1";
        mysqli_query($conn, $sqlDepositar);
        $sqlInserirTransfer = "INSERT INTO varys(tipo, valor, agente, origem, destino) VALUES ('$tipo','$valor','$agente','$origem','$destino')";
        mysqli_query($conn, $sqlInserirTransfer);
        header("Location: ../home.php?transfer=sucess");
        exit();
    } else {
        header("Location: ../home.php?home=unknowError");
        exit();
    }
} else {
    header("Location: ../home.php=error");
    exit();
}
