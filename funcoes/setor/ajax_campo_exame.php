<?php 
    include '../../conexao.php';

    $var_campo = $_POST['campo'];
    $tipo = $_POST['tipo'];

    if($tipo == '1'){
        $cons_campo = "SELECT DS_EXAME AS CAMPO 
                        FROM escala_medica.EXAME 
                        WHERE CD_ESPECIALIDADE = $var_campo
                        ORDER BY DS_EXAME ASC";

    }else{
        $cons_campo = "SELECT CD_EXAME AS CAMPO 
                        FROM escala_medica.EXAME 
                        WHERE DS_EXAME = '$var_campo'
                        ORDER BY CD_EXAME ASC";
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