<?php 

    include '../../conexao.php';

    $var_tipo = $_GET['var_tipo'];
    if($var_tipo != ''){
    
        $cons_setor = "SELECT DS_SETOR AS SETOR, CD_SETOR AS CODIGO FROM escala_medica.SETOR WHERE TP_SETOR = '$var_tipo' ORDER BY DS_SETOR ASC";

        $result_setor = oci_parse($conn_ora, $cons_setor);

        oci_execute($result_setor);
        echo 'Setor:';
        echo '<select id="setor" class="form-control" onchange="campo_prestador()">';
        echo '<option  value="">Selecione</option>';
            while($row_setor = oci_fetch_array($result_setor)){
                echo '<option value='. $row_setor['CODIGO'] .'>'. $row_setor['SETOR'] .'</option>';
            }
        echo '</select>';

    }else{ ?>
        Setor:
        <select class="form-control">
            <option  value="">Selecione</option>
        </select>
    <?php
    }
?>