<?php
    include '../../conexao.php';

    session_start();

    $var_cd_setor = $_POST['cd_setor'];
    $var_ds_setor = $_POST['ds_setor'];
    $var_tp_setor = $_POST['tp_setor'];
    $var_cd_responsavel = $_POST['cd_responsavel'];
    $usuario = $_SESSION['usuarioLogin'];

    echo $cons_update = "UPDATE escala_medica.SETOR SET 
                    TP_SETOR = '$var_tp_setor',
                    DS_SETOR = '$var_ds_setor',
                    CD_PRESTADOR_MV = $var_cd_responsavel,
                    CD_USUARIO_ULT_ALT = '$usuario',
                    HR_ULT_ALT = SYSDATE
                    WHERE CD_SETOR = $var_cd_setor";
    $result_update = oci_parse($conn_ora, $cons_update);

    oci_execute($result_update);







?>