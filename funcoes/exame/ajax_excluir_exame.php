<?php
    include '../../conexao.php';

    $var_cd_exame = $_POST['cd_exame'];

    $cons_qtd = "SELECT COUNT(*) AS QTD FROM escala_medica.SETOR WHERE CD_EXAME = $var_cd_exame";

    $result_qtd = oci_parse($conn_ora, $cons_qtd);

    oci_execute($result_qtd);

    $row_qtd = oci_fetch_array($result_qtd);

    $var_qtd = $row_qtd['QTD'];

    if($var_qtd == 0){
        $cons_exame = "DELETE escala_medica.EXAME str WHERE str.CD_EXAME = $var_cd_exame";
        $result_exame = oci_parse($conn_ora, $cons_exame);
        //oci_execute($result_exame);
        echo 'Exame apagado com sucesso!';
    }else{
        echo 'Já existe um setor vinculado a esse exame';
    }
    

?>

