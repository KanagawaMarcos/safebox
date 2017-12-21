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

    //verifica se estão vazios
    if (empty($uid) || empty($pwd)) {
        header("Location: ../index.php?login=empty");
        exit();
    } else {
        //Verifica se existe algum usuario cadastrado com o email/login passado
        $sql = "SELECT * FROM users WHERE `user_uid`=? OR `user_email`=?";
        //$sql = "SELECT * FROM users WHERE user_uid='$uid' OR user_email='$uid'";

        //Cria o Prepared Statement
        $statement = mysqli_stmt_init($conn);

        //Prepara o statement que será executado
        if(!mysqli_stmt_prepare($statement,$sql)){
          header("Location: ../index.php?statement1=error");
          exit();
        }else{

          //Subistitui os parametros no statement da requisição
          mysqli_stmt_bind_param($statement, "ss", $uid, $uid);

          //Executa a requisicao ao banco de dados
          mysqli_stmt_execute($statement);

          //Recebe o resultado da requisicao
          $result = mysqli_stmt_get_result($statement);
          //$result = mysqli_query($conn, $sql);        //Antiga versao
          $resultCheck = mysqli_num_rows($result);
          //Antiga versao

          if ($resultCheck < 1) {
              header("Location: ../index.php?login=error1");
              mysqli_stmt_close($statement);
              exit();
          } else {
              //Itera através de todos resultados da requisicao(usuarios com login/email usado)
              if ($row = mysqli_fetch_assoc($result)) {

                  //Comparado a senha dada com a senha do usuário atual
                  $hashedPwdCheck = password_verify($pwd, $row['user_pwd']);

                  //Se a senha estiver incorreta
                  if ($hashedPwdCheck == false) {
                      header("Location: ../index.php?login=error");
                      mysqli_stmt_close($statement);
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
                      mysqli_stmt_close($statement);
                      exit();
                }
            }
         }
      }
    }
//se a url foi acessada diretamente
} else {
    header("Location: ../index.php?login=error");
    exit();
}
