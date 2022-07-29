<?php 
include '../../conexao.php';

session_start();

$data = date('m/d/Y H:i', time());
//declaramos uma variavel para monstarmos a tabela 

$date = date('m/d/Y', time());
$dadosXls = ""; 
$dadosXls .= " <table class='table table-fixed table-hover table-striped' cellspacing='0' cellpadding='0'>"; 
$dadosXls .= " <thead><tr>"; 

$dadosXls .= " <th>  Setor  </th>";  
$dadosXls .= " <th>  Inicio  </th>";  
$dadosXls .= " <th>  Fim  </th>";  
$dadosXls .= " <th>  Prestador  </th>";  
$dadosXls .= " <th>  Comercial 1 </th>"; 
$dadosXls .= " <th>  Celular  </th>"; 
$dadosXls .= " <th>  E-mail  </th>"; 
$dadosXls .= " <th>  Comercial 2  </th>"; 
$dadosXls .= " <th>  Celular 2  </th>"; 

$dadosXls .= " </tr></thead>"; 

echo $cons_escala = $_SESSION['excel'];
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
    
    $dadosXls .= " <td class='align-middle' style='text-align: center !important;'> ".$row_escala['SETOR']." </td>"; 
    $dadosXls .= " <td class='align-middle' style='text-align: center !important;'> ".$row_escala['INICIAL']." </td>"; 
    $dadosXls .= " <td class='align-middle' style='text-align: center !important;'> ".$row_escala['FINAL']." </td>";  
    $dadosXls .= " <td class='align-middle' style='text-align: center !important;'>". $var_sn_diarista ."". $tp_sexo ."". $row_escala['NM_PRESTADOR'] ."</td>"; 
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
$dadosXls .= "<tr>Gerado no dia ". $data ."</tr>";
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
