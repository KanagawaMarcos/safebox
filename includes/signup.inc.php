<?php
if(isset($_POST['submit'])){
    //inicializa a váriavel conn
    //determina onde e como conectar ao banco de dados
    include_once 'dbh.inc.php';
    //faz a inclusão dos campos no banco de dados da variável conn
    //elas vem a partir do metodo POST, tornando-se repectivamente $_POST['input-tag-name']
    $first = mysqli_real_escape_string($conn, $_POST['first']);
    $last = mysqli_real_escape_string($conn, $_POST['last']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $userpermission = mysqli_real_escape_string($conn, $_POST['tipo']);
    $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
    $uid = mysqli_real_escape_string($conn, $_POST['uid']);

    //ERROS
    //campos vazios
    if(empty($first) || empty($last) || empty($email) || empty($pwd) || empty($uid)){
        header("Location: ../home.php?home=empty");
        exit();
    } else {
        //analiza se estes caracteres existem no primeiro nome
        if (!preg_match("/^[a-zA-ZÁ-ú]*$/", $uid) || !preg_match("/[a-zA-ZÀ-ú]$/", $first) || !preg_match("/[a-zA-ZÀ-ú]$/", $last)) {
            header("Location: ../home.php?home=invalidName");
            exit();
        } else {
            //utiliza um filtro no email
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                header("Location: ../home.php?home=invalidEmail");
                exit();
            } else {
                //analiza se o usuario já existe
                $sql = "SELECT * FROM users WHERE user_uid='$uid' OR user_email='$email'";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);
                if($resultCheck>0){
                    //o usuário já foi tomado
                    header("Location: ../home.php?home=userTaken");
                    exit();
                } else {
                    //embaralhando a senha
                    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
                    //Inserindo o usuário no banco de dados
                    $sql = "INSERT INTO users(user_uid, user_first, user_last, user_email, user_saldo1, user_saldo2, user_permission, user_pwd) VALUES ('$uid', '$first','$last','$email', 0, 0, $userpermission,'$hashedPwd');";
                    mysqli_query($conn, $sql);
                    //redirecionando para a página que informa que o login foi um sucesso
                    header("Location: ../home.php?home=sucess");
                    exit();
                }
            }
        }
    }

} else {
    //redireciona quem não entrou na url a partir do botão
    header("Location: ../home.php?home=error");
    exit();
}
