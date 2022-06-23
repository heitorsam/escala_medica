<?php 
    //CABECALHO
    include 'cabecalho.php';

    $var_sn_adm = @$_POST['sn_administrador'];
?>

<div class="div_br"> </div>

        <!--MENSAGENS-->
        <?php
            include 'js/mensagens.php';
            include 'js/mensagens_usuario.php';
        ?>

                <div class="div_br"> </div>
                <div class="div_br"> </div>

                <h11><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Cadastros</h11>

                <div class="div_br"> </div>
                <?php if(!isset($var_sn_adm)){ ?>
                <a href="setor.php" class="botao_home" type="submit"><i class="fa fa-building"></i> Setores</a></td></tr>
                <span class="espaco_pequeno"></span>
                <a href="escala.php" class="botao_home" type="submit"><i class="far fa-calendar-alt"></i> Escala</a></td></tr>
                <?php } ?>

            <div class="div_br"> </div>
            <div class="div_br"> </div>
            <div class="div_br"> </div>  

<?php
    //RODAPE
    include 'rodape.php';
?>