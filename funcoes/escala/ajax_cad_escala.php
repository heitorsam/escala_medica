<?php
    include '../../conexao.php';

    session_start();

    $var_mes = $_POST['mes'];
    $var_ano = $_POST['ano'];
    $var_tipo = $_POST['tipo'];
    $var_setor = $_POST['setor'];
    $var_num_plantonista = $_POST['num_plantonista'];
    $var_codigo = $_POST['codigo'];
    $var_dia = $_POST['dia'];
    $var_hr_in = $_POST['hr_in'];
    $var_hr_fn = $_POST['hr_fn'];
    $var_diarista = $_POST['diarista'];
    $usuario = $_SESSION['usuarioLogin'];

    $var_periodo = $var_mes .'/'. $var_ano;


    //VERIFICANDO SE O SETOR POSSUI ESPECIALIDADE
    $cons_tp_setor = "SELECT st.TP_SETOR, st.CD_ESPECIALID
                      FROM escala_medica.SETOR st
                      WHERE st.CD_SETOR = '$var_setor'";

    $result_tp_setor = oci_parse($conn_ora, $cons_tp_setor);

    oci_execute($result_tp_setor);

    $row_tp_setor = oci_fetch_array($result_tp_setor);

    $var_tp_setor = $row_tp_setor['TP_SETOR'];
    $var_cd_especialid = $row_tp_setor['CD_ESPECIALID'];

     $cons_responsavel = "SELECT pr.CD_PRESTADOR AS CODIGO 
                         FROM dbamv.PRESTADOR pr 
                         LEFT JOIN dbamv.ESP_MED esp
                           ON esp.CD_PRESTADOR = pr.CD_PRESTADOR
                         WHERE pr.Ds_Codigo_Conselho = '$var_codigo'
                         AND pr.CD_TIP_PRESTA in (3, 8)";
                    
    if($var_tp_setor == 'D' && isset($var_cd_especialid)){

        echo $cons_responsavel .= " AND esp.CD_ESPECIALID = '$var_cd_especialid'";

    }

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

        echo $cons_setor = "INSERT INTO escala_medica.ESCALA
                            (CD_ESCALA,
                            PERIODO,
                            CD_SETOR,
                            CD_PRESTADOR_MV,
                            NUM_PRESTADOR,
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
                            '$var_num_plantonista',
                            '$var_dia',
                            '$var_diarista',
                            '$var_hr_in',
                            '$var_hr_fn',
                            '$usuario',
                            SYSDATE)";
        $result_setor = oci_parse($conn_ora, $cons_setor);
        oci_execute($result_setor);

?>

