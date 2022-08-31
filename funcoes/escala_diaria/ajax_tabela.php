<?php 

    session_start();

    include '../../conexao.php';

    $dia = $_GET['dia'];

    $mes = $_GET['mes'];

    $ano = $_GET['ano'];

    $setor = $_GET['setor'];

    $tp_setor = $_GET['tp_setor'];

    $num = $_GET['num'];

    $cons_escala = "SELECT esc.CD_PRESTADOR_MV AS CD_PRESTADOR,
                            pr.TP_SEXO AS SEXO,
                            esc.DIA,
                            esc.PERIODO,
                            CASE WHEN esc.NUM_PRESTADOR = 'R' THEN 'Retaguarda'
                            ELSE
                            ESC.NUM_PRESTADOR END AS NUM_PRESTADOR,
                            pr.nm_prestador AS NM_PRESTADOR,
                            st.DS_SETOR AS SETOR,
                            TO_CHAR(TO_DATE(LPAD(esc.DIA,2) || '/' || '01/2022' || ' ' || esc.HR_INICIAL || ':00', 'DD/MM/YYYY HH24:MI:SS'),'DD/MM/YYYY HH24:MI') AS INICIAL,
                            CASE 
                            WHEN esc.HR_FINAL < esc.HR_INICIAL THEN TO_CHAR(TO_DATE(LPAD(esc.DIA,2) || '/' || '01/2022' || ' ' || esc.HR_FINAL || ':00', 'DD/MM/YYYY HH24:MI:SS') + 1,'DD/MM/YYYY HH24:MI')
                                ELSE TO_CHAR(TO_DATE(LPAD(esc.DIA,2) || '/' || '01/2022' || ' ' || esc.HR_FINAL || ':00', 'DD/MM/YYYY HH24:MI:SS'),'DD/MM/YYYY HH24:MI')
                            END AS FINAL,
                            esc.DIARISTA,
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
                                and tip.cd_tip_comun = 11) CELULAR_2,
                            (SELECT tip.nr_ddd_celular
                            from dbamv.prestador_tip_comun tip
                            where tip.cd_prestador = pr.cd_prestador
                                and tip.cd_tip_comun = 1) DDD,
                            (SELECT tip.nr_ddi_celular
                            from dbamv.prestador_tip_comun tip
                            where tip.cd_prestador = pr.cd_prestador
                                and tip.cd_tip_comun = 1) DDI
                        FROM escala_medica.ESCALA esc
                        INNER JOIN dbamv.Prestador pr
                            ON esc.cd_prestador_mv = pr.cd_prestador
                        INNER JOIN escala_medica.setor st
                            ON st.Cd_Setor = esc.cd_setor
                        WHERE esc.periodo = '$mes/$ano'";                     

                        //REGRA DIA 
                        if($dia <> ''){

                            $cons_escala .=  "AND esc.dia = '$dia'";
                        }

                        if($tp_setor <> ''){

                            $cons_escala .= "AND st.TP_SETOR = '$tp_setor'";
                        } 

                        if($setor <> ''){
                            $cons_escala .= "AND esc.CD_SETOR = '$setor'";

                        }

                        if($num <> ''){
                            $cons_escala .= "AND NUM_PRESTADOR = '$num'";

                        }
                        
                        $cons_escala .= "ORDER BY ESC.CD_SETOR, INICIAL, NUM_PRESTADOR ASC";

    //echo $cons_escala;
    $result_escala = oci_parse($conn_ora, $cons_escala);

    oci_execute($result_escala);

    $_SESSION['excel'] = $cons_escala;

    if($setor == ''){
        $_SESSION['tp'] = 0;
    }else{
        $_SESSION['tp'] = 1;
        $_SESSION['setor'] = $setor;
    }

?>

<div class="div_br"></div>
<div class="table-responsive col-md-12">
            
    <table class="table table-fixed table-hover table-striped " cellspacing="0" cellpadding="0">

        <thead><tr>
            <!--COLUNAS-->
            <th class="align-middle" style="text-align: center !important;"><span>Setor</span></th> 
            <th class="align-middle" style="text-align: center !important;"><span>Inicio</span></th>
            <th class="align-middle" style="text-align: center !important;"><span>Fim</span></th>
            <th class="align-middle" style="text-align: center !important;"><span>Prestador</span></th>  
            <th class="align-middle" style="text-align: center !important;"><span>Ordem</span></th>                     
            <th class="align-middle" style="text-align: center !important;"><span>Comercial 1</span></th>
            <th class="align-middle" style="text-align: center !important;"><span>Celular</span></th>
            <th class="align-middle" style="text-align: center !important;"><span>E-mail</span></th>
            <th class="align-middle" style="text-align: center !important;"><span>Comercial 2</span></th>
            <th class="align-middle" style="text-align: center !important;"><span>Celular 2</span></th>
        </tr></thead>            

        <tbody> 
            <?php
                $var_modal_adicionar = 1;
                $var_modal_confirmar = 1;
                    while($row_escala = @oci_fetch_array($result_escala)){  ?>  
                        <?php 
                            if($row_escala['DIARISTA'] == 'S'){
                                $var_sn_diarista = 'Diarista - ';
                            }else{
                                $var_sn_diarista = ''; 
                            }
                            if($row_escala['SEXO'] == 'F'){
                                $var_dr_nm = 'Dra. ';
                            }else if($row_escala['SEXO'] == 'M'){
                                $var_dr_nm = 'Dr. ';
                            }else{
                                $var_dr_nm = 'Dr(a). ';
                            }
                        
                        ?>
                        <tr>
                            <td class='align-middle' style='text-align: center;'><?php echo @$row_escala['SETOR']; ?></td> 
                            <td class='align-middle' style='text-align: center;'><?php echo @$row_escala['INICIAL']; ?></td>
                            <td class='align-middle' style='text-align: center;'><?php echo @$row_escala['FINAL']; ?></td>
                            <td class='align-middle' style='text-align: center;'><?php echo $var_sn_diarista.''. $var_dr_nm .''. @$row_escala['NM_PRESTADOR']; ?></td>
                            <td class='align-middle' style='text-align: center;'><?php echo @$row_escala['NUM_PRESTADOR']; ?></td>
                            <td class='align-middle' style='text-align: center;'><?php echo @$row_escala['TELEFONE_COMERCIAL_1']; ?></td>
                            <td class='align-middle' style='text-align: center;'><?php echo @$row_escala['CELULAR']; ?></td>
                            <td class='align-middle' style='text-align: center;'><?php echo @$row_escala['E_MAIL']; ?></td>
                            <td class='align-middle' style='text-align: center;'><?php echo @$row_escala['TELEFONE_COMERCIAL_2']; ?></td>
                            <td class='align-middle' style='text-align: center;'><?php echo @$row_escala['CELULAR_2']; ?></td>
                             
                        </tr>
                    
                    <?php 
                    } 
                ?>
        </tbody>
    </table>
</div>