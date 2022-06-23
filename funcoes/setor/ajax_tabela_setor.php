<?php
    include '../../conexao.php';

    $cons_setor = "SELECT str.CD_SETOR, str.DS_SETOR,(SELECT pre.NM_PRESTADOR FROM dbamv.PRESTADOR pre WHERE pre.CD_PRESTADOR = str.CD_PRESTADOR_MV) AS RESPONSAVEL FROM escala_medica.setor str";
    $result_setor = oci_parse($conn_ora, $cons_setor);
    oci_execute($result_setor);

    echo '<div class="table-responsive">';
            
        echo '<table class="table table-fixed table-hover table-striped " cellspacing="0" cellpadding="0">';

            echo '<thead><tr>';
                //<!--COLUNAS-->
                echo '<th class="align-middle" style="text-align: center !important;"><span>Código</span></th>';
                echo '<th class="align-middle" style="text-align: center !important;"><span>Setor</span></th>';
                echo '<th class="align-middle" style="text-align: center !important;"><span>Responsavel</span></th>';
                echo '<th class="align-middle" style="text-align: center !important;"><span>Opções</span></th>';
            echo '</tr></thead> ';           

            echo '<tbody>';
                while($row_setor = oci_fetch_array($result_setor)){   
                echo '<tr>';
                    echo "<td class='align-middle' style='text-align: center;'> ". $row_setor['CD_SETOR'] ." </td>";
                    echo "<td class='align-middle' style='text-align: center;'> ". $row_setor['DS_SETOR'] ." </td>";
                    echo "<td class='align-middle' style='text-align: center;'> ". $row_setor['RESPONSAVEL'] ." </td>";
                    echo "<td class='aling-middle' style='text-align: center;'> <button class='btn btn-adm' onclick='excluir_setor(". $row_setor['CD_SETOR'] .")'><i class='fas fa-trash'></i></button></td>";
                echo '</tr>';
                } 
            echo '</tbody>';         
        echo '</table>';
        echo '</div>';
    
    echo '</div>';
?>