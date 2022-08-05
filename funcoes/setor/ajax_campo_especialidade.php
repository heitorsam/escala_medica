<?php 
    include '../../conexao.php';

    $var_tipo = $_POST['tipo'];
    $var_campo = $_POST['campo'];

    if($var_tipo == '1'){
        $cons_campo = "SELECT DS_ESPECIALID AS CAMPO 
                        FROM dbamv.especialid 
                        WHERE CD_ESPECIALID = '$var_campo' 
                        AND SN_ATIVO = 'S'
                        ORDER BY DS_ESPECIALID ASC";
    }else{
        $cons_campo = "SELECT CD_ESPECIALID AS CAMPO 
                        FROM dbamv.especialid 
                        WHERE DS_ESPECIALID = UPPER('$var_campo') 
                        AND SN_ATIVO = 'S'
                        ORDER BY CD_ESPECIALID ASC";
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