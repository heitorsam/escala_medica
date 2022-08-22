<?php
    include '../../conexao.php';

    session_start();

    $var_cd_setor = $_POST['cd_setor'];
    $var_cd_conselho = $_POST['cd_responsavel'];
    $var_cd_especie = @$_POST['cd_especie'];
    $usuario = $_SESSION['usuarioLogin'];

    $cons_cd_prest = "SELECT CD_PRESTADOR 
                        FROM dbamv.PRESTADOR 
                        WHERE DS_CODIGO_CONSELHO = '$var_cd_conselho'
                        AND CD_TIP_PRESTA in (3, 8)";

    $result_cd_prest = oci_parse($conn_ora, $cons_cd_prest);

    oci_execute($result_cd_prest);

    $row_cd_prest = oci_fetch_array($result_cd_prest);

    $var_cd_prest = $row_cd_prest['CD_PRESTADOR'];

    if($var_cd_especie != ''){
        $cons_qtd_esp = "SELECT COUNT(*) AS QTD 
                            FROM dbamv.ESPECIALID esp 
                            WHERE esp.CD_ESPECIALID = $var_cd_especie 
                            AND esp.SN_ATIVO = 'S'";
        
        $result_qtd_esp = oci_parse($conn_ora, $cons_qtd_esp);
        oci_execute($result_qtd_esp);
        $row_qtd_esp = oci_fetch_array($result_qtd_esp);

    }

    $cons_qtd_resp = "SELECT COUNT(*) AS QTD 
                        FROM dbamv.PRESTADOR pr 
                        WHERE pr.CD_PRESTADOR = $var_cd_prest 
                        AND pr.TP_SITUACAO = 'A'";

    $result_qtd_resp = oci_parse($conn_ora, $cons_qtd_resp);

    oci_execute($result_qtd_resp);
    
    $row_qtd_resp = oci_fetch_array($result_qtd_resp);
    


    if($row_qtd_resp['QTD'] > 0){
        if($var_cd_especie == ''){
            $cons_update = "UPDATE escala_medica.SETOR SET 
                            CD_PRESTADOR_MV = $var_cd_prest,
                            CD_CONSELHO = '$var_cd_conselho',
                            CD_USUARIO_ULT_ALT = '$usuario',
                            HR_ULT_ALT = SYSDATE
                            WHERE CD_SETOR = $var_cd_setor";
            $result_update = oci_parse($conn_ora, $cons_update);

            oci_execute($result_update);

            echo 'Editado com sucesso!';
        }else{
            if($row_qtd_esp['QTD'] == '1'){
                $cons_update = "UPDATE escala_medica.SETOR SET 
                        CD_PRESTADOR_MV = $var_cd_prest,
                        CD_CONSELHO = $var_cd_conselho,
                        CD_USUARIO_ULT_ALT = '$usuario',
                        HR_ULT_ALT = SYSDATE
                        WHERE CD_SETOR = $var_cd_setor";
                $result_update = oci_parse($conn_ora, $cons_update);

                oci_execute($result_update);

                echo 'Editado com sucesso!';
            }else{
                echo 'Especialidade não existe';
            }
        }
    }else{
        echo "Responsavel inativo ou não existe!";
    }






?>