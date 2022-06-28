<?php 
    include '../../conexao.php';

    $dia = $_GET['dia'];

    $mes = $_GET['mes'];

    $ano = $_GET['ano'];

    $setor = $_GET['setor'];

    if($mes == ''){
        $cons_escala = "SELECT esc.CD_PRESTADOR_MV AS CD_PRESTADOR,
                            pr.nm_prestador AS NM_PRESTADOR,
                            st.DS_SETOR AS SETOR,
                            esc.hr_inicial AS INICIAL,
                            esc.hr_final AS FINAL,
                            esc.DIA AS DIA,
                            esc.PERIODO,
                            (SELECT tip.ds_tip_comun_prest
                            from dbamv.prestador_tip_comun tip
                            where tip.cd_prestador = pr.cd_prestador
                                and tip.cd_tip_comun = 1) TELEFONE_COMERCIAL_1,
                            (SELECT tip.ds_tip_comun_prest
                            from dbamv.prestador_tip_comun tip
                            where tip.cd_prestador = pr.cd_prestador
                                and tip.cd_tip_comun = 3) CELULAR,
                            (SELECT tip.ds_tip_comun_prest
                            from dbamv.prestador_tip_comun tip
                            where tip.cd_prestador = pr.cd_prestador
                                and tip.cd_tip_comun = 7) E_MAIL,
                            (SELECT tip.ds_tip_comun_prest
                            from dbamv.prestador_tip_comun tip
                            where tip.cd_prestador = pr.cd_prestador
                                and tip.cd_tip_comun = 10) TELEFONE_COMERCIAL_2,
                            (SELECT tip.ds_tip_comun_prest
                            from dbamv.prestador_tip_comun tip
                            where tip.cd_prestador = pr.cd_prestador
                                and tip.cd_tip_comun = 11) CELULAR_2
                        FROM escala_medica.ESCALA esc
                        INNER JOIN dbamv.Prestador pr
                            ON esc.cd_prestador_mv = pr.cd_prestador
                        INNER JOIN escala_medica.setor st
                            ON st.Cd_Setor = esc.cd_setor
                        ORDER BY esc.PERIODO DESC, esc.DIA, esc.HR_INICIAL, esc.HR_FINAL
                        ";
    }else if($dia == ''){
        $cons_escala = "SELECT esc.CD_PRESTADOR_MV AS CD_PRESTADOR,
                            esc.DIA,
                            esc.PERIODO,
                            pr.nm_prestador AS NM_PRESTADOR,
                            st.DS_SETOR AS SETOR,
                            esc.hr_inicial AS INICIAL,
                            esc.hr_final AS FINAL,
                            esc.DIA AS DIA,
                            esc.PERIODO,
                            (SELECT tip.ds_tip_comun_prest
                            from dbamv.prestador_tip_comun tip
                            where tip.cd_prestador = pr.cd_prestador
                                and tip.cd_tip_comun = 1) TELEFONE_COMERCIAL_1,
                            (SELECT tip.ds_tip_comun_prest
                            from dbamv.prestador_tip_comun tip
                            where tip.cd_prestador = pr.cd_prestador
                                and tip.cd_tip_comun = 3) CELULAR,
                            (SELECT tip.ds_tip_comun_prest
                            from dbamv.prestador_tip_comun tip
                            where tip.cd_prestador = pr.cd_prestador
                                and tip.cd_tip_comun = 7) E_MAIL,
                            (SELECT tip.ds_tip_comun_prest
                            from dbamv.prestador_tip_comun tip
                            where tip.cd_prestador = pr.cd_prestador
                                and tip.cd_tip_comun = 10) TELEFONE_COMERCIAL_2,
                            (SELECT tip.ds_tip_comun_prest
                            from dbamv.prestador_tip_comun tip
                            where tip.cd_prestador = pr.cd_prestador
                                and tip.cd_tip_comun = 11) CELULAR_2
                        FROM escala_medica.ESCALA esc
                        INNER JOIN dbamv.Prestador pr
                            ON esc.cd_prestador_mv = pr.cd_prestador
                        INNER JOIN escala_medica.setor st
                            ON st.Cd_Setor = esc.cd_setor
                        WHERE esc.periodo = '$mes/$ano'
                        AND esc.CD_SETOR LIKE '%$setor%'
                        ORDER BY esc.PERIODO DESC, esc.DIA, esc.HR_INICIAL, esc.HR_FINAL
                        ";
    }else{
        $cons_escala = "SELECT esc.CD_PRESTADOR_MV AS CD_PRESTADOR,
                            esc.DIA,
                            esc.PERIODO,
                            pr.nm_prestador AS NM_PRESTADOR,
                            st.DS_SETOR AS SETOR,
                            esc.hr_inicial AS INICIAL,
                            esc.hr_final AS FINAL,
                            esc.DIA AS DIA,
                            esc.PERIODO,
                            (SELECT tip.ds_tip_comun_prest
                            from dbamv.prestador_tip_comun tip
                            where tip.cd_prestador = pr.cd_prestador
                                and tip.cd_tip_comun = 1) TELEFONE_COMERCIAL_1,
                            (SELECT tip.ds_tip_comun_prest
                            from dbamv.prestador_tip_comun tip
                            where tip.cd_prestador = pr.cd_prestador
                                and tip.cd_tip_comun = 3) CELULAR,
                            (SELECT tip.ds_tip_comun_prest
                            from dbamv.prestador_tip_comun tip
                            where tip.cd_prestador = pr.cd_prestador
                                and tip.cd_tip_comun = 7) E_MAIL,
                            (SELECT tip.ds_tip_comun_prest
                            from dbamv.prestador_tip_comun tip
                            where tip.cd_prestador = pr.cd_prestador
                                and tip.cd_tip_comun = 10) TELEFONE_COMERCIAL_2,
                            (SELECT tip.ds_tip_comun_prest
                            from dbamv.prestador_tip_comun tip
                            where tip.cd_prestador = pr.cd_prestador
                                and tip.cd_tip_comun = 11) CELULAR_2
                        FROM escala_medica.ESCALA esc
                        INNER JOIN dbamv.Prestador pr
                            ON esc.cd_prestador_mv = pr.cd_prestador
                        INNER JOIN escala_medica.setor st
                            ON st.Cd_Setor = esc.cd_setor
                        WHERE esc.periodo = '$mes/$ano'
                        AND esc.dia = '$dia'
                        AND esc.CD_SETOR LIKE '%$setor%'
                        ORDER BY esc.PERIODO DESC, esc.DIA, esc.HR_INICIAL, esc.HR_FINAL
                        ";
    }

    $result_escala = oci_parse($conn_ora, $cons_escala);

    oci_execute($result_escala);

