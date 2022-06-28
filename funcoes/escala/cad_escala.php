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
    $usuario = $_SESSION['usuarioLogin'];

    $var_periodo = $var_mes .'/'. $var_ano;

    $cons_seq_nextval="SELECT escala_medica.SEQ_CD_ESCALA.nextval AS CD_ESCALA
                        FROM DUAL";

        $result_seq_nextval = oci_parse($conn_ora, $cons_seq_nextval);
        @oci_execute($result_seq_nextval);
        $row_seq_nextval = oci_fetch_array($result_seq_nextval);

        $var_cd_escala = $row_seq_nextval['CD_ESCALA'];


    $cons_qtd = "SELECT COUNT(*) AS QTD 
                        FROM escala_medica.ESCALA 
                        WHERE DIA = $var_dia 
                        AND PERIODO = '$var_periodo' 
                        AND HR_INICIAL = '$var_hr_in' 
                        AND HR_FINAL = '$var_hr_fn' 
                        AND CD_SETOR = $var_setor";

    $result_qtd = oci_parse($conn_ora, $cons_qtd);

    oci_execute($result_qtd);

    $row_qtd = oci_fetch_array($result_qtd);


    if($row_qtd['QTD'] == 0){

        $cons_setor = "INSERT INTO escala_medica.ESCALA (CD_ESCALA, 
                                                                PERIODO, 
                                                                CD_SETOR, 
                                                                CD_PRESTADOR_MV, 
                                                                DIA, 
                                                                HR_INICIAL, 
                                                                HR_FINAL, 
                                                                CD_USUARIO_CADASTRO, 
                                                                HR_CADASTRO)
                            VALUES($var_cd_escala, 
                                    '$var_periodo', 
                                    $var_setor, 
                                    $var_codigo, 
                                    '$var_dia', 
                                    '$var_hr_in', 
                                    '$var_hr_fn',
                                    '$usuario', 
                                    SYSDATE)";
        $result_setor = oci_parse($conn_ora, $cons_setor);
        oci_execute($result_setor);

        echo 'Cadastrado com secesso!';

    }else{
        echo 'Já tem um cadastro com esse horario!';
    }

?>

