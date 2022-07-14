<?php
    include '../../conexao.php';

    $cons_escala = "SELECT 
                    esc.CD_ESCALA,
                    st.ds_setor,
                    st.tp_setor,
                    prest.nm_mnemonico AS NOME,
                    esc.hr_inicial,
                    CASE
                    WHEN esc.hr_final < esc.HR_INICIAL THEN '23:59'
                    ELSE esc.HR_FINAL
                    END HR_FINAL,
                    esc.periodo,
                    esc.dia,
                    esc.CD_ESCALA,
                    esc.CD_PRESTADOR_MV,
                    esc.DIARISTA,
                    prest.TP_SEXO AS SEXO
                    FROM escala_medica.ESCALA esc
                    INNER JOIN escala_medica.SETOR st
                    ON st.cd_setor = esc.cd_setor
                    INNER JOIN dbamv.prestador prest
                    ON prest.cd_prestador = esc.cd_prestador_mv
                    WHERE TO_CHAR(TO_DATE(esc.periodo, 'MM/YY'), 'MM/YYYY') = '$mes/$ano'
                    AND esc.DIA = $dia
                    AND esc.CD_SETOR = $setor
                    UNION ALL 
                    
                    SELECT 
                    esc.CD_ESCALA,
                    st.ds_setor,
                    st.tp_setor,
                    prest.nm_mnemonico AS NOME,
                    CASE
                    WHEN esc.HR_FINAL < esc.hr_inicial THEN '00:00'
                    ELSE esc.hr_inicial
                    END hr_inicial,
                    esc.HR_FINAL,
                    esc.periodo,
                    esc.dia + 1 AS DIA,
                    esc.CD_ESCALA,
                    esc.CD_PRESTADOR_MV,
                    esc.DIARISTA,
                    prest.TP_SEXO AS SEXO
                    FROM escala_medica.ESCALA esc
                    INNER JOIN escala_medica.SETOR st
                    ON st.cd_setor = esc.cd_setor
                    INNER JOIN dbamv.prestador prest
                    ON prest.cd_prestador = esc.cd_prestador_mv
                    WHERE TO_CHAR(TO_DATE(esc.periodo, 'MM/YY'), 'MM/YYYY') = '$mes/$ano'
                    AND esc.DIA = $dia - 1
                    AND esc.CD_SETOR = $setor
                    AND esc.hr_final < esc.HR_INICIAL
                    ORDER BY 5 ASC, 6 ASC ";

    $rescult_escala = oci_parse($conn_ora, $cons_escala);

    oci_execute($rescult_escala);

    $contador_dias = 0;
    $contador_vago = 0;
    $vago_ultimo_valor = '00:00';


    while ($row_escala = oci_fetch_array($rescult_escala)){             
        $tipo = $row_escala['TP_SETOR'];
        if($tipo <> 'P'){
            //IF VAGO PRIMEIRO HORARIO
            if($row_escala['HR_INICIAL'] <> '00:00' && $contador_vago == 0){
                echo '</br>';
                echo '<div style="font-size: 12px; color: red;" > <i class="far fa-clock"></i> ' . '00:00' . ' - ' . 
                str_pad(substr($row_escala['HR_INICIAL'],0,2) -1, 2, "0", STR_PAD_LEFT). ':59'; 
                echo '</br>';  
                echo ' Vago </div>';        
                $contador_dias++;
            }
            
            //IF VAGO INTERMEDIARIO
            if($row_escala['HR_INICIAL'] <> $vago_ultimo_valor && $contador_vago <> 0 ){
                
                echo '<div style="border-top: solid 1px #838383; width: 10%; margin: 0 auto; margin-top:8px; margin-bottom:8px;"></div>';

                echo '<div style="font-size: 12px; color: red;" > <i class="far fa-clock"></i> ' . $vago_ultimo_valor
                . ' - ' . 
                str_pad(substr($row_escala['HR_INICIAL'],0,2) -1, 2, "0", STR_PAD_LEFT). ':59';
                echo '</br>';
                echo 'Vago</div>';

            } 

            //VALOR VAGO NECESSARIO PARA CALCULAR DADOS
            $vago_ultimo_valor = str_pad(substr($row_escala['HR_FINAL'],0,2) + 1, 2, "0", STR_PAD_LEFT). ':00';
        }
        if($contador_dias == 0){

            echo '</br>';

        }else{

            echo '<div style="border-top: solid 1px #838383; width: 10%; margin: 0 auto; margin-top:8px; margin-bottom:8px;"></div>';
        }
        if($row_escala['DIARISTA'] == 'S'){
            $sn_diaria = 'Diarista - ';
        }else{
            $sn_diaria = '';
        }

        if($row_escala['SEXO'] == 'F'){
            $dr_nm = 'Dra. ';
        }else if($row_escala['SEXO'] == 'M'){
            $dr_nm = 'Dr. ';
        }else{
            $dr_nm = 'Dr(a). ';
        }

        echo '<div style="font-size: 12px;" > <i class="far fa-clock"></i> '.$row_escala['HR_INICIAL']. ' - '. $row_escala['HR_FINAL'].'  <i class="far fa-trash-alt" style="color: red" onclick="apagar_escala('. $row_escala['CD_ESCALA'] .')" ></i>';
        echo '</br>';
        echo '<i class="fas fa-user-md"></i> ' . $sn_diaria .''. $dr_nm .''.  $row_escala['NOME'].'  <i class="fas fa-info-circle" style="color: #3185c1" onclick="abrir_modal_visu('. $row_escala['CD_ESCALA'] .')"></i></div>';
          
        $contador_dias++;
        $contador_vago++;
    }

    if($tipo <> 'P'){
        //IF VAGO FINAL
        if($vago_ultimo_valor <> '24:00'){

            echo '<div style="font-size: 12px; color: red;" > <i class="far fa-clock"></i> ' . $vago_ultimo_valor . ' - ' . '23:59' . '';
            echo '</br>';
            echo 'Vago </div>';
        } 
    }
    echo '</br>';







?>