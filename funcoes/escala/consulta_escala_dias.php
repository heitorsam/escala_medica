<?php
    include '../../conexao.php';

    $sinal = '<>';

    $cons_escala = "SELECT 
                    esc.CD_ESCALA,
                    st.ds_setor,
                    st.tp_setor,
                    prest.nm_mnemonico AS NOME,
                    esc.hr_inicial,
                    ESC.NUM_PRESTADOR,
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
                    AND esc.num_prestador <> 'R'
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
                    ESC.NUM_PRESTADOR,
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
                    AND esc.num_prestador = 'R'
                    ORDER BY 5 ASC, 6 ASC, 7 ASC ";

        $cons_escala_r = "SELECT 
                    esc.CD_ESCALA,
                    st.ds_setor,
                    st.tp_setor,
                    prest.nm_mnemonico AS NOME,
                    esc.hr_inicial,
                    ESC.NUM_PRESTADOR,
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
                    AND esc.num_prestador = 'R'
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
                    ESC.NUM_PRESTADOR,
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
                    AND esc.num_prestador = 'R'
                    ORDER BY 5 ASC, 6 ASC, 7 ASC ";

    $rescult_escala = oci_parse($conn_ora, $cons_escala);

    oci_execute($rescult_escala);


    $rescult_escala_r = oci_parse($conn_ora, $cons_escala_r);

    oci_execute($rescult_escala_r);

    $contador_dias = 0;


    while ($row_escala = oci_fetch_array($rescult_escala)){             
        $tipo = $row_escala['TP_SETOR'];
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
        echo '<i class="fas fa-user-md"></i> ' . $sn_diaria .''. $dr_nm .''.  $row_escala['NOME'].' - '. $row_escala['NUM_PRESTADOR'] .'  <i class="fas fa-info-circle" style="color: #3185c1" onclick="abrir_modal_visu('. $row_escala['CD_ESCALA'] .')"></i></div>';
          
        $contador_dias++;

    }

    while ($row_escala = oci_fetch_array($rescult_escala_r)){             
        $tipo = $row_escala['TP_SETOR'];
        if($contador_dias == 0){

            echo '</br>';

        }else{
            echo '<div style="border-top: solid 1px #838383; width: 10%; margin: 0 auto; margin-top:8px; margin-bottom:8px;"></div>';
            echo '<div style="margin: 0 auto; margin-top:8px; margin-bottom:8px;">Retaguarda</div>';
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
        echo '<i class="fas fa-user-md"></i> ' . $sn_diaria .''. $dr_nm .''.  $row_escala['NOME'].' - '. $row_escala['NUM_PRESTADOR'] .'  <i class="fas fa-info-circle" style="color: #3185c1" onclick="abrir_modal_visu('. $row_escala['CD_ESCALA'] .')"></i></div>';
          
        $contador_dias++;

    }


    echo '</br>';







?>