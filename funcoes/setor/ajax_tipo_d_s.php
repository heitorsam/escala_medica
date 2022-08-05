<?php
include '../../conexao.php';
?>
    <div class="col-md-12">
        <input id="cd_exame" hidden>
        Exame:
        <!--auto complete funcionario responsavel-->
        <?php 

            //CONSULTA_LISTA
            $consulta_lista = "SELECT ex.DS_EXAME AS NOME 
                                FROM escala_medica.EXAME ex
                                ORDER BY 1 ASC";
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

            include 'autocomplete_exame.php';

        ?>



                    
        <!--FIM CAIXA AUTOCOMPLETE--> 
    </div>
<script>
    function campos_exame(tipo){
        
        campo = document.getElementById('input_valor_exame').value;
        

        if(campo != ''){
            $.ajax({
                url: "funcoes/setor/ajax_campo_exame.php",
                type: "POST",
                data: {
                    tipo: tipo,
                    campo: campo,
                    },
                cache: false,
                success: function(dataResult){
                    
                    document.getElementById('cd_exame').value = dataResult;
                    
                    
                },
            });
        }else{
            
            document.getElementById('cd_exame').value = '';
            
        }
    }
</script>