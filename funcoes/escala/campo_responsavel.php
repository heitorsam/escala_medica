<?php 
    include '../../conexao.php';

    $var_tipo = $_POST['tipo'];
    $var_campo = $_POST['campo'];

    if($var_tipo == '1'){
        $cons_campo = "SELECT NM_PRESTADOR AS CAMPO FROM dbamv.PRESTADOR WHERE CD_PRESTADOR = '$var_campo' AND TP_SITUACAO = 'A'";
    }else{
        $cons_campo = "SELECT CD_PRESTADOR AS CAMPO FROM dbamv.PRESTADOR WHERE NM_PRESTADOR LIKE '%$var_campo%' AND TP_SITUACAO = 'A'";
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