<?php 
    include '../conexao.php';

    //APAGRA
    echo $cons_delete = "DELETE escala_medica.DIVISAO_HORA";
    $result_delete = oci_parse($conn_ora, $cons_delete);
    oci_execute($result_delete);

    //REPOPULA A TABELA
    for($i = 0; $i <= 23 ; $i++){

        //echo $i;
        echo '</br>';
        if($i < 10){
            echo $cons_horas_in = "INSERT INTO escala_medica.DIVISAO_HORA(TP_HORA, DS_HORA) VALUES('I', '0$i:00')";
            echo $cons_horas_fn = "INSERT INTO escala_medica.DIVISAO_HORA(TP_HORA, DS_HORA) VALUES('F', '0$i:59')";

        }else{
            echo$cons_horas_in = "INSERT INTO escala_medica.DIVISAO_HORA(TP_HORA, DS_HORA) VALUES('I', '$i:00')";
            echo$cons_horas_fn = "INSERT INTO escala_medica.DIVISAO_HORA(TP_HORA, DS_HORA) VALUES('F', '$i:59')";
        }

        $result_horas_in = oci_parse($conn_ora, $cons_horas_in);
        $result_horas_fn = oci_parse($conn_ora, $cons_horas_fn);
        oci_execute($result_horas_in);
        oci_execute($result_horas_fn);
    }





?>