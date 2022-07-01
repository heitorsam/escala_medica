<?php 
    include '../../conexao.php';

    $var_tipo = $_POST['tipo'];
    $var_campo = $_POST['campo'];
    $var_especie = $_POST['cd_especie'];

    if($var_especie != ''){
        if($var_tipo == '1'){
            $cons_campo = "SELECT prest.NM_PRESTADOR AS CAMPO
                                FROM dbamv.PRESTADOR prest
                            INNER JOIN dbamv.ESP_MED em
                                ON em.CD_PRESTADOR = prest.CD_PRESTADOR
                            WHERE prest.CD_PRESTADOR = $var_campo
                                AND prest.TP_SITUACAO = 'A'
                                AND em.SN_ESPECIAL_PRINCIPAL = 'S'
                                AND em.CD_ESPECIALID = $var_especie";
        }else{
            $cons_campo = "SELECT prest.CD_PRESTADOR AS CAMPO
                                FROM dbamv.PRESTADOR prest
                            INNER JOIN dbamv.ESP_MED em
                                ON em.CD_PRESTADOR = prest.CD_PRESTADOR
                            WHERE prest.NM_PRESTADOR = UPPER('$var_campo')
                                AND prest.TP_SITUACAO = 'A'
                                AND em.SN_ESPECIAL_PRINCIPAL = 'S'
                                AND em.CD_ESPECIALID = $var_especie";
        }
    }else{
        if($var_tipo == '1'){
            $cons_campo = "SELECT NM_PRESTADOR AS CAMPO FROM dbamv.PRESTADOR WHERE CD_PRESTADOR = '$var_campo' AND TP_SITUACAO = 'A'";
        }else{
            $cons_campo = "SELECT CD_PRESTADOR AS CAMPO FROM dbamv.PRESTADOR WHERE NM_PRESTADOR = UPPER('$var_campo') AND TP_SITUACAO = 'A'";
        }
    }

    $result_campo = oci_parse($conn_ora, $cons_campo);
    oci_execute($result_campo);

    $row_campo = @oci_fetch_array($result_campo);

    if(isset($row_campo['CAMPO'])){

        echo $row_campo['CAMPO'];

    }else{
        
        echo '';
    }
?>