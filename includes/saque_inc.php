<?php
session_start();
if(isset($_POST['submit']) AND isset($_SESSION['u_id'])){
    include_once 'dbh.inc.php';
    $valor = mysqli_real_escape_string($conn, $_POST['valor']);
    $agente = $_SESSION['u_uid'];
    $destino = NULL;
    $origem = mysqli_real_escape_string($conn, $_POST['caixa']);
    //Se algum arquivo foi passado
    $tipo = "saque";

    if($_FILES['imagem']['size'] == 0){
      $tipo = "saque";
    }else{
      $tipo = "pagamento";
    }
    //===========================
    //Efetua upload da imagem do pagamento

    $fileName = $_FILES['imagem']['name'];

    $fileTmpName = $_FILES['imagem']['tmp_name'];
    $fileSize = $_FILES['imagem']['size'];
    $fileError = $_FILES['imagem']['error'];
    $fileType = $_FILES['imagem']['type'];
    $fileExt = explode('.',$fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');

    $caminhoFinalImagem = "";
    //Verifica se alguma imagem foi colocada
    if($_FILES['imagem']['size'] == 0){
      //so efetua o saque normalmente
    }else{
      //Verifica se a extensao eh valida
      if(!in_array($fileActualExt,$allowed)){
        header("Location: ../home.php?saque=imgUpload=WrongExtension");
        exit();
      }else{
        if($fileError === 0){
          if($fileSize < 1000000){
          	//chmod('../comprovantes/', 0777);
            $fileNameNew = uniqid('',true).".".$fileActualExt;
            $fileDestination = '../comprovantes/'.$fileNameNew;
            $caminhoFinalImagem = $fileDestination;
            move_uploaded_file($fileTmpName, $fileDestination);
            //$sqlComprovante = "INSERT INTO comprovantes(imagem ) VALUES('$fileDestination',)";
            //mysqli_query($conn, $sqlComprovante);
          }else{
            header("Location: ../home.php?fileTooBig");
            exit();
          }
        }else{
          header("Location: ../home.php?saque=error=Upload");
          exit();
        }
      }
    }


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
    //$sql = "SELECT * FROM caixinhas WHERE caixinha_id='$saqueid'";
    $statement = mysqli_stmt_init($conn);
    $sql = "SELECT * FROM caixinhas WHERE `caixinha_id`=?";

    if(!mysqli_stmt_prepare($statement, $sql)){
      header("Location: ../home.php?stmt=errorBind");
      mysqli_stmt_close($statement);
      exit();
    }else{
      mysqli_stmt_bind_param($statement, "i", $saqueid);
      mysqli_stmt_execute($statement);

      //$result = mysqli_query($conn, $sql);
      $result = mysqli_stmt_get_result($statement);
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
=======
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
                if($tipo === "pagamento"){
                  $sqlInserirSaque = "INSERT INTO varys(tipo, valor, agente, origem, destino,imagem) VALUES ('$tipo','$valor','$agente','$origem','$destino','$caminhoFinalImagem')";
                }else{
                  $sqlInserirSaque = "INSERT INTO varys(tipo, valor, agente, origem, destino) VALUES ('$tipo','$valor','$agente','$origem','$destino')";
                }
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
