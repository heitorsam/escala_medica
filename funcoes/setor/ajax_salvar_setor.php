<?php
    include '../../conexao.php';

    session_start();

    $var_cd_setor = $_POST['cd_setor'];
    $var_ds_setor = $_POST['ds_setor'];
    $var_tp_setor = $_POST['tp_setor'];
    $var_cd_responsavel = $_POST['cd_responsavel'];
    $usuario = $_SESSION['usuarioLogin'];

    $cons_qtd = "SELECT COUNT(*) AS QTD FROM dbamv.PRESTADOR pr where pr.CD_PRESTADOR = $var_cd_responsavel and pr.TP_SITUACAO = 'A'";

    $result_qtd = oci_parse($conn_ora, $cons_qtd);

    oci_execute($result_qtd);

    $row_qtd = oci_fetch_array($result_qtd);

    if($row_qtd['QTD'] > 0){

        $cons_update = "UPDATE escala_medica.SETOR SET 
                        TP_SETOR = '$var_tp_setor',
                        DS_SETOR = '$var_ds_setor',
                        CD_PRESTADOR_MV = $var_cd_responsavel,
                        CD_USUARIO_ULT_ALT = '$usuario',
                        HR_ULT_ALT = SYSDATE
                        WHERE CD_SETOR = $var_cd_setor";
        $result_update = oci_parse($conn_ora, $cons_update);

        oci_execute($result_update);

        echo 'Editado com sucesso!';

    }else{
        echo "Responsavel inativo ou não existe!";
    }






?>