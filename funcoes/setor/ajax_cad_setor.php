<?php
    include '../../conexao.php';

    session_start();

    $var_cd_especialidade = @$_POST['cd_especialidade'];
    $var_tipo = $_POST['tipo'];
    $var_ds = $_POST['ds_setor'];
    $var_responsavel = $_POST['cd_responsavel'];
    $var_sn_exame = $_POST['sn_exame'];
    $var_cd_exame = $_POST['cd_exame'];
    $usuario = $_SESSION['usuarioLogin'];

    $cons_cd_prest = "SELECT prest.cd_prestador 
                        FROM dbamv.Prestador prest 
                        WHERE prest.ds_codigo_conselho = '$var_responsavel'
                        AND prest.CD_TIP_PRESTA in (3, 8)";

    $result_cd_prest = oci_parse($conn_ora, $cons_cd_prest);
    oci_execute($result_cd_prest);
    $row_cd_prest = oci_fetch_array($result_cd_prest);

    $var_cd_prest = $row_cd_prest['CD_PRESTADOR'];


    $cons_seq_nextval="SELECT escala_medica.Seq_Cd_Setor.nextval AS CD_SETOR
                        FROM DUAL";

    $result_seq_nextval = oci_parse($conn_ora, $cons_seq_nextval);
    oci_execute($result_seq_nextval);
    $row_seq_nextval = oci_fetch_array($result_seq_nextval);

    $var_cd_produto = $row_seq_nextval['CD_SETOR'];

    if($var_cd_especialidade == '' && $var_sn_exame == 'S'){
        ECHO $cons_cd_especialidade = "SELECT CD_ESPECIALIDADE FROM escala_medica.Exame WHERE CD_EXAME = $var_cd_exame";

        $result_cd_especialidade = oci_parse($conn_ora, $cons_cd_especialidade);
        oci_execute($result_cd_especialidade);
        $row_cd_especialidade = oci_fetch_array($result_cd_especialidade);

        $var_cd_especialidade = $row_cd_especialidade['CD_ESPECIALIDADE'];
    }







   
    if($var_cd_especialidade == ''){
        $cons_setor = "INSERT INTO escala_medica.SETOR
                                (CD_SETOR,
                                CD_ESPECIALID,
                                TP_SETOR,
                                SN_EXAME,
                                CD_EXAME,
                                DS_SETOR,
                                CD_PRESTADOR_MV,
                                CD_CONSELHO,
                                CD_USUARIO_CADASTRO,
                                HR_CADASTRO)
                            VALUES
                                ($var_cd_produto, NULL, '$var_tipo', '$var_sn_exame', '$var_cd_exame' ,'$var_ds' , $var_cd_prest, '$var_responsavel' , '$usuario', SYSDATE)";

    }else{
        $cons_setor = "INSERT INTO escala_medica.SETOR
                            (CD_SETOR,
                            CD_ESPECIALID,
                            TP_SETOR,
                            SN_EXAME,
                            CD_EXAME,
                            DS_SETOR,
                            CD_PRESTADOR_MV,
                            CD_CONSELHO,
                            CD_USUARIO_CADASTRO,
                            HR_CADASTRO)
                        VALUES
                            ($var_cd_produto, '$var_cd_especialidade', '$var_tipo', '$var_sn_exame', '$var_cd_exame' , '$var_ds' , $var_cd_prest, '$var_responsavel' , '$usuario', SYSDATE)";
    
    }
    echo $cons_setor;
    $result_setor = oci_parse($conn_ora, $cons_setor);
    oci_execute($result_setor);


?>

