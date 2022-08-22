<?php 
    include '../../conexao.php';

    $var_campo = $_POST['campo'];
    $tipo = $_POST['tipo'];

    if($tipo == '1'){
        $cons_campo = "SELECT NM_PRESTADOR AS CAMPO 
                        FROM dbamv.PRESTADOR 
                        WHERE DS_CODIGO_CONSELHO = TO_CHAR('$var_campo') 
                        AND TP_SITUACAO = 'A' 
                        AND cd_tip_presta in (3, 8)
                        ORDER BY NM_PRESTADOR ASC";

    }else{
        $cons_campo = "SELECT DS_CODIGO_CONSELHO AS CAMPO 
                        FROM dbamv.PRESTADOR 
                        WHERE NM_PRESTADOR = UPPER('$var_campo') 
                        AND TP_SITUACAO = 'A' 
                        AND cd_tip_presta in (3, 8)
                        ORDER BY DS_CODIGO_CONSELHO ASC";
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