<?php

    include '../../conexao.php';

    $mes = $_GET['mes'];

    $ano = $_GET['ano'];

    $i = 1;

    $cons_dia = "SELECT TO_CHAR(LAST_DAY(TO_DATE('01/' || '$mes' || '/' || '$ano','DD/MM/YYYY')),'DD') AS ULTIMA_DIA FROM DUAL";

    $result_dia = oci_parse($conn_ora, $cons_dia);

    oci_execute($result_dia);

    $row_dia = oci_fetch_array($result_dia);
    echo 'Dia:';
    echo '<select class="form-control" id="dia">';
        for($i = 1; $i <= $row_dia['ULTIMA_DIA']; $i++){
            echo '<option value="'. $i .'">'. $i .'</option>';
        }
    echo '</select>';

?>