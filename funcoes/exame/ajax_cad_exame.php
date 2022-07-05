<?php
    include '../../conexao.php';

    session_start();

    $var_cd_especialidade = $_POST['cd_especialidade'];
    $var_ds_exame = $_POST['ds_exame'];
    $var_usuario = $_SESSION['usuarioLogin'];



    $cons_seq_nextval="SELECT escala_medica.SEQ_CD_EXAME.nextval AS CD_EXAME
                        FROM DUAL";

    $result_seq_nextval = oci_parse($conn_ora, $cons_seq_nextval);
    @oci_execute($result_seq_nextval);
    $row_seq_nextval = oci_fetch_array($result_seq_nextval);

    $var_cd_produto = $row_seq_nextval['CD_EXAME'];

   
    
    echo $cons_exame = "INSERT INTO escala_medica.EXAME (CD_EXAME, DS_EXAME, CD_ESPECIALIDADE,CD_USUARIO_CADASTRO, HR_CADASTRO, CD_USUARIO_ULT_ALT, HR_ULT_ALT)
                        VALUES($var_cd_produto, '$var_ds_exame',  $var_cd_especialidade, '$var_usuario', SYSDATE, NULL, NULL)";
    
    
    $result_exame = oci_parse($conn_ora, $cons_exame);
    oci_execute($result_exame);


?>

