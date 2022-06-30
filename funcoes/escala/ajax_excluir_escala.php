<?php
    include '../../conexao.php';

    session_start();

    $cd_escala = $_POST['cd_escala'];

    echo $cons_setor = "DELETE escala_medica.ESCALA WHERE CD_ESCALA = $cd_escala";
    $result_setor = oci_parse($conn_ora, $cons_setor);
    oci_execute($result_setor);


?>

