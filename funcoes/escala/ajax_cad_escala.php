<?php
    include '../../conexao.php';

    session_start();

    $var_mes = $_POST['mes'];
    $var_ano = $_POST['ano'];
    $var_tipo = $_POST['tipo'];
    $var_setor = $_POST['setor'];
    $var_codigo = $_POST['codigo'];
    $var_dia = $_POST['dia'];
    $var_hr_in = $_POST['hr_in'];
    $var_hr_fn = $_POST['hr_fn'];
    $var_diarista = $_POST['diarista'];
    $usuario = $_SESSION['usuarioLogin'];

    $var_periodo = $var_mes .'/'. $var_ano;

    $cons_responsavel = "SELECT pr.CD_PRESTADOR AS CODIGO 
                            FROM dbamv.PRESTADOR pr 
                        WHERE pr.Ds_Codigo_Conselho = '$var_codigo'
                        AND pr.CD_TIP_PRESTA = 8";

    $result_responsavel = oci_parse($conn_ora, $cons_responsavel);

    oci_execute($result_responsavel);

    $row_responsavel = oci_fetch_array($result_responsavel);

    $var_responsavel = $row_responsavel['CODIGO'];

    $cons_seq_nextval="SELECT escala_medica.SEQ_CD_ESCALA.nextval AS CD_ESCALA
                        FROM DUAL";

        $result_seq_nextval = oci_parse($conn_ora, $cons_seq_nextval);
        @oci_execute($result_seq_nextval);
        $row_seq_nextval = oci_fetch_array($result_seq_nextval);

        $var_cd_escala = $row_seq_nextval['CD_ESCALA'];

    $cons_qtd = "SELECT SUM(res.QTD_OCORRENCIAS) AS QTD 
                    FROM(
                    SELECT calc.*,
                    CASE 
                      WHEN calc.HR_INICIAL_PHP BETWEEN calc.HR_INICIAL AND calc.HR_FINAL THEN 1
                      WHEN calc.HR_FINAL_PHP BETWEEN calc.HR_INICIAL AND calc.HR_FINAL THEN 1
                      ELSE 0
                    END AS QTD_OCORRENCIAS
                    FROM (SELECT esc.CD_ESCALA, 
                          TO_DATE(LPAD(esc.DIA,2) || '/' || '$var_periodo' || ' ' || esc.HR_INICIAL || ':00', 'DD/MM/YYYY HH24:MI:SS') AS HR_INICIAL,
                          CASE 
                          WHEN esc.HR_FINAL < esc.HR_INICIAL THEN TO_DATE(LPAD(esc.DIA,2) || '/' || '$var_periodo' || ' ' || esc.HR_FINAL || ':00', 'DD/MM/YYYY HH24:MI:SS') + 1
                          ELSE TO_DATE(LPAD(esc.DIA,2) || '/' || '$var_periodo' || ' ' || esc.HR_FINAL || ':00', 'DD/MM/YYYY HH24:MI:SS')
                          END AS HR_FINAL,
                          TO_DATE(LPAD($var_dia,2) || '/' || '$var_periodo' || ' ' || '$var_hr_in' || ':00', 'DD/MM/YYYY HH24:MI:SS') AS HR_INICIAL_PHP,
                          CASE 
                          WHEN '$var_hr_fn' < '$var_hr_in' THEN TO_DATE(LPAD($var_dia,2) || '/' || '$var_periodo' || ' ' || '$var_hr_fn' || ':00', 'DD/MM/YYYY HH24:MI:SS') + 1
                          ELSE TO_DATE(LPAD($var_dia,2) || '/' || '$var_periodo' || ' ' || '$var_hr_fn' || ':00', 'DD/MM/YYYY HH24:MI:SS')
                          END AS HR_FINAL_PHP
                          FROM escala_medica.ESCALA esc
                          WHERE esc.CD_SETOR = $var_setor 
                          AND esc.PERIODO = '$var_periodo'                    
                          ) calc ) res";

    $result_qtd = oci_parse($conn_ora, $cons_qtd);

    oci_execute($result_qtd);

    $row_qtd = oci_fetch_array($result_qtd);


    if($row_qtd['QTD'] == 0 || $var_tipo == 'P'){

        $cons_setor = "INSERT INTO escala_medica.ESCALA
                            (CD_ESCALA,
                            PERIODO,
                            CD_SETOR,
                            CD_PRESTADOR_MV,
                            DIA,
                            DIARISTA,
                            HR_INICIAL,
                            HR_FINAL,
                            CD_USUARIO_CADASTRO,
                            HR_CADASTRO)
                        VALUES
                            ($var_cd_escala,
                            '$var_periodo',
                            $var_setor,
                            $var_responsavel,
                            '$var_dia',
                            '$var_diarista',
                            '$var_hr_in',
                            '$var_hr_fn',
                            '$usuario',
                            SYSDATE)";
        $result_setor = oci_parse($conn_ora, $cons_setor);
        oci_execute($result_setor);

        echo '1';

    }else{

        
        echo 'Já existe um cadastro com esse horario!';

    }

?>

