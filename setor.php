<?php 
    //CABECALHO
    include 'cabecalho.php';

    include 'conexao.php';
?>

    <h11><i class="fa fa-building"></i> Setor:</h11>
    <span class="espaco_pequeno" style="width: 6px;" ></span>
    <h27> <a href="home.php" style="color: #444444; text-decoration: none;"> <i class="fa fa-reply" aria-hidden="true"></i> Voltar </a> </h27> 
    <div class="div_br"> </div> 

        <!--MENSAGENS-->
        <?php
            include 'js/mensagens.php';
            include 'js/mensagens_usuario.php';
        ?>
    <div class="row">
        <div class="col-md-2">
            Tipo:
            <select id="tipo" class="form-control">
                <option value="">Selecione</option>
                <option value="D">Distancia</option>
                <option value="P">Presencial</option>
            </select>
        </div>
        <div class="col-md-3">
            Descrição:
            <input type="text" id="ds_setor" class="form-control">
        </div>
        <div class="col-md-2">
            Código:
            <input type="number" id="cd_responsavel" onkeyup = "campos_responsavel('1')" class="form-control">
        </div>
        <div class="col-md-4">
            Responsavel:
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
                include 'funcoes/setor/autocomplete_prestador.php';

            ?>
                        
            <!--FIM CAIXA AUTOCOMPLETE-->   
        </div>
        <div class="col-md-1">
            <br>
            <button class="btn btn-primary" onclick="cadastrar_setor()"><i class="fas fa-plus"></i></button>
        </div>
    </div>
    <div class="div_br"></div>
    <div class="div_br"></div>
    <div class="row">
        <div id="tabela_setor" class="col-md-12"></div>
    </div>
<?php
    //RODAPE
    include 'rodape.php';
?>

<script>

    window.onload = function() { criar_tabela_setor() };

    function cadastrar_setor(){
        var tipo = document.getElementById('tipo').value;
        var ds_setor = document.getElementById('ds_setor').value;
        var cd_responsavel = document.getElementById('cd_responsavel').value;
        var responsavel = document.getElementById('input_valor').value;

        if(tipo == ''){
            document.getElementById('tipo').focus();
        }else if(ds_setor == ''){
            document.getElementById('ds_setor').focus();
        }else if(responsavel == ''){
            document.getElementById('input_valor').focus();
        }else if(cd_responsavel == ''){
            document.getElementById('cd_responsavel').focus();
        }else{
            
            $.ajax({
                url: "funcoes/setor/cad_setor.php",
                type: "POST",
                data: {
                    tipo: tipo,
                    ds_setor: ds_setor,
                    cd_responsavel: cd_responsavel
                    },
                cache: false,
                success: function(dataResult){
                    //alert(dataResult);
                    document.getElementById('ds_setor').value = '';
                    document.getElementById('input_valor').value = '';
                    document.getElementById('cd_responsavel').value = '';
                    criar_tabela_setor();
                                       
                },
            });

        }
    }

    function criar_tabela_setor(){
        $('#tabela_setor').load('funcoes/setor/ajax_tabela_setor.php');
    }

    function excluir_setor(cd_setor){
        $.ajax({
                url: "funcoes/setor/excluir_setor.php",
                type: "POST",
                data: {
                    cd_setor: cd_setor
                    },
                cache: false,
                success: function(dataResult){
                    criar_tabela_setor();
                    alert(dataResult);
                    
                },
            });
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
                url: "funcoes/setor/campo_responsavel.php",
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

    function editar_setor(tp_setor, ds_setor, cd_setor, cd_responsavel, responsavel){

        document.getElementById('cd_setor_modal').value = cd_setor;
        document.getElementById('ds_setor_modal').value = ds_setor;
        if(tp_setor == 'P'){
            document.getElementById('tp_setor_modal').selectedIndex = "0";
        }else{
            document.getElementById('tp_setor_modal').selectedIndex = "1";
        }
        
        document.getElementById('cd_responsavel_modal').value = cd_responsavel;

        $('#editar_modal').modal({
            show: true
        });
    }

    function salvar_setor(){
        var cd_setor = document.getElementById('cd_setor_modal').value;
        var ds_setor = document.getElementById('ds_setor_modal').value;
        var tp_setor = document.getElementById('tp_setor_modal').value;
        var cd_responsavel = document.getElementById('cd_responsavel_modal').value;

        $.ajax({
                url: "funcoes/setor/ajax_salvar_setor.php",
                type: "POST",
                data: {
                    cd_setor: cd_setor,
                    ds_setor: ds_setor,
                    tp_setor: tp_setor,
                    cd_responsavel: cd_responsavel
                    },
                cache: false,
                success: function(dataResult){
                    document.location.reload(true);
                },
            });

    }



</script>