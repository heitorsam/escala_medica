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
            <select id="tipo" class="form-control" onchange="campo_tipo()">
                <option value="">Selecione</option>
                <option value="D">Distancia</option>
                <option value="P">Presencial</option>
                <option value="F">Fixa</option>
            </select>
        </div>
        <div class="col-md-1" id="div_exame">
            Exame:
            <input type="checkbox" id="ck_exame" onclick="campo_tipo()" class="form-control" style="zoom:0.8; margin-top: 6px;">
        </div>
        <div id="div_tipo">
            Descrição:
            <input type="text" id="ds_setor" class="form-control">
        </div>
    </div>
    <div class="div_br"></div>
    <div class="row">
        <div class="col-md-2">
            CRM:
            <input type="text" onkeyup ="campos_responsavel('1')" id="cd_responsavel" class="form-control" autocomplete="off"> 
        </div>
        <div class="col-md-4">
            Responsável:
            <!--auto complete funcionario responsavel-->
            <?php 
            
                //CONSULTA_LISTA
                $consulta_lista = "SELECT pre.CD_PRESTADOR AS CODIGO,
                                            replace(pre.NM_PRESTADOR, CHR(10), '') AS NOME
                                    from dbamv.PRESTADOR pre
                                    WHERE pre.TP_SITUACAO = 'A'
                                    AND pre.cd_tip_presta = 8
                                    ORDER BY 2";
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
            <button class="btn btn-primary" id="btn_cad" onclick="cadastrar_setor()" disabled><i class="fas fa-plus" ></i></button>
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

    window.onload = function() { criar_tabela_setor();
                                    document.getElementById('div_exame').style.display = "none"; };

    function cadastrar_setor(){
        var tipo = document.getElementById('tipo').value;
        var sn_exame = document.getElementById('ck_exame').checked;
        
        if(sn_exame == true){
            sn_exame = 'S';
        }else{
            sn_exame = 'N';
        }

        if(tipo == 'P' || tipo == 'F'){
            var cd_especialidade = null;
            var ds_setor = document.getElementById('ds_setor').value;
            var cd_exame = null;
        }else if(tipo == 'D' && sn_exame == 'S'){
            
            var cd_exame = document.getElementById('cd_exame').value;
            var ds_setor = document.getElementById('input_valor_exame').value;
        }else{
            var cd_exame = null;
            var cd_especialidade = document.getElementById('cd_especialidade').value;
            var ds_setor = document.getElementById('input_valor_tipo').value;
        }
        var cd_responsavel = document.getElementById('cd_responsavel').value;
        var responsavel = document.getElementById('input_valor').value;
        
        if(tipo == ''){
            document.getElementById('tipo').focus();
        }else if(cd_especialidade == '' && tipo == 'D'){
            document.getElementById('cd_especialidade').focus();
        }else if(ds_setor == ''){
            if(tipo == 'P' || tipo == 'F'){
                document.getElementById('ds_setor').focus();
            }else{
                document.getElementById('input_valor_tipo').focus();
            }
            
        }else if(responsavel == ''){
            document.getElementById('input_valor').focus();
        }else if(cd_responsavel == ''){
            document.getElementById('input_valor').focus();
        }else{
            
            $.ajax({
                url: "funcoes/setor/ajax_cad_setor.php",
                type: "POST",
                data: {
                    cd_exame: cd_exame,
                    cd_especialidade: cd_especialidade,
                    tipo: tipo,
                    ds_setor: ds_setor,
                    cd_responsavel: cd_responsavel,
                    sn_exame: sn_exame,
                    },
                cache: false,
                success: function(dataResult){   
                    alert(dataResult);
                    if(tipo == 'P' || tipo == 'F'){
                        document.getElementById('ds_setor').value = '';
                    }else if(tipo == 'D' && sn_exame == 'S'){
                        document.getElementById('cd_exame').value = '';
                        document.getElementById('input_valor_exame').value = '';
                    }else{
                        document.getElementById('cd_especialidade').value = '';
                        document.getElementById('input_valor_tipo').value = '';
                    }
                    
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
                url: "funcoes/setor/ajax_excluir_setor.php",
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
        if(tipo == 1){
            var campo = document.getElementById('cd_responsavel').value;

        }else{
            var campo = document.getElementById('input_valor').value;

        }
        
        if(campo != ''){
            $.ajax({
                url: "funcoes/setor/ajax_campo_responsavel.php",
                type: "POST",
                data: {
                    campo: campo,
                    tipo: tipo
                    },
                cache: false,
                success: function(dataResult){
                    if(tipo == 1){
                        document.getElementById('input_valor').value = dataResult;
                    }else{
                        document.getElementById('cd_responsavel').value = dataResult;
                    }
                },
            });
        }else{
            if(tipo == 1){
                document.getElementById('input_valor').value = '';

            }else{
                document.getElementById('cd_responsavel').value = '';

            }
            
        }
    }

    function campos_responsavel_modal(tipo){
        if(tipo == 1){
           var campo = document.getElementById('cd_responsavel_modal').value;
        }else{
            var campo = document.getElementById('input_valor_modal').value;
        }
        if(campo != ''){
            $.ajax({
                url: "funcoes/setor/ajax_campo_responsavel.php",
                type: "POST",
                data: {
                    campo: campo,
                    tipo: tipo
                    },
                cache: false,
                success: function(dataResult){
                    if(tipo == 1){
                        document.getElementById('input_valor_modal').value = dataResult
                    }else{
                        document.getElementById('cd_responsavel_modal').value = dataResult;
                    }
                },
            });
        }else{
            if(tipo == 1){
                document.getElementById('input_valor_modal').value = '';
            }else{
                document.getElementById('cd_responsavel_modal').value = '';
            }
        }
    }

    function editar_setor(tp_setor, ds_setor, cd_setor, cd_responsavel, responsavel, cd_especie, ds_especie){
        
        if(tp_setor == 'P' ){
            document.getElementById('tp_setor_modal').selectedIndex = "0";
            document.getElementById('div_cd').style.display = "none";
        }else if(tp_setor == 'F'){
            document.getElementById('tp_setor_modal').selectedIndex = "2";
            document.getElementById('div_cd').style.display = "none";
        }else{
            document.getElementById('tp_setor_modal').selectedIndex = "1";
            document.getElementById('div_cd').style.display = "block";
            
            
        }

        document.getElementById('ds_setor_modal').value = ds_setor;
        document.getElementById('ds_especie_modal').value = ds_especie;
        document.getElementById('cd_especialidade_modal').value = cd_especie;
        document.getElementById('cd_setor_modal').value = cd_setor;
        document.getElementById('cd_responsavel_modal').value = cd_responsavel;
        document.getElementById('input_valor_modal').value = responsavel;
        $('#editar_modal').modal({
            show: true
        });
        
    }

    function salvar_setor(){

        var cd_setor = document.getElementById('cd_setor_modal').value;
        var cd_responsavel = document.getElementById('cd_responsavel_modal').value;


        if(cd_responsavel == ''){
            alert('Responsavel não pode ser vazio');
        }else{
            $.ajax({
                url: "funcoes/setor/ajax_salvar_setor.php",
                type: "POST",
                data: {
                    cd_setor: cd_setor,
                    cd_responsavel: cd_responsavel,
                    },
                cache: false,
                success: function(dataResult){
                    alert(dataResult);
                    criar_tabela_setor();
                },
            });
        }
    }

    function campo_tipo(){
        var tipo = document.getElementById('tipo').value;
        var sn_exame = document.getElementById('ck_exame').checked;
        
        if(tipo == 'D'){
            document.getElementById('div_exame').style.display = "block";
            if(sn_exame == true){
                $('#div_tipo').load('funcoes/setor/ajax_tipo_d_s.php');
            }else{
                $('#div_tipo').load('funcoes/setor/ajax_tipo_d_n.php');
            }
            document.getElementById('btn_cad').disabled = false;
        }else if(tipo == 'P' || tipo == 'F'){
            document.getElementById('ck_exame').checked = false;
            document.getElementById('div_exame').style.display = "none";
            document.getElementById('btn_cad').disabled = false;
            $('#div_tipo').load('funcoes/setor/ajax_tipo_p.php');

        }else{
            $('#div_tipo').load('funcoes/setor/ajax_tipo_p.php');
            document.getElementById('ck_exame').checked = false;
            document.getElementById('div_exame').style.display = "none";
            document.getElementById('btn_cad').disabled = true;
        }
    }
    function campos_especialidade_modal(tipo){
        //tipo 1 : código
        if(tipo == '1'){
            var campo = document.getElementById('cd_especialidade_modal').value;
        //tipo 2 : nome
        }else{
            var campo = document.getElementById('input_valor_especialidade_modal').value;
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
                        document.getElementById('input_valor_especialidade_modal').value = dataResult;
                    }else{
                        document.getElementById('cd_especialidade_modal').value = dataResult;
                    }
                    
                },
            });
        }else{
            if(tipo == '1'){
                document.getElementById('input_valor_especialidade_modal').value = '';
            }else{
                document.getElementById('cd_especialidade_modal').value = '';
            }
        }
    }

    function campo_tipo_modal(){
        
        var tipo = document.getElementById('tp_setor_modal').value;
        document.getElementById('cd_especialidade_modal').value = "";
        document.getElementById('input_valor_especialidade_modal').value = "";
        document.getElementById('ds_setor_modal').value = "";

        if(tipo == 'P' || tipo == 'F'){
            
            document.getElementById('ds_setor_modal').value = "";
            document.getElementById('ds_setor_modal').style.display = "block";
            document.getElementById('div_cd').style.display = "none";
            document.getElementById('input_valor_especialidade_modal').style.display = "none";
        }else if(tipo == 'D'){
            
            document.getElementById('cd_especialidade_modal').value = "";
            document.getElementById('input_valor_especialidade_modal').value = "";
            document.getElementById('ds_setor_modal').style.display = "none";
            document.getElementById('div_cd').style.display = "block";
            document.getElementById('input_valor_especialidade_modal').style.display = "block";
        }else{
            
        }
    }


</script>


