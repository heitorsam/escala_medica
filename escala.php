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
            Tipo:
            <select onchange="$('#div_setor').load('funcoes/escala/ajax_campo_setor.php?var_tipo='+ this.value)" class="form-control" name="tipo" id="tipo">
                <option value="">Selecione </option>
                <option value="P">Presencial</option>
                <option value="D">Distancia</option>
            </select>
        </div>
        <div id="div_setor" class="col-md-3">
            Setor:
            <select  id="setor" class="form-control">
                <option  value="">Selecione</option>
            </select>
        </div>
        <div class="col-md-1">
            <br>
            <button class="btn btn-primary" onclick="buscar_escala()"><i class="fas fa-search"></i></button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            Código:
            <input type="number" id="cd_responsavel" onkeyup = "campos_responsavel('1')" class="form-control">
        </div>
        <div class="col-md-4">
            Prestador:
            <!--auto complete funcionario responsavel-->
            <?php 
            
                //CONSULTA_LISTA
                $consulta_lista = "SELECT pre.CD_PRESTADOR AS CODIGO, replace(pre.NM_PRESTADOR,CHR(10),'') AS NOME from dbamv.PRESTADOR pre WHERE pre.TP_SITUACAO = 'A' ORDER BY 2";
                $result_lista = oci_parse($conn_ora, $consulta_lista);																									

                //EXECUTANDO A CONSULTA SQL (ORACLE)
                oci_execute($result_lista);            

            ?>

            <script>

                //LISTA
                var countries = [     
                    <?php
                        while($row_lista = oci_fetch_array($result_lista)){	
                            echo '"'. str_replace('"' , '', $row_lista['NOME']) .'",';                
                        }
                    ?>
                ];

                </script>

                <?php
                //AUTOCOMPLETE
                include 'funcoes/escala/autocomplete_prestador.php';

            ?>
                        
            <!--FIM CAIXA AUTOCOMPLETE-->   
        </div>
        <div id="div_dia" class="col-md-1">
            Dia:
            <select class="form-control">
                <option value="">--</option>
            </select>
        </div>
        <div class="col-md-2">
            Hora Inicial:
            <?php
                $cons_hr_in = "SELECT hr.DS_HORA AS HORA FROM escala_medica.DIVISAO_HORA hr WHERE hr.TP_HORA = 'I'";
                $result_hr_in = oci_parse($conn_ora, $cons_hr_in);
                oci_execute($result_hr_in);

                echo "<select id='hora_inicial' class='form-control'>";
                    while($row_hr_in = oci_fetch_array($result_hr_in)){
                        echo "<option value=" . $row_hr_in['HORA'] .">". $row_hr_in['HORA'] ."</option>";
                    }
                echo "</select>";
            ?>
        </div>
        <div class="col-md-2">
            Hora Final:
            <?php
                $cons_hr_fn = "SELECT hr.DS_HORA AS HORA FROM escala_medica.DIVISAO_HORA hr WHERE hr.TP_HORA = 'F'";
                $result_hr_fn = oci_parse($conn_ora, $cons_hr_fn);
                oci_execute($result_hr_fn);

                echo "<select id='hora_final' class='form-control'>";
                    while($row_hr_fn = oci_fetch_array($result_hr_fn)){
                        echo "<option value=" . $row_hr_fn['HORA'] .">". $row_hr_fn['HORA'] ."</option>";
                    }
                echo "</select>";
            ?>
        </div>
        <div class="col-md-1">
            <br>
            <button class="btn btn-primary" onclick="cad_escala()"><i class="fas fa-plus"></i></button>
        </div>
    </div>
<?php
    //RODAPE
    include 'rodape.php';
?>

<script>

    window.onload = function() { campo_dia() };

    function buscar_escala(){
        //alert('Função em desenvolvimento');
    }

    function campos_responsavel(tipo){
        //tipo 1 : código
        if(tipo == '1'){
            var campo = document.getElementById('cd_responsavel').value;
        //tipo 2 : nome
        }else{
            var campo = document.getElementById('input_valor').value;
        }

        if(campo != ''){
            $.ajax({
                url: "funcoes/escala/campo_responsavel.php",
                type: "POST",
                data: {
                    tipo: tipo,
                    campo: campo,
                    },
                cache: false,
                success: function(dataResult){
                    if(tipo == '1'){
                        document.getElementById('input_valor').value = dataResult;
                    }else{
                        document.getElementById('cd_responsavel').value = dataResult;
                    }
                    
                },
            });
        }else{
            if(tipo == '1'){
                document.getElementById('input_valor').value = '';
            }else{
                document.getElementById('cd_responsavel').value = '';
            }
        }
    }

    function campo_dia(){
        var mes = document.getElementById('mes').value;
        var ano = document.getElementById('ano').value;

        $('#div_dia').load('funcoes/escala/ajax_campo_dia.php?mes='+ mes +'&&ano=' + ano);

    }

    function cad_escala(){
        var mes = document.getElementById('mes').value;
        var ano = document.getElementById('ano').value;
        var tipo = document.getElementById('tipo').value;
        var setor = document.getElementById('setor').value;
        var codigo = document.getElementById('cd_responsavel').value;
        var dia = document.getElementById('dia').value;
        var hr_in = document.getElementById('hora_inicial').value;
        var hr_fn = document.getElementById('hora_final').value;

        //alert('mes: '+ mes +' ano: '+ ano +' tipo: '+ tipo +' setor: '+ setor +' codigo: '+ codigo +' dia: '+ dia +' hr_in: '+ hr_in +' hr_fn: '+ hr_fn)
        $.ajax({
                url: "funcoes/escala/cad_escala.php",
                type: "POST",
                data: {
                    mes: mes,
                    ano: ano,
                    tipo: tipo,
                    setor: setor,
                    codigo: codigo,
                    dia: dia,
                    hr_in: hr_in,
                    hr_fn: hr_fn,
                    },
                cache: false,
                success: function(dataResult){
                    tabela_escala();
                },
            });
    }

    function tabela_escala(){
        alert('Função em deenvolvimento');
    }


</script>

