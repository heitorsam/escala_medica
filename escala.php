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
            <select class="form-control" name="mes" id="mes">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
            </select>
        </div>
        <div class="col-md-2">
            Ano:
            <select class="form-control" name="ano" id="ano">
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
                <option value="2029">2029</option>
                <option value="2030">2030</option>
                <option value="2031">2031</option>
            </select>
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
            <select class="form-control">
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
                $consulta_lista = "SELECT pre.CD_PRESTADOR AS CODIGO, replace(pre.Nm_Mnemonico,CHR(10),'') AS NOME from dbamv.PRESTADOR pre WHERE pre.TP_SITUACAO = 'A' ORDER BY 2";
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
    </div>
<?php
    //RODAPE
    include 'rodape.php';
?>

<script>

    function buscar_escala(){
        alert('Função em desenvolvimento');
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


</script>