<?php 
    include '../../conexao.php';

    $var_tipo = $_POST['tipo'];
    $var_campo = $_POST['campo'];

    if($var_tipo == '1'){
        $cons_campo = "SELECT NM_MNEMONICO AS CAMPO FROM dbamv.PRESTADOR WHERE CD_PRESTADOR = '$var_campo' AND TP_SITUACAO = 'A' AND cd_tip_presta = 8";
    }else{
        $cons_campo = "SELECT CD_PRESTADOR AS CAMPO FROM dbamv.PRESTADOR WHERE NM_PRESTADOR = '$var_campo' AND TP_SITUACAO = 'A' AND cd_tip_presta = 8";
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