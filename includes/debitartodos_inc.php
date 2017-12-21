<?php
/**
 * Created by PhpStorm.
 * User: anton
 * Date: 01/12/2017
 * Time: 11:45
 */
if(isset($_POST['submit'])){
    include_once 'dbh.inc.php';
    $valor = mysqli_real_escape_string($conn, $_POST['valor']);
    if($valor <= 0){
        header("Location: ../home.php?home.php=tooLow");
        exit();
    }
    $selectedSaldo = mysqli_real_escape_string($conn, $_POST['saldo']);
    $saqueid = 0;
    if($selectedSaldo === "saldo1"){
        $saqueid = 1;
    } elseif ($selectedSaldo === "saldo2"){
        $saqueid = 2;
    } else {
        header("Location: ../home.php?index=unknowError");
        exit();
    }
    $query="SELECT * FROM users";
    $results = mysqli_query($conn,$query);
    while ($row = mysqli_fetch_array($results)) {
        $id = $row['user_uid'];
        if($saqueid == 1){
            $sqlDebitar = "UPDATE users SET user_saldo1=(user_saldo1 - $valor) WHERE user_uid='$id'";
            mysqli_query($conn, $sqlDebitar);
        }elseif ($saqueid == 2){
            $sqlDebitar= "UPDATE users SET user_saldo2=(user_saldo2 - $valor) WHERE user_uid='$id'";
            mysqli_query($conn, $sqlDebitar);
        }
    }
    header("Location: ../home.php?index=sucess");
    exit();
} else {
    header("Location: ../home.php");
    exit();
}