<?php 
    //CABECALHO
    include 'cabecalho.php';

    include 'conexao.php';
?>

    <h11><i class="fa fa-building"></i> Escala:</h11>
    <span class="espaco_pequeno" style="width: 6px;" ></span>
    <h27> <a href="home.php" style="color: #444444; text-decoration: none;"> <i class="fa fa-reply" aria-hidden="true"></i> Voltar </a> </h27> 
    <div class="div_br"> </div> 

    <div class="row">

        <div class="col-md-2">
            Ano:
            <?php
            echo '<select class="form-control" onchange="campo_dia()" name="ano" id="ano">';
                $cons_ano = "SELECT DISTINCT res.ANO
                                FROM(SELECT DISTINCT SUBSTR(esc.PERIODO,4,5) AS  ANO
                                    FROM escala_medica.ESCALA esc

                                    UNION ALL

                                    SELECT TO_CHAR(SYSDATE+60, 'YYYY') AS ANO
                                    FROM DUAL
                                ) res";
                $result_ano = oci_parse($conn_ora, $cons_ano);
                oci_execute($result_ano);
                while($row_ano = oci_fetch_array($result_ano)){
                    echo '<option value= '. $row_ano['ANO'] .'>'. $row_ano['ANO'] .'</option>';
                }

            echo '</select>';
            ?>
        </div>

        <div class="col-md-1">
            Mês:
            <select class="form-control" onchange="campo_dia()" name="mes" id="mes">
                <option value="01">1</option>
                <option value="02">2</option>
                <option value="03">3</option>
                <option value="04">4</option>
                <option value="05">5</option>
                <option value="06">6</option>
                <option value="07">7</option>
                <option value="08">8</option>
                <option value="09">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
            </select>
        </div>
        
        <div id="div_dia" class="col-md-2">
            Dia:
            <select id="dia" class="form-control">
                <option value=""></option>
            </select>
        </div>
        <div class="col-md-3">
            Setor:
            <select class="form-control" id="setor">
                <option value=''>Todos</option>
                <?php
                    $cons_setor = "SELECT CD_SETOR AS CODIGO, DS_SETOR AS DESCRICAO FROM escala_medica.SETOR";
                    $result_setor = oci_parse($conn_ora, $cons_setor);
                    oci_execute($result_setor);
                    while($row_setor = oci_fetch_array($result_setor)){
                        echo '<option value="'. $row_setor['CODIGO'] .'" >'. $row_setor['DESCRICAO'] .'</option>';
                    }
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <br>
            <button class="btn btn-primary" onclick="buscar_escala()"><i class="fas fa-search"></i></button>
            <button class="btn btn-primary" onclick="excel()"><i class="fas fa-file-excel"></i></button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" id="tabela_escala"></div>
    </div>
<?php
    //RODAPE
    include 'rodape.php';
?>

<script>
    //
    now = new Date

    window.onload = function() { document.getElementById('mes').selectedIndex = now.getMonth();campo_dia(); buscar_escala();};

    function buscar_escala(){
        var setor = document.getElementById('setor').value;
        var dia = document.getElementById('dia').value;
        var mes = document.getElementById('mes').value;
        var ano = document.getElementById('ano').value;
        $('#tabela_escala').load('funcoes/escala_telefonista/ajax_tabela.php?dia='+ dia +'&&mes=' + mes + '&&ano='+ ano + '&&setor='+ setor);
    }

    function excel(){
        var excel = document.getElementById('excel').value;

        window.location.href = "funcoes/escala_telefonista/excel.php?excel=" + excel;
    }

    function campo_dia(){
        var mes = document.getElementById('mes').value;
        var ano = document.getElementById('ano').value;

        $('#div_dia').load('funcoes/escala_telefonista/ajax_campo_dia.php?mes='+ mes +'&&ano=' + ano);

    }


</script>

