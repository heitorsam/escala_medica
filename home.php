<?php 
    //CABECALHO
    include 'cabecalho.php';

    include 'conexao.php';

    $var_sn_adm = @$_SESSION['sn_administrador'];


    $cons_qtd = "SELECT COUNT(*) AS QTD FROM escala_medica.DIVISAO_HORA";

    $result_qtd = oci_parse($conn_ora, $cons_qtd);

    oci_execute($result_qtd);

    $row_qtd = oci_fetch_array($result_qtd);

    if($row_qtd['QTD'] == 0){
        header('Location:funcoes/alimentar_tabela_horas.php');
    }

?>

<div class="div_br"> </div>

        <!--MENSAGENS-->
        <?php
            include 'js/mensagens.php';
            include 'js/mensagens_usuario.php';
        ?>

                <div class="div_br"> </div>
                <div class="div_br"> </div>

                <h11><i class="far fa-calendar-alt"></i> Escalas</h11>

                <div class="div_br"> </div>

                <?php if($var_sn_adm == 'S'){ ?>

                <a href="escala.php" class="botao_home" type="submit"><i class="far fa-calendar-alt"></i> Escala</a>
                <span class="espaco_pequeno"></span>

                <?php } ?>
                <a href="escala_diaria.php" class="botao_home" type="submit"><i class="far fa-calendar-alt"></i> Escala Diaria</a>
                
                <?php if($var_sn_adm == 'N'){
                    header('Location:escala_diaria.php');
                }?>
                
                <?php if($var_sn_adm == 'S'){ ?>
                    <div class="div_br"> </div>
                    <div class="div_br"> </div>

                    <h11><i class="fas fa-cog"></i> Configurações</h11>

                    <div class="div_br"> </div>

                    <a href="exame.php" class="botao_home btn-adm" type="submit"><i class="far fa-clipboard"></i> Exame</a>
                    <span class="espaco_pequeno"></span>
                    <a href="setor.php" class="botao_home btn-adm" type="submit"><i class="fa fa-building"></i> Setor</a>
                    <span class="espaco_pequeno"></span>
                <?php } ?>
            <div class="div_br"> </div>
            <div class="div_br"> </div>
            <div class="div_br"> </div>  

<?php
    //RODAPE
    include 'rodape.php';
?>