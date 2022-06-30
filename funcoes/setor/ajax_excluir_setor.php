<?php
    include '../../conexao.php';

    $var_cd_setor = $_POST['cd_setor'];

    $cons_qtd = "SELECT COUNT(*) AS QTD FROM escala_medica.ESCALA WHERE CD_SETOR = '$var_cd_setor'";

    $result_qtd = oci_parse($conn_ora, $cons_qtd);

    oci_execute($result_qtd);

    $row_qtd = oci_fetch_array($result_qtd);

    if($row_qtd['QTD'] > 0){
        echo 'Não é possivel apagar esse setor pois já existem vínculos!';
    }else{
    $cons_setor = "DELETE escala_medica.SETOR str WHERE str.CD_SETOR = $var_cd_setor";
    $result_setor = oci_parse($conn_ora, $cons_setor);
    oci_execute($result_setor);
    echo 'Setor apagado com sucesso!';
    }

?>

