<?php 
include '../../conexao.php';

session_start();

//declaramos uma variavel para monstarmos a tabela 

$date = date('m/d/Y', time());
$dadosXls = ""; 
$dadosXls .= " <table class='table table-fixed table-hover table-striped' cellspacing='0' cellpadding='0' border='1'>"; 
$dadosXls .= " <thead style = 'background-color: #3185c1; font-color: #fff' ><tr>"; 
$dadosXls .= " <th class='align-middle' style='text-align: center !important;'>  Dia  </th>"; 
$dadosXls .= " <th class='align-middle' style='text-align: center !important;'>  Prestador  </th>";
$dadosXls .= " <th class='align-middle' style='text-align: center !important;'>  Horário  </th>"; 
$dadosXls .= " <th class='align-middle' style='text-align: center !important;'>  Setor  </th>";  
$dadosXls .= " <th class='align-middle' style='text-align: center !important;'>  Telefone comercial  </th>"; 
$dadosXls .= " <th class='align-middle' style='text-align: center !important;'>  Telefone comercial 2  </th>"; 
$dadosXls .= " <th class='align-middle' style='text-align: center !important;'>  Celular  </th>"; 
$dadosXls .= " <th class='align-middle' style='text-align: center !important;'>  Celular 2  </th>"; 
$dadosXls .= " <th class='align-middle' style='text-align: center !important;'>  E-mail  </th>"; 
$dadosXls .= " </thead></tr>"; 

$cons_escala = $_SESSION['excel'];
$result_escala = oci_parse($conn_ora, $cons_escala);
oci_execute($result_escala);

while($row_escala = oci_fetch_array($result_escala)){ 
    if($row_escala['DIARISTA'] == 'S'){
        $var_sn_diarista = 'Diarista - ';
    }else{
        $var_sn_diarista = ''; 
    }

    if($row_escala['SEXO'] == 'F'){
        $tp_sexo = 'Dra. ';
    }else if($row_escala['SEXO'] == 'M'){
        $tp_sexo = 'Dr. ';
    }else{
        $tp_sexo = 'Dr(a). ';
    }

    $dadosXls .= " <tr>"; 
    if($row_escala['DIA'] < 10){
        $dadosXls .= " <td class='align-middle' style='text-align: center !important;'> 0".$row_escala['DIA']."/". $row_escala['PERIODO'] ." </td>"; 
    }else{
        $dadosXls .= " <td class='align-middle' style='text-align: center !important;'> ".$row_escala['DIA']."/". $row_escala['PERIODO'] ." </td>"; 
    }
    $dadosXls .= " <td class='align-middle' style='text-align: center !important;'>". $var_sn_diarista ."". $tp_sexo ."". $row_escala['NM_PRESTADOR'] ."</td>"; 
    $dadosXls .= " <td class='align-middle' style='text-align: center !important;'> ".$row_escala['INICIAL']." - ". $row_escala['FINAL'] ." </td>"; 
    $dadosXls .= " <td class='align-middle' style='text-align: center !important;'> ".$row_escala['SETOR']." </td>"; 
    $dadosXls .= " <td class='align-middle' style='text-align: center !important;'> ".$row_escala['TELEFONE_COMERCIAL_1']." </td>"; 
    $dadosXls .= " <td class='align-middle' style='text-align: center !important;'> ".$row_escala['CELULAR']." </td>"; 
    $dadosXls .= " <td class='align-middle' style='text-align: center !important;'> ".$row_escala['E_MAIL']." </td>"; 
    $dadosXls .= " <td class='align-middle' style='text-align: center !important;'> ".$row_escala['TELEFONE_COMERCIAL_2']." </td>"; 
    $dadosXls .= " <td class='align-middle' style='text-align: center !important;'> ".$row_escala['CELULAR_2']." </td>"; 
    $dadosXls .= " </tr>"; 
    if($_SESSION['tp'] == 1){
        $setor = $row_escala['SETOR'];
    }
} 
$dadosXls .= " </table>";
// Definimos o nome do arquivo que será exportado 

if($_SESSION['tp'] == 1){
    $arquivo = "escala_medica-". $setor ."-". $_SESSION['dt'] .".xls"; 
}else{
    $arquivo = "escala_medica-". $_SESSION['dt'] .".xls"; 
}
// Configurações header para forçar o download 
header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="'.$arquivo.'"'); 
header('Cache-Control: max-age=0'); 
// Se for o IE9, isso talvez seja necessário 
header('Cache-Control: max-age=1'); 
// Envia o conteúdo do arquivo 
echo $dadosXls; 
exit; 

?>
