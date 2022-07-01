<?php 
    //CABECALHO
    include 'cabecalho.php';

    include 'conexao.php';
?>

    <h11><i class="far fa-calendar-alt"></i> Escala Diaria:</h11>
    <span class="espaco_pequeno" style="width: 6px;" ></span>
    <?php if($_SESSION['sn_administrador'] == 'S'){ ?>
    <h27> <a href="home.php" style="color: #444444; text-decoration: none;"> <i class="fa fa-reply" aria-hidden="true"></i> Voltar </a> </h27> 
    <?php } ?>
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

        <div class="col-md-2">
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
        <div class="col-md-2">
            Tipo:
            <select onchange="$('#div_setor').load('funcoes/escala_diaria/ajax_campo_setor.php?var_tipo='+ this.value)" class="form-control" name="tipo" id="tipo">
                <option value="">Selecione </option>
                <option value="P">Presencial</option>
                <option value="D">Distancia</option>
            </select>
        </div>
        <div id="div_setor" class="col-md-2">
            Setor:
            <select  id="setor" class="form-control">
                <option  value="">Selecione</option>
            </select>
        </div>
        <div class="col-md-2">
            <br>
            <button class="btn btn-primary" onclick="buscar_escala()"><i class="fas fa-search"></i></button>
            <button class="btn btn-primary" id="btn_excel" onclick="excel()" disabled><i class="fas fa-file-excel"></i></button>
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
    now = new Date

    window.onload = function() { document.getElementById('mes').selectedIndex = now.getMonth(); campo_dia();};

    function buscar_escala(){
        document.getElementById('btn_excel').disabled = false;
        var setor = document.getElementById('setor').value;
        var tipo = document.getElementById('tipo').value;
        var dia = document.getElementById('dia').value;
        var mes = document.getElementById('mes').value;
        var ano = document.getElementById('ano').value;
        $('#tabela_escala').load('funcoes/escala_diaria/ajax_tabela.php?dia='+ dia +'&&mes=' + mes + '&&ano='+ ano + '&&setor='+ setor +'&&tp_setor='+ tipo);
    }

    function excel(){
        window.location.href = "funcoes/escala_diaria/excel.php";
    }

    function campo_dia(){
        var mes = document.getElementById('mes').value;
        var ano = document.getElementById('ano').value;

        $('#div_dia').load('funcoes/escala_diaria/ajax_campo_dia.php?mes='+ mes +'&&ano=' + ano);

    }


</script>

