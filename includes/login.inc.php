<?php

session_start();
//se o botão foi clicado
if(isset($_POST['submit'])){
    //inicializa a váriavel conexão
    include 'dbh.inc.php';
    //recebe o usuário
    $uid = mysqli_real_escape_string($conn, $_POST['uid']);
    //recebe a senha embaralhada
    $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

    //ERROS
    //verifica se estão vazios
    if (empty($uid) || empty($pwd)) {
        header("Location: ../index.php?login=empty");
        exit();
    } else {
        //recebe da sql a tabela de usuários
        $sql = "SELECT * FROM users WHERE user_uid='$uid' OR user_email='$uid'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck < 1) {
            header("Location: ../index.php?login=error");
            exit();
        } else {
            //faz a váriavel row receber a linha do resultado da pesquisa
            if ($row = mysqli_fetch_assoc($result)) {
                //desembaralhando a senha e comparando
                $hashedPwdCheck = password_verify($pwd, $row['user_pwd']);
                //se a senha estiver incorreta
                $hashedPwdCheck = password_verify($pwd, $row['user_pwd']);
                //se a senha estiver incorreta
                if ($hashedPwdCheck == false) {
                    header("Location: ../index.php?login=error");
                    exit();
                } elseif ($hashedPwdCheck == true) {
                    //inicia a sessão
                    //log in
                    $_SESSION['u_id'] = $row['user_id'];
                    $_SESSION['u_first'] = $row['user_first'];
                    $_SESSION['u_last'] = $row['user_last'];
                    $_SESSION['u_email'] = $row['user_email'];
                    $_SESSION['u_uid'] = $row['user_uid'];
                    $_SESSION['u_permission'] = $row['user_permission'];
                    $_SESSION['u_saldo1'] = $row['user_saldo1'];
                    $_SESSION['u_saldo2'] = $row['user_saldo2'];
                    header("Location: ../home.php?login=sucess");
                    exit();
                }
            }
        }

    }
//se a url foi acessada diretamente
} else {
    header("Location: ../index.php?login=error");
    exit();
}
