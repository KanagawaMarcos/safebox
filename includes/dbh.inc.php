<?php
//este código serve somente para não registrar
//a conexão inumeras vezes

//inicializa as váriaveis para criar uma conexão
$dbServername = "localhost";
$dbUsername = "petbox";
$dbPassword = "QMwzv5yGnYuCLtEt";
$dbName = "loginsys";

//'inicializa' a conexão
$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);