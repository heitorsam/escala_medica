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
        <div class="col-md-2">
            Dia:
            <input id="data" type="date" class="form-control">
        </div>
        <div class="col-md-3">
            Setor:
            <select class="form-control" id="setor">
                <option value=''>---</option>
                <?php
                    $cons_setor = "SELECT CD_SETOR AS CODIGO, DS_SETOR AS DESCRICAO FROM escala_medica.SETOR";
                    $result_setor = oci_parse($conn_ora, $cons_setor);
                    oci_execute($result_setor);
                    while($row_setor = oci_fetch_array($result_setor)){
                        echo '<option value="'. $row_setor['CODIGO'] .'" >'. $row_setor['DESCRICAO'] .'</option>';
                    }
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <br>
            <button class="btn btn-primary" onclick="buscar_escala()"><i class="fas fa-search"></i></button>
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

    window.onload = function() {buscar_escala() };

    function buscar_escala(){
        var data = document.getElementById('data').value;
        var setor = document.getElementById('setor').value;
        var dia = data.substring(8, 10);
        var mes = data.substring(5, 7);
        var ano = data.substring(0, 4);
        $('#tabela_escala').load('funcoes/escala_telefonista/ajax_tabela.php?dia='+ dia +'&&mes=' + mes + '&&ano='+ ano + '&&setor='+ setor);
    }

</script>

