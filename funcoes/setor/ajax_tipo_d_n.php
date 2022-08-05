<?php
include '../../conexao.php';
?>
<div class="col-md-12">
    Código:
    <input type="number" id="cd_especialidade" onkeyup = "campos_especialidade('1')" class="form-control">
    Especialidade:
    <!--auto complete funcionario responsavel-->
    <?php 

        //CONSULTA_LISTA
        $consulta_lista = "SELECT esp.ds_especialid AS Nome 
                            FROM dbamv.especialid esp 
                            WHERE esp.SN_ATIVO = 'S'
                            ORDER BY esp.DS_ESPECIALID";
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

        include 'autocomplete_tipo.php';

    ?>



                
    <!--FIM CAIXA AUTOCOMPLETE--> 

</div>
<script>
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