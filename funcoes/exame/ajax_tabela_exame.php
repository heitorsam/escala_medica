<?php
    include '../../conexao.php';

    $cons_exame = "SELECT ex.*, esp.ds_especialid AS DS_ESP
                    FROM escala_medica.EXAME ex
                    INNER JOIN dbamv.especialid esp
                    ON ex.cd_especialidade = esp.cd_especialid
                    ";
    $result_exame = oci_parse($conn_ora, $cons_exame);
    oci_execute($result_exame);

    echo '<div class="table-responsive">';
            
        echo '<table class="table table-fixed table-hover table-striped " cellspacing="0" cellpadding="0">';

            echo '<thead><tr>';
                //<!--COLUNAS-->
                echo '<th class="align-middle" style="text-align: center !important;"><span>Código Exame</span></th>';
                echo '<th class="align-middle" style="text-align: center !important;"><span>Descrição do Exame</span></th>';
                echo '<th class="align-middle" style="text-align: center !important;"><span>Código da Especialidade</span></th>';
                echo '<th class="align-middle" style="text-align: center !important;"><span>Descrição da Especialidade</span></th>';
                echo '<th class="align-middle" style="text-align: center !important;"><span>Opções</span></th>';
            echo '</tr></thead> ';           

            echo '<tbody>';
                while($row_exame = oci_fetch_array($result_exame)){   
                    echo '<tr>';?>
                        <td class='align-middle' style='text-align: center;'> <?php echo $row_exame['CD_EXAME'] ?> </td>
                        <td class="align-middle" id="DS_EXAME<?php echo $row_exame['CD_EXAME'] ?>" style="text-align: center;" 
                        ondblclick="fnc_editar_campo('escala_medica.EXAME', 'DS_EXAME', '<?php echo @$row_exame['DS_EXAME']; ?>', 'CD_EXAME', '<?php echo @$row_exame['CD_EXAME']; ?>', '')"> 
                        <?php echo $row_exame['DS_EXAME'] ?> </td>
                        <td class='align-middle' style='text-align: center;'> <?php echo $row_exame['CD_ESPECIALIDADE'] ?> </td>
                        <td class='align-middle' style='text-align: center;'> <?php echo $row_exame['DS_ESP'] ?> </td>
                       
                        <td class='align-middle' style='text-align: center;'><button class="btn btn-adm" onclick="excluir_exame('<?php echo $row_exame['CD_EXAME'] ?>')" ><i class="fas fa-trash"></i></button></td>
                    <?php
                    echo '</tr>';
                } 
            echo '</tbody>';         
        echo '</table>';
        echo '</div>';
    
    echo '</div>';
?>

