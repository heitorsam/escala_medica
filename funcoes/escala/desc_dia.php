<?php 
    include '../../conexao.php';

    $cd_escala = $_GET['cd_escala']; 

    $cons_desc = "SELECT esc.CD_PRESTADOR_MV AS CD_PRESTADOR,
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
                    WHERE esc.CD_ESCALA = $cd_escala
                ORDER BY esc.PERIODO DESC, esc.DIA, esc.HR_INICIAL, esc.HR_FINAL";
    $result_desc = oci_parse($conn_ora, $cons_desc);
    oci_execute($result_desc);
    $row_desc = oci_fetch_array($result_desc);
?>



    


<div class="row">
                    <div class="col-md-3">
                        Código do Prestdor:
                        <input type="text" id="cd_prestador" value="<?php echo $row_desc['CD_PRESTADOR'] ?>" class="form-control" readonly>
                    </div>
                    <div class="col-md-4">
                        Prestador:
                        <input type="text" id="nm_prestador" value="<?php echo $row_desc['NM_PRESTADOR'] ?>" class="form-control" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        Setor:
                        <input type="text" id="setor" value="<?php echo $row_desc['SETOR'] ?>" class="form-control" readonly>
                    </div>
                    <div class="col-md-2">
                        Hora Inicial:
                        <input type="text" id="hr_inicial" value="<?php echo $row_desc['INICIAL'] ?>" class="form-control" readonly>
                    </div>
                    <div class="col-md-2">
                        Hora Final:
                        <input type="text" id="hr_final" value="<?php echo $row_desc['FINAL'] ?>" class="form-control" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        Telefone Comercial:
                        <input type="text" id="tlf_comrecial" value="<?php echo @$row_desc['TELEFONE_COMERCIAL_1'] ?>" class="form-control" readonly>
                    </div>
                    <div class="col-md-3">
                        Celular:
                        <input type="text" id="celular" value="<?php echo @$row_desc['CELULAR'] ?>" class="form-control" readonly>
                    </div>
                    <div class="col-md-3">
                        Telefone Comercial 2:
                        <input type="text" id="tlf_comrecial_2" value="<?php echo @$row_desc['TELEFONE_COMERCIAL_2'] ?>" class="form-control" readonly>
                    </div>
                    <div class="col-md-3">
                        Celular 2:
                        <input type="text" id="celular_2" value="<?php echo @$row_desc['CELULAR_2'] ?>" class="form-control" readonly>
                    </div>
                    <div class="col-md-5">
                        Email:
                        <input type="text" id="email" value="<?php echo @$row_desc['E_MAIL'] ?>" class="form-control" readonly>
                    </div>
                </div>