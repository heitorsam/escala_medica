<?php 
    //CABECALHO
    include 'cabecalho.php';

    include 'conexao.php';
?>

    <h11><i class="far fa-clipboard"></i> Exame:</h11>
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
            Código:
            <input type="number" id="cd_especialidade" onkeyup = "campos_especialidade('1')" class="form-control">
        </div>
        <div class="col-md-3">
            Especialidade:
            <!--auto complete funcionario responsavel-->
            <?php 

                //CONSULTA_LISTA
                $consulta_lista = "SELECT esp.ds_especialid AS Nome FROM dbamv.especialid esp WHERE esp.SN_ATIVO = 'S'";
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

                include 'funcoes/exame/autocomplete_especialidade.php';

            ?>
        
            <!--FIM CAIXA AUTOCOMPLETE--> 

        </div>
        <div class="col-md-4">
            Descrição:
            <input type="text" id="ds_exame" class="form-control">
        </div>
        <div class="col-md-1">
            <br>
            <button class="btn btn-primary" id="btn_cad" onclick="cadastrar_exame()"><i class="fas fa-plus" ></i></button>
        </div>
    </div>
    <div class="div_br"></div>
    <div class="div_br"></div>
    <div class="row">
        <div id="tabela_exame" class="col-md-12"></div>
    </div>
<?php
    //RODAPE
    include 'rodape.php';
    include 'funcoes/js_editar_campos.php';
?>

<script>

    window.onload = function() { criar_tabela_exame() };

    function cadastrar_exame(){
        var ds_exame = document.getElementById('ds_exame').value;
        var cd_especialidade = document.getElementById('cd_especialidade').value;

        if(ds_exame == ''){
            document.getElementById('ds_exame').focus();
        }else if(cd_especialidade == ''){
            document.getElementById('cd_especialidade').focus();
        }else{
            $.ajax({
                url: "funcoes/exame/ajax_cad_exame.php",
                type: "POST",
                data: {
                    ds_exame: ds_exame,
                    cd_especialidade: cd_especialidade
                    },
                cache: false,
                success: function(dataResult){
                    //alert(dataResult);
                    document.getElementById('ds_exame').value = '';
                    document.getElementById('cd_especialidade').value = '';
                    document.getElementById('input_valor_tipo').value = '';
                    criar_tabela_exame();                  
                },
            });
        }

        
    }

    function criar_tabela_exame(){
        $('#tabela_exame').load('funcoes/exame/ajax_tabela_exame.php');
    }

    function excluir_exame(cd_exame){
        $.ajax({
                url: "funcoes/exame/ajax_excluir_exame.php",
                type: "POST",
                data: {
                    cd_exame: cd_exame
                    },
                cache: false,
                success: function(dataResult){
                    criar_tabela_exame();
                    alert(dataResult);
                    
                },
            });
    }

    function campos_especialidade(tipo){
        //tipo 1 : código
        if(tipo == '1'){
            var campo = document.getElementById('cd_especialidade').value;
        //tipo 2 : nome
        }else{
            var campo = document.getElementById('input_valor_tipo').value;
        }

        if(campo != ''){
            $.ajax({
                url: "funcoes/setor/ajax_campo_especialidade.php",
                type: "POST",
                data: {
                    tipo: tipo,
                    campo: campo,
                    },
                cache: false,
                success: function(dataResult){
                    if(tipo == '1'){
                        document.getElementById('input_valor_tipo').value = dataResult;
                    }else{
                        document.getElementById('cd_especialidade').value = dataResult;
                    }
                    
                },
            });
        }else{
            if(tipo == '1'){
                document.getElementById('input_valor_tipo').value = '';
            }else{
                document.getElementById('cd_especialidade').value = '';
            }
        }
    }
</script>