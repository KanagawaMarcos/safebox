<?php
session_start();
if(isset($_SESSION['u_uid'])){
    header("Location: ../rootfolder/home.php?index=login");
    exit();
}
?>

    <!DOCTYPE html>

    <html>

    <head>

        <title>PetBox Login</title>
        <meta charset ="utf-8" />
        <!--==========Links para layouts========-->
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link href="https://fonts.googleapis.com/css?family=Crete+Round" rel="stylesheet">
        <link rel="stylesheet" href="css/estilo.css" />

    </head>

    <body>

    <!--==========Caixa de login========-->
    <div class="login-box">
        <div class="log-text">
            <h2 class="text">PetBox</h2>
            <p class="text" style="color: grey;"><small>Sistema de controle de finanças do Pet Computação.</small></p>
        </div>

        <!--==========Ligações com BD para autenticação========-->
        <form action="includes/login.inc.php" method="POST">
            <br>
            <input class="bordaArredondada textoLogin" type="text" name="uid" placeholder="   Username/E-mail" size="25"/><br><br>
            <input class="bordaArredondada textoLogin" type="password" name="pwd" placeholder="   Senha" size="25"/><br>
            <br>
            <input type="submit"  name="submit" value="Login" size="30" class="w3-btn  w3-large w3-round text"/>
        </form>

    </div>
    <!--==========Fim da caixa de login========-->
    </body>

    </html>



<?php
include_once 'footer.php';
?>