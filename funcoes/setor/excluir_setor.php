<?php
    include '../../conexao.php';

    $var_cd_setor = $_POST['cd_setor'];

    echo $cons_setor = "DELETE escala_medica.SETOR str WHERE str.CD_SETOR = $var_cd_setor";
    $result_setor = oci_parse($conn_ora, $cons_setor);
    oci_execute($result_setor);


?>

