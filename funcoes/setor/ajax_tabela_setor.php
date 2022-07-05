<?php
    include '../../conexao.php';

    $cons_setor = "SELECT str.CD_SETOR,
                        str.DS_SETOR,
                        str.CD_CONSELHO    AS CD_PRESTADOR,
                        prest.nm_prestador AS RESPONSAVEL,
                        prest.tp_sexo      AS SEXO,
                        str.TP_SETOR       AS TIPO,
                        str.cd_especialid,
                        esp.ds_especialid
                    FROM escala_medica.setor str
                    INNER JOIN dbamv.prestador prest
                    ON prest.ds_codigo_conselho = TO_CHAR(str.cd_conselho)
                    INNER JOIN dbamv.especialid esp
                    ON esp.cd_especialid = str.cd_especialid
                    WHERE prest.cd_tip_presta = 8
                    ORDER BY 1
                    ";
    $result_setor = oci_parse($conn_ora, $cons_setor);
    oci_execute($result_setor);

    echo '<div class="table-responsive">';
            
        echo '<table class="table table-fixed table-hover table-striped " cellspacing="0" cellpadding="0">';

            echo '<thead><tr>';
                //<!--COLUNAS-->
                echo '<th class="align-middle" style="text-align: center !important;"><span>Código Setor</span></th>';
                echo '<th class="align-middle" style="text-align: center !important;"><span>Descrição</span></th>';
                echo '<th class="align-middle" style="text-align: center !important;"><span>Tipo</span></th>';
                echo '<th class="align-middle" style="text-align: center !important;"><span>CRM</span></th>';
                echo '<th class="align-middle" style="text-align: center !important;"><span>Responsável</span></th>';
                echo '<th class="align-middle" style="text-align: center !important;"><span>Opções</span></th>';
            echo '</tr></thead> ';           

            echo '<tbody>';
                while($row_setor = oci_fetch_array($result_setor)){   
                    echo '<tr>';
                        echo "<td class='align-middle' style='text-align: center;'> ". $row_setor['CD_SETOR'] ." </td>";
                        echo "<td class='align-middle' style='text-align: center;'> ". $row_setor['DS_SETOR'] ." </td>";
                        echo "<td class='align-middle' style='text-align: center;'> ". $row_setor['TIPO'] ." </td>";
                        echo "<td class='align-middle' style='text-align: center;'> ". $row_setor['CD_PRESTADOR'] ." </td>";
                        if($row_setor['SEXO'] == 'F'){
                            echo "<td class='align-middle' style='text-align: center;'> Dra. ". $row_setor['RESPONSAVEL'] ." </td>"; 
                        }else if($row_setor['SEXO'] == 'M'){
                            echo "<td class='align-middle' style='text-align: center;'> Dr. ". $row_setor['RESPONSAVEL'] ." </td>"; 
                        }else{
                            echo "<td class='align-middle' style='text-align: center;'> Dr(a). ". $row_setor['RESPONSAVEL'] ." </td>"; 
                        }?>
                        <td class='aling-middle' style='text-align: center;'><button class='btn btn-primary' onclick="editar_setor('<?php echo $row_setor['TIPO'] ?>','<?php echo $row_setor['DS_SETOR'] ?>','<?php echo $row_setor['CD_SETOR'] ?>', '<?php echo $row_setor['CD_PRESTADOR'] ?>', '<?php echo $row_setor['RESPONSAVEL'] ?>', <?php echo $row_setor['CD_ESPECIALID'] ?>,'<?php echo $row_setor['DS_ESPECIALID'] ?>')"><i class='fas fa-edit'></i>
                        <?php echo  "</button> <button class='btn btn-adm' onclick='excluir_setor(". $row_setor['CD_SETOR'] .")'><i class='fas fa-trash'></i></button></td>";
                    echo '</tr>';
                } 
            echo '</tbody>';         
        echo '</table>';
        echo '</div>';
    
    echo '</div>';
?>

<div class="modal fade" id="editar_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-2">
                        Código do Setor:
                        <input type="text" class="form-control" id="cd_setor_modal" readonly>
                    </div>
                    <div class="col-md-2" id="div_cd">
                        Código Especi.:
                        <input type="number" id="cd_especialidade_modal" class="form-control" disabled>
                    </div>
                    <div class="col-md-3">
                        Descrição Especi.:
                        <input type="text" id="ds_especie_modal" class="form-control" disabled>
                    </div>
                    <div class="col-md-3">
                        Descrição setor:
                        <input type="text" id="ds_setor_modal" class="form-control" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        Tipo:
                        <select class="form-control" id="tp_setor_modal" disabled>
                            <option value="P">Presencial</option>
                            <option value="D">Distancia</option>
                            <option value="F">Fixo</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        CRM:
                        <input type="text" class="form-control" onkeyup = "campos_responsavel_modal('1')" id="cd_responsavel_modal">
                    </div>
                    <div class="col-md-4">
                        Responsável:
                        <!--auto complete funcionario responsavel-->
                        <?php 
                    
                            //CONSULTA_LISTA
                            $consulta_lista = "SELECT pre.CD_PRESTADOR AS CODIGO,
                                                        replace(pre.NM_PRESTADOR, CHR(10), '') AS NOME
                                                from dbamv.PRESTADOR pre
                                                WHERE pre.TP_SITUACAO = 'A'
                                                AND pre.cd_tip_presta = 8
                                                ORDER BY 2";
                            $result_lista = oci_parse($conn_ora, $consulta_lista);																									
                            //EXECUTANDO A CONSULTA SQL (ORACLE)
                            oci_execute($result_lista);            

                        ?>

                        <script>
                            //LISTA
                            var countries = [     
                                <?php
                                    while($row_lista = oci_fetch_array($result_lista)){	
                                        echo '"'. str_replace('"' , '', $row_lista['NOME']) .'",';                
                                    }
                                ?>
                            ];
                        </script>

                        <?php   
                        include 'autocomplete_modal.php';
                        ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Fechar</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="salvar_setor()" ><i class="fas fa-save"></i> Salvar</button>
            </div>
        </div>
    </div>
</div>
