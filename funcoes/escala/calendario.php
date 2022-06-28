<?php

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

//VARIAVEIS DE PESQUISA
$setor = $_GET['setor'];
$ano = $_GET['ano'];
$mes = $_GET['mes'];
$dia = 1;

//DATA
$data = $ano . '-' . $mes . '-' . $dia;
$databr = str_pad($dia, 2, 0, STR_PAD_LEFT) . '/' . $mes . '/' . $ano;

//ULTIMO DIA
$ultimo_dia = date("t", mktime(0,0,0,$mes,'01',$ano));      
//echo '</br>';

//DIA DA SEMANA
//echo $dia_semana = strftime('%A', strtotime($data));
//echo '</br>';

//MES
echo '<div style="margin: 0 auto; text-align:center;">';



echo '<table style="margin: 0 auto;">';

    //CONTADOR CONSTRUTOR
    $cont_estrut = 1;

    //CONTADOR AUXILIAR SEMANA
    $dia_aux_semana = 1;

    //LIBERA CONTADOR
    $libera_contador = 0;
    
    while($cont_estrut <= 49){

        if($cont_estrut <= 7){

            $data_aux_semana = 2020 . '-' . 11 . '-' . $dia_aux_semana; 

            echo '<td class="quadro_semana">';                    

                echo utf8_encode(ucfirst(str_replace('-feira','',strftime('%A', strtotime($data_aux_semana)))));                   

                $dia_aux_semana = $dia_aux_semana + 1;

            echo '</td>';

        }else{

            if($cont_estrut > 7 AND $cont_estrut <=14){

                $data_aux_semana = 2020 . '-' . 11 . '-' . $dia_aux_semana; 

                echo '<td class="quadro_calendario">';
                        
                    //DATA
                    $data = $ano . '-' . $mes . '-' . $dia;
                    $databr = str_pad($dia, 2, 0, STR_PAD_LEFT) . '/' . $mes . '/' . $ano;     

                    $semana_vdd = str_replace('-feira','',strftime('%A', strtotime($data_aux_semana)));

                    $semana_atual = str_replace('-feira','',strftime('%A', strtotime($data)));

                    //VALIDA INICIO DA CONTAGEM
                    if($semana_vdd == $semana_atual AND $libera_contador == 0){

                        $libera_contador = 1;
                        $dia = 1;

                    }

                    //INICIA A CONTAGEM
                    if($libera_contador == 1){

                        echo '<div class="detalhe_dia">';
                            
                            echo $dia; 
                            
                        echo '</div>';                            

                        include 'consulta_escala_dias.php'; 

                        $dia = $dia + 1;                                                  
                    
                    }
                    
                $dia_aux_semana = $dia_aux_semana + 1;

                echo '</td>';

            }else{

                echo '<td class="quadro_calendario">';

                    //EXIBE ATEO ULTIMO DIA
                    if($dia <= $ultimo_dia){

                        $databr = str_pad($dia, 2, 0, STR_PAD_LEFT) . '/' . $mes . '/' . $ano; 

                        echo '<div class="detalhe_dia">';
                            
                            echo $dia; 
                            
                        echo '</div>';

                        include 'consulta_escala_dias.php'; 

                        $dia = $dia + 1;  

                    }

                echo '</td>';

            }

        }

        if($cont_estrut == 7 OR $cont_estrut == 14 OR $cont_estrut == 21 OR $cont_estrut == 28 OR $cont_estrut == 35 OR $cont_estrut == 42){

            echo '</tr>';

            echo '<tr>';

        }

        $cont_estrut = $cont_estrut + 1;

    }

echo '</table>';

?>

<div id="modal_desc" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalhes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="div_desc" class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>






    <style>

    .quadro_calendario{

        width: 50px;
        height: 50px;
        text-align: center;
        border: solid 1px #d5d5d5;
        font-size: 14px;

    }

    .quadro_semana{

        border: solid 1px #d5d5d5;
        width: 140px;
        height: 10px;
        text-align: center;
        background-color: #efefef;
    }

    .detalhe_dia{

        font-size: 12px;
        text-align:center;
        background-color: rgba(70, 165, 212,0.15)

    }

    table{
        border-spacing: 0px;
    }

</style>