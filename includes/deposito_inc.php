<?php
session_start();
if(isset($_POST['submit']) AND isset($_SESSION['u_id'])){
    include_once 'dbh.inc.php';


    //-----Upload file code------
    //File variables
    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];
    //Array of extension and filename
    $fileExt = explode('.', $fileName);
    //Only the last data, whitch is the extension
    $fileActualExt = strtolower(end($fileExt));
    //Array of allowed file extension
    $allowed = array('jpg','jpeg','png','pdf');
    //===========================

    $agente = mysqli_real_escape_string($conn, $_POST['agente']);
    $valor = mysqli_real_escape_string($conn, $_POST['valor']);
    $destino = mysqli_real_escape_string($conn, $_POST['caixa']);
    $justificativa = mysqli_real_escape_string($conn, $_POST['justificativa']);
    $origem = NULL;
    $tipo = "deposito";
    $deposit = 0;

    if($destino === "caixinha1"){
        $deposit = 1;
    } elseif ($destino === "caixinha2"){
        $deposit = 2;
    }

    if(empty($valor)){
        header("Location: ../home.php?index=empty");
        exit();
    } else {
        if (!preg_match("/^[a-zA-ZÁ-ú]*$/", $agente) || !is_numeric($valor) || $valor<=0) {
            header("Location: ../home.php?index=invalidInput");
            exit();
        } else {
            $sql = "SELECT * FROM users WHERE user_uid='$agente'";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);

            if($resultCheck > 0){
                //o usuário existe
                $sqlDepositar = "UPDATE caixinhas SET caixinha_value=caixinha_value+'$valor' WHERE caixinha_id = '$deposit'";
                mysqli_query($conn, $sqlDepositar);
                if($deposit === 1){
                    $sqlDepositarUser = "UPDATE users SET user_saldo1=user_saldo1+'$valor' WHERE user_uid='$agente'";
                    mysqli_query($conn, $sqlDepositarUser);
                } elseif ($deposit === 2){
                    $sqlDepositarUser = "UPDATE users SET user_saldo2=user_saldo2+'$valor' WHERE user_uid='$agente'";
                    mysqli_query($conn, $sqlDepositarUser);
                }
                $sqlInserirDeposito = "INSERT INTO varys(tipo, valor, agente, origem, destino, justificativa) VALUES ('$tipo','$valor','$agente','$origem','$destino','$justificativa')";


                //-----Upload file code------
                if(in_array($fileActualExt,$allowed)){
                  if($fileError === 0){
                    if($fileSize < 1000000){
                      $fileNameNew = uniqid('',true).".".$fileActualExt;
                      $fileDestination = '../comprovantes/'.$fileNameNew;
                      if(move_uploaded_file($fileTmpName, $fileDestination)){
	                      $sqlInserirDeposito = "INSERT INTO varys(tipo, valor, agente, origem, destino,imagem,justificativa) VALUES ('$tipo','$valor','$agente','$origem','$destino','$fileDestination','$justificativa')";
                	      mysqli_query($conn, $sqlInserirDeposito);
        	              header("Location: ../home.php?deposit&upload=sucess");
	                      exit();
		      }else{
			header("Location: ../home.php?deposito&error=permission");
			}
                    }else{
                      //echo 'file too big!';die();
                    }
                  }else{
                    //echo 'error uploading!';die();
                  }
                }else{
                  //echo 'extension not allowed!';die();
                }
                //===========================

                //Se a imagem der algum problema, simplismente faz o depósito convencional
                header("Location: ../home.php?deposit=sucess");
                mysqli_query($conn, $sqlInserirDeposito);
                exit();
            } else {
                header("Location: ../home.php?index=error");
                exit();
            }
        }
    }
} else {
    header("Location: ../home.php");
    exit();
}
