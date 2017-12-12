<?php
/**
 * Created by PhpStorm.
 * User: anton
 * Date: 04/12/2017
 * Time: 21:04
 */
if(isset($_POST['submit'])){
    include_once 'dbh.inc.php';
    $sql = "SELECT * FROM varys WHERE id=(SELECT max(id) FROM varys)";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $valor = $row['valor'];
    $agente = $row['agente'];
    $tipo = $row['tipo'];
    //echo $valor, $agente, $tipo;die();
    if($tipo === "deposito"){
        if($row['destino'] === "caixinha1"){
            $sqlDepositar = "UPDATE caixinhas SET caixinha_value=caixinha_value-'$valor' WHERE caixinha_id = 1";
            mysqli_query($conn, $sqlDepositar);
            $sqlDepositarUser = "UPDATE users SET user_saldo1=user_saldo1-'$valor' WHERE user_uid='$agente'";
            mysqli_query($conn, $sqlDepositarUser);
        } elseif($row['destino'] === "caixinha2"){
            $sqlDepositar = "UPDATE caixinhas SET caixinha_value=caixinha_value-'$valor' WHERE caixinha_id = 2";
            mysqli_query($conn, $sqlDepositar);
            $sqlDepositarUser = "UPDATE users SET user_saldo2=user_saldo2-'$valor' WHERE user_uid='$agente'";
            mysqli_query($conn, $sqlDepositarUser);
        }
        $id = $row['id'];
        $sql = "DELETE FROM varys WHERE id=$id;";
        mysqli_query($conn, $sql);
        header("Location: ../home.php?=sucess1");
        exit();
    } elseif($tipo === "saque"){
        if($row['origem'] === "caixinha1"){
            $sqlDepositar = "UPDATE caixinhas SET caixinha_value=caixinha_value+'$valor' WHERE caixinha_id = 1";
            mysqli_query($conn, $sqlDepositar);
            $sqlDepositarUser = "UPDATE users SET user_saldo1=user_saldo1+'$valor' WHERE user_uid='$agente'";
            mysqli_query($conn, $sqlDepositarUser);
        } elseif($row['origem'] === "caixinha2"){
            $sqlDepositar = "UPDATE caixinhas SET caixinha_value=caixinha_value+'$valor' WHERE caixinha_id = 2";
            mysqli_query($conn, $sqlDepositar);
            $sqlDepositarUser = "UPDATE users SET user_saldo2=user_saldo2+'$valor' WHERE user_uid='$agente'";
            mysqli_query($conn, $sqlDepositarUser);
        }
        $id = $row['id'];
        $sql = "DELETE FROM varys WHERE id=$id;";
        mysqli_query($conn, $sql);
        header("Location: ../home.php?=sucess2");
        exit();
    } elseif($tipo === "transferencia"){
        if($row['origem'] === "caixinha1"){
            $sqlDepositar = "UPDATE caixinhas SET caixinha_value=caixinha_value+'$valor' WHERE caixinha_id = 1";
            mysqli_query($conn, $sqlDepositar);
            $sqlDepositar = "UPDATE caixinhas SET caixinha_value=caixinha_value-'$valor' WHERE caixinha_id = 2";
            mysqli_query($conn, $sqlDepositar);
        } elseif($row['origem'] === "caixinha2"){
            $sqlDepositar = "UPDATE caixinhas SET caixinha_value=caixinha_value-'$valor' WHERE caixinha_id = 1";
            mysqli_query($conn, $sqlDepositar);
            $sqlDepositar = "UPDATE caixinhas SET caixinha_value=caixinha_value+'$valor' WHERE caixinha_id = 2";
            mysqli_query($conn, $sqlDepositar);

        }
        $id = $row['id'];
        $sql = "DELETE FROM varys WHERE id=$id;";
        mysqli_query($conn, $sql);
        header("Location: ../home.php?=sucess3");
        exit();
    } else {
        header("Location: ../home.php?=processingError");
        exit();
    }
} else {
    header("Location: ../home.php?=unknowError");
    exit();
}