?>
<input type="hidden" id="excel" value="<?php echo $cons_escala ?>">
<div class="div_br"></div>
<div class="table-responsive col-md-12">
            
    <table class="table table-fixed table-hover table-striped " cellspacing="0" cellpadding="0">

        <thead><tr>
            <!--COLUNAS-->
            <th class="align-middle" style="text-align: center !important;"><span>Dia</span></th>
            <th class="align-middle" style="text-align: center !important;"><span>Prestador</span></th>
            <th class="align-middle" style="text-align: center !important;"><span>Setor</span></th>
            <th class="align-middle" style="text-align: center !important;"><span>Inicio</span></th>
            <th class="align-middle" style="text-align: center !important;"><span>Fim</span></th>
            <th class="align-middle" style="text-align: center !important;"><span>Telefone Comercial 1</span></th>
            <th class="align-middle" style="text-align: center !important;"><span>Telefone Comercial 2</span></th>
            <th class="align-middle" style="text-align: center !important;"><span>Celular</span></th>
            <th class="align-middle" style="text-align: center !important;"><span>Celular 2</span></th>
            <th class="align-middle" style="text-align: center !important;"><span>E-mail</span></th>
        </tr></thead>            

        <tbody> 
            <?php
                $var_modal_adicionar = 1;
                $var_modal_confirmar = 1;
                    while($row_escala = @oci_fetch_array($result_escala)){  ?>  
                        
                        <tr>
                            <td class='align-middle' style='text-align: center;'><?php if($row_escala['DIA'] >= 10){
                                                                                            echo @$row_escala['DIA'].'/'. $row_escala['PERIODO']; 
                                                                                        }else{
                                                                                            echo '0'. @$row_escala['DIA'].'/'. $row_escala['PERIODO']; 
                                                                                            }?></td>
                            <td class='align-middle' style='text-align: center;'><?php echo @$row_escala['NM_PRESTADOR']; ?></td>
                            <td class='align-middle' style='text-align: center;'><?php echo @$row_escala['SETOR']; ?></td>
                            <td class='align-middle' style='text-align: center;'><?php echo @$row_escala['INICIAL']; ?></td>
                            <td class='align-middle' style='text-align: center;'><?php echo @$row_escala['FINAL']; ?></td>
                            <td class='align-middle' style='text-align: center;'><?php echo @$row_escala['TELEFONE_COMERCIAL_1']; ?></td>
                            <td class='align-middle' style='text-align: center;'><?php echo @$row_escala['TELEFONE_COMERCIAL_2']; ?></td>
                            <td class='align-middle' style='text-align: center;'><?php echo @$row_escala['CELULAR']; ?></td>
                            <td class='align-middle' style='text-align: center;'><?php echo @$row_escala['CELULAR_2']; ?></td>
                            <td class='align-middle' style='text-align: center;'><?php echo @$row_escala['E_MAIL']; ?></td> 
                        </tr>
                    
                    <?php 
                    } 
                ?>
        </tbody>
    </table>
</div>