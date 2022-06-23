<?php
    include '../../conexao.php';

    session_start();

    $var_tipo = $_POST['tipo'];
    $var_ds = $_POST['ds_setor'];
    $var_responsavel = $_POST['responsavel'];
    $usuario = $_SESSION['usuarioLogin'];

    $cons_seq_nextval="SELECT escala_medica.Seq_Cd_Setor.nextval AS CD_SETOR
                        FROM DUAL";

        $result_seq_nextval = oci_parse($conn_ora, $cons_seq_nextval);
        @oci_execute($result_seq_nextval);
        $row_seq_nextval = oci_fetch_array($result_seq_nextval);

        $var_cd_produto = $row_seq_nextval['CD_SETOR'];

    echo $cons_setor = "INSERT INTO escala_medica.SETOR (CD_SETOR, TP_SETOR, DS_SETOR, CD_PRESTADOR_MV, CD_USUARIO_CADASTRO, HR_CADASTRO, CD_USUARIO_ULT_ALT, HR_ULT_ALT)
                        VALUES($var_cd_produto, '$var_tipo', '$var_ds', (SELECT CD_PRESTADOR FROM dbamv.PRESTADOR pre WHERE Nm_Mnemonico LIKE '%$var_responsavel%'), '$usuario', SYSDATE, '$usuario', SYSDATE)";
    $result_setor = oci_parse($conn_ora, $cons_setor);
    oci_execute($result_setor);


?>

