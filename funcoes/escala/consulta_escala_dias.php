<?php
    include '../../conexao.php';

    $cons_escala = "SELECT st.ds_setor,
                    st.tp_setor,
                    prest.nm_mnemonico AS NOME,
                    esc.hr_inicial,
                    esc.hr_final,
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
                    ORDER BY esc.hr_inicial ASC, esc.hr_final ASC";

    $rescult_escala = oci_parse($conn_ora, $cons_escala);

    oci_execute($rescult_escala);

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
        echo '<i class="fas fa-user-md"></i> ' . $sn_diaria .''. $dr_nm .''.  $row_escala['NOME'].'  <i class="fas fa-info-circle" style="color: #3185c1" onclick="abrir_modal_visu('. $row_escala['CD_ESCALA'] .')"></i></div>';
          
        $contador_dias++;

    }


    echo '</br>';







?>