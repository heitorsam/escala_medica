<?php
    include '../../conexao.php';

    session_start();

    $var_cd_especialidade = $_POST['cd_especialidade'];
    echo $var_tipo = $_POST['tipo'];
    echo '</br>';
    $var_ds = $_POST['ds_setor'];
    $var_responsavel = $_POST['cd_responsavel'];
    $usuario = $_SESSION['usuarioLogin'];

    $cons_seq_nextval="SELECT escala_medica.Seq_Cd_Setor.nextval AS CD_SETOR
                        FROM DUAL";

        $result_seq_nextval = oci_parse($conn_ora, $cons_seq_nextval);
        @oci_execute($result_seq_nextval);
        $row_seq_nextval = oci_fetch_array($result_seq_nextval);

        $var_cd_produto = $row_seq_nextval['CD_SETOR'];

   
    if($var_cd_especialidade == ''){
        $cons_setor = "INSERT INTO escala_medica.SETOR (CD_SETOR, CD_ESPECIALID,TP_SETOR, DS_SETOR, CD_PRESTADOR_MV, CD_USUARIO_CADASTRO, HR_CADASTRO)
                        VALUES($var_cd_produto, NULL, '$var_tipo', '$var_ds', $var_responsavel, '$usuario', SYSDATE)";
    
    }else{
        $cons_setor = "INSERT INTO escala_medica.SETOR (CD_SETOR, CD_ESPECIALID,TP_SETOR, DS_SETOR, CD_PRESTADOR_MV, CD_USUARIO_CADASTRO, HR_CADASTRO)
                        VALUES($var_cd_produto, '$var_cd_especialidade', '$var_tipo', '$var_ds', $var_responsavel, '$usuario', SYSDATE)";
    
    }
    $result_setor = oci_parse($conn_ora, $cons_setor);
    oci_execute($result_setor);


?>

