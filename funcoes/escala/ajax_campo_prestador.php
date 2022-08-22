<?php 
    include '../../conexao.php';

    $cd_setor = $_GET['cd_escala'];

    $cons_esp = "SELECT CD_ESPECIALID AS ESPECIALIDADE FROM escala_medica.SETOR WHERE CD_SETOR = '$cd_setor' ORDER BY CD_ESPECIALID ASC";
    $result_esp = oci_parse($conn_ora, $cons_esp);																									

    //EXECUTANDO A CONSULTA SQL (ORACLE)
    oci_execute($result_esp); 
    
    $row_esp = oci_fetch_array($result_esp);

    @$cd_especialidade = $row_esp['ESPECIALIDADE'];
?>


CRM:
<input type="text" id="cd_responsavel" onkeyup = "campos_responsavel('1', '<?php echo @$cd_especialidade ?>')" class="form-control" autocomplete="off">


Prestador:     
    <!--auto complete prestador-->  
<?php

    if($cd_especialidade != ''){

    //CONSULTA_LISTA
        $consulta_lista = "SELECT prest.DS_CODIGO_CONSELHO,  replace(prest.NM_PRESTADOR, CHR(10), '') AS NOME
                            FROM dbamv.PRESTADOR prest
                            INNER JOIN dbamv.ESP_MED em
                            ON em.CD_PRESTADOR = prest.CD_PRESTADOR
                            WHERE prest.tp_situacao = 'A'
                            AND prest.cd_tip_presta in (3, 8)
                            AND em.CD_ESPECIALID = '$cd_especialidade'
                            ORDER BY prest.DS_CODIGO_CONSELHO ASC";
    }else{
        $consulta_lista =" SELECT pre.DS_CODIGO_CONSELHO AS CODIGO,
                                replace(pre.NM_PRESTADOR, CHR(10), '') AS NOME
                            from dbamv.PRESTADOR pre
                            WHERE pre.TP_SITUACAO = 'A'
                            AND pre.cd_tip_presta in (3, 8)
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




