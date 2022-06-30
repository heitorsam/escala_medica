<?php 
    include '../../conexao.php';

    $cd_setor = $_GET['cd_escala'];

    $cons_esp = "SELECT CD_ESPECIALID AS ESPECIALIDADE FROM escala_medica.SETOR WHERE CD_SETOR LIKE '%$cd_setor%'";
    $result_esp = oci_parse($conn_ora, $cons_esp);																									

    //EXECUTANDO A CONSULTA SQL (ORACLE)
    oci_execute($result_esp); 
    
    $row_esp = oci_fetch_array($result_esp);

    $cd_especialidade = $row_esp['ESPECIALIDADE'];
?>



<input type="number" id="cd_responsavel" onkeyup = "campos_responsavel('1', '<?php echo @$cd_especialidade ?>')" class="form-control" hidden>


Prestador:     
    <!--auto complete prestador-->  
<?php

    if($cd_especialidade != ''){

    //CONSULTA_LISTA
        $consulta_lista = "SELECT prest.CD_PRESTADOR,  replace(prest.NM_PRESTADOR, CHR(10), '') AS NOME
                            FROM dbamv.PRESTADOR prest
                            INNER JOIN dbamv.ESP_MED em
                            ON em.CD_PRESTADOR = prest.CD_PRESTADOR
                            WHERE em.SN_ESPECIAL_PRINCIPAL = 'S'
                            AND prest.tp_situacao = 'A'
                            AND em.CD_ESPECIALID LIKE '%$cd_especialidade%'";
    }else{
        $consulta_lista =" SELECT pre.CD_PRESTADOR AS CODIGO,
                                replace(pre.NM_PRESTADOR, CHR(10), '') AS NOME
                            from dbamv.PRESTADOR pre
                            WHERE pre.TP_SITUACAO = 'A'
                            AND pre.cd_tip_presta = 8
                            ORDER BY 2";
    }
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
    include 'autocomplete_prestador.php';

?>
            
<!--FIM CAIXA AUTOCOMPLETE-->   




