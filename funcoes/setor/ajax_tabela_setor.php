<?php
    include '../../conexao.php';

    $cons_setor = "SELECT str.CD_SETOR,
                        str.DS_SETOR,
                        str.CD_PRESTADOR_MV AS CD_PRESTADOR,
                        (SELECT pre.NM_PRESTADOR
                        FROM dbamv.PRESTADOR pre
                        WHERE pre.CD_PRESTADOR = str.CD_PRESTADOR_MV) AS RESPONSAVEL,
                        str.TP_SETOR AS TIPO,
                        str.cd_especialid 
                    FROM escala_medica.setor str
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
                echo '<th class="align-middle" style="text-align: center !important;"><span>Código Responsável</span></th>';
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
                        echo "<td class='align-middle' style='text-align: center;'> Dr(a). ". $row_setor['RESPONSAVEL'] ." </td>"; ?>
                        <td class='aling-middle' style='text-align: center;'><button class='btn btn-primary' onclick="editar_setor('<?php echo $row_setor['TIPO'] ?>','<?php echo $row_setor['DS_SETOR'] ?>','<?php echo $row_setor['CD_SETOR'] ?>', '<?php echo $row_setor['CD_PRESTADOR'] ?>', '<?php echo $row_setor['RESPONSAVEL'] ?>', <?php echo $row_setor['CD_ESPECIALID'] ?>)"><i class='fas fa-edit'></i>
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
                    <div class="col-md-2" id="div_tipo">
                        Código do Setor:
                        <input type="text" class="form-control" id="cd_setor_modal" readonly>
                    </div>
                    <div class="col-md-2" id="div_cd">
                        Código:
                        <input type="number" id="cd_especialidade_modal" onkeyup = "campos_especialidade_modal('1')" class="form-control" >
                    </div>
                    <div class="col-md-4">
                        Descrição:
                        <input type="text" id="ds_setor_modal" class="form-control" >

                        <!--auto complete funcionario responsavel-->
                        <?php 

                            //CONSULTA_LISTA
                            $consulta_lista = "SELECT esp.ds_especialid AS Nome FROM dbamv.especialid esp WHERE esp.SN_ATIVO = 'S'";
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

                            include 'autocomplete_especialidade_modal.php';

                        ?>



                                    
                        <!--FIM CAIXA AUTOCOMPLETE--> 

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        Tipo:
                        <select class="form-control" onchange="campo_tipo_modal()" id="tp_setor_modal">
                            <option value="P">Presencial</option>
                            <option value="D">Distancia</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        Código Responsável:
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
<script>
    
</script>