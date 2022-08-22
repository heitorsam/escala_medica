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
                            WHERE prest.DS_CODIGO_CONSELHO = '$var_campo'
                                AND prest.TP_SITUACAO = 'A'
                                AND em.CD_ESPECIALID = $var_especie
                                AND prest.cd_tip_presta in (3, 8)
                                ORDER BY prest.NM_PRESTADOR ASC";
        }else{
            $cons_campo = "SELECT prest.DS_CODIGO_CONSELHO AS CAMPO
                                FROM dbamv.PRESTADOR prest
                            INNER JOIN dbamv.ESP_MED em
                                ON em.CD_PRESTADOR = prest.CD_PRESTADOR
                            WHERE prest.NM_PRESTADOR = UPPER('$var_campo')
                                AND prest.TP_SITUACAO = 'A'
                                AND em.CD_ESPECIALID = $var_especie
                                AND prest.cd_tip_presta in (3, 8)";
        }
    }else{
        if($var_tipo == '1'){
            $cons_campo = "SELECT NM_PRESTADOR AS CAMPO 
                            FROM dbamv.PRESTADOR 
                            WHERE DS_CODIGO_CONSELHO = '$var_campo' 
                            AND TP_SITUACAO = 'A'
                            AND cd_tip_presta in (3, 8)
                            ORDER BY NM_PRESTADOR ASC";
        }else{
            $cons_campo = "SELECT DS_CODIGO_CONSELHO AS CAMPO 
                            FROM dbamv.PRESTADOR 
                            WHERE NM_PRESTADOR = UPPER('$var_campo') 
                            AND TP_SITUACAO = 'A'
                            AND cd_tip_presta in (3, 8)
                            ORDER BY DS_CODIGO_CONSELHO";
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