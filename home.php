<?php 
    //CABECALHO
    include 'cabecalho.php';

    //DIRETORIO DO PROJETO
    $page_file_temp = $_SERVER["PHP_SELF"];
    $_SESSION['RAIZ'] = $_SERVER['DOCUMENT_ROOT'] . '/' . dirname($page_file_temp) . '/';

    //DEFININDO O MODULO PRODUTO COMO PADRÃO NA SESSION
    $_SESSION['modulosconfig'] = 'div_produto';

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

                <a href="workflow.php" class="botao_home" type="submit"><i class="fa-regular fa-clipboard"></i> Workflow</a></td></tr>

                <span class="espaco_pequeno"></span>

                <a href="configuracoes.php" class="botao_home" type="submit"><i class="fa-solid fa-gear"></i> Configurações</a></td></tr>


            <div class="div_br"> </div>
            <div class="div_br"> </div>
            <div class="div_br"> </div>  

<?php
    //RODAPE
    include 'rodape.php';
?